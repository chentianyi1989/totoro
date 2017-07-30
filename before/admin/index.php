<?

define('IN_ECS', true);
require_once '../commons/init.php';


//print_r($_SERVER);



$smarty->display("admin/index.html");




//require 'commons/smarty/libs/Smarty.class.php';
//
//$smarty = new Smarty;
//
//$smarty->template_dir="templates";	 //指定模版存放目录
//$smarty->compile_dir="templates_c";	 //指定编译文件存放目录
//$smarty->config_dir   =   'configs'; 
//$smarty->cache_dir   =   'cache'; 
//$smarty->caching   =   false; 
//
//$smarty->compile_check = true;
//$smarty->debugging = true;
//
//$smarty->assign("Name","Fred Irving Johnathan Bradley Peppergill");
//$smarty->assign("FirstName",array("John","Mary","James","Henry"));
//$smarty->assign("LastName",array("Doe","Smith","Johnson","Case"));
//$smarty->assign("Class",array(array("A","B","C","D"), array("E", "F", "G", "H"),
//	  array("I", "J", "K", "L"), array("M", "N", "O", "P")));
//
//$smarty->assign("contacts", array(array("phone" => "1", "fax" => "2", "cell" => "3"),
//	  array("phone" => "555-4444", "fax" => "555-3333", "cell" => "760-1234")));
//
//$smarty->assign("option_values", array("NY","NE","KS","IA","OK","TX"));
//$smarty->assign("option_output", array("New York","Nebraska","Kansas","Iowa","Oklahoma","Texas"));
//$smarty->assign("option_selected", "NE");
//
//$smarty->display('index.html');