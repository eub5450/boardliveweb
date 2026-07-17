<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agency;
use Hash;
use DB;

class UserController extends Controller
{
    public function Info($id)
    {
        $user = User::find(trim((string) $id));
        $next_agency_code = $this->nextAgencyCode();

        if (!$user) {
            return response()->json([
                'error' => 'User not found',
                'user' => null,
                'next_agency_code' => $next_agency_code,
            ]);
        }

        return response()->json(['success' => 'User Find', 'user' => $user, 'next_agency_code' => $next_agency_code]);
    }

    private function nextAgencyCode()
    {
        $latest = Agency::query()
            ->whereNotNull('code')
            ->orderByRaw('CAST(code AS UNSIGNED) DESC')
            ->first();

        $next = $latest ? ((int) $latest->code) + 1 : 1000;
        while (Agency::where('code', (string) $next)->exists()) {
            $next++;
        }

        return (string) $next;
    }

    public function UserEmailChange()
    {
        return view('backend.user.user_details_change');
    }

    public function UserEmailChangeStore(Request $request)
    {
        if ($request->input('change_mode') === 'email_only') {
            return $this->UserEmailOnlyChangeStore($request);
        }

        $request->validate([
            'email' => 'required|email',
            'user_id' => 'required|integer|min:1|max:99999',
        ], [
            'user_id.max' => 'Target user ID must be 5 digits or less. 6 digit IDs are blocked.',
        ]);

        $email = trim(strtolower($request->email));
        $newId = (int) $request->user_id;

        if (User::where('id', $newId)->exists()) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'Target user ID is already used. Choose a free ID.',
                'alert-type' => 'error',
            ]);
        }

        $sourceUser = User::whereRaw('LOWER(email) = ?', [$email])->first();
        if (!$sourceUser) {
            return $this->createUserWithSelectedId($email, $newId);
        }

        if ((int) $sourceUser->id === $newId) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'This email already has the selected ID.',
                'alert-type' => 'info',
            ]);
        }

        $oldId = (int) $sourceUser->id;
        $stamp = gmdate('Ymd_His');
        $relatedColumns = $this->userReferenceColumns();

        try {
            DB::beginTransaction();

            $this->backupRows('users', 'id', [$oldId], "users_emailchange_backup_{$stamp}");
            foreach ($relatedColumns as $item) {
                $this->backupRows($item->TABLE_NAME, $item->COLUMN_NAME, [$oldId], "{$item->TABLE_NAME}_{$item->COLUMN_NAME}_emailchange_backup_{$stamp}");
            }

            foreach ($relatedColumns as $item) {
                DB::table($item->TABLE_NAME)
                    ->where($item->COLUMN_NAME, $oldId)
                    ->update([$item->COLUMN_NAME => $newId]);
            }

            DB::table('users')->where('id', $oldId)->update([
                'id' => $newId,
                'phone' => $newId,
                'email' => $email,
                'updated_at' => now(),
            ]);

            DB::commit();

            $this->syncUsersAutoIncrement();

            return Redirect()->back()->with([
                'messege' => "User ID changed successfully: {$email} {$oldId} -> {$newId}",
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $error) {
            DB::rollBack();
            return Redirect()->back()->withInput()->with([
                'messege' => 'User ID change failed: ' . $error->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    private function createUserWithSelectedId($email, $newId)
    {
        $pass = 123456;
        $deviceId = $this->randomTenDigitId();
        $imeiNumber = $this->randomTenDigitId();

        try {
            DB::beginTransaction();
            DB::table('users')->insert([
                'id' => $newId,
                'name' => 'New User',
                'device_id' => $deviceId,
                'imei_number' => $imeiNumber,
                'phone' => $newId,
                'email' => $email,
                'level' => 1,
                'is_vip' => 0,
                'profile' => 'store/profile/default.png',
                'balance' => 0,
                'entry_level' => 0,
                'role' => 2,
                'status' => 1,
                'password' => Hash::make($pass),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();

            $this->syncUsersAutoIncrement();

            return Redirect()->back()->with([
                'messege' => "New user created successfully: {$email} -> ID {$newId}",
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $error) {
            DB::rollBack();
            return Redirect()->back()->withInput()->with([
                'messege' => 'New user create failed: ' . $error->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    private function randomTenDigitId()
    {
        return (string) random_int(1000000000, 9999999999);
    }

    private function UserEmailOnlyChangeStore(Request $request)
    {
        $request->validate([
            'email_only_user_id' => 'required|integer|min:1',
            'new_email' => 'required|email',
        ]);

        $userId = (int) $request->email_only_user_id;
        $newEmail = trim(strtolower($request->new_email));

        try {
            $result = DB::transaction(function () use ($userId, $newEmail) {
                $user = User::where('id', $userId)->lockForUpdate()->first();
                if (!$user) {
                    throw new \RuntimeException('__USER_NOT_FOUND__');
                }

                $emailOwner = User::whereRaw('LOWER(email) = ?', [$newEmail])->lockForUpdate()->first();
                if ($emailOwner && (int) $emailOwner->id === $userId) {
                    throw new \RuntimeException('__SAME_EMAIL__');
                }

                $backupIds = [$userId];
                if ($emailOwner) {
                    $backupIds[] = (int) $emailOwner->id;
                }
                $this->backupRows('users', 'id', array_unique($backupIds), 'users_email_only_backup_' . gmdate('Ymd_His'));

                if ($emailOwner) {
                    $oldEmail = trim(strtolower((string) $user->email));
                    if ($oldEmail === '' || $oldEmail === $newEmail) {
                        $oldEmail = $emailOwner->id . '@broadlive.local';
                    }
                    $emailOwner->email = $oldEmail;
                    $emailOwner->save();
                    $user->email = $newEmail;
                    $user->save();

                    return ['mode' => 'swapped', 'owner_id' => (int) $emailOwner->id];
                }

                $user->email = $newEmail;
                $user->save();

                return ['mode' => 'updated'];
            });
        } catch (\RuntimeException $e) {
            $messages = [
                '__USER_NOT_FOUND__' => 'User ID not found.',
                '__SAME_EMAIL__' => 'This user already has that email.',
            ];
            return Redirect()->back()->withInput()->with([
                'messege' => $messages[$e->getMessage()] ?? 'Email change failed.',
                'alert-type' => $e->getMessage() === '__SAME_EMAIL__' ? 'info' : 'error',
            ]);
        } catch (\Throwable $error) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'Email change failed: ' . $error->getMessage(),
                'alert-type' => 'error',
            ]);
        }

        $message = $result['mode'] === 'swapped'
            ? 'Email changed successfully. Previous email owner user ID ' . $result['owner_id'] . ' received this user old email.'
            : "Email changed successfully for user ID {$userId}.";

        return Redirect()->back()->with([
            'messege' => $message,
            'alert-type' => 'success',
        ]);
    }

    private function userReferenceColumns()
    {
        $database = DB::getDatabaseName();
        $columns = ['user_id', 'users_id', 'sender_id', 'receiver_id', 'host_id', 'owner_id', 'created_by', 'updated_by'];
        $marks = implode(',', array_fill(0, count($columns), '?'));
        $params = array_merge([$database], $columns);

        return DB::select("
            SELECT table_name AS TABLE_NAME, column_name AS COLUMN_NAME
            FROM information_schema.columns
            WHERE table_schema = ?
              AND table_name <> 'users'
              AND column_name IN ({$marks})
            ORDER BY table_name, column_name
        ", $params);
    }

    private function backupRows($table, $column, array $ids, $backupTable)
    {
        if (empty($ids)) {
            return;
        }

        $tableSql = $this->quoteIdentifier($table);
        $columnSql = $this->quoteIdentifier($column);
        $backupSql = $this->quoteIdentifier($backupTable);
        $idList = implode(',', array_map('intval', $ids));

        DB::statement("CREATE TABLE IF NOT EXISTS {$backupSql} AS SELECT * FROM {$tableSql} WHERE {$columnSql} IN ({$idList})");
    }

    private function syncUsersAutoIncrement()
    {
        $maxId = (int) DB::table('users')->max('id');
        $nextId = $maxId + 1;
        DB::statement("ALTER TABLE users AUTO_INCREMENT = {$nextId}");
    }

    private function quoteIdentifier($name)
    {
        return '`' . str_replace('`', '``', $name) . '`';
    }
}
