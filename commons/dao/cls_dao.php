<?php
/**
 * 数据持久层 底层封装
 * 
 * @author chenty
 *
 */
class DataSource {
	
	var $db;
	
	function DataSource($db)
	{
		$this->db = $db;
	}
	
	/**
	 * 得到数据库指定条件的行数
	 * @param $table
	 * @param $where
	 * @return unknown_type
	 */
	function get_count($table,$where)
	{
		$sql = "select * from ".DB_PREFIX."$table $where";
		$query = $this->db->query($sql);
		return $this->db->num_rows($query);
	}
	
	/**
	 * 得到分页数据
	 * @param $table
	 * @param $where
	 * @param $order
	 * @param $pageno
	 * @param $pagesize
	 * @return unknown_type
	 */
	function get_page($table,$where,$order,$pageno,$pagesize)
	{
		$offset = $pagesize * ($pageno - 1);
		$sql = "select * from ".DB_PREFIX."$table $where $order limit $offset,$pagesize";
		//echo $sql;
		$query = $this->db->query($sql);
		$datas = array();
		$row = $this->db->fetch_array($query);
		while($row)
		{
			$datas[] = $row;
			$row = $this->db->fetch_array($query);
		}
		$result = array();
		
		$result['datas'] = $datas;
		$sql = "select * from ".DB_PREFIX."$table $where";
		$query = $this->db->query($sql);
		//得到总数
		$sumnum = $this->db->num_rows($query);
		$result['sumnum'] = $sumnum;
		//得到总页数
		$result['pagenum'] = $sumnum%$pagesize==0 ? $sumnum/$pagesize : (int)($sumnum/$pagesize)+1;
		return $result;
	}
	
	/**
	 * 获取信息
	 * @param $table
	 * @param $where
	 * @return unknown_type
	 */
	function select($table,$where)
	{
		$sql = "select * from ".DB_PREFIX."$table $where";
		return $this->query($sql);
	}
	
	
	
	/**
	 * 执行查询sql
	 * @param $sql
	 * @return unknown_type
	 */
	function query($sql) {
		$query = $this->db->query($sql);
		return $this->db->fetch_array($query);
	}
	
	/**
	 * 更新信息
	 * @param $table
	 * @param $updates
	 * @param $where
	 * @return unknown_type
	 */
	function update($table,$updates,$where)
	{
		$sql = "update ".DB_PREFIX."$table set ";
		foreach ($updates as $key => $value)
		{
			$sql .= $key . "=" .$value .",";
		}
		$sql = substr($sql,0,strlen($sql)-1);
		$sql .= " $where";
		$this->db->query($sql);
	}
	
	/**
	 * 插入数据
	 * @param $table
	 * @param $inserts
	 * @return unknown_type
	 */
	function insert($table,$inserts)
	{
		$sql = "insert into ".DB_PREFIX."$table({keys}) values({values})";
		$keys = "";
		$values = "";
		foreach ($inserts as $key => $value)
		{
			$keys .= $key . ",";
			$values .= "'".$value."',";
		}
		$keys = substr($keys,0,strlen($keys)-1);
		$values = substr($values,0,strlen($values)-1);
		$sql = str_replace('{keys}',$keys,$sql);
		$sql = str_replace('{values}',$values,$sql);
		$this->db->query($sql);
	}
	
	
	/**
	 * 删除数据
	 * @param $table
	 * @param $where
	 * @return unknown_type
	 */
	function delete($table,$where)
	{
		$sql = "delete from ".DB_PREFIX."$table $where";
		$this->db->query($sql);
	}
	
}

?>