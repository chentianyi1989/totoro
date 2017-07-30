<?php


return [
    //红利类型
    'dividend_type' => [
        1 => '充值红利',
        2 => '平台红利',
        3 => '返水'
    ],
    //充值类型
    'recharge_type' => [
        1 => '支付宝',
        2 => '微信',
        3 => '银行转账',
        4 => '第三方支付'
    ],
    //充值状态
    'recharge_status' => [
        1 => '待确认',
        2 => '汇款成功',
        3 => '汇款失败'
    ],
    //提款状态
    'drawing_status' => [
        1 => '待确认',
        2 => '提款成功',
        3 => '提款失败'
    ],
    //用户状态
    'member_status' => [
        0 => '启用',
        1 => '禁用'
    ],
    //平台转账类型
    'transfer_type' => [
        0 => '转入游戏',
        1 => '转出游戏'
    ],
    'api_type' => [
        1 => 'AG',
        2 => 'MG',
        3 => 'BBIN'
    ],
    'productType' => [
        1 => 'AG',
        2 => 'MG',
        3 => 'BBIN'
    ],
    'on_line' => [
        0 => '上线',
        1 => '下线'
    ],
    'game_type' => [
        1 => '真人',
        2 => '捕鱼',
        3 => '电子',
        4 => '彩票',
        5 => '体育',
        6 => '棋牌',
        7 => '其他'
    ],
    'activity_type' => [
        1 => '返水活动',
        2 => '红利活动',
        3 => '充值活动',
        4 => '展示活动'
    ],
    'gender' => [
        0 => '男',
        1 => '女'
    ],
    'feedback_type' => [
        1 => '平台问题',
        2 => '财务问题',
        3 => '提供建议'
    ],
    'is_read' => [
        0 => '未读',
        1 => '已读'
    ],
    'productCode' => [
        3=> 'PT',
        12 => 'PNG'
    ],
    'tcg_game_type' => [
        'RNG' => 'RNG',
        'LIVE' => 'LIVE',
        'PVP' => 'PVP'
    ],
    'tcg_client_type' => [
        'pc' => 'pc',
        'phone' => 'phone',
        'web' => 'web',
        'html5' => 'html5'
    ]
];