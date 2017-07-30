<?php

return [
    // 请选择签名类型，默认为md5商户根据自己要求
    'SIGN_TYPE' => 'MD5',

    // 支付系统密钥，
    'KEY' => '23c39ebc61094227ead1a11b8a5cea62',

    //  支付（正式环境）
    'GATEWAY_URL' => 'http://gate.aospay.cn/cooperate/gateway.cgi',

    // 商户在支付平台的平台号
    'MERCHANT_ID' => '2017062037010009',

    // 商户通知地址（请根据自己的部署情况设置下面的路径）
    'MERCHANT_NOTIFY_URL' => '',

    //支付版本的api的版本号
    'API_VERSION' => '1.0.0.0',

    //网银支付
    'APINAME_PAY' => 'TRADE.B2C',

    //扫码支付
    'APINAME_SCANPAY' => 'TRADE.SCANPAY',

    //支付订单查询
    'APINAME_QUERY' => 'TRADE.QUERY',

    //退款申请
    'APINAME_REFUND' => 'TRADE.REFUND',

    //单笔委托结算
    'APINAME_SETTLE' => 'TRADE.SETTLE',

    //单笔委托结算查询
    'APINAME_SETTLE_QUERY' => 'TRADE.SETTLE.QUERY',

    //支付
    'APINAME_NOTIFY' => 'TRADE.NOTIFY',

    'status' => [
        0 => '未支付',
        1 => '支付成功',
        2 => '支付失败',
        4 => '部分退款',
        5 => '退款',
        9 => '退款处理中',

    ]
];