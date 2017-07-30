<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\WechatSimpleReply;
use App\Models\WechatUser;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    //
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        //Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){
            $msg = "";
            switch ($message->MsgType) {
                case 'event':
                    $msg = $this->eventReply($message);
                    break;
                case 'text':
                    $msg = $this->textReply($message->Content);
                    break;
                case 'image':
                    $msg = '图片';
                    break;
                case 'voice':
                    $msg = '音频';
                    break;
                case 'video':
                    $msg = '视频';
                    break;
                case 'location':
                    $msg = '位置';
                    break;
                case 'link':
                    $msg = '链接';
                    break;
                default:
                    $msg = '其他';
                    break;
            }

            return $msg;
        });

        //Log::info('return response.');

        return $wechat->server->serve();
    }

    public function callback()
    {
        $wechat = app('wechat');

        $user = $wechat->oauth->user();
        //dd($user);
        session('wechat.oauth_user', $user->toArray());
    }

    protected function getUser($openid)
    {
        $mod = WechatUser::firstOrCreate([
            'openid' => $openid
        ]);

        $user = app('wechat')->user->get($openid);


        if (count($mod->member) <=0)
        {
            Member::create([
                'real_name' => $user->nickname,
                'nick_name' => $user->nickname,
                'gender' => $user->sex,
                'city' => $user->city,
                'province' => $user->province,
                'country' => $user->country,
            ]);
        }

        if (isset($user->nickname) || isset($user->headimgurl))
        {
            $mod->update([
                'nickname' => $user->nickname,
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
    }

    protected function updateUser($openid)
    {
        $mod = WechatUser::where('openid', $openid)->first();

        $mod->update([
            'is_subscribed' => 0
        ]);
    }

    //事件回复
    protected function eventReply($message)
    {
        $msg = '';
        if ($message->Event == 'subscribe')
        {
            $openid = $message->FromUserName;
            $msg .= '谢谢关注';
            $this->getUser($openid);
            if (isset($message->EventKey)){
                $msg .= "关注二维码场景 ".$message->EventKey;
            }
        } elseif ($message->Event == 'unsubscribe')//取消关注
        {
            $openid = $message->FromUserName;
            $this->updateUser($openid);
        } elseif (isset($message->EventKey))
        {
            $msg = $this->keywordReply($message->EventKey);
        }
        $msg .= '';

        return $msg;
    }

    protected function keywordReply($keyword)
    {
        $msg = '';
        if ($keyword == '456')
        {
            $msg .= '请点击以下链接，了解详情：'."\r\n";
            $msg .='1、<a href="http://wechat.7tink.com/wechat/index">如何注册及绑定?</a>'."\r\n";
            $msg .='2、<a href="http://wechat.7tink.com/wechat/index">如何赚取佣金?</a>'."\r\n";
            $msg .='3、<a href="http://wechat.7tink.com/wechat/index">如何获得积分?</a>'."\r\n";
            $msg .='4、<a href="http://wechat.7tink.com/wechat/index">积分的用途?</a>'."\r\n";
            $msg .='5、<a href="http://wechat.7tink.com/wechat/index">如何下单?</a>'."\r\n";
            $msg .='6、<a href="http://wechat.7tink.com/wechat/index">如何体现?</a>'."\r\n";
            $msg .='7、<a href="http://www.baidu.com">如何常见问题?</a>'."\r\n";
            return $msg;
        }
        $msg = $keyword;
        return $msg;
    }

    protected function simpleReply($keyword)
    {
        $mod = WechatSimpleReply::where('keyword', $keyword)->first();
        if ($mod)
            $msg = $mod->content;
        else
            $msg = '文本';

        return $msg;
    }

    //文本回复
    protected function textReply($keyword)
    {
        $mod = WechatSimpleReply::where('keyword', $keyword)->first();
        if ($mod)
            $msg = $mod->content;
        else
            $msg = '文本';

        return $msg;
    }
}
