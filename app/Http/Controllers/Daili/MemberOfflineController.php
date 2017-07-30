<?php

namespace App\Http\Controllers\Daili;

use App\Http\Controllers\Daili\DailiBaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Traits\ValidationTrait;
class MemberOfflineController extends DailiBaseController
{
    use ValidationTrait;

    public function index(Request $request)
    {
        $mod = new Member();
        $name = $status = '';

        if ($request->has('name'))
        {
            $name = $request->get('name');
            $mod = $mod->where('name', 'like', "%$name%");
        }
        if ($request->has('status'))
        {
            $status = $request->get('status');
            $mod = $mod->where('status', $status);
        }

        $data = $mod->where('top_id', $this->getDaili()->id)->orderBy('created_at', 'desc')->paginate(config('admin.page-size'));

        return view('daili.member_offline.index', compact('data', 'name', 'status'));
    }

    public function create()
    {
        return view('daili.member_offline.create');
    }

    public function store(Request $request)
    {
        $validator = $this->verify($request, 'member_offline.store');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        if (strlen((string)$request->get('name')) >10  || strlen((string)$request->get('name')) < 7)
            return responseWrong('用户名为7-10位数字字母组合');

        if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$request->get('name')))
            return responseWrong('不允许输入特殊字符');

        $daili = $this->getDaili();
        $data = $request->all();

            Member::create([
                'name' => $data['name'],
                'password' => 123456,
                'original_password' => 123456,
                'top_id' => $daili->id,
                'invite_code' => str_random(6),
                'qk_pwd' => 123456
            ]);

        return responseSuccess('', '添加成功', route('daili.member_offline'));

    }

//    public function store(Request $request)
//    {
//        if (!$request->has('num'))
//            return responseWrong('请输入 生成会员数量');
//        $num = (int)$request->get('num');
//
//        if ($num< 1 || $num >20)
//            return responseWrong('数量在1到20之间');
//
//        $daili = $this->getDaili();
//
//        foreach (range(1, $num) as $key => $val)
//        {
//            //获取代理下的下线数量
//            $n = $daili->under_members()->count();
//
//            Member::create([
//                'name' => getMemberOfflineId($daili->id, $n + 1),
//                'password' => 123456,
//                'original_password' => 123456,
//                'top_id' => $daili->id,
//                'invite_code' => str_random(6),
//                'qk_pwd' => 123456
//            ]);
//        }
//
//        return responseSuccess('', '添加成功', route('daili.member_offline'));
//    }
}
