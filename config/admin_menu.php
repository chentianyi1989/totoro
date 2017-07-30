<?php

return [
    'system' =>[
        'name' => '系统管理',
        'icon' => 'fa fa-cog',
        'router' => '',
        'is_hide' => 1,
        'submenus' => [
            [
                'title' => '管理员列表',
                'router' => 'user.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '新增管理员',
                        'router' => 'user.store'
                    ],
                    [
                        'name' => '编辑管理员',
                        'router' => 'user.update'
                    ]
                ]
            ],
            [
                'title' => '管理组',
                'router' => 'role.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '新增管理组',
                        'router' => 'role.store'
                    ],
                    [
                        'name' => '编辑管理组',
                        'router' => 'role.update'
                    ],
                    [
                        'name' => '关联权限',
                        'router' => 'role.update'
                    ]
                ]
            ],
//            [
//                'title' => '管理员操作日志',
//                'router' => '',
//                'icon' => 'fa fa-circle-o',
//                'is_hide' => 0,
//                'actions' => [
//
//                ]
//            ],
            [
                'title' => '银行卡设置',
                'router' => 'bank_card.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '新增银行卡',
                        'router' => 'bank_card.store'
                    ],
                    [
                        'name' => '编辑银行卡',
                        'router' => 'bank_card.update'
                    ],
                    [
                        'name' => '删除银行卡',
                        'router' => 'bank_card.destroy'
                    ]
                ]
            ],
            [
                'title' => '修改余额记录',
                'router' => 'admin_action_money_log.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                ]
            ],
            [
                'title' => '系统设置',
                'router' => 'system_config.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '编辑系统设置',
                        'router' => 'system_config.update'
                    ]
                ]
            ],
//            [
//                'title' => 'IP设置',
//                'router' => 'black_list_ip.index',
//                'icon' => 'fa fa-circle-o',
//                'is_hide' => 1,
//                'actions' => [
//                    [
//                        'name' => '新增黑名单IP',
//                        'router' => 'black_list_ip.store'
//                    ],
//                    [
//                        'name' => '编辑黑名单IP',
//                        'router' => 'black_list_ip.update'
//                    ],
//                    [
//                        'name' => '删除黑名单IP',
//                        'router' => 'black_list_ip.destroy'
//                    ]
//                ]
//            ],
//            [
//                'title' => '系统日志',
//                'router' => '',
//                'icon' => 'fa fa-circle-o',
//                'is_hide' => 0,
//                'actions' => [
//
//                ]
//            ]
        ]
    ],
    'member' => [
        'name' => '用户管理',
        'icon' => 'fa fa-users',
        'router' => '',
        'is_hide' => 1,
        'submenus' => [
            [
                'title' => '用户列表',
                'router' => 'member.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '查看用户',
                        'router' => 'member.show'
                    ],
                    [
                        'name' => '编辑用户',
                        'router' => 'member.update'
                    ],
                    [
                        'name' => '禁用用户',
                        'router' => 'member.check'
                    ],
                    [
                        'name' => '删除用户',
                        'router' => 'member.destroy'
                    ]
                ]
            ],
//            [
//                'title' => '用户消息',
//                'router' => '',
//                'icon' => 'fa fa-circle-o',
//                'is_hide' => 1,
//                'actions' => [
//
//                ]
//            ],
            [
                'title' => '用户红利',
                'router' => 'dividend.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ],
//            [
//                'title' => '银行卡',
//                'router' => '',
//                'icon' => 'fa fa-circle-o',
//                'is_hide' => 1,
//                'actions' => [
//
//                ]
//            ],
            [
                'title' => '登录日志',
                'router' => 'member_login_log.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ],
            [
                'title' => '游戏记录',
                'router' => 'game_record.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ],
            [
                'title' => '平台转账记录',
                'router' => 'transfer.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ]
        ]
    ],
    'money' => [
        'name' => '财务管理',
        'icon' => 'fa fa-money',
        'router' => '',
        'is_hide' => 1,
        'submenus' => [
//            [
//                'title' => '银行汇款',
//                'router' => 'recharge_bank.index',
//                'icon' => 'fa fa-circle-o',
//                'is_hide' => 1,
//                'actions' => [
//
//                ]
//            ],
//            [
//                'title' => '支付宝汇款',
//                'router' => 'recharge_ali.index',
//                'icon' => 'fa fa-circle-o',
//                'is_hide' => 1,
//                'actions' => [
//
//                ]
//            ],
//            [
//                'title' => '微信汇款',
//                'router' => 'recharge_weixin.index',
//                'icon' => 'fa fa-circle-o',
//                'is_hide' => 1,
//                'actions' => [
//
//                ]
//            ],
            [
                'title' => '充值',
                'router' => 'recharge.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '确认充值',
                        'router' => 'recharge.confirm'
                    ],
                    [
                        'name' => '不确认充值',
                        'router' => 'recharge.update'
                    ],
                ]
            ],
            [
                'title' => '提款',
                'router' => 'drawing.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '确认提款',
                        'router' => 'drawing.confirm'
                    ],
                    [
                        'name' => '不确认提款',
                        'router' => 'drawing.update'
                    ],
                ]
            ]
        ]
    ],
    'daili' => [
        'name' => '代理管理',
        'icon' => 'fa fa-list',
        'router' => '',
        'is_hide' => 1,
        'submenus' => [
            [
                'title' => '代理审核',
                'router' => 'member_daili_apply.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '审核代理',
                        'router' => 'member_daili_apply.show'
                    ],
                    [
                        'name' => '编辑代理',
                        'router' => 'member_daili_apply.update'
                    ]
                ]
            ],
            [
                'title' => '代理列表',
                'router' => 'member_daili.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '新增代理',
                        'router' => 'member_daili.store'
                    ],
                    [
                        'name' => '编辑代理',
                        'router' => 'member_daili.update'
                    ],
                    [
                        'name' => '删除代理',
                        'router' => 'member_daili.destroy'
                    ]
                ]
            ],
            [
                'title' => '下线会员',
                'router' => 'member_offline.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ],
            [
                'title' => '会员存款记录',
                'router' => 'member_offline_recharge.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ],
            [
                'title' => '会员提款记录',
                'router' => 'member_offline_drawing.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ],
            [
                'title' => '会员领取红利记录',
                'router' => 'member_offline_dividend.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ],
            [
                'title' => '会员输赢报表',
                'router' => 'member_offline_game_record.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ],
            [
                'title' => '发放佣金',
                'router' => 'send_daili_money.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '发放佣金',
                        'router' => 'send_daili_money.store'
                    ]
                ]
            ],
            [
                'title' => '佣金记录',
                'router' => 'daili_money_log.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ],
            [
                'title' => '佣金等级',
                'router' => 'yj_level.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '新增佣金等级',
                        'router' => 'yj_level.store'
                    ],
                    [
                        'name' => '编辑佣金等级',
                        'router' => 'yj_level.update'
                    ],
                    [
                        'name' => '删除佣金等级',
                        'router' => 'yj_level.destroy'
                    ]
                ]
            ]
        ]
    ],
    'fs' => [
        'name' => '返水管理',
        'icon' => 'fa fa-gg',
        'router' => '',
        'is_hide' => 1,
        'submenus' => [
            [
                'title' => '返水等级',
                'router' => 'fs_level.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '新增返水等级',
                        'router' => 'fs_level.store'
                    ],
                    [
                        'name' => '编辑返水等级',
                        'router' => 'fs_level.update'
                    ],
                    [
                        'name' => '删除返水等级',
                        'router' => 'fs_level.destroy'
                    ]
                ]
            ],
            [
                'title' => '一键返水',
                'router' => 'send_fs.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '发放返水',
                        'router' => 'send_fs.store'
                    ]
                ]
            ],
            [
                'title' => '返水记录',
                'router' => 'fs.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ]
        ]
    ],
    'activity' => [
        'name' => '活动管理',
        'icon' => 'fa fa-map-o',
        'router' => '',
        'is_hide' => 1,
        'submenus' => [
            [
                'title' => '活动列表',
                'router' => 'activity.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '新增活动',
                        'router' => 'activity.store'
                    ],
                    [
                        'name' => '编辑活动',
                        'router' => 'activity.update'
                    ],
                    [
                        'name' => '删除活动',
                        'router' => 'activity.destroy'
                    ]
                ]
            ],
            [
                'title' => '新增活动',
                'router' => 'activity.create',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [

                ]
            ]
        ]
    ],
    'system_notice' => [
        'name' => '内容管理',
        'icon' => 'fa fa-link',
        'router' => '',
        'is_hide' => 1,
        'submenus' => [
            [
                'title' => '系统公告',
                'router' => 'system_notice.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '新增系统公告',
                        'router' => 'system_notice.store'
                    ],
                    [
                        'name' => '编辑系统公告',
                        'router' => 'system_notice.update'
                    ],
                    [
                        'name' => '删除系统公告',
                        'router' => 'system_notice.destroy'
                    ]
                ]
            ],
            [
                'title' => '站内消息',
                'router' => 'message.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '新增站内消息',
                        'router' => 'message.store'
                    ],
                    [
                        'name' => '编辑站内消息',
                        'router' => 'message.update'
                    ],
                    [
                        'name' => '删除站内消息',
                        'router' => 'message.destroy'
                    ]
                ]
            ]
        ]
    ],
    'api' => [
        'name' => '接口管理',
        'icon' => 'fa fa-paper-plane-o',
        'router' => '',
        'is_hide' => 1,
        'submenus' => [
            [
                'title' => '接口列表',
                'router' => 'api.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                    [
                        'name' => '新增接口',
                        'router' => 'api.store'
                    ],
                    [
                        'name' => '编辑接口',
                        'router' => 'api.update'
                    ],
                    [
                        'name' => '删除接口',
                        'router' => 'api.destroy'
                    ]
                ]
            ]
        ]
    ],
    'personal' => [
        'name' => '个人资料',
        'icon' => 'fa fa-paper-plane-o',
        'router' => '',
        'is_hide' => 0,
        'submenus' => [
            [
                'title' => '个人资料',
                'router' => 'personal.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 0,
                'actions' => [
                    [
                        'name' => '编辑个人资料',
                        'router' => 'user.personal.post'
                    ]
                ]
            ]
        ]
    ],
    'feedback' => [
        'name' => '反馈管理',
        'icon' => 'fa fa-commenting-o',
        'router' => '',
        'is_hide' => 1,
        'submenus' => [
            [
                'title' => '反馈列表',
                'router' => 'feedback.index',
                'icon' => 'fa fa-circle-o',
                'is_hide' => 1,
                'actions' => [
                ]
            ]
        ]
    ]
//    'platform' => [
//        'name' => '平台管理',
//        'icon' => 'fa fa-paper-plane-o',
//        'router' => '',
//        'is_hide' => 1,
//        'submenus' => [
//            [
//                'title' => '平台账户余额',
//                'router' => 'api.index',
//                'icon' => 'fa fa-circle-o',
//                'is_hide' => 1,
//                'actions' => [
//                    [
//                        'name' => '新增接口',
//                        'router' => 'api.store'
//                    ],
//                    [
//                        'name' => '编辑接口',
//                        'router' => 'api.update'
//                    ],
//                    [
//                        'name' => '删除接口',
//                        'router' => 'api.destroy'
//                    ]
//                ]
//            ]
//        ]
//    ]
];