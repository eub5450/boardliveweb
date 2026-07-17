<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\BanDevice;
use Auth;
use Carbon\Carbon;
use DB;
use Image;

class BanController extends Controller
{
    public function Index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $users = collect();

        if ($q !== '') {
            $users = User::query()
                ->where('id', $q)
                ->orWhere('phone', $q)
                ->orWhere('email', 'like', '%'.$q.'%')
                ->orWhere('name', 'like', '%'.$q.'%')
                ->orderBy('id', 'desc')
                ->limit(25)
                ->get();
        }

        $ban_ids = User::where('status', 0)
            ->whereNotNull('ban_type')
            ->orderBy('updated_at', 'desc')
            ->limit(500)
            ->get();

        return view('backend.power.ban', compact('users', 'ban_ids', 'q'));
    }

    public function Active(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'id_number' => 'required|integer',
            'ban_type' => 'required|in:A,B,C,D',
            'proved' => 'required|file|max:10240',
        ]);

        if ((int) $validated['user_id'] !== (int) $validated['id_number']) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'ID confirmation does not match.',
                'alert-type' => 'warning',
            ]);
        }

        $user = User::find($validated['user_id']);
        if (!$user) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'User not found.',
                'alert-type' => 'error',
            ]);
        }

        try {
            $provedUrl = $this->storeProofUpload($request->file('proved'));

            DB::transaction(function () use ($user, $validated, $provedUrl) {
                $user->is_invisible = 0;
                $user->status = 0;
                $user->ban_type = $validated['ban_type'];
                $user->ban_proved = $provedUrl;
                $user->ban_by = Auth::id();
                $user->api_token = null;
                $user->game_api_key = null;
                $user->remember_token = null;
                $user->is_device_ban = $validated['ban_type'] === 'A' ? 1 : 0;

                if ($validated['ban_type'] === 'A') {
                    $user->open_time = null;
                    if (!empty($user->device_id) && !BanDevice::where('device_id', $user->device_id)->exists()) {
                        DB::table('ban_devices')->insert([
                            'device_id' => $user->device_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                } elseif ($validated['ban_type'] === 'B') {
                    $user->open_time = Carbon::now()->addDays(30)->format('Y-m-d H:i:s');
                    $this->removeDeviceBan($user);
                } elseif ($validated['ban_type'] === 'C') {
                    $user->open_time = Carbon::now()->addDay()->format('Y-m-d H:i:s');
                    $this->removeDeviceBan($user);
                } else {
                    $user->open_time = Carbon::now()->addHour()->format('Y-m-d H:i:s');
                    $this->removeDeviceBan($user);
                }

                $user->save();
            });

            return Redirect()->back()->with([
                'messege' => 'ID Banned Successfully',
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $error) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'Ban failed: '.$error->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    public function Reject($id)
    {
        $user = User::find($id);

        if (!$user) {
            return Redirect()->back()->with([
                'messege' => 'User not found.',
                'alert-type' => 'error',
            ]);
        }

        try {
            DB::transaction(function () use ($user) {
                $this->removeDeviceBan($user);
                $user->status = 1;
                $user->ban_proved = null;
                $user->ban_type = null;
                $user->ban_by = null;
                $user->open_time = null;
                $user->is_device_ban = 0;
                $user->save();
            });

            return Redirect()->back()->with([
                'messege' => 'ID Unbanned Successfully',
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $error) {
            return Redirect()->back()->with([
                'messege' => 'Unban failed: '.$error->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    private function removeDeviceBan(User $user)
    {
        if (!empty($user->device_id)) {
            BanDevice::where('device_id', $user->device_id)->delete();
        }
    }

    private function storeProofUpload($file)
    {
        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages(['proved' => 'Proof upload failed.']);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
        if (!in_array($extension, $allowed, true)) {
            throw ValidationException::withMessages(['proved' => 'Invalid proof file type: '.$extension]);
        }

        $targetDir = base_path('store/bannedproved');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $safeName = preg_replace('/[^a-zA-Z0-9_-]+/', '-', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $safeName = trim($safeName, '-') ?: 'proof';
        if ($extension === 'pdf') {
            $fileName = gmdate('YmdHis').'-'.uniqid().'-'.$safeName.'.pdf';
            $file->move($targetDir, $fileName);

            return 'store/bannedproved/'.$fileName;
        }

        $fileName = gmdate('YmdHis').'-'.uniqid().'-'.$safeName.'.webp';
        $image = Image::make($file->getRealPath())->orientate()->resize(1400, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $this->saveOptimizedWebp($image, $targetDir.DIRECTORY_SEPARATOR.$fileName);

        return 'store/bannedproved/'.$fileName;
    }

    private function saveOptimizedWebp($image, string $absolutePath): void
    {
        foreach ([88, 82, 76, 70, 64, 58, 52, 46] as $quality) {
            $image->encode('webp', $quality)->save($absolutePath);
            if (is_file($absolutePath) && filesize($absolutePath) <= 102400) {
                return;
            }
        }

        while (is_file($absolutePath) && filesize($absolutePath) > 102400 && $image->width() > 800) {
            $image->resize(max(800, (int) floor($image->width() * 0.9)), null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->encode('webp', 52)->save($absolutePath);
        }
    }
}
