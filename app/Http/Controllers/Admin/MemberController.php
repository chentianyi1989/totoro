<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminActionMoneyLog;
use App\Models\Dividend;
use App\Models\Drawing;
use App\Models\GameRecord;
use App\Models\Recharge;
use Illuminate\Http\Request;
use App\Models\Member;
use Auth;
class MemberController extends AdminBaseController
{
    public function index(Request $request)
    {
        $mod = new Member();
        $name = $status = $real_name = $register_ip = '';
        if ($request->has('name'))
        {
            $name = $request->get('name');
            $mod = $mod->where('name', 'like', "%$name%");
        }
        if ($request->has('real_name'))
        {
            $real_name = $request->get('real_name');
            $mod = $mod->where('real_name', 'like', "%$real_name%");
        }
        if ($request->has('register_ip'))
        {
            $register_ip = $request->get('register_ip');
            $mod = $mod->where('register_ip', 'like', "%$register_ip%");
        }
        if ($request->has('status'))
        {
            $status = $request->get('status');
            $mod = $mod->where('status', $status);
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(config('admin.page-size'));

        return view('admin.member.index', compact('data', 'name', 'status','real_name', 'register_ip'));
    }

    public function showGameRecordInfo(Request $request, $id)
    {
        $mod = new GameRecord();
        $start_at = $end_at = $api_type ='';
        if ($request->has('api_type'))
        {
            $api_type = $request->get('api_type');
            $mod = $mod->where('api_type', $api_type);
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

        $mod = $mod->where('member_id', $id);

        $data = $mod->orderBy('created_at', 'desc')->paginate(config('admin.page-size'));

        $total_netAmount = $mod->sum('netAmount');
        $total_betAmount = $mod->sum('betAmount');

        return view('admin.member.showGameRecordInfo', compact('data','start_at', 'end_at', 'api_type', 'total_netAmount', 'total_betAmount', 'id'));
    }

    public function showRechargeInfo(Request $request, $id)
    {
        $mod = new Recharge();

        $status = $payment_type = '';

        if ($request->has('status'))
        {
            $status = $request->get('status');
            $mod = $mod->where('status', $status);
        }

        if ($request->has('payment_type'))
        {
            $payment_type = $request->get('payment_type');
            $mod = $mod->where('payment_type', $payment_type);
        }

        $mod = $mod->where('member_id', $id);

        $data = $mod->orderBy('created_at', 'asc')->paginate(config('admin.page-size'));

        $total_recharge = $mod->sum('money');
        $total_diff_money = $mod->sum('diff_money');

        return view('admin.member.showRechargeInfo', compact('data', 'status', 'payment_type', 'total_recharge', 'total_diff_money', 'id'));
    }

    public function showDrawingInfo(Request $request, $id)
    {
        $mod = new Drawing();

        $status = '';

        if ($request->has('status'))
        {
            $status = $request->get('status');
            $mod = $mod->where('status', $status);
        }
        $mod = $mod->where('member_id', $id);

        $data = $mod->orderBy('created_at', 'asc')->paginate(config('admin.page-size'));

        $total_money = $mod->sum('money');
        $total_counter_fee = $mod->sum('counter_fee');

        return view('admin.member.showDrawingInfo', compact('data', 'status', 'total_money', 'total_counter_fee', 'id'));
    }

    public function showDividendInfo(Request $request, $id)
    {
        $mod = new Dividend();

        $type = '';

        if ($request->has('type'))
        {
            $type = $request->get('type');
            $mod = $mod->where('type', $type);
        }

        $mod = $mod->where('member_id', $id);

        $data = $mod->orderBy('created_at', 'asc')->paginate(config('admin.page-size'));

        $total_money = $mod->sum('money');

        return view('admin.member.showDividendInfo', compact('data','total_money', 'type','id'));
    }

    public function export(Request $request)
    {
        $map = [];
        if ($request->has('name'))
        {
            $name = $request->get('name');
            $map['name'] = ['name', 'like', "%$name%"];
        }

        if ($request->has('realname'))
        {
            $realname = $request->get('realname');
            $map['realname'] = ['realname', 'like', "%$realname%"];
        }

        //默认不显示超级管理员
        $map['is_super_admin'] = 0;
        $data = MemberRepository::getByWhere($map)->toArray();

        Excel::create('测试', function ($excel) use ($data) {
            $excel->sheet('Sheetname', function ($sheet) use ($data) {
                $sheet->rows(
                    $data
                );
            });
        })->download('xls');
    }

    public function create()
    {
        return view('admin.member.create');
    }

    /**
     *
     * 创建
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = $this->verify($request, 'member.store');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $data = $request->all();

        Member::create($data);

        return responseSuccess('','', route('member.index'));
    }

    /**
     *
     * 编辑
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data= Member::findOrFail($id);

        return view('admin.member.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
//        $validator = $this->verify($request, 'member.update');
//
//        if ($validator->fails())
//        {
//            $messages = $validator->messages()->toArray();
//            return responseWrong($messages);
//        }

        if ($request->has('qk_pwd'))
        {
            $q = (string)$request->get('qk_pwd');
            if (!is_numeric($request->get('qk_pwd')) || strlen($q) != 6)
            return responseWrong('取款密码为6位数字');
        }

        $member= Member::findOrFail($id);
        $old_money = $member->money;
        $old_fs_money = $member->fs_money;
        $new_money = $request->get('money');
        $new_fs_money = $request->get('fs_money');
        if (!$request->has('password'))
        {
            if ($request->has('qk_pwd'))
                $member->update([
                    'money' => $request->get('money'),
                    'fs_money' => $request->get('fs_money'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'qk_pwd' => $request->get('qk_pwd')
                ]);
            else
                $member->update([
                    'money' => $request->get('money'),
                    'fs_money' => $request->get('fs_money'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'bank_username' => $request->get('bank_username'),
                    'bank_name' => $request->get('bank_name'),
                    'bank_card' => $request->get('bank_card'),
                    'bank_branch_name' => $request->get('bank_branch_name'),
                    'bank_address' => $request->get('bank_address'),
                    
                ]);
        }else{
            $member->update($request->all());
        }

        //如果
        if ($old_money != $new_money || $old_fs_money != $new_fs_money)
        {
            $user = Auth::user();
            AdminActionMoneyLog::create([
                'member_id' => $member->id,
                'user_id' => $user->id,
                'old_money' => $old_money,
                'new_money' => $new_money,
                'old_fs_money' => $old_fs_money,
                'new_fs_money' => $new_fs_money
            ]);
        }

        return responseSuccess('','', route('member.index'));
    }

    public function destroy($id)
    {
        Member::destroy($id);

        return respS();
    }

    public function check($id, $status)
    {
        $mod = Member::findOrFail($id);
        $mod->update([
            'status' => $status
        ]);

        return respS();
    }
}
