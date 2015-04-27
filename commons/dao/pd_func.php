<?php 
function auto_send_msg($recvid,$count) {
	global $data_access;
	$user = $data_access->select("user","where uid=$recvid");
	$result = $data_access->get_page("msgconfig","","",1,10000000);
	$msglist = $result['datas'];
	for($i=0; $i<$count; $i++) {
		$sendcount = $data_access->get_count("user","where sex<>'$user[sex]'");
		$index = mt_rand(1,$sendcount);
		$send = $data_access->select("user","where sex<>'$user[sex]' limit $index,1");
		if($send) {
			$sendcount = count($msglist) - 1;
			$index = mt_rand(0,$sendcount);
			$inserts = array();
			$inserts['sendid'] = $send['uid'];
			$inserts['recvid'] = $recvid;
			$inserts['sendtime'] = date("Y-m-d G:i:s");
			$inserts['title'] = $msglist[$index]['title'];
			$inserts['content'] = $msglist[$index]['content'];
			$inserts['flag'] = 0;
			$data_access->insert("message",$inserts);
		}
	}
}

function ajax_callback($callback,$respath) {
	if(!empty($callback)) {
		$path = $respath."res/scripts/ajax.js";
		echo <<<HTML
		<script src="$path" type="text/javascript"></script>
		<script>
		var ajaxTool = new AJAXRequest;
		ajaxTool.get("$callback", function(obj) {});
		</script>	
HTML;
	}

}


?>