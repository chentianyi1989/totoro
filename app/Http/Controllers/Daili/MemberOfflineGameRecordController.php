<?php

namespace App\Http\Controllers\Daili;

use App\Http\Controllers\Daili\DailiBaseController;
use App\Models\TcgGameRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\GameRecord;
class MemberOfflineGameRecordController extends DailiBaseController
{

    public function index(Request $request)
    {
        $mod = new GameRecord();
        $playerName = $start_at = $end_at = $api_type = $name = '';
        if ($request->has('name'))
        {
            $name = $request->get('name');
            $m_list = Member::where('name', 'LIKE', "%$name%")->pluck('id')->toArray();
            $mod = $mod->whereIn('member_id', $m_list);
        }
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
        if ($request->has('start_at'))
        {
            $start_at = $request->get('start_at');
            $mod = $mod->where('betTime', '>=', $start_at);
        }
        if ($request->has('end_at'))
        {
            $end_at = $request->get('end_at');
            $mod = $mod->where('betTime', '<=',$end_at);
        }

        $m_list = Member::where('top_id', $this->getDaili()->id)->pluck('id');
        $mod = $mod->whereIn('member_id', $m_list);

        $total_netAmount = $mod->sum('netAmount');
        $total_betAmount = $mod->sum('betAmount');

        $data = $mod->orderBy('created_at', 'desc')->paginate(config('admin.page-size'));

        return view('daili.member_offline_game_record.index', compact('data', 'playerName','start_at', 'end_at', 'api_type', 'total_netAmount', 'total_betAmount', 'name'));
    }

//    public function index(Request $request)
//    {
//        $mod = new GameRecord();
//        $productType =$username= $start_at = $end_at  = '';
//
//
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
//        $m_list = Member::where('top_id', $this->getDaili()->id)->pluck('id');
//        $mod = $mod->whereIn('member_id', $m_list);
//
//        $total_netPnl = $mod->sum('netPnl');
//        $total_betAmount = $mod->sum('betAmount');
//
//        $data = $mod->orderBy('created_at', 'desc')->paginate(config('admin.page-size'));
//
//        return view('daili.member_offline_game_record.index', compact('data', 'username','start_at', 'end_at', 'productType', 'total_netPnl', 'total_betAmount'));
//    }
}
