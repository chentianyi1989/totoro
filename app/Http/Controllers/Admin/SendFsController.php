<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dividend;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GameRecord;
class SendFsController extends AdminBaseController
{

    public function index(Request $request)
    {
        $mod = new Member();
        $name = $api_type = '';
        $gameType = [1,3];//默认真人和电子
        $start_at = date('Y-m-d', strtotime('-1 day'));
        $end_at = date('Y-m-d 23:59:59', strtotime('-1 day'));
        if ($request->has('api_type'))
        {
            $api_type = $request->get('api_type');
            //$mod = $mod->where('api_type', $api_type);
        }
        if ($request->has('gameType'))
        {
            $gameType = $request->get('gameType');
        }
        if ($request->has('name'))
        {
            $name = $request->get('name');
            $mod = $mod->where('name', 'like', "%$name%");
        }
        if ($request->has('start_at'))
        {
            $start_at = $request->get('start_at');
            //$mod = $mod->where('betAmount', '>=', $start_at);
        }
        if ($request->has('end_at'))
        {
            $end_at = $request->get('end_at');
            //$mod = $mod->where('betAmount', '<=',$end_at);
        }

        //$data = $mod->orderBy('created_at', 'desc')->paginate(config('admin.page-size'));
        $data = $mod->orderBy('created_at', 'desc')->get();


        return view('admin.send_fs.index', compact('data', 'name', 'start_at', 'end_at', 'api_type','gameType'));
    }

    public function store(Request $request)
    {
        $validator = $this->verify($request, 'send_fs.store');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $data = $request->all();
        foreach ($data['member_id'] as $k => $item)
        {
            $member = Member::findOrFail($item);

            $member->increment('fs_money', $data['money'][$item]);

            Dividend::create([
                'member_id' => $item,
                'type' => 3,
                'describe' => '返水',
                'money' => $data['money'][$item],
                //'remark' => $data['remark'][$item],
            ]);
        }

        return responseSuccess();
    }
}
