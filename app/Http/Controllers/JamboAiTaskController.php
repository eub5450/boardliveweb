<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JamboAiTaskController extends Controller
{
    private const SOURCE_APP = 'broadlive';
    private const SOURCE_DOMAIN = 'broadlive.xyz';
    private const ALLOWED_ADMIN_ID = '11133';

    private function authorizePet(): string
    {
        $adminId = (string) Auth::id();
        abort_unless($adminId !== '' && hash_equals(self::ALLOWED_ADMIN_ID, $adminId), 403);
        return $adminId;
    }

    private function cleanText($value, int $max = 1000): string
    {
        $text = trim(strip_tags((string) $value));
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $text) ?? '';
        return Str::limit($text, $max, '');
    }

    private function taskQuery(string $adminId)
    {
        return DB::table('jambo_ai_tasks')
            ->where('source_app', self::SOURCE_APP)
            ->where('admin_id', $adminId);
    }

    public function index(Request $request)
    {
        $adminId = $this->authorizePet();
        $tasks = $this->taskQuery($adminId)
            ->whereIn('status', ['submitted', 'busy'])
            ->orderByDesc('id')
            ->limit(25)
            ->get();
        $history = $this->taskQuery($adminId)
            ->whereIn('status', ['done', 'cancelled'])
            ->orderByDesc('id')
            ->limit(25)
            ->get();
        return response()->json(['ok' => true, 'tasks' => $tasks, 'history' => $history], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function history(Request $request)
    {
        $adminId = $this->authorizePet();
        $history = $this->taskQuery($adminId)
            ->whereIn('status', ['done', 'cancelled'])
            ->orderByDesc('id')
            ->limit(100)
            ->get();
        return response()->json(['ok' => true, 'history' => $history], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $adminId = $this->authorizePet();
        $request->validate(['message' => 'required|string|max:1000']);
        $message = $this->cleanText($request->input('message'));
        if ($message === '') {
            return response()->json(['ok' => false, 'error' => 'message_required'], 422);
        }
        $id = DB::table('jambo_ai_tasks')->insertGetId([
            'source_app' => self::SOURCE_APP,
            'source_domain' => self::SOURCE_DOMAIN,
            'admin_id' => $adminId,
            'message' => $message,
            'status' => 'submitted',
            'created_by' => $adminId,
            'updated_by' => $adminId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $task = DB::table('jambo_ai_tasks')->where('id', $id)->first();
        return response()->json([
            'ok' => true,
            'task' => $task,
            'message' => 'Message sent to ops sir. I will follow that and wait for reply.',
        ], 201, [], JSON_UNESCAPED_UNICODE);
    }

    public function cancel($id)
    {
        $adminId = $this->authorizePet();
        $updated = $this->taskQuery($adminId)
            ->where('id', (int) $id)
            ->whereIn('status', ['submitted', 'busy'])
            ->update([
                'status' => 'cancelled',
                'updated_by' => $adminId,
                'updated_at' => now(),
            ]);
        return response()->json(['ok' => (bool) $updated]);
    }

    public function sendTooltip(Request $request, $id)
    {
        $adminId = $this->authorizePet();
        $tooltip = $this->cleanText($request->input('tooltip'), 500);
        if ($tooltip === '') {
            return response()->json(['ok' => false, 'error' => 'tooltip_required'], 422);
        }
        $updated = $this->taskQuery($adminId)
            ->where('id', (int) $id)
            ->update([
                'tooltip' => $tooltip,
                'updated_by' => $adminId,
                'updated_at' => now(),
            ]);
        return response()->json(['ok' => (bool) $updated]);
    }

    public function markBusy($id)
    {
        $adminId = $this->authorizePet();
        $updated = $this->taskQuery($adminId)
            ->where('id', (int) $id)
            ->whereIn('status', ['submitted', 'busy'])
            ->update([
                'status' => 'busy',
                'tooltip' => 'Start my job soon. It is live sir.',
                'updated_by' => $adminId,
                'updated_at' => now(),
            ]);
        return response()->json(['ok' => (bool) $updated]);
    }

    public function markDone(Request $request, $id)
    {
        $adminId = $this->authorizePet();
        $note = $this->cleanText($request->input('note'), 1000) ?: 'Your work completed sir.';
        $updated = $this->taskQuery($adminId)
            ->where('id', (int) $id)
            ->whereIn('status', ['submitted', 'busy'])
            ->update([
                'status' => 'done',
                'tooltip' => 'Ops completed: Your work completed sir.',
                'done_note' => $note,
                'done_by' => $adminId,
                'done_at' => now(),
                'updated_by' => $adminId,
                'updated_at' => now(),
            ]);
        return response()->json(['ok' => (bool) $updated]);
    }
}
