<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Web\WebBaseController;
use App\Models\Api;
use App\Models\BankCard;
use App\Models\Drawing;
use App\Models\Feedback;
use App\Models\MemberMessage;
use App\Models\Recharge;
use App\Models\SystemNotice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ValidationTrait;
use Hash;
use App\Http\Controllers\Api\ApiClientController;
class IndexController extends ApiClientController
{
    use ValidationTrait;

    /**
     *
     * 基本信息
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userCenter()
    {
        $api_list = Api::where('on_line', 0)->orderBy('created_at', 'desc')->get();

        return view('member.single_info', compact('api_list'));
    }

    /**
     *
     * 银行资料
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bank_load()
    {
        return view('member.bank_load');
    }

    /**
     *
     * 账户设置
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account_load()
    {
        $api_list = Api::where('on_line', 0)->orderBy('created_at', 'desc')->get();

        return view('member.account_load', compact('api_list'));
    }

    public function message_list()
    {

        return view('member.message_list');
    }

    /**
     *
     * 安全密码
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function safe_psw()
    {
        return view('member.safe_psw');
    }

    /**
     *
     * 登录密码
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login_psw()
    {
        return view('member.login_psw');
    }

    /**
     *
     * 会员存款
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finance_center()
    {
        return view('member.finance_center');
    }

    /**
     *
     * 会员提款
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function member_drawing()
    {
        $member = $this->getMember();
        if (!$member->bank_username)
            return redirect()->to(route('member.update_bank_info'));
        return view('member.member_drawing');
    }

    /**
     *
     * 户内转账
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indoor_transfer()
    {
        $api_list = Api::where('on_line', 0)->orderBy('created_at', 'desc')->get();
        return view('member.indoor_transfer', compact('api_list'));
    }

    /**
     *
     * 客户报表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customer_report(Request $request)
    {
        $type = $request->has('type')?$request->get('type'):0;

        return view('member.customer_report', compact('type'));
    }

    /**
     *
     * 公告信息
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function service_center()
    {
        $system_notices = SystemNotice::where('on_line', 0)->orderBy('sort', 'asc')->orderBy('created_at', 'desc')->get();

        return view('member.service_center', compact('system_notices'));
    }

    /**
     *
     * 投诉建议
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function complaint_proposal()
    {
        return view('member.complaint_proposal');
    }

    public function update_bank_info()
    {
        return view('member.update_bank_info');
    }

    public function post_update_bank_info(Request $request)
    {
        $validator = $this->verify($request, 'member.update_bank_info');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $data = $request->all();
        $member = $this->getMember();

        $member->update($data);

        return responseSuccess('', '', route('member.bank_load'));
    }

    //修改取款密码
    public function update_qk_password(Request $request)
    {
        $validator = $this->verify($request, 'member.update_qk_password');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $data = $request->all();
        $member = $this->getMember();

        if ($member->qk_pwd != $data['old_password'])
        {
            return responseWrong('原密码错误');
        }

        $member->update([
            'qk_pwd' => $data['password']
        ]);

        return responseSuccess('', '修改成功');
    }

    public function update_login_password(Request $request)
    {
        $validator = $this->verify($request, 'member.update_login_password');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $data = $request->all();
        $member = $this->getMember();
        if (!Hash::check($data['old_password'], $member->password))
        {
            return responseWrong('原密码错误');
        }

        $member->update([
            'password' => bcrypt($data['password']),
            'original_password' => $data['password']
        ]);

        return responseSuccess('', '修改成功');
    }

    public function recharge_type(Request $request)
    {
        if(!$request->has('type'))
            return responseWrong('请选择充值类型');

        $type = $request->get('type');
        $route = '';
        if ($type == 1)
            $route = route('member.weixin_pay');
        elseif ($type == 2)
            $route = route('member.ali_pay');
        elseif ($type == 3)
            $route = route('member.bank_pay');
        elseif ($type == 4)
            $route = route('member.third_bank_pay');
        elseif ($type == 5)
            $route = route('member.third_pay_scan');

        return responseSuccess('','', $route);
    }

    //微信支付
    public function weixin_pay()
    {
        return view('member.weixin_pay');
    }

    //支付宝支付
    public function ali_pay()
    {
        return view('member.ali_pay');
    }

    //银行卡支付
    public function bank_pay()
    {
        $bank_card_list = BankCard::where('on_line', 0)->orderBy('created_at', 'desc')->get();

        return view('member.bank_pay', compact('bank_card_list'));
    }

    public function third_bank_pay()
    {
        return view('member.third_bank_pay');
    }

    public function third_pay_scan()
    {
        return view('member.third_pay_scan');
    }

    //提交微信支付
    public function post_weixin_pay(Request $request)
    {
        $validator = $this->verify($request, 'member.post_weixin_pay');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $data = $request->all();
        $member = $this->getMember();

        Recharge::create([
            'bill_no' => getBillNo(),
            'member_id' => $member->id,
            'name' => $member->name,
            'money' => $data['money'],
            'payment_type' => 2,
            'account' => $data['account'],
            'status' => 1,
            'hk_at' => $data['paytime'].' '.$data['date_h'].':'.$data['date_i'].':'.$data['date_s']
        ]);

        return responseSuccess('','提交成功', route('member.customer_report').'?type=0');
    }

    //提交支付宝支付
    public function post_ali_pay(Request $request)
    {
        $validator = $this->verify($request, 'member.post_ali_pay');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $data = $request->all();
        $member = $this->getMember();

        Recharge::create([
            'bill_no' => getBillNo(),
            'member_id' => $member->id,
            'name' => $member->name,
            'money' => $data['money'],
            'payment_type' => 1,
            'account' => $data['account'],
            'status' => 1,
            'hk_at' => $data['paytime'].' '.$data['date_h'].':'.$data['date_i'].':'.$data['date_s']
        ]);

        return responseSuccess('','提交成功', route('member.customer_report').'?type=0');
    }

    //提交银行卡支付
    public function post_bank_pay(Request $request)
    {
        $validator = $this->verify($request, 'member.post_bank_pay');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $data = $request->all();
        $member = $this->getMember();

        Recharge::create([
            'bill_no' => getBillNo(),
            'member_id' => $member->id,
            'name' => $data['name'],
            'money' => $data['money'],
            'payment_type' => 3,
            'account' => $data['account'],
            'payment_desc' => $data['payment_desc'],
            'status' => 1,
            'hk_at' => $data['paytime'].' '.$data['date_h'].':'.$data['date_i'].':'.$data['date_s']
        ]);

        return responseSuccess('','提交成功', route('member.customer_report').'?type=0');
    }

    //提交提款
    public function post_drawing(Request $request)
    {
        $member = $this->getMember();

        if (!$member->bank_username)
            return responseWrong('请先设置银行卡信息','', route('member.update_bank_info'));

        $validator = $this->verify($request, 'member.post_drawing');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $data = $request->all();

        if ($data['money'] > $member->money)
            return responseWrong('提款金额大于余额');
        if ($data['qk_pwd'] != $member->qk_pwd)
            return responseWrong('取款密码不正确');

        Drawing::create([
            'bill_no' => getBillNo(),
            'member_id' => $member->id,
            'name' => $member->bank_username,
            'money' => $data['money'],
            'account' => $member->bank_card,
            'bank_name' => $member->bank_name,
            'bank_card' => $member->bank_card,
            'bank_address' => $member->bank_address
        ]);

        $member->decrement('money', $data['money']);

        return responseSuccess('','提交成功', route('member.customer_report').'?type=1');
    }

    //提交额度转换
    public function post_transfer(Request $request)
    {
        $validator = $this->verify($request, 'member.post_transfer');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $input = $request->all();
        $member = $this->getMember();
        $api = Api::findOrFail($input['account2']);

        $api_name = $api->api_name;
        $username = $member->name;
        $password = $member->original_password;
        $amount = $input['money'];
        $transfer_type = $input['transfer_type'];
        $account1 = $input['account1']==1?'money':'fs_money';

        $data = [];
        //转账类型
        if ($transfer_type == 0)//转入游戏
        {
            if ($account1 == 'money' && $member->money < $amount)
                return responseWrong('账户余额不足');
            if ($account1 == 'fs_money' && $member->fs_money < $amount)
                return responseWrong('账户余额不足');

            $res = $this->deposit($api_name, $username, $password, $amount, $account1);
            if ($res['Code'] != 0)
                return responseWrong('失败！错误代码'.$res['Code'].' 请联系客服解决');
        } elseif ($transfer_type == 1)//转出游戏
        {
            $res = $this->withdrawal($api_name, $username, $password, $amount, $account1);
            if ($res['Code'] != 0)
                return responseWrong('失败！错误代码'.$res['Code'].' 请联系客服解决');
        }

        return responseSuccess('','提交成功', route('member.customer_report').'?type=2');

    }

    //提交反馈
    public function post_feedback(Request $request)
    {
        $validator = $this->verify($request, 'member.post_feedback');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $data = $request->all();

        Feedback::create([
            'type' => $data['type'],
            'content' => $data['content'],
            'phone' => $data['phone'],
            'member_id' => $this->getMember()->id
        ]);

        return responseSuccess('', '谢谢您的反馈！', route('member.complaint_proposal'));
    }

    public function play_game(Request $request)
    {
        $member = $this->getMember();
        $api_name = strtoupper($request->get('api_name'));
        $product_type = $request->get('product_type');
        $game_code = $request->get('game_code');
        $url = '';
        $res = $this->login($api_name,$member->name,$member->original_password,$product_type, $game_code);
        if ($res['status'] == 0)
            $url = $res['game_url'];

        return view('member.play_game', compact('url'));
    }
}
