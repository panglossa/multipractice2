<?php
/*
Panglossa go!Johnny PHP library
version 7.0
release 2017-07-05
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Araçatuba - SP - Brazil - 2017
*/
////////////////////////////////////////////////
class TConfig {
	var $data = array();
	var $db = null;
	var $gjversion = '8.0';
	/*******************************/
	function __construct($afilename = 'config.php', $adb = null, $atablename = 'config'){
		$this->data = array('x' => 1, 'y' => 2);
		//echo "[{$afilename}]";
		if((trim($afilename)!='')and(file_exists($afilename))){
			require_once($afilename);
			}
		$this->tablename = $atablename;
		foreach($this->data as $key => $val){
			$this->$key = $val;
			}
		if($adb!=null){
			$this->db = &$adb;
			}else{
			if (isset($this->db_mode)) {
				
				if ($this->db_mode=='sqlite'){
					if (isset($this->db_database)) {
						$this->db = TDB($this->db_database, $this->db_mode);
						$this->inittable();
						}
					}else if ($this->db_mode=='mysql'){
					if ((isset($this->db_host))&&(isset($this->db_user))&&(isset($this->db_password))&&(isset($this->db_port))) {
						$this->db = TDB($this->db_database, $this->db_mode, $this->db_user, $this->db_password, $this->db_host, $this->db_port);
						$this->inittable();
						}
					}
				}
			}
		}
	/*******************************/
	function inittable(){
		if ($this->db_mode=='sqlite'){
			$createconfigtable = 'CREATE TABLE IF NOT EXISTS config (id INTEGER PRIMARY KEY  NOT NULL ,key varchar(255) NOT NULL , val text, info varchar(255) DEFAULT (null) );';
			$this->db->query($createconfigtable);
			}else if ($this->db_mode=='mysql'){
			$createconfigtable = "CREATE TABLE IF NOT EXISTS `config` (  `id` int(11) NOT NULL,   `key` varchar(255) NOT NULL,   `val` text,   `info` text);";
			$this->db->query($createconfigtable);
			$this->db->query("ALTER TABLE `config` ADD PRIMARY KEY (`id`);");
			$this->db->query("ALTER TABLE `config` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
			}
		
		}
	/*******************************/
	function set($values = array(), $optional = null){
		if(is_array($values)){
			foreach($values as $key => $item){
				if(is_array($item)){
					$this->set($item);
					}else{
					$this->data[$key] = $item;
					$this->$key = & $this->data[$key];
					}
				}
			}else if (is_string($values)){
			if(($optional != null)or(!isset($this->data[$values]))){
				$this->data[$values] = $optional;
				$this->$values = & $this->data[$values];
				}
			}
		}
	/*******************************/
	function get($ids = array()){
		if(is_array($ids)){
			$res = array();
			foreach($ids as $id){
				if(isset($this->data[$id])){
					$res[$id] = $this->data[$id];
					}else{
					$res[$id] = '';
					}
				}
			}else if(is_string($ids)){
			$res = '';
			if(isset($this->data[$ids])){
				$res = $this->data[$ids];
				}
			return $res;
			}
		}
	/*******************************/
	function val($items = array()){
		if (is_array($items)){
			$res = array();
			foreach($items as $item){
				if(is_array($item)){
					foreach($item as $key =>$val){
						$this->set($key, $val);
						$res[$key] = $val;
						}
					}else{
					$res[$item] = $this->get($item);
					}
				}
			return $res;
			}else{
			return $this->get($items);
			}
		}
	/*******************************/
	function db_set($values = array(), $optional = null){
		if($this->db!=null){
			if(is_array($values)){
				foreach($values as $key => $item){
					if(is_array($item)){
						$this->db_set($item);
						}else{
						$this->data[$key] = $item;
						$this->$key = &$this->data[$key];
						$this->db->updateorinsert($this->tablename, array('key' => $key, 'val' => $item), "`key` = '{$key}'");
						}
					}
				}else if (is_string($values)){
				if(($optional !== null)or(!isset($this->data[$values]))){
					$this->data[$values] = $optional;
					$this->$values = & $this->data[$values];
					$this->db->updateorinsert($this->tablename, array('key' => $values, 'val' => $optional), "`key` = '{$values}'");
					}
				}
			}else{
			$this->set($values, $optional);
			}
		}
	/*******************************/
	function db_get($ids = array()){
		if($this->db!=null){
			if(is_array($ids)){
				$res = array();
				foreach($ids as $id){
					$res[$id] = '';
					$d = $this->db->select($this->tablename, 'val', "key = {$id}");
					if($d!=null){
						$res[$id] = $d;
						}
					}
				$this->set($res);
				return $res;
				}else{
				$res = '';
				$res[$ids] = '';
				$d = $this->db->select($this->tablename, 'val', "key = {$id}");
				if($d!=null){
					$res = $d;
					}
				$this->set($ids, $res);
				return $res;
				}
			}else{
			return $this->get($ids);
			}
		}	
	/*******************************/
	function db_val($items = array()){
		if($this->db!=null){
			if (is_array($items)){
				$res = array();
				foreach($items as $item){
					if(is_array($item)){
						foreach($item as $key =>$val){
							$this->db_set($key, $val);
							$res[$key] = $val;
							}
						}else{
						$res[$item] = $this->db_get($item);
						}
					}
				return $res;
				}else{
				return $this->db_get($items);
				}
			}else{
			return $this->val($items);
			}
		}	
	/*******************************/
	function readdb(){
		if($this->db!=null){
			$this->inittable();
			$items = $this->db->select($this->tablename);
			foreach($items as $item){
				$this->set($item['key'], $item['val']);
				}
			}
		}
	/*******************************/
	}
////////////////////////////////////////////////
?>