<?php
error_reporting(7);
ob_start();
if (!defined('IN_ECS')) {
    die('Hacking attempt');
}
echo __FILE__.'<br/>';
echo chdir(dirname(__FILE__)).'<br/>';
echo str_replace('includes/init.php', '', str_replace('\\', '/', __FILE__));

define('root',dirname(__FILE__));
//define('ctx',dirname($_SERVER[SCRIPT_NAME]));
define('ctx',"/totoro");

//echo "<br/>root-->".root."<br/>ctx-->".ctx."<br/>REQUEST_URI-->".$_SERVER['REQUEST_URI'];


define('ONS_ROOT', dirname(__FILE__));

echo "<br/>ONS_ROOT-->".ONS_ROOT;


echo "<br/>".ONS_ROOT.'/smarty/cls_smarty.php';

include_once(ONS_ROOT.'/smarty/cls_smarty.php');
include_once(ONS_ROOT.'/dao/pd_base.php');
include_once(ONS_ROOT.'/dao/pd_func.php');
include_once(ONS_ROOT.'/dao/cls_mysql_config.php');
include_once(ONS_ROOT.'/dao/cls_mysql.php');
include_once(ONS_ROOT.'/dao/cls_dao.php');



date_default_timezone_set('PRC');
header('Content-Type: text/html; charset=UTF-8');
define('SITE_TITLE','acmilan');
define("KEY_SPACE","1234567890");
$mysql = new MySql(DB_HOST, DB_USER, DB_PASSWD, DB_NAME ,DB_UT);
$db = new DataSource($mysql);
$smarty = new cls_smarty();

//项目名称
$smarty->assign("projectName","totoro");
//当前用户
$smarty->assign("name","chentianyi");
//系统根路径
$smarty->assign("ctx",ctx);





