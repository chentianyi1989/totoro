<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\GameRecord;

class GameRecordController extends AdminBaseController
{

    public function index(Request $request)
    {
        $mod = new GameRecord();
        $playerName = $start_at = $end_at = $api_type = '';
        if ($request->has('api_type'))
        {
            $api_type = $request->get('api_type');
            $mod = $mod->where('api_type', $api_type);
        }
        if ($request->has('playerName'))
        {
            $playerName = $request->get('playerName');
            $mod = $mod->where('playerName', 'like', "%$playerName%");
        }
        if ($request->has('start_at_recalcuTime'))
        {
            $start_at = $request->get('start_at_recalcuTime');
            $mod = $mod->where('recalcuTime', '>=', $start_at);
        }
        if ($request->has('end_at_recalcuTime'))
        {
            $end_at = $request->get('end_at_recalcuTime');
            $mod = $mod->where('recalcuTime', '<=',$end_at);
        }
        
        if ($request->has('start_at_betTime')){
            
            $start_at = $request->get('start_at_betTime');
            $mod = $mod->where('betTime', '>=', $start_at);
        }
        if ($request->has('end_at_betTime')){
            
            $end_at = $request->get('end_at_betTime');
            $mod = $mod->where('betTime', '<=',$end_at);
        }

        $total_netAmount = $mod->sum('netAmount');
        $total_betAmount = $mod->sum('betAmount');

        $data = $mod->orderBy('recalcuTime', 'desc')->paginate(config('admin.page-size'));

        return view('admin.game_record.index', compact('data', 'playerName', 'start_at_recalcuTime', 'end_at_recalcuTime','start_at_betTime','end_at_betTime', 'api_type', 'total_netAmount', 'total_betAmount'));
    }
    
    public function syncGameRecord (Request $request){
        
//         use App\Http\Controllers\Api\AgController;
//         use App\Http\Controllers\Api\BbinController;
        
        $ag = \App::make(\App\Http\Controllers\Api\AgController::class);
        \App::call([$ag, "getGameRecord"]);
        
        $bbin = \App::make(\App\Http\Controllers\Api\BbinController::class);
        \App::call([$bbin, "getGameRecord"]);
        
        return $this->index($request);
        
    }
//    public function index(Request $request)
//    {
//        $mod = new GameRecord();
//        $username = $start_at = $end_at = $productType = '';
//        if ($request->has('productType'))
//        {
//            $productType = $request->get('productType');
//            $mod = $mod->where('productType', $productType);
//        }
//        if ($request->has('username'))
//        {
//            $username = $request->get('username');
//            $mod = $mod->where('username', 'like', "%$username%");
//        }
//        if ($request->has('start_at'))
//        {
//            $start_at = $request->get('start_at');
//            $mod = $mod->where('betTime', '>=', $start_at);
//        }
//        if ($request->has('end_at'))
//        {
//            $end_at = $request->get('end_at');
//            $mod = $mod->where('betTime', '<=',$end_at);
//        }
//
//        $data = $mod->orderBy('created_at', 'desc')->paginate(config('admin.page-size'));
//
//        $total_netPnl = $mod->sum('netPnl');
//        $total_betAmount = $mod->sum('betAmount');
//
//        return view('admin.game_record.index', compact('data', 'username', 'start_at', 'end_at', 'productType', 'total_netPnl', 'total_betAmount'));
//    }
}
