<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Web\WebBaseController;
use App\Models\Member;
use App\Models\PayRecord;
use App\Models\Recharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PayService;
use Illuminate\Support\Facades\Log;

class PayController extends WebBaseController
{
    public function pay(Request $request)
    {
        $config = config('pay');
        $data['service'] = $config['APINAME_PAY'];
        $data['version'] = $config['API_VERSION'];
        $data['merId'] = $config['MERCHANT_ID'];

        $tradeNo = getBillNo();
        $amount = $request->get('amount')?sprintf("%.2f", $request->get('amount')):0.01;
        $bankId = $request->get('bankId')?:'ICBC';
        $clientIp = $request->getClientIp();

        $data['tradeNo'] = $tradeNo;
        $data['tradeDate'] = date('Ymd');
        $data['amount'] = $amount;
        $data['notifyUrl'] = route('pay.notify');
        $data['extra'] = '';
        $data['summary'] = '在线充值';
        $data['expireTime'] = 60;
        $data['clientIp'] = $clientIp;
        $data['bankId'] = $bankId;

        $data = $this->transfer($data);

        $pPay = new PayService($config['KEY'],$config['GATEWAY_URL']);
        // 准备待签名数据
        $str_to_sign = $pPay->prepareSign($data);
        // 数据签名
        $signMsg = $pPay->sign($str_to_sign);

        $data['sign'] = $signMsg;

        $member = $this->getMember();
        //产生支付记录
        PayRecord::create([
            'member_id' => $member->id,
            'order_no' => $tradeNo,
            'money' => $amount,
            'pay_type' => 1,
            'bankId' => $bankId,
            'clientIp' => $clientIp,
            'before_request_result' => json_encode($data)
        ]);
        //充值记录
        Recharge::create([
            'bill_no' => $tradeNo,
            'member_id' => $member->id,
            'name' => $member->name,
            'money' => $amount,
            'payment_type' => 4,
            'account' => '第三方支付',
            'status' => 1,
            'hk_at' => date('Y-m-d H:i:s')
        ]);

        // 生成表单数据
        echo $pPay->buildForm($data,$config['GATEWAY_URL']);


    }

    public function pay_scan(Request $request)
    {
        $config = config('pay');
        $data['service'] = $config['APINAME_SCANPAY'];
        $data['version'] = $config['API_VERSION'];
        $data['merId'] = $config['MERCHANT_ID'];

        $tradeNo = getBillNo();
        $amount = $request->get('amount')?sprintf("%.2f", $request->get('amount')):0.01;
        $typeId = $request->get('typeId')?:1;
        $clientIp = $request->getClientIp();

        //
        if ($typeId == 1)
        {
            if ($amount> 2000 || $amount < 100)
                return respF('支付宝扫码充值范围100-2000元');
        } elseif ($typeId ==2) {
            if ($amount > 3000 || $amount < 100)
                return respF('微信扫码充值范围100-3000元');
        }


        $data['tradeNo'] = $tradeNo;
        $data['tradeDate'] = date('Ymd');
        $data['amount'] = $amount;
        $data['notifyUrl'] = route('pay.notify');
        $data['extra'] = '';
        $data['summary'] = '在线充值';
        $data['expireTime'] = 60;
        $data['clientIp'] = $clientIp;
        //类型 微信 支付宝
        $data['typeId'] = $typeId;

        $data = $this->transfer($data);
        // 初始化
        $pPay = new PayService($config['KEY'],$config['GATEWAY_URL']);
        // 准备待签名数据
        $str_to_sign = $pPay->prepareSign($data);
        // 数据签名
        $sign = $pPay->sign($str_to_sign);
        // 准备请求数据
        $to_requset = $pPay->prepareRequest($str_to_sign, $sign);

        $member = $this->getMember();
        //产生支付记录
        PayRecord::create([
            'member_id' => $member->id,
            'order_no' => $tradeNo,
            'money' => $amount,
            'pay_type' => 2,
            'typeId' => $typeId,
            'clientIp' => $clientIp,
            'before_request_result' => $to_requset
        ]);
        //充值记录
        Recharge::create([
            'bill_no' => $tradeNo,
            'member_id' => $member->id,
            'name' => $member->name,
            'money' => $amount,
            'payment_type' => 4,
            'account' => '第三方支付',
            'status' => 1,
            'hk_at' => date('Y-m-d H:i:s')
        ]);

        //请求数据
        $resultData = $pPay->request($to_requset);
        // 准备验签数据
        $to_verify = $pPay->prepareVerify($resultData);
        // 签名验证
        $resultVerify = $pPay->verify($to_verify[0], $to_verify[1]);
        if ($resultVerify) {
            // 响应吗
            preg_match('{<code>(.*?)</code>}', $resultData, $match);
            $respCode = $match[1];
            // 响应信息
            preg_match('{<desc>(.*?)</desc>}', $resultData, $match);
            $respDesc = $match[1];

            if ($respCode == '00')
            {
                preg_match('{<qrCode>(.*?)</qrCode>}', $resultData, $match);
                $respqrCode= $match[1];

            } else {
                echo $respDesc;exit;
            }


            $base64 =base64_decode($respqrCode);

            $value="http://www.useryx.com";
            $errorCorrectionLevel = "L"; // 纠错级别：L、M、Q、H
            $matrixPointSize = "4"; // 点的大小：1到10
            //echo  $base64;

            //EWM();
        } else {
            echo "验证签名失败";
            return false;
        }

        if ($request->has('is_m') && $request->get('is_m') == 1)
        {
            return view('wap.pay_scan', compact('base64', 'value', 'errorCorrectionLevel', 'matrixPointSize', 'typeId'));
        }

        return view('member.pay_scan', compact('base64', 'value', 'errorCorrectionLevel', 'matrixPointSize', 'typeId'));
    }

    public function success()
    {
        $r = route('member.customer_report').'?type=0';
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(strpos($agent,"comFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") || strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS"))
        {
            $r = route('wap.recharge_record');
        }
        return view('member.pay_success', compact('r'));
    }

    public function notify(Request $request)
    {
        $config = config('pay');
        $res = $request->all();
        Log::info($res);
        // 请求数据赋值
        $data = [];
        $data['service'] = $res["service"];
        // 商户号
        $data['merId'] = $res["merId"];
        // 订单号
        $data['tradeNo'] = $res["tradeNo"];
        // 商户交易日期
        $data['tradeDate'] = $res["tradeDate"];
        // 支付订单号
        $data['opeNo'] = $res["opeNo"];
        // 订单日期
        $data['opeDate'] = $res["opeDate"];
        // 支付金额(单位元，显示用)
        $data['amount'] = $res["amount"];
        // 订单状态，0-未支付，1-支付成功，2-失败，4-部分退款，5-退款，9-退款处理中
        $data['status'] = $res["status"];
        // 商户参数，支付平台返回商户上传的参数，可以为空
        $data['extra'] = $res["extra"];
        // 支付账务日期
        $data['payTime'] = $res["payTime"];
        // 签名数据
        $data['sign'] = $res["sign"];
        //通知类型 0 -前台 - 1服务器
        $data['notifyType'] = $res["notifyType"];

        // 初始化
        $pPay = new PayService($config['KEY'],$config['GATEWAY_URL']);
        // 准备准备验签数据
        $str_to_sign = $pPay->prepareSign($data);
        // 验证签名
        $resultVerify = $pPay->verify($str_to_sign, $data['sign']);
        //var_dump($data);
        if ($resultVerify)
        {
            if ('1' == $data["notifyType"]) {
                //处理订单
                $mod = PayRecord::where('order_no', $data["tradeNo"])->first();
                if ($mod)
                {
                    $member = Member::find($mod->member_id);
                    $recharge = Recharge::where('bill_no', $data["tradeNo"])->first();

                    $mod->update([
                        'opeNo' => $data['opeNo'],
                        'payTime' => $data["payTime"],
                        'status' => $data["status"],
                        'after_request_result' => json_encode($data)
                    ]);


                    //如果处理成功
                    if ($recharge)
                    {
                        if ($data['status'] == 1 && $recharge->status != 2)
                        {
                            //中心账户
                            $member->increment('money', $data["amount"]);
                            //支付记录
                            $recharge->update([
                                'status' =>2,
                                'confirm_at' => date('Y-m-d H:i:s'),
                            ]);
                        } elseif ($data['status'] == 2) {
                            $recharge->update([
                                'status' =>3,
                            ]);
                        }
                    }
                }


                return "SUCCESS";
//                $url = "notify.php";
//                Header("Location: $url");
               // return true;
            } elseif ('0' == $data["notifyType"]) {
                return redirect()->to(route('pay.success'));
            }

        }
        else
        {
            // 把获得的这些数据显示到页面上，这里只是为了演示，实际应用中应该不需要把这些数据显示到页面上。
            echo "验证签名失败";
            echo "接口名称 ".$data['service'].'<br>';
            echo "支付金额： ".$data['amount'].'<br>';
            echo "商户号： ".$data['merId'].'<br>';
            echo "商户参数：： ".$data['extra'].'<br>';
            echo "商户订单号： ".$data['tradeNo'].'<br>';
            echo "商户交易日期： ".$data['tradeDate']."元".'<br>';
            echo "支付平台订单号： ".$data['opeNo']."元".'<br>';
            echo "支付平台订单日期： ".$data['opeDate']."元".'<br>';
            echo "订单状态： ".$data['status']."元".'<br>';
            return false;
        }
    }

    protected function transfer($data)
    {
        if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['notifyUrl']))
        {
            $data['notifyUrl'] = iconv("GBK","UTF-8", $data['notifyUrl']);
        }


        if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['extra']))
        {
            $data['extra'] = iconv("GBK","UTF-8", $data['extra']);
        }

        if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['summary']))
        {
            $data['summary'] = iconv("GBK","UTF-8", $data['summary']);
        }

        return $data;
    }
}
