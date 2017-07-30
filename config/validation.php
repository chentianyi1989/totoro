<?php

return [
    'member' => [
        'register_one' => [
            'name' => [
                'name' => '用户名',
                'rules' => 'required|min:7|max:10|unique:members',
                'message' => ['min' => '用户名最少为7位', 'max' => '用户名最多为10位','unique' => '该名称已存在']
            ],
            'password' => [
                'name' => '注册密码',
                'rules' => 'required|min:6|max:12|confirmed',
                'message' => ['min' => '密码最少为6位', 'max' => '密码最多为12位', 'confirmed' => '两次密码输入不一致']
            ],
            'check1' => [
                'name' => '条款一',
                'rules' => 'required',
                'message' => ['required' => '请同意勾选条款一']
            ],
            'check2' => [
                'name' => '条款二',
                'rules' => 'required',
                'message' => ['required' => '请同意勾选条款二']
            ],
        ],
        'register_two' => [
            'real_name' => [
                'name' => '真实姓名',
                'rules' => 'required|max:255',
                'message' => []
            ],
            'gender' => [
                'name' => '性别',
                'rules' => 'required',
                'message' => ['required' => '请选择 性别']
            ],
            'phone' => [
                'name' => '手机号码',
                'rules' => 'required|regex:/^1[34578]\d{9}$/',
                'message' => ['required' => '请填写 手机号码','regex'=> '请填写 正确的手机号码']
            ],
            'qq' => [
                'name' => '联系QQ',
                'rules' => 'required',
                'message' => []
            ],
            'email' => [
                'name' => '邮箱',
                'rules' => 'required|email|max:255|unique:members',
                'message' => []
            ],
            'qk_pwd' => [
                'name' => '取款密码',
                'rules' => 'required|numeric|min:6',
                'message' => []
            ]
        ],
        'login' => [
            'name' => [
                'name' => '用户名',
                'rules' => 'required|min:6|max:10',
                'message' => []
            ],
//            'email' => [
//                'name' => '注册邮箱',
//                'rules' => 'required|email|max:255|unique:members',
//                'message' => []
//            ],
            'password' => [
                'name' => '注册密码',
                'rules' => 'required|min:6',
                'message' => []
            ],
        ],
        'update_qk_password' => [
            'old_password' => [
                'name' => '原密码',
                'rules' => 'required|min:6',
                'message' => []
            ],
            'password' => [
                'name' => '新密码',
                'rules' => 'required|min:6|confirmed',
                'message' => ['confirmed' => '两次密码输入不一致']
            ],
        ],
        'update_login_password' => [
            'old_password' => [
                'name' => '原密码',
                'rules' => 'required|min:6',
                'message' => []
            ],
            'password' => [
                'name' => '新密码',
                'rules' => 'required|min:6|confirmed',
                'message' => ['confirmed' => '两次密码输入不一致']
            ],
        ],
        'update_bank_info' => [
            'bank_name' => [
                'name' => '收款银行',
                'rules' => 'required',
                'message' => ['required' => '请选择 收款银行']
            ],
            'bank_address' => [
                'name' => '开户地址',
                'rules' => 'required',
                'message' => []
            ],
            'bank_branch_name' => [
                'name' => '开户网点',
                'rules' => 'required',
                'message' => []
            ],
            'bank_username' => [
                'name' => '开户姓名',
                'rules' => 'required',
                'message' => []
            ],
            'bank_card' => [
                'name' => '银行账号',
                'rules' => 'required',
                'message' => []
            ],
        ],
        'post_weixin_pay' => [
            'money' => [
                'name' => '汇款金额',
                'rules' => 'required',
                'message' => []
            ],
            'account' => [
                'name' => '汇款账号',
                'rules' => 'required',
                'message' => []
            ],
            'paytime' => [
                'name' => '汇款时间',
                'rules' => 'required',
                'message' => []
            ]
        ],
        'post_ali_pay' => [
            'money' => [
                'name' => '汇款金额',
                'rules' => 'required',
                'message' => []
            ],
            'account' => [
                'name' => '汇款账号',
                'rules' => 'required',
                'message' => []
            ],
            'paytime' => [
                'name' => '汇款时间',
                'rules' => 'required',
                'message' => []
            ]
        ],
        'post_bank_pay' => [
            'money' => [
                'name' => '汇款金额',
                'rules' => 'required',
                'message' => []
            ],
            'payment_desc' => [
                'name' => '付款银行',
                'rules' => 'required',
                'message' => ['required' => '请选择 付款银行']
            ],
            'name' => [
                'name' => '付款户名',
                'rules' => 'required',
                'message' => []
            ],
            'account' => [
                'name' => '付款账号',
                'rules' => 'required',
                'message' => []
            ],
            'paytime' => [
                'name' => '汇款时间',
                'rules' => 'required',
                'message' => []
            ]
        ],
        'post_drawing' => [
            'money' => [
                'name' => '取款金额',
                'rules' => 'required',
                'message' => []
            ],
            'qk_pwd' => [
                'name' => '取款密码',
                'rules' => 'required',
                'message' => []
            ],
        ],
        'post_transfer' => [
            'account2' => [
                'name' => '游戏平台',
                'rules' => 'required',
                'message' => ['required' => '请选择 游戏平台']
            ],
            'money' => [
                'name' => '转换金额',
                'rules' => 'required',
                'message' => []
            ],
            'transfer_type' => [
                'name' => '转换类型',
                'rules' => 'required',
                'message' => ['required' => '请选择 转换类型']
            ],
        ],
        'post_feedback' => [
            'type' => [
                'name' => '反馈类型',
                'rules' => 'required',
                'message' => ['required' => '请选择 反馈类型']
            ],
            'content' => [
                'name' => '反馈内容',
                'rules' => 'required',
                'message' => []
            ],
            'phone' => [
                'name' => '手机号码',
                'rules' => 'required|regex:/^1[34578]\d{9}$/',
                'message' => ['required' => '请填写 手机号码','regex'=> '请填写 正确的手机号码']
            ]
        ],
        'update' => [
//            'password' => [
//                'name' => '登录密码',
//                'rules' => 'min:6|max:12',
//                'message' => []
//            ],
//            'qk_pwd' => [
//                'name' => '取款密码',
//                'rules' => 'numeric|min:6',
//                'message' => []
//            ]
            'phone' => [
                'name' => '手机号码',
                'rules' => 'required|regex:/^1[34578]\d{9}$/',
                'message' => ['required' => '请填写 手机号码','regex'=> '请填写 正确的手机号码']
            ],
            'email' => [
                'name' => '邮箱',
                'rules' => 'required|email|max:255',
                'message' => []
            ],
        ]
    ],
    'fs_level' => [
        'store' => [
            'level' => [
                'name' => '返水等级',
                'rules' => 'required',
                'message' => ['required' => '请选择 返水等级']
            ],
            'name' => [
                'name' => '等级名称',
                'rules' => 'required',
                'message' => []
            ],
            'quota' => [
                'name' => '额度',
                'rules' => 'required',
                'message' => []
            ],
            'rate' => [
                'name' => '返水比例',
                'rules' => 'required',
                'message' => []
            ],
        ]
    ],
    'black_list_ip' => [
        'store' => [
            'ip' => [
                'name' => 'IP地址',
                'rules' => 'required|ip',
                'message' => []
            ]
        ]
    ],
    'recharge' => [
        'confirm' => [
            'money' => [
                'name' => '充值金额',
                'rules' => 'required|min:1',
                'message' => []
            ],
            'diff_money' => [
                'name' => '赠送金额',
                'rules' => 'min:1',
                'message' => []
            ],
        ]
    ],
    'yj_level' => [
        'store' => [
            'level' => [
                'name' => '佣金等级',
                'rules' => 'required',
                'message' => ['required' => '请选择 佣金等级']
            ],
            'name' => [
                'name' => '等级名称',
                'rules' => 'required',
                'message' => []
            ],
            'min' => [
                'name' => '最小金额',
                'rules' => 'required',
                'message' => []
            ],
            'num' => [
                'name' => '活跃用户数量',
                'rules' => 'required|min:1',
                'message' => []
            ],
            'rate' => [
                'name' => '佣金比例',
                'rules' => 'required',
                'message' => []
            ],
        ]
    ],
    'send_daili_money' => [
        'store' => [
            'top_id' => [
                'name' => '代理',
                'rules' => 'required',
                'message' => ['required' => '请选择代理']
            ],
        ]
    ],
    'send_fs' => [
        'store' => [
            'member_id' => [
                'name' => '用户',
                'rules' => 'required',
                'message' => ['required' => '请选择用户']
            ],
        ]
    ],
    'member_daili' => [
        's_store' => [
            'member_id' => [
                'name' => '会员',
                'rules' => 'required',
                'message' => ['required' => '请选择 成为代理的会员']
            ]
        ]
    ],
    'api' => [
        'store' => [
            'api_name' => [
                'name' => '接口名称',
                'rules' => 'required',
                'message' => []
            ],
            'api_money' => [
                'name' => '接口余额',
                'rules' => 'required|min:0',
                'message' => []
            ],
        ]
    ],
    'system_notice' => [
        'store' => [
//            'title' => [
//                'name' => '标题',
//                'rules' => 'required',
//                'message' => []
//            ],
            'content' => [
                'name' => '内容',
                'rules' => 'required|min:0',
                'message' => []
            ],
        ]
    ],
    'message' => [
        'store' => [
            'title' => [
                'name' => '标题',
                'rules' => 'required',
                'message' => []
            ],
            'content' => [
                'name' => '内容',
                'rules' => 'required|min:0',
                'message' => []
            ],
            'send_member' => [
                'name' => '发送的用户',
                'rules' => 'required',
                'message' => ['required' => '请选择 发放的用户']
            ],
        ],
        'update' => [
            'title' => [
                'name' => '标题',
                'rules' => 'required',
                'message' => []
            ],
            'content' => [
                'name' => '内容',
                'rules' => 'required|min:0',
                'message' => []
            ]
        ]
    ],
    'bank_card' => [
        'store' => [
            'bank_id' => [
                'name' => '开户行',
                'rules' => 'required',
                'message' => []
            ],
            'username' => [
                'name' => '持卡人姓名',
                'rules' => 'required',
                'message' => []
            ],
            'card_no' => [
                'name' => '卡号',
                'rules' => 'required',
                'message' => []
            ]
        ]
    ],
    'activity' => [
        'store' => [
            'title' => [
                'name' => '活动标题',
                'rules' => 'required',
                'message' => []
            ],
//            'api' => [
//                'name' => '参与接口',
//                'rules' => 'required',
//                'message' => ['required' => '请选择 参与的接口']
//            ]
        ]
    ],
    'user' => [
        'personal' => [
            'name' => [
                'name' => '用户名',
                'rules' => 'required',
                'message' => []
            ],
            'email' => [
                'name' => '邮箱',
                'rules' => 'required|email',
                'message' => ['email' => '请填写 正确的邮箱地址']
            ],
//            'password' => [
//                'name' => '密码',
//                'rules' => 'min:6',
//                'message' => ['min' => '请至少输入6位字符密码']
//            ],
        ],
        'store' => [
            'name' => [
                'name' => '用户名',
                'rules' => 'required',
                'message' => []
            ],
            'email' => [
                'name' => '邮箱',
                'rules' => 'required|email',
                'message' => ['email' => '请填写 正确的邮箱地址']
            ],
            'password' => [
                'name' => '密码',
                'rules' => 'required|min:6',
                'message' => ['min' => '请至少输入6位字符密码']
            ],
        ],
        'update' => [
            'name' => [
                'name' => '用户名',
                'rules' => 'required',
                'message' => []
            ],
            'email' => [
                'name' => '邮箱',
                'rules' => 'required|email',
                'message' => ['email' => '请填写 正确的邮箱地址']
            ],
//            'password' => [
//                'name' => '密码',
//                'rules' => 'min:6',
//                'message' => ['min' => '请至少输入6位字符密码']
//            ],
        ]
    ],
    'role' => [
        'store' => [
            'name' => [
                'name' => '角色名',
                'rules' => 'required',
                'message' => []
            ]
        ],
        'relation' => [
            'routers' => [
                'name' => '权限',
                'rules' => 'required',
                'message' => ['']
            ]
        ]
    ],
    'member_offline' => [
        'store' => [
            'name' => [
                'name' => '用户名',
                'rules' => 'required|min:7|max:10|unique:members',
                'message' => ['min' => '用户名最少为7位', 'max' => '用户名最多为10位','unique' => '该名称已存在']
            ],
        ]
    ],
    'wap' => [
        'login' => [
            'name' => [
                'name' => '用户名',
                'rules' => 'required|min:7|max:10',
                'message' => []
            ],
            'password' => [
                'name' => '注册密码',
                'rules' => 'required|min:6',
                'message' => []
            ],
        ],
        'register' => [
            'name' => [
                'name' => '用户名',
                'rules' => 'required|min:7|max:10|unique:members',
                'message' => ['min' => '用户名最少为7位', 'max' => '用户名最多为10位','unique' => '该名称已存在']
            ],
            'password' => [
                'name' => '注册密码',
                'rules' => 'required|min:6|max:12|confirmed',
                'message' => ['min' => '密码最少为6位', 'max' => '密码最多为12位','confirmed' => '两次密码输入不一致']
            ],
            'real_name' => [
                'name' => '真实姓名',
                'rules' => 'required|max:255',
                'message' => []
            ],
            'qk_pwd' => [
                'name' => '取款密码',
                'rules' => 'required|numeric|min:6',
                'message' => ['min' => '取款密码 为6位数字']
            ]
        ],
        'post_transfer' => [
            'out_account' => [
                'name' => '转出账户',
                'rules' => 'required',
                'message' => ['required' => '请选择 转出账户']
            ],
            'in_account' => [
                'name' => '转入账户',
                'rules' => 'required',
                'message' => ['required' => '请选择 转入账户']
            ],
            'money' => [
                'name' => '转账金额',
                'rules' => 'required',
                'message' => []
            ]
        ],
        'post_weixin_pay' => [
            'money' => [
                'name' => '汇款金额',
                'rules' => 'required',
                'message' => []
            ],
            'account' => [
                'name' => '汇款账号',
                'rules' => 'required',
                'message' => []
            ],
            'paytime' => [
                'name' => '汇款时间',
                'rules' => 'required',
                'message' => []
            ]
        ],
        'post_ali_pay' => [
            'money' => [
                'name' => '汇款金额',
                'rules' => 'required',
                'message' => []
            ],
            'account' => [
                'name' => '汇款账号',
                'rules' => 'required',
                'message' => []
            ],
            'paytime' => [
                'name' => '汇款时间',
                'rules' => 'required',
                'message' => []
            ]
        ],
        'post_bank_pay' => [
            'money' => [
                'name' => '汇款金额',
                'rules' => 'required',
                'message' => []
            ],
            'payment_desc' => [
                'name' => '付款银行',
                'rules' => 'required',
                'message' => ['required' => '请选择 付款银行']
            ],
            'name' => [
                'name' => '付款户名',
                'rules' => 'required',
                'message' => []
            ],
            'account' => [
                'name' => '付款账号',
                'rules' => 'required',
                'message' => []
            ],
            'paytime' => [
                'name' => '汇款时间',
                'rules' => 'required',
                'message' => []
            ]
        ],
        'update_bank_info' => [
            'bank_name' => [
                'name' => '收款银行',
                'rules' => 'required',
                'message' => ['required' => '请选择 收款银行']
            ],
            'bank_address' => [
                'name' => '开户地址',
                'rules' => 'required',
                'message' => []
            ],
//            'bank_branch_name' => [
//                'name' => '开户网点',
//                'rules' => 'required',
//                'message' => []
//            ],
//            'bank_username' => [
//                'name' => '开户姓名',
//                'rules' => 'required',
//                'message' => []
//            ],
            'bank_card' => [
                'name' => '银行账号',
                'rules' => 'required',
                'message' => []
            ],
        ],
        'post_drawing' => [
            'money' => [
                'name' => '取款金额',
                'rules' => 'required',
                'message' => []
            ],
            'qk_pwd' => [
                'name' => '取款密码',
                'rules' => 'required',
                'message' => []
            ],
        ],
        'update_qk_password' => [
            'old_password' => [
                'name' => '原密码',
                'rules' => 'required|min:6',
                'message' => []
            ],
            'password' => [
                'name' => '新密码',
                'rules' => 'required|min:6|confirmed',
                'message' => ['confirmed' => '两次密码输入不一致']
            ],
        ],
        'update_login_password' => [
            'old_password' => [
                'name' => '原密码',
                'rules' => 'required|min:6',
                'message' => []
            ],
            'password' => [
                'name' => '新密码',
                'rules' => 'required|min:6|confirmed',
                'message' => ['confirmed' => '两次密码输入不一致']
            ],
        ],
        'post_agent_apply' => [
            'qq' => [
                'name' => 'QQ号码',
                'rules' => 'required',
                'message' => []
            ],
            'phone' => [
                'name' => '手机号码',
                'rules' => 'required|regex:/^1[34578]\d{9}$/',
                'message' => ['required' => '请填写 手机号码','regex'=> '请填写 正确的手机号码']
            ],
            'about' => [
                'name' => '申请理由',
                'rules' => 'required',
                'message' => []
            ]
        ],
        'post_set_phone' => [
            'phone' => [
                'name' => '手机号码',
                'rules' => 'required|regex:/^1[34578]\d{9}$/',
                'message' => ['required' => '请填写 手机号码','regex'=> '请填写 正确的手机号码']
            ],
        ]
    ]


];