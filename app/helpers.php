<?php


/**
 * 返回成功请求
 *
 * @param string $data
 * @param string $msg
 * @param string $header
 * @param string $value
 * @return mixed
 */
function responseSuccess($data = '', $msg = '成功', $url = '', $header = 'Content-Type', $value = 'application/json')
{
    $msg = is_array($msg)?json_encode($msg):json_encode([$msg?:trans('response.success')]);
    $res['status']  = ['errorCode' => 0, 'msg' => trans($msg)?trans($msg):$msg];
    $res['data']    = $data;
    $res['url']     = $url;
    return response($content = $res, $status = 200)->header($header, $value);
}

/**
 * 返回错误的请求
 *
 * @param string $msg
 * @param int $code
 * @param string $data
 * @param string $header
 * @param string $value
 * @return mixed
 */
function responseWrong($msg = '失败',  $data = '', $url = '', $code = 1, $header = 'Content-Typeaa', $value = 'application/json')
{
    $msg = is_array($msg)?json_encode($msg):json_encode([$msg?:trans('response.fail')]);
    $res['status']  = ['errorCode' => $code, 'msg' => trans($msg)?trans($msg):$msg];
    $res['data']    = $data;
    $res['url']  = $url;
    return response($content = $res, $status = 200)->header($header, $value);
}

/**
 * 成功跳转
 * @param string $msg
 * @param string $route
 * @return \Illuminate\Http\RedirectResponse
 */
function respS($msg = '', $route = '')
{
    $msg = trans($msg)?trans($msg):trans('res.success');
    return $route?redirect($route)->with('msg_ok', $msg):redirect()->back()->with('msg_ok', $msg);
}

/**
 * 失败跳转
 * @param string $msg
 * @param string $route
 * @return \Illuminate\Http\RedirectResponse
 */
function respF($msg = '', $route = '')
{
    $msg = trans($msg)?trans($msg):trans('res.fail');
    return $route?redirect($route)->with('msg_no', $msg):redirect()->back()->with('msg_no', $msg);
}

function getBillNo()
{
    return time().str_random(5);
}

/**
 * curl方法拖数据
 *
 */
function curl_data($url = '', $method = 0 , $param='')
{
    $postUrl    = $url;
    $curlPost   = $param;
    $ch         = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, $method);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);

    return $data;
}