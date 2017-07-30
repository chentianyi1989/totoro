<?php

namespace App\Http\Controllers\Wap;

use App\Http\Controllers\Api\ApiClientController;
use App\Http\Controllers\Member\PtController;
use App\Http\Controllers\Web\WebBaseController;
use App\Models\Api;
use App\Models\BankCard;
use App\Models\BlackListIp;
use App\Models\DailiMoneyLog;
use App\Models\Dividend;
use App\Models\Drawing;
use App\Models\GameList;
use App\Models\GameRecord;
use App\Models\Member;
use App\Models\MemberDailiApply;
use App\Models\MemberLoginLog;
use App\Models\Recharge;
use App\Models\SystemNotice;
use App\Models\TcgGameList;
use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ValidationTrait;
use Auth;
use Hash;
class IndexController extends WebBaseController
{
    use ValidationTrait;

    //首页
    public function index()
    {
        $system_notices = SystemNotice::where('on_line', 0)->orderBy('sort', 'asc')->orderBy('created_at', 'desc')->get();
        return view('wap.index', compact('system_notices'));
    }

    //pt 电子游戏列表
    public function pt_rng_game_list()
    {
        $data = TcgGameList::where('productCode', 'PT')->where('client_type', 'phone')->where('on_line', 0)->where('gameType', 'RNG')->orderBy('sort', 'asc')->get();

        return view('wap.pt.rng_game_list', compact('data'));
    }

    //pt 真人游戏列表
    public function pt_live_game_list()
    {
        $data = TcgGameList::where('productCode', 'PT')->where('on_line', 0)->where('gameType', 'LIVE')->orderBy('sort', 'asc')->get();

        return view('wap.pt.live_game_list', compact('data'));
    }

    public function png_rng_game_list()
    {
        $data = TcgGameList::where('productCode', 'PNG')->where('client_type', 'phone')->where('on_line', 0)->where('gameType', 'RNG')->orderBy('sort', 'asc')->get();

        return view('wap.png.rng_game_list', compact('data'));
    }

    //pt 真人游戏列表
    public function png_live_game_list()
    {
        $data = TcgGameList::where('productCode', 'PNG')->where('on_line', 0)->where('gameType', 'LIVE')->orderBy('sort', 'asc')->get();

        return view('wap.png.live_game_list', compact('data'));
    }

    //ag 电子游戏列表
    public function ag_eGame_list()
    {
        return view('wap.ag.eGame_list');
    }

    //mg 电子游戏列表
    public function mg_eGame_list()
    {
        return view('wap.mg.eGame_list');
    }

    public function login()
    {
        return view('wap.login');
    }

    public function postLogin(Request $request)
    {
        $validator = $this->verify($request, 'wap.login');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        if (Auth::guard('member')->attempt(['name' => $request->name, 'password' => $request->password]))
        {
            //return respS('登录成功',  route('member.index'));
            $member = auth('member')->user();
            $member->update([
                'is_login' => 1
            ]);
            MemberLoginLog::create([
                'member_id' => $member->id,
                'ip' => $request->getClientIp()
            ]);
            return responseSuccess('', '登录成功', route('member.userCenter'));
        }

        return responseWrong('用户名或密码错误');

    }

    public function register(Request $request)
    {
        $i_code = $request->get('i_code');

        return view('wap.register', compact('i_code'));
    }

    public function postRegister(Request $request)
    {
        $validator = $this->verify($request, 'wap.register');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        if(!$request->has('i_code'))
            return responseWrong('无效提交');

        //验证ip
        if (in_array($request->getClientIp(), BlackListIp::pluck('ip')->toArray()))
            return responseWrong('该ip限制，请联系客服');

        if (strlen((string)$request->get('name')) >10  || strlen((string)$request->get('name')) < 7)
            return responseWrong('用户名为7-10位数字字母组合');

        if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$request->get('name')))
            return responseWrong('不允许输入特殊字符');

        $data = $request->all();

        $dali_mod = '';
        if ($request->has('i_code'))
        {
            $dali_mod = Member::where('is_daili', 1)->where('invite_code', $request->get('i_code'))->first();
        }

        Member::create([
            'name' => $data['name'],
            'password' => bcrypt($data['password']),
            'original_password' => substr(md5(md5($data['name'])), 0,10),
            'invite_code' => str_random(5),
            'real_name' => $data['real_name'],
            'qk_pwd' => $data['qk_pwd'],
            'top_id' => $dali_mod?$dali_mod->id:0,
            'register_ip' => $request->getClientIp()
        ]);

        return responseSuccess('','注册成功', route('wap.login'));
    }

    public function userinfo(Request $request)
    {
        $api_mod= Api::where('on_line', 0)->orderBy('created_at', 'desc')->get();
        $member = $this->getMember();
        return view('wap.userinfo', compact('api_mod'));
    }

    public function agent()
    {
        return view('wap.agent');
    }

    public function agent_apply()
    {
        return view('wap.agent_apply');
    }

    public function post_agent_apply(Request $request)
    {
        $validator = $this->verify($request, 'wap.post_agent_apply');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $data = $request->all();
        $member = $this->getMember();
        MemberDailiApply::create([
            'member_id' => $member->id,
            'phone' => $data['phone'],
            'msn_qq' => $data['qq'],
            'about' => $data['about']
        ]);

        return responseSuccess('','提交成功', route('wap.agent'));
    }

    public function bind_bank()
    {
        return view('wap.bind_bank');
    }

    public function post_bind_bank(Request $request)
    {
        $validator = $this->verify($request, 'wap.update_bank_info');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $data = $request->all();
        $member = $this->getMember();

        $member->update($data);

        return responseSuccess('', '绑定成功', route('wap.drawing'));
    }

    public function set_phone()
    {
        return view('wap.set_phone');
    }

    public function post_set_phone(Request $request)
    {
        $validator = $this->verify($request, 'wap.post_set_phone');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $data = $request->all();
        $member = $this->getMember();

        $member->update([
            'phone' => $data['phone']
        ]);

        return responseSuccess('', '设置成功', route('wap.index'));
    }

    public function drawing()
    {

        if (!$this->getMember()->bank_card)
            return redirect()->to(route('wap.bind_bank'));

        return view('wap.drawing');
    }

    public function post_drawing(Request $request)
    {
        $member = $this->getMember();

        if (!$member->bank_card)
            return responseWrong('请先设置银行卡信息','', route('wap.update_bank_info'));

        $validator = $this->verify($request, 'wap.post_drawing');

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

        return responseSuccess('','提交成功', route('wap.drawing_record'));
    }



    public function recharge()
    {
        return view('wap.recharge');
    }

    public function weixin_pay()
    {
        return view('wap.weixin_pay');
    }

    public function post_weixin_pay(Request $request)
    {
        $validator = $this->verify($request, 'wap.post_weixin_pay');

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

        return responseSuccess('', '', route('wap.recharge_record'));
    }

    public function ali_pay()
    {
        return view('wap.ali_pay');
    }

    public function post_ali_pay(Request $request)
    {
        $validator = $this->verify($request, 'wap.post_ali_pay');

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

        return responseSuccess('', '', route('wap.recharge_record'));
    }

    public function bank_pay()
    {
        $bank_card_list = BankCard::where('on_line', 0)->orderBy('created_at', 'desc')->get();

        return view('wap.bank_pay', compact('bank_card_list'));
    }

    public function post_bank_pay(Request $request)
    {
        $validator = $this->verify($request, 'wap.post_bank_pay');

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

        return responseSuccess('', '', route('wap.recharge_record'));
    }

    public function third_bank_pay()
    {
        return view('wap.third_bank_pay');
    }

    public function third_pay_scan()
    {
        return view('wap.third_pay_scan');
    }

    public function reset_password()
    {
        return view('wap.reset_password');
    }

    public function reset_login_password(Request $request)
    {
        $validator = $this->verify($request, 'wap.update_login_password');

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

    public function reset_qk_password(Request $request)
    {
        $validator = $this->verify($request, 'wap.update_qk_password');

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

    public function transfer()
    {
        return view('wap.transfer');
    }

    public function post_transfer(Request $request)
    {
        $validator = $this->verify($request, 'wap.post_transfer');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $member = $this->getMember();
        $in_account = $request->get('in_account');
        $out_account = $request->get('out_account');
        $money = $request->get('money');

        $o = new ApiClientController();

        if ($in_account == $out_account || ($in_account> 2 && $out_account > 2))
        {
            return responseWrong('不支持该种类型转换，请重新选择');
        }

        //
        if ($out_account == 1)//从中心账户转出
        {
            if ($member->money < $money)
                return responseWrong('账户余额不足');

            $api = Api::findOrFail($in_account);

            $res = $o->deposit($api->api_name, $member->name, $member->original_password, $money, 'money');
            if ($res['Code'] != 0)
                return responseWrong('失败！错误代码'.$res['Code'].' 请联系客服解决');
        } elseif ($out_account == 2){//从返水账户转出

            if ($member->fs_money < $money)
                return responseWrong('账户余额不足');

            $api = Api::findOrFail($in_account);

            $res = $o->deposit($api->api_name, $member->name, $member->original_password, $money, 'fs_money');
            if ($res['Code'] != 0)
                return responseWrong('失败！错误代码'.$res['Code'].' 请联系客服解决');
        } elseif ($in_account == 1){// 转入中心账户

            $api = Api::findOrFail($out_account);
            $res = $o->withdrawal($api->api_name, $member->name, $member->original_password, $money, 'money');
            if ($res['Code'] != 0)
                return responseWrong('失败！错误代码'.$res['Code'].' 请联系客服解决');
        }

        return responseSuccess('', '转换成功');
    }

    public function drawing_record(Request $request)
    {
        $data = Drawing::where('member_id', $this->getMember()->id)->orderBy('created_at', 'desc')->paginate(config('web.page-size'));

        return view('wap.drawing_record', compact('data'));
    }

    public function game_record(Request $request)
    {

        $api_type = '';
        $mod = new GameRecord();
        if ($request->has('api_type'))
        {
            $api_type = $request->get('api_type');
            $mod = $mod->where('api_type', $api_type);
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(config('web.page-size'));

        return view('wap.game_record', compact('data', 'api_type'));
    }

    public function recharge_record(Request $request)
    {

        $data = Recharge::where('member_id', $this->getMember()->id)->orderBy('created_at', 'desc')->paginate(config('web.page-size'));

        return view('wap.recharge_record', compact('data'));
    }

    public function transfer_record(Request $request)
    {
        $cn_begin = $cn_end = date('Y-m-d');

        $s_begin_h = $request->get('s_begin_h')?:'00';
        $s_begin_i = $request->get('s_begin_i')?:'00';

        $s_end_h  = $request->get('s_end_h')?:'23';

        $s_end_i = $request->get('s_end_i')?:'59';

        $mod = new Transfer();
        if ($request->has('cn_begin'))
        {
            $cn_begin = $request->get('cn_begin');
            $mod = $mod->where('created_at', '>=', $cn_begin." ".$s_begin_h.":".$s_begin_i.":00");
        }

        if ($request->has('cn_end'))
        {
            $cn_end = $request->get('cn_end');
            $mod = $mod->where('created_at', '<=', $cn_end." ".$s_end_h.":".$s_end_i.":00");
        }


        $data = $mod->where('member_id', $this->getMember()->id)->orderBy('created_at', 'desc')->paginate(config('web.page-size'));

        return view('wap.transfer_record', compact('data', 'cn_begin', 'cn_end', 's_begin_h', 's_begin_i', 's_end_h', 's_end_i'));
    }

    public function daili_money_log(Request $request)
    {
        $data = DailiMoneyLog::where('member_id', $this->getMember()->id)->orderBy('created_at', 'desc')->paginate(config('web.page-size'));

        return view('wap.daili_money_log', compact('data'));
    }

    public function member_offline(Request $request)
    {
        $data = Member::where('top_id', $this->getMember()->id)->orderBy('created_at', 'desc')->paginate(config('web.page-size'));

        return view('wap.member_offline', compact('data'));
    }

    public function member_offline_recharge(Request $request)
    {
        $mod = new Recharge();
        $name = '';
        $cn_begin =  date('Y-m-d');

        $cn_end = date('Y-m-d');

        if ($request->has('cn_begin'))
        {
            $cn_begin = $request->get('cn_begin');
            $mod = $mod->where('created_at', '>=', "$cn_begin");
        }

        if ($request->has('cn_end'))
        {
            $cn_end = $request->get('cn_end');
            $mod = $mod->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime($cn_end)));
        }

        if ($request->has('name'))
        {
            $name = $request->get('name');
            $m_list = Member::where('top_id', $this->getMember()->id)->where('name', 'LIKE', "%$name%")->pluck('id');
        } else {
            $m_list = Member::where('top_id', $this->getMember()->id)->pluck('id');
        }

        $mod = $mod->whereIn('member_id', $m_list);

        $data = $mod->orderBy('created_at', 'desc')->paginate(config('web.page-size'));

        return view('wap.member_offline_recharge' ,compact('data', 'name', 'cn_begin', 'cn_end'));
    }

    public function member_offline_drawing(Request $request)
    {
        $mod = new Drawing();
        $name = '';
        $cn_begin =  date('Y-m-d');

        $cn_end = date('Y-m-d');

        if ($request->has('cn_begin'))
        {
            $cn_begin = $request->get('cn_begin');
            $mod = $mod->where('created_at', '>=', "$cn_begin");
        }

        if ($request->has('cn_end'))
        {
            $cn_end = $request->get('cn_end');
            $mod = $mod->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime($cn_end)));
        }

        if ($request->has('name'))
        {
            $name = $request->get('name');
            $m_list = Member::where('top_id', $this->getMember()->id)->where('name', 'LIKE', "%$name%")->pluck('id');
        } else {
            $m_list = Member::where('top_id', $this->getMember()->id)->pluck('id');
        }

        $mod = $mod->whereIn('member_id', $m_list);

        $data = $mod->orderBy('created_at', 'desc')->paginate(config('web.page-size'));

        return view('wap.member_offline_drawing' ,compact('data', 'name', 'cn_begin', 'cn_end'));
    }


    public function member_offline_sy(Request $request)
    {
        $cn_begin =  '';

        $cn_end = '';

        $m_list = Member::where('top_id', $this->getMember()->id)->pluck('id');
        $recharge_mod = new Recharge();
        $drawing_mod = new Drawing();
        $dividend_mod = new Dividend();

        if ($request->has('cn_begin'))
        {
            $cn_begin = $request->get('cn_begin');
            $recharge_mod = $recharge_mod->where('created_at', '>=', $cn_begin);
            $drawing_mod = $drawing_mod->where('created_at', '>=', $cn_begin);
            $dividend_mod = $dividend_mod->where('created_at', '>=', $cn_begin);
        }

        if ($request->has('cn_end'))
        {
            $cn_end = $request->get('cn_end');
            $recharge_mod = $recharge_mod->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime($cn_end)));
            $drawing_mod = $drawing_mod->where('created_at', '>=', date('Y-m-d 23:59:59', strtotime($cn_end)));
            $dividend_mod = $dividend_mod->where('created_at', '>=', date('Y-m-d 23:59:59', strtotime($cn_end)));
        }

        $total_recharge = $recharge_mod->whereIn('member_id', $m_list)->sum('money');
        $recharge_count = $recharge_mod->whereIn('member_id', $m_list)->count();

        $total_drawing = $drawing_mod->whereIn('member_id', $m_list)->sum('money');
        $drawing_count = $drawing_mod->whereIn('member_id', $m_list)->count();

        $total_dividend = $dividend_mod->whereIn('member_id', $m_list)->sum('money');
        $dividend_count = $dividend_mod->whereIn('member_id', $m_list)->count();


        return view('wap.member_offline_sy', compact('cn_begin', 'cn_end', 'total_recharge', 'recharge_count', 'total_drawing', 'drawing_count', 'total_dividend', 'dividend_count'));
    }



}
