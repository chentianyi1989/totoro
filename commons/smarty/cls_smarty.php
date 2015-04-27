<?
require 'libs/Smarty.class.php';

class cls_smarty {
	
//	var $smarty ;
       
	
	var $_var = array();
	function cls_smarty(){
		$this->smarty = new Smarty;
		
//		$this->smarty->compile_check = true;
//		$smarty->debugging = true;
		
		$this->smarty->template_dir="themes/default/admin";	//指定模版存放目录
        $this->smarty->compile_dir="themes/c";	 			//指定编译文件存放目录
        $this->smarty->config_dir="themes/config";	 		//指定配置文件存放目录
        $this->smarty->cache_dir="themes/cache";	 		//指定缓存存放目录
        $this->smarty->caching=false;	 					//关闭缓存（设置为true表示启用缓存）
        $this->smarty->left_delimiter="#{";	 				//指定左标签
//        $this->smarty->right_delimiter="}";	 			//指定右标签
	}
	
	/**
     * 注册变量
     * @access  public
     * @param   mix      $tpl_var
     * @param   mix      $value
     * @return  void
     */
    function assign($tpl_var, $value = ''){
    	
        $this->smarty->assign($tpl_var,$value);
    }
	
    /**
     * 跳转页面
     * @param $path
     * @return unknown_type
     */
    function display ($path) {
    	
    	$this->smarty->display($path);
    }
    
}


?>
