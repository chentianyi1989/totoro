<?php 
define('IN_ECS', true);

//require_once '/totoro/commons/init.php';

require_once dirname(__FILE__).'/../../commons/init.php';


$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") {
	
	
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	
}elseif ($act == "update") {
	
}elseif ($act == "del") {
	
}else {
	$users = $db->select("sys_user","where username='admin'");
	//$smarty->assign("users",$users);
	
	print_r($users);
	$smarty->display("admin/user/list.html");
}

?>