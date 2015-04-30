<?php 
define('IN_ECS', true);

require_once dirname(__FILE__).'/../../commons/init.php';


$act = $_REQUEST[act];

if (empty($act)) {
	$act = "list";	
}

if ($act == "list") {
	
	$db->select();
	
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	
}elseif ($act == "update") {
	
}elseif ($act == "del") {
	
}

?>