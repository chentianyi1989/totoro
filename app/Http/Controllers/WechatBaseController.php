<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WechatUser;
class WechatBaseController extends Controller
{
    protected function getWechatUser()
    {
        //return WechatUser::findOrFail(1);

        $oauth_user = session('wechat.oauth_user');
        $openid = $oauth_user->id;

        $mod = WechatUser::firstOrCreate([
            'openid' => $openid
        ]);

        if (!isset($mod->nickname) || !isset($mod->avatar))
        {

            $user = app('wechat')->user->get($openid);

            if (isset($user->nickname) || isset($user->headimgurl))
            {
                $mod->update([
                    //'nickname' => (string)$user->nickname,
                    'gender' => $user->sex,
                    'language' => $user->language,
                    'city' => $user->city,
                    'province' => $user->province,
                    'country' => $user->country,
                    'avatar' => $user->headimgurl,
                    'is_subscribed' => $user->subscribe,
                    'subscribed_at' => date('Y-m-d H:i:s', $user->subscribe_time)
                ]);

            }

            return WechatUser::where('openid', $openid)->first();

        }

        return $mod;
    }

    //
    protected function getMember()
    {
        $oauth_user = session('wechat.oauth_user');
        $openid = $oauth_user->id;

        $mod = WechatUser::where('openid', $openid)->first()->member;

        //本地调试 临时
        //$mod = Member::findOrFail(1);

        return $mod;
    }
}
