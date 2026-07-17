<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomCommentController extends Controller
{
    public function Send(Request $request)
    {
        $token       = $request->access_token;
        $channelName = trim($request->channelName ?? '');
        $userId      = trim($request->user_id ?? '');
        $message     = trim($request->message ?? '');
        $response    = array();

        if ($token !== '0411f0028cfb768b3a3d96ac3aa37dw3e5') {
            array_push($response, array('message' => 'Unauthorized', 'code' => '401'));
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        if ($channelName === '' || $userId === '' || $message === '') {
            array_push($response, array('message' => 'Missing required fields', 'code' => '400'));
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        try {
            $pusher = new \Pusher\Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                ['cluster' => config('broadcasting.connections.pusher.options.cluster'), 'useTLS' => true]
            );
            $pusher->trigger(
                'bd_chat',
                'App\\Events\\BDEvent',
                json_encode([[
                    'channel_type'   => '11',
                    'channelName'    => $channelName,
                    'id'             => $userId,
                    'message'        => $message,
                    'name'           => $request->name ?? '',
                    'profile'        => $request->profile ?? '',
                    'level'          => $request->level ?? '1',
                    'is_vip'         => $request->is_vip ?? '0',
                    'frame'          => $request->frame ?? '',
                    'is_official_id' => $request->is_official_id ?? '0',
                    'is_agency'      => $request->is_agency ?? '0',
                    'is_host_id'     => $request->is_host_id ?? '0',
                    'comment_badge'  => $request->comment_badge ?? '',
                    'event_id'       => $request->event_id ?? '',
                    'balance'        => $request->balance ?? '0',
                    'type'           => $request->type ?? 'message',
                ]], JSON_UNESCAPED_UNICODE)
            );
        } catch (\Throwable $e) {
            // silently skip if Pusher fails — client still shows comment locally
        }

        array_push($response, array('message' => 'ok', 'code' => '200'));
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
