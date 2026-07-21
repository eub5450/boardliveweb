<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use App\Services\V4\RankingService;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function RankList(Request $request, RankingService $service)
    {
        $response = array();
        if ($request->access_token == "0411f0028cfb768b3a3d96ac3aa37dw3e5") {
            array_push($response, $service->monthlyPayload());
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        array_push($response, array('message'=>'Unauthorized','code'=>'401'));
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function TopList(Request $request, RankingService $service)
    {
        $response = array();
        if ($request->access_token == "0411f0028cfb768b3a3d96ac3aa37dw3e5") {
            array_push($response, $service->topListPayload());
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        array_push($response, array('message'=>'Unauthorized','code'=>'401'));
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Authenticated caller's own rank/total — real DB numbers, never seeded.
     */
    public function MyRank(Request $request, RankingService $service)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(
                ['message' => 'Unauthorized', 'code' => '401'],
                401,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }

        return response()->json(
            $service->myRankPayload((int) $user->id),
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
