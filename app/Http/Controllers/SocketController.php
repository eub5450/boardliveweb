<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Events\RealtimeEvent;

class SocketController extends Controller
{
    public function index(Request $request){
        $data=User::all();
        event(new RealtimeEvent($data));
        return response('Event Triggered')->withoutCookie('event');
    }
}
