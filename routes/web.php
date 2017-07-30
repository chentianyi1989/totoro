<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['domain' => 'm.mxxfun.com', 'namespace' => 'Wap'],function ($router)
{
    Route::get('/','IndexController@index')->name('wap.init');

});

Route::group(['domain' => 'admin.mxxfun.com'],function ($router)
{
    $router->get('/', 'Admin\AuthController@getLogin')->name('admin.init');
});
//二级域名指向
Route::group(['domain' => 'agent.mxxfun.com'],function ($router)
{
    $router->get('/', 'Daili\AuthController@getLogin')->name('daili.init');
});

Route::get('/maintain', 'Web\IndexController@maintain')->name('web.maintain');

Route::any('/wechat', 'WechatController@serve');

Route::group(['prefix' => 'sync','namespace' => 'Sync'],function ($router)
{

    Route::get('/getPtGameList/{type}', 'SyncController@getPtGameList')->name('sync.getPtGameList');
    Route::get('/getTcgGameRecord', 'SyncController@getTcgGameRecord')->name('sync.getTcgGameRecord');

});

//手机
Route::group(['domain' => 'm.mxxfun.com', 'prefix' => 'm','namespace' => 'Wap'],function ($router)
{
    $router->get('/', 'IndexController@index')->name('wap.index');

    //pt游戏列表
    $router->get('pt/live_game_list', 'IndexController@pt_live_game_list')->name('pt.live_game_list');
    $router->get('pt/rng_game_list', 'IndexController@pt_rng_game_list')->name('pt.rng_game_list');

    $router->get('login', 'LoginController@showLoginForm')->name('wap.login');

    $router->post('login', 'LoginController@postLogin')->name('wap.login.post');
    $router->post('logout', 'LoginController@logout')->name('wap.logout');

    $router->get('register', 'IndexController@register')->name('wap.register');
    $router->post('register', 'IndexController@postRegister')->name('wap.register.post');

    //需要登录
    Route::group(['middleware' => 'auth.member:member'],function ($router){
        //
        $router->get('userinfo', 'IndexController@userinfo')->name('wap.userinfo');

        $router->get('agent', 'IndexController@agent')->name('wap.agent');
        $router->get('agent_apply', 'IndexController@agent_apply')->name('wap.agent_apply');
        $router->post('agent_apply', 'IndexController@post_agent_apply')->name('wap.post_agent_apply');

        //设置手机
        $router->get('set_phone', 'IndexController@set_phone')->name('wap.set_phone');
        $router->post('set_phone', 'IndexController@post_set_phone')->name('wap.post_set_phone');

        $router->get('bind_bank', 'IndexController@bind_bank')->name('wap.bind_bank');
        $router->post('bind_bank', 'IndexController@post_bind_bank')->name('wap.post_bind_bank');
        //提款
        $router->get('drawing', 'IndexController@drawing')->name('wap.drawing');
        $router->post('drawing', 'IndexController@post_drawing')->name('wap.post_drawing');

        $router->get('drawing_record', 'IndexController@drawing_record')->name('wap.drawing_record');
        $router->get('game_record', 'IndexController@game_record')->name('wap.game_record');
        $router->get('recharge_record', 'IndexController@recharge_record')->name('wap.recharge_record');
        $router->get('transfer_record', 'IndexController@transfer_record')->name('wap.transfer_record');
        //
        $router->get('daili_money_log', 'IndexController@daili_money_log')->name('wap.daili_money_log');
        $router->get('member_offline', 'IndexController@member_offline')->name('wap.member_offline');
        $router->get('member_offline_recharge', 'IndexController@member_offline_recharge')->name('wap.member_offline_recharge');
        $router->get('member_offline_drawing', 'IndexController@member_offline_drawing')->name('wap.member_offline_drawing');
        $router->get('member_offline_sy', 'IndexController@member_offline_sy')->name('wap.member_offline_sy');

        //充值
        $router->get('recharge', 'IndexController@recharge')->name('wap.recharge');
        $router->get('weixin_pay', 'IndexController@weixin_pay')->name('wap.weixin_pay');
        $router->post('weixin_pay', 'IndexController@post_weixin_pay')->name('wap.post_weixin_pay');
        $router->get('ali_pay', 'IndexController@ali_pay')->name('wap.ali_pay');
        $router->post('ali_pay', 'IndexController@post_ali_pay')->name('wap.post_ali_pay');
        $router->get('bank_pay', 'IndexController@bank_pay')->name('wap.bank_pay');
        $router->post('bank_pay', 'IndexController@post_bank_pay')->name('wap.post_bank_pay');
        //第三方
        $router->get('third_bank_pay', 'IndexController@third_bank_pay')->name('wap.third_bank_pay');
        $router->get('third_pay_scan', 'IndexController@third_pay_scan')->name('wap.third_pay_scan');

        $router->get('recharge_record', 'IndexController@recharge_record')->name('wap.recharge_record');

        $router->get('reset_password', 'IndexController@reset_password')->name('wap.reset_password');
        $router->post('reset_login_password', 'IndexController@reset_login_password')->name('wap.reset_login_password');
        $router->post('reset_qk_password', 'IndexController@reset_qk_password')->name('wap.reset_qk_password');

        $router->get('transfer', 'IndexController@transfer')->name('wap.transfer');
        $router->post('transfer', 'IndexController@post_transfer')->name('wap.post_transfer');

        $router->get('transfer_record', 'IndexController@transfer_record')->name('wap.transfer_record');

        //游戏列表
        $router->get('ag/eGame_list', 'IndexController@ag_eGame_list')->name('wap.ag_eGame_list');
        $router->get('mg/eGame_list', 'IndexController@mg_eGame_list')->name('wap.mg_eGame_list');
    });


});

//前台用户
Route::group(['namespace' => 'Web', 'middleware' => 'web.maintain'],function ($router)
{
    Route::get('/', 'IndexController@index')->name('web.index');
    Route::get('activities', 'IndexController@activityList')->name('web.activityList');
    Route::get('activity/{id}', 'IndexController@activityDetail')->name('web.activityDetail');
    Route::get('liveCasino', 'IndexController@liveCasino')->name('web.liveCasino');
    Route::get('egame', 'IndexController@egame')->name('web.egame');
    Route::get('esports', 'IndexController@esports')->name('web.esports');
    Route::get('lottory', 'IndexController@lottory')->name('web.lottory');
    Route::get('catchFish', 'IndexController@catchFish')->name('web.catchFish');

    //
    $router->get('register_one', 'IndexController@register_one')->name('web.register_one');
    $router->post('register_one', 'IndexController@post_register_one')->name('web.post_register_one');
    $router->get('register_two', 'IndexController@register_two')->name('web.register_two');
    $router->post('register_two', 'IndexController@post_register_two')->name('web.post_register_two');
    $router->get('register_success', 'IndexController@register_success')->name('web.register_success');
    $router->get('login', 'IndexController@login')->name('web.login');

    //需要登录
//    Route::group(['middleware' => 'auth.member:member'],function ($router){
//        $router->get('member_center', 'MemberController@member_center')->name('member.member_center');
//
//        //异步加载页面
//        $router->get('sync/{name}', 'IndexController@syncTpl')->name('sync.tpl');
//    });

});

//前台用户
Route::group(['prefix' => 'member','namespace' => 'Member'],function ($router)
{
    //$router->get('login', 'LoginController@showLoginForm')->name('member.login');
    //$router->get('register', 'RegisterController@showRegisterForm')->name('member.register');
//    $router->post('register', 'RegisterController@store')->name('member.register.post');
    $router->post('login', 'LoginController@postLogin')->name('member.login.post');
    $router->post('logout', 'LoginController@logout')->name('member.logout');
    $router->get('password/request', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    //需要登录
    Route::group(['middleware' => 'auth.member:member'],function ($router){
        //个人资料
        $router->get('/userCenter', 'IndexController@userCenter')->name('member.userCenter');
        $router->get('/bank_load', 'IndexController@bank_load')->name('member.bank_load');
        $router->get('/account_load', 'IndexController@account_load')->name('member.account_load');
        $router->get('/update_bank_info', 'IndexController@update_bank_info')->name('member.update_bank_info');
        $router->post('/update_bank_info', 'IndexController@post_update_bank_info')->name('member.post_update_bank_info');
        $router->get('/message_list', 'IndexController@message_list')->name('member.message_list');
        $router->get('/messageList', 'AsyncController@messageList')->name('member.messageList');

        $router->get('api/check', 'ApiClientController@check')->name('member.api.check');
        //安全管理
        $router->get('/safe_psw', 'IndexController@safe_psw')->name('member.safe_psw');
        $router->get('/login_psw', 'IndexController@login_psw')->name('member.login_psw');
        $router->post('update_qk_password', 'IndexController@update_qk_password')->name('member.update_qk_password');
        $router->post('update_login_password', 'IndexController@update_login_password')->name('member.update_login_password');
        //财务中心
        $router->get('/finance_center', 'IndexController@finance_center')->name('member.finance_center');
        $router->get('/member_drawing', 'IndexController@member_drawing')->name('member.member_drawing');
        $router->get('/indoor_transfer', 'IndexController@indoor_transfer')->name('member.indoor_transfer');

        $router->get('recharge_type', 'IndexController@recharge_type')->name('member.recharge_type');
        $router->get('/weixin_pay', 'IndexController@weixin_pay')->name('member.weixin_pay');
        $router->post('/weixin_pay', 'IndexController@post_weixin_pay')->name('member.post_weixin_pay');
        $router->get('/ali_pay', 'IndexController@ali_pay')->name('member.ali_pay');
        $router->post('/ali_pay', 'IndexController@post_ali_pay')->name('member.post_ali_pay');
        $router->get('/bank_pay', 'IndexController@bank_pay')->name('member.bank_pay');
        $router->post('/bank_pay', 'IndexController@post_bank_pay')->name('member.post_bank_pay');
        $router->post('drawing', 'IndexController@post_drawing')->name('member.drawing');
        $router->post('/transfer', 'IndexController@post_transfer')->name('member.post_transfer');
        //客户报表
        $router->get('/customer_report', 'IndexController@customer_report')->name('member.customer_report');
        $router->get('/rechargeList', 'AsyncController@rechargeList')->name('member.rechargeList');
        $router->get('/drawingList', 'AsyncController@drawingList')->name('member.drawingList');
        $router->get('/transferList', 'AsyncController@transferList')->name('member.transferList');
        $router->get('/gameRecordList', 'AsyncController@gameRecordList')->name('member.gameRecordList');
        $router->get('/dividendList', 'AsyncController@dividendList')->name('member.dividendList');

        //服务中心
        $router->get('/service_center', 'IndexController@service_center')->name('member.service_center');
        $router->get('/complaint_proposal', 'IndexController@complaint_proposal')->name('member.complaint_proposal');
        $router->post('/feedback', 'IndexController@post_feedback')->name('member.post_feedback');

        //第三方支付
        //$router->get('pay', 'PayController@pay')->name('member.pay');
        $router->get('third_bank_pay', 'IndexController@third_bank_pay')->name('member.third_bank_pay');
        $router->get('third_pay_scan', 'IndexController@third_pay_scan')->name('member.third_pay_scan');
        Route::post('pay', 'PayController@pay')->name('pay');
        Route::post('pay_scan', 'PayController@pay_scan')->name('pay_scan');


    });

});

Route::group(['domain' => 'agent.mxxfun.com','prefix' => 'daili','namespace' => 'Daili'],function ($router){

    Route::get('/login', ['as' => 'daili.login','uses' => 'AuthController@getLogin']);
    Route::post('/login', ['as' => 'daili.login.post','uses' => 'AuthController@postLogin']);
    Route::get('/loginOut', ['as' => 'daili.login.out','uses' => 'AuthController@getLoginOut']);

    //需要登录
    Route::group(['middleware' => ['auth.daili']], function($router){
        //后台首页
        $router->get('/', 'DailiController@index')->name('daili.index');
        //系统设置
        //个人资料
        Route::resource("user", 'UserController');
        Route::get('personal', ['as' => 'user.personal', 'uses' => 'UserController@getPersonal']);
        Route::post('personal', ['as' => 'user.personal.post', 'uses' => 'UserController@postPersonal']);
        //代理
        //代理列表
        Route::get('member_daili', 'MemberDailiController@index')->name('daili.member_daili');
        //下线会员
        Route::get('member_offline', 'MemberOfflineController@index')->name('daili.member_offline');
        Route::get('member_offline/create', 'MemberOfflineController@create')->name('daili.member_offline.create');
        Route::post('member_offline/store', 'MemberOfflineController@store')->name('daili.member_offline.store');
        //下线会员存款记录
        Route::get('member_offline_recharge', 'MemberOfflineRechargeController@index')->name('daili.member_offline_recharge');
        //下线会员提款记录
        Route::get('member_offline_drawing', 'MemberOfflineDrawingController@index')->name('daili.member_offline_drawing');
        //下线会员红利记录
        Route::get('member_offline_dividend', 'MemberOfflineDividendController@index')->name('daili.member_offline_dividend');
        //下线会员输赢记录
        Route::get('member_offline_game_record', 'MemberOfflineGameRecordController@index')->name('daili.member_offline_game_record');
        //佣金记录
        Route::get('daili_money_log', 'DailiMoneyLogController@index')->name('daili.daili_money_log');

    });
});

Route::group(['domain' => 'admin.mxxfun.com','prefix' => 'admin','namespace' => 'Admin'],function ($router){

    Route::get('/login', ['as' => 'admin.login','uses' => 'AuthController@getLogin']);
    Route::post('/login', ['as' => 'admin.login.post','uses' => 'AuthController@postLogin']);
    Route::get('/loginOut', ['as' => 'admin.login.out','uses' => 'AuthController@getLoginOut']);
    $router->get('hk_notice', 'AdminController@hk_notice')->name('admin.hk_notice');
    $router->get('tk_notice', 'AdminController@tk_notice')->name('admin.tk_notice');
    //需要登录
    Route::group(['middleware' => ['authorize']], function($router){
        //后台首页
        $router->get('/', 'AdminController@index')->name('admin.index');
        //系统设置
        //个人资料
        Route::resource("user", 'UserController');
        Route::get('personal', ['as' => 'user.personal', 'uses' => 'UserController@getPersonal']);
        Route::post('personal', ['as' => 'user.personal.post', 'uses' => 'UserController@postPersonal']);
        //管理组
        Route::get('role/relation/{id}', ['as' => 'role.relation', 'uses' => 'RoleController@showRelation']);
        Route::post('role/relation/{id}', ['as' => 'role.relation.post', 'uses' => 'RoleController@relation']);
        Route::resource("role", 'RoleController');
        //系统配置
        Route::get('bank_card/check/{id}/{status}', 'BankCardController@check')->name('bank_card.check');
        Route::resource("bank_card", 'BankCardController');
        Route::resource("system_config", 'SystemConfigController');
        Route::resource("black_list_ip", 'BlackListIpController');
        Route::resource("admin_action_money_log", 'AdminActionMoneyLogController');


        //会员管理
        Route::get('member/check/{id}/{status}', 'MemberController@check')->name('member.check');
        //
        Route::get('member/showGameRecordInfo/{id}', 'MemberController@showGameRecordInfo')->name('member.showGameRecordInfo');
        Route::get('member/showRechargeInfo/{id}', 'MemberController@showRechargeInfo')->name('member.showRechargeInfo');
        Route::get('member/showDrawingInfo/{id}', 'MemberController@showDrawingInfo')->name('member.showDrawingInfo');
        Route::get('member/showDividendInfo/{id}', 'MemberController@showDividendInfo')->name('member.showDividendInfo');
        Route::resource('member', 'MemberController');
        //红利记录
        Route::resource('dividend', 'DividendController');
        //登录记录
        Route::resource('member_login_log', 'MemberLoginLogController');
        //游戏记录
        Route::resource('game_record', 'GameRecordController');
        //平台转账
        Route::resource('transfer', 'TransferController');


        //返水
        //返水等级
        Route::resource('fs_level', 'FsLevelController');
        Route::resource('send_fs', 'SendFsController');
        Route::resource('fs', 'FsController');


        //代理
        //代理审核
        Route::resource('member_daili_apply', 'MemberDailiApplyController');
        //代理列表
        Route::resource('member_daili', 'MemberDailiController');
        //下线会员
        Route::resource('member_offline', 'MemberOfflineController');
        //下线会员存款记录
        Route::resource('member_offline_recharge', 'MemberOfflineRechargeController');
        //下线会员提款记录
        Route::resource('member_offline_drawing', 'MemberOfflineDrawingController');
        //下线会员红利记录
        Route::resource('member_offline_dividend', 'MemberOfflineDividendController');
        //下线会员输赢记录
        Route::resource('member_offline_game_record', 'MemberOfflineGameRecordController');
        //佣金记录
        Route::get('daili_money_log/show_by_id/{id}', 'DailiMoneyLogController@show_by_id')->name('daili_money_log.show_by_id');
        Route::resource('daili_money_log', 'DailiMoneyLogController');
        //发放佣金
        Route::resource('send_daili_money', 'SendDailiMoneyController');
        //佣金等级
        Route::resource('yj_level', 'YjLevelController');

        //财务
        //充值、存款列表
        //微信
        Route::put('recharge_weixin/confirm/{id}', 'RechargeWeixinController@confirm')->name('recharge_weixin.confirm');//确认汇款成功
        Route::resource('recharge_weixin', 'RechargeWeixinController');
        //支付宝
        Route::put('recharge_ali/confirm/{id}', 'RechargeAliController@confirm')->name('recharge_ali.confirm');//确认汇款成功
        Route::resource('recharge_ali', 'RechargeAliController');
        //银行卡
        Route::put('recharge_bank/confirm/{id}', 'RechargeBankController@confirm')->name('recharge_bank.confirm');//确认汇款成功
        Route::resource('recharge_bank', 'RechargeBankController');

        Route::put('recharge/confirm/{id}', 'RechargeController@confirm')->name('recharge.confirm');//确认汇款成功
        Route::resource('recharge', 'RechargeController');
        //提款
        Route::put('drawing/confirm/{id}', 'DrawingController@confirm')->name('drawing.confirm');//确认提款成功
        Route::resource('drawing', 'DrawingController');
        //活动
        Route::get('activity/check/{id}/{status}', 'ActivityController@check')->name('activity.check');
        Route::resource('activity', 'ActivityController');

        //内容管理
        //系统公告
        Route::get('system_notice/check/{id}/{status}', 'SystemNoticeController@check')->name('system_notice.check');
        Route::resource('system_notice', 'SystemNoticeController');
        Route::resource('message', 'MessageController');
        //平台管理
        //接口列表
        Route::get('api/check/{id}/{status}', 'ApiController@check')->name('api.check');
        Route::resource('api', 'ApiController');

        //反馈
        Route::get('feedback/check/{id}/{status}', 'FeedbackController@check')->name('feedback.check');
        Route::resource('feedback', 'FeedbackController');

    });
});

//APi
Route::group(['namespace' => 'Api', 'middleware' => 'auth.member:member'],function ($router){
    //进游戏
    $router->get('ag/playGame', 'AgController@login')->name('ag.playGame');
    $router->get('bbin/playGame', 'BbinController@login')->name('bbin.playGame');
    $router->get('mg/playGame', 'MgController@login')->name('mg.playGame');
    $router->get('og/playGame', 'OgController@login')->name('og.playGame');
    $router->get('allbet/playGame', 'AllbetController@login')->name('allbet.playGame');
    $router->get('pt/playGame', 'PtController@login')->name('pt.playGame');
    $router->get('png/playGame', 'PngController@login')->name('png.playGame');
    $router->get('ebet/playGame', 'EbetController@login')->name('ebet.playGame');

    $router->get('mg_mobile/playGame', 'MgController@login_mobile')->name('mg_mobile.playGame');

    //查询余额 统一接口
    $router->get('api/check', 'ApiClientController@check')->name('member.api.check');

});

Route::any('upload', 'UploadController@upload')->name('upload.post');
Route::any('pay/notify', 'Member\PayController@notify')->name('pay.notify');
Route::get('pay/success', 'Member\PayController@success')->name('pay.success');