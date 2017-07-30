<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\BlackListIp;
use App\Models\GameList;
use App\Models\Member;
use App\Models\MemberLoginLog;
use App\Models\SystemConfig;
use App\Models\SystemNotice;
use App\Services\TcgService;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use Auth;
class IndexController extends Controller
{
    use ValidationTrait;

    public function index()
    {
        $system_notices = SystemNotice::where('on_line', 0)->orderBy('sort', 'asc')->orderBy('created_at', 'desc')->get();
        $game_list = GameList::all();
        return view('web.index', compact('system_notices', 'game_list'));
    }

    public function login()
    {
        return view('web.login');
    }

    public function activityList()
    {
        $data = Activity::where('on_line', 0)->orderBy('created_at', 'desc')->get();

        return view('web.activityList', compact('data'));
    }

    public function activityDetail($id)
    {
        $data = Activity::where('on_line', 0)->where('id', $id)->first();

        return view('web.activityDetail', compact('data'));
    }

    public function liveCasino()
    {
        $system_notices = SystemNotice::where('on_line', 0)->orderBy('sort', 'asc')->orderBy('created_at', 'desc')->get();
        return view('web.liveCasino', compact('system_notices'));
    }

    public function egame()
    {
        $system_notices = SystemNotice::where('on_line', 0)->orderBy('sort', 'asc')->orderBy('created_at', 'desc')->get();
        $game_list = GameList::all();
        return view('web.egame', compact('system_notices','game_list'));
    }
    public function esports()
    {
        $system_notices = SystemNotice::where('on_line', 0)->orderBy('sort', 'asc')->orderBy('created_at', 'desc')->get();
        return view('web.esports', compact('system_notices'));
    }
    public function lottory()
    {
        $system_notices = SystemNotice::where('on_line', 0)->orderBy('sort', 'asc')->orderBy('created_at', 'desc')->get();
        return view('web.lottory', compact('system_notices'));
    }

    public function catchFish()
    {
        return view('web.catchFish');
    }

    public function maintain()
    {
        $mod = SystemConfig::findOrFail(1);
        if ($mod->is_maintain == 0)
            return redirect()->to(route('web.index'));

        $str = $mod->maintain_desc;
        return view('web.maintain', compact('str'));
    }

    public function register_one(Request $request)
    {
        $i_code = $request->get('i_code');
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(strpos($agent,"comFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") || strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS"))
        {
            return redirect()->to(route('wap.register').'?i_code='.$i_code);
        }
        $register_name = $request->has('register_name')?$request->get('register_name'):'';

        return view('web.register_one', compact('i_code', 'register_name'));
    }

    public function post_register_one(Request $request)
    {
        $validator = $this->verify($request, 'member.register_one');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        if(!$request->has('i_code'))
            return responseWrong('无效提交');

        if (strlen((string)$request->get('name')) >10  || strlen((string)$request->get('name')) < 7)
            return responseWrong('用户名为7-10位数字字母组合');

        if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$request->get('name')))
            return responseWrong('不允许输入特殊字符');

        $data = $request->all();

        $name = trim($data['name'], ' ');
        $pwd = trim($data['password'], ' ');
        $i_code = isset($data['i_code'])?trim($data['i_code'], ' '):'';

        if (Member::where('name', $data['name'])->first())
            return responseWrong('该账号已被注册');

        return responseSuccess('', '', route('web.register_two')."?register_name=$name&pwd=$pwd&i_code=$i_code");
    }

    public function register_two(Request $request)
    {
        $register_name = $request->get('register_name');
        $pwd = $request->get('pwd');
        $i_code = $request->get('i_code');

        return view('web.register_two', compact('register_name', 'pwd', 'i_code'));
    }

    public function post_register_two(Request $request)
    {
        $validator = $this->verify($request, 'member.register_two');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $data = $request->all();

        //判断是否为代理邀请注册
        $dali_mod = '';
        if ($request->has('invite_code'))
        {
            $dali_mod = Member::where('is_daili', 1)->where('invite_code', $request->get('invite_code'))->first();
        }

        Member::create([
            'name' => $data['name'],
            'original_password' => substr(md5(md5($data['name'])), 0,10),
            'password' => bcrypt($data['password']),
            'invite_code' => time().str_random(5),
            'real_name' => $data['real_name'],
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'qq' => $data['qq'],
            'email' => $data['email'],
            'top_id' => $dali_mod?$dali_mod->id:0,
            'qk_pwd' => $data['qk_pwd'],
            'register_ip' => $request->getClientIp()
        ]);

        if (Auth::guard('member')->attempt(['name' => $data['name'], 'password' => $data['password']]))
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

        return responseSuccess('', '', route('web.register_success'));
    }

    public function register_success(Request $request)
    {
        return view('web.register_success');
    }

    public function syncTpl($name)
    {
        return view('web.member.'.$name);
    }
}

