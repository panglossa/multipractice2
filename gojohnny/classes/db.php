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
class TDB {
	var $pdo = null;
	var $type = 'sqlite';
	var $dbname = 'gojohnny.sqlite';
	var $dbhost = 'localhost';
	var $result = null;
	var $connected = false;
	var $server = ''; //used by informix
	var $protocol = 'onsoctcp'; //used by informix
	var $tables = array();
	var $pdofetchmode = PDO::FETCH_ASSOC;
	var $gjversion = '7.0';
	///////////////////////////////////////////////////////
	public function __construct(
		$adatabase = 'gojohnny.sqlite', /*Corresponds to the file name in SQLite and Firebird, to the database name in other drivers*/
		$atype = 'sqlite', 
		$auser = 'root', /*ignored in sqlite; default value for MySQL*/
		$apassword = '',  /*ignored in sqlite; default value for MySQL*/
		$ahost = 'localhost',  /*ignored in sqlite; default value for MySQL*/
		$aport = 3306, /*ignored in sqlite; default value for MySQL*/
		$aserver = '', /*used by informix*/
		$aprotocol = 'onsoctcp' /*used by informix*/
		){
		$this->dbname = $adatabase;
		$this->database = &$this->dbname;
		$this->type = strtolower($atype);
		$this->user = $auser;
		$this->password = $apassword;
		$this->dbhost = $ahost;
		$this->host = &$this->dbhost;
		$this->port = $aport;
		$this->server = $aserver;
		$this->protocol = $aprotocol;
		
		$this->defaultconditionconjunction = 'AND';
		$this->defaultconditionoperator = '=';
		$this->connect();
		if ($this->connected){
			$this->tables = $this->listtables();
			}
		}
	///////////////////////////////////////////////////////
	function connect(){
		try {
			switch ($this->type) {
				case 'sqlite':
					$this->pdo = new PDO("sqlite:{$this->dbname}");
					$this->result = true;
					$this->connected = true;
					break;
				case 'mysql':
					$this->pdo = new PDO("mysql:dbname={$this->dbname};port={$this->port};host={$this->host};charset=utf8;", $this->user, $this->password);
					$this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
					$this->result = true;
					$this->connected = true;
					break;
				case 'cubrid':
					$this->pdo = new PDO("cubrid:host={$this->host};port={$this->port};dbname={$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'dblib':
					$this->pdo = new PDO("dblib:host={$this->host}:{$this->port};dbname={$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'mssql':
					$this->pdo = new PDO("mssql:host={$this->host};port={$this->port};dbname={$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'firebird':
					$this->pdo = new PDO("firebird:dbname={$this->host}:{$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'ibm':
					$this->pdo = new PDO("odbc:{$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'informix':
					$this->pdo = new PDO("informix:host={$this->dbhost};service={$this->port};database={$this->dbname}; server={$this->server}; protocol={$this->protocol};EnableScrollableCursors=1", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'oci':
					$this->pdo = new PDO("oci:dbname={$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'odbc':
					$this->pdo = new PDO("mysql:dbname={$this->dbname};port={$this->port};host={$this->host}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'sybase':
					$this->pdo = new PDO("sybase:host={$this->host};dbname={$this->dbname}, {$this->user}, {$this->password}");
					$this->result = true;
					$this->connected = true;
					break;
				case 'memory':
					$this->pdo = new PDO("sqlite::memory:");
					$this->result = true;
					$this->connected = true;
					break;
				}
			}catch(PDOException $e){
			$this->result = $e->getMessage();
			$this->connected = false;
			}
		return $this->connected;
		}
	///////////////////////////////////////////////////////
	function listtables(){
		////////////////////////////////////////////
		//Does this work with all database drivers?
		////////////////////////////////////////////
		$res = array();
		$tmp = $this->pdo->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_SCHEMA='{$this->database}';");
		if ($tmp!==false){
			foreach($tmp as $row){
				$res[] = $row['TABLE_NAME'];
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function createtable($name = '', $fields = array(), $options = array()){
		if($this->connected){
			$error = false;
			}else{
			$error = 'Not connected.';
			}
		$name = trim($name);
		
		if(
			($name!='')
			&&
			(
				(
					(is_array($fields))
					&&(count($fields)>0)
					)
				||
				(
					(is_string($fields))
					&&
					(trim($fields)!='')
				)
			)
			){
			$q = "CREATE TABLE IF NOT EXISTS `{$name}` (\n";
			$f = '';
			if (is_array($fields)){
				if (count($fields)>0){
					foreach($fields as $field){
						if((is_array($field))&&((((isset($field['name']))&&(trim($field['name'])!=''))&&((isset($field['type']))&&(trim($field['type'])!=''))))){
							if ($f!=''){
								$f .= ",\n";
								}
							//regex desperately needed!
							$field['type'] = trim(strtolower($field['type']));
							$field['type'] = str_replace('int ', 'integer ', $field['type']);
							$field['type'] = str_replace('int(', 'integer(', $field['type']);
							if ($field['type']=='int'){
								$field['type'] = 'integer';
								}
							if ($field['type']=='char'){
								$field['type'] = 'char(255)';
								}
							if ($field['type']=='varchar'){
								$field['type'] = 'varchar(255)';
								}
							if(!isset($field['null'])){
								$field['null'] = false;
								}
							$f .= "`{$field['name']}` {$field['type']}";
							if (isset($field['collate'])){
								$f .= " COLLATE {$field['collate']}";
								}
							if ((isset($field['unique']))&&($field['unique']!=false)){
								$f .= ' UNIQUE';
								}
							if ((isset($field['primary']))&&($field['primary']!=false)){
								switch($this->type){
									case 'mysql':
										if (is_array($options)){
											$options['primary'] = $field['name'];
											}
										$field['autoincrement'] = true;
										break;
									case 'sqlite':
										$f .= ' PRIMARY KEY';
										break;
									}
								
								}
							if (isset($field['autoincrement'])){
								if ($this->type=='sqlite'){
									$f .= ' AUTOINCREMENT';
									}else{
									$f .= ' AUTO_INCREMENT';
									}
								}
							if (isset($field['default'])){
								$f .= ' DEFAULT ' . $this->pdo->quote($field['default']);
								}
							if (
								($field['null']==true)
								||
								($field['null']==1)
								||
								(strtolower($field['null'])=='null')
								){
								$f .= ' NULL';
								}else{
								$f .= ' NOT NULL';
								}
							}else{
							$error = 'You need to provide at least a name and a type for each column.';
							}
						}
					}else{
					$error = 'You need to provide at least one field definition.';
					}
				}else{
				$f = "{$fields}\n";
				}
			$q .= $f;
			if (is_array($options)){
				if(isset($options['primary'])){
					switch($this->type){
						case 'mysql':
							$q .= ",\nPRIMARY KEY (`{$options['primary']}`)";
							break;
						}
					}
				}
			$q .= "\n) ";
			if (is_array($options)){
				if (isset($options['engine'])){
					$q .= " ENGINE={$options['engine']}";
					}
				if (isset($options['charset'])){
					$q .= " DEFAULT CHARSET={$options['charset']}";
					}
				if (isset($options['collate'])){
					$q .= " COLLATE={$options['collate']}";
					}
				if (isset($options['autoincrement'])){
					$q .= " AUTO_INCREMENT={$options['autoincrement']}";
					}
				
				}else if (is_string($options)){
				$q .= " {$options};";
				}
			$q .= ';';
			}
		
		try{
			//echo $q;
			$error = $this->pdo->prepare($q)->execute();
			}catch(PDOException $e){
			$error = $e->getMessage();
			}
		return $error;
		}
	///////////////////////////////////////////////////////
	function exec($q){
		if($this->connected){
			return $this->pdo->exec($q);
			}
		}
	///////////////////////////////////////////////////////
	function query($s){
		$res = array();
		try{
			//echo "\n<br/>{$s}<br/>\n";
			$tmp = $this->pdo->prepare($s);
			$tmp->execute();
			}catch(PDOException $e){
			return false;
			}
		$i = 0;
		
		if ($tmp!=false){
			while ($row = $tmp->fetch($this->pdofetchmode)){
				if(count($row)>0){
					if(isset($row['id'])){
						$res[$row['id']] = $row;
						}else{
						$res[$i++] = $row;
						}
					}
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function rawquery($s, $fetchmode = 'num'){
		switch ($fetchmode) {
			case 'lazy':
				$fetchmode = PDO::FETCH_LAZY;
				break;
			case 'assoc':
				$fetchmode = PDO::FETCH_ASSOC;
				break;
			case 'named':
				$fetchmode = PDO::FETCH_NAMED;
				break;
			case 'props_late':
				$fetchmode = PDO::FETCH_PROPS_LATE;
				break;
			case 'serialize':
				$fetchmode = PDO::FETCH_SERIALIZE;
				break;
			case 'classtype':
				$fetchmode = PDO::FETCH_CLASSTYPE;
				break;
			case 'keypair':
			case 'key_pair':
				$fetchmode = PDO::FETCH_KEY_PAIR;
				break;
			case 'unique':
				$fetchmode = PDO::FETCH_UNIQUE;
				break;
			case 'group':
				$fetchmode = PDO::FETCH_GROUP;
				break;
			case 'into':
				$fetchmode = PDO::FETCH_INTO;
				break;
			case 'func':
				$fetchmode = PDO::FETCH_FUNC;
				break;
			case 'class':
				$fetchmode = PDO::FETCH_CLASS;
				break;
			case 'column':
				$fetchmode = PDO::FETCH_COLUMN;
				break;
			case 'bound':
				$fetchmode = PDO::FETCH_BOUND;
				break;
			case 'obj':
				$fetchmode = PDO::FETCH_OBJ;
				break;
			case 'both':
				$fetchmode = PDO::FETCH_BOTH;
				break;
			default:
				$fetchmode = PDO::FETCH_NUM;
			}
		$res = array();
		try{
			$tmp = $this->pdo->prepare($s);
			$tmp->execute();
			}catch(PDOException $e){
			return false;
			}
		if ($tmp!=false){
			while ($row = $tmp->fetch($fetchmode)){
				$res[] = $row;
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function gettable($tablename = '', $what = '*', $conditions = array(), $limit = 0, $order = '', $dir = ''){
		require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'auxclasses' . DIRECTORY_SEPARATOR . 'db_table.php');
		$fields = array();
		/*
		get field definitions from table in the database
		*/
		/*
		for SQLite:
		$result = $pdo->query("PRAGMA table_info(" . $table_name . ")");
$result->setFetchMode(PDO::FETCH_ASSOC);
$meta = array();
foreach ($result as $row) {
  $meta[$row['name']] = array(
    'pk' => $row['pk'] == '1',
    'type' => $row['type'],
  );
}
		*/
		$select = $this->pdo->query("SELECT * FROM {$tablename}");
		for ($i = 0; $i < $select->columnCount(); $i++) {
			$info = $select->getColumnMeta($i);
		    $fields[] = array(
		    	'name' => $info['name'],
		    	'type' => $info['native_type'],
		    	'length' => $info['len'],
		    	'collation' => '',
		    	'attributes' => '',
		    	'null' => $info['flags'][0],
		    	'primary' => (
		    		(count($info['flags'])>1)
		    		&&
		    		($info['flags'][1]=='primary_key')
		    		),
		    	'default' => '',
		    	'autoincrement' => false,
		    	'comments' => '',
		    	'values' => ''
		    	);
			}
		if(count($fields)>0){
			$res = new TDBTable($tablename, $fields);
			}else{
			$res = false;
			}
		return $res;
		
		}
	///////////////////////////////////////////////////////
	function fetchtable($tablename){
		return $this->fetch($tablename);
		}
	///////////////////////////////////////////////////////
	function fetch($options = array()){
		$res = null;
		$tablename = '';
		$what = '*';
		$conditions = array();
		$limit = 0;
		$order = '';
		$dir = '';
		if (is_array($options)){
			if (isset($options['table'])) {
				$tablename = $options['table'];
				if (isset($options['what'])) {
					$what = $options['what'];
					} else if (isset($options['columns'])) {
					$what = $options['columns'];
					} else if (isset($options['cols'])) {
					$what = $options['cols'];
					}
				if (isset($options['conditions'])) {
					$conditions = $options['conditions'];
					} else if (isset($options['condition'])) {
					$conditions = $options['condition'];
					} else if (isset($options['where'])) {
					$conditions = $options['where'];
					}
				if (isset($options['limit'])) {
					$limit = $options['limit'];
					}
				if (isset($options['order'])) {
					$order = $options['order'];
					}
				if (isset($options['dir'])) {
					$dir = $options['dir'];
					}
				}
			}else if (is_string($options)) {
			//$options is a table name
			$tablename = $options;
			}
		if ($tablename!='') {
			$res = $this->select($tablename, $what, $conditions, $limit, $order, $dir);
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function select($tablename = '', $what = '*', $conditions = array(), $limit = 0, $order = '', $dir = ''){
		//echo "[{$limit}]";
		$res = array();
		$tablename = trim($tablename);
		if($tablename==''){
			$res = 'Please provide a table name.';
			}else{
			if (is_array($what)){
				$what = implode(',', $what);
				}else{
				if (trim($what)==''){
					$what = '*';
					}
				}
			$where = trim($this->processconditions($conditions));
			if ($where=='1'){
				$where = '';
				}else{
				$where = " WHERE {$where}";
				}
			if(($limit===0)||($limit=='0')){
				$limit = '';
				}else{
				$limit = " LIMIT {$limit}";
				}
			//echo "[{$limit}]";
			if(trim($order)!=''){
				$order = " ORDER BY {$order}";
				$dir = trim(strtoupper($dir));
				if(($dir=='ASC')||($dir=='DESC')){
					$order .= " {$dir}";
					}
				}
			if ($where!=''){
				//$limit = '';
				}
			$s = "SELECT {$what} FROM {$tablename}{$where}{$order}{$limit};";
			//echo "[{$s}]\n\n";
			return $this->query($s);
			}
		}
	///////////////////////////////////////////////////////
	function getrow($tablename = '', $what = '*', $conditions = array(), $limit = 1, $order = '', $dir = ''){
		$res = array();
		$data = $this->select($tablename, $what, $conditions, $limit, $order, $dir);
		foreach($data as $row){
			$res = $row;
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function getfirstrow($tablename = '', $what = '*', $conditions = array(), $order = '', $dir = ''){
		$res = false;
		$data = $this->select($tablename, $what, $conditions, 1, $order, $dir);
		foreach($data as $row){
			if ($res === false){
				$res = $row;
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function getlastrow($tablename = '', $what = '*', $conditions = array(), $order = '', $dir = ''){
		$res = array();
		$data = $this->select($tablename, $what, $conditions, 0, $order, $dir);
		foreach($data as $row){
			$res = $row;
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function getcol($tablename = '', $col = 'id', $conditions = array(), $limit = 0, $order = '', $dir = ''){
		$res = array();
		$data = $this->select($tablename, $col, $conditions, $limit, $order, $dir);
		foreach($data as $row){
			if (isset($row[$col])){
				$res[] = $row[$col];
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function getval($tablename = '', $col = 'id', $key = 'id', $val = '-1', $operator = '='){
		$res = '';
		//echo "[{$val}]";
		if (trim($key)!=''){
			$data = $this->select(
				$tablename, 
				$col, 
				$this->processconditions(
					array(
						array(
							'key' => $key, 
							'operator' => $operator, 
							'val' => $val
							)
						)
					),
				1
				);
			foreach($data as $row){
				if (isset($row[$col])) {
					$res = $row[$col];
					}
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function insert($tablename = '', $data = array()){
		//echo "[{$tablename}]";
		//print_r($data);
		$tablename = trim($tablename);
		if ($tablename!=''){
			//we have a tablename
			if ((is_array($data))&&(count($data)>0)){
				if((isset($data[0]))&&(is_array($data[0]))){
					$res = true;
					foreach($data as $row){
						$keys = '';
						$vals = '';
						foreach($row as $key => $val){
							if ($keys!=''){
								$keys .= ', ';
								}
							$keys .= "`{$key}`";
							if ($vals!=''){
								$vals .= ', ';
								}
							$vals .= ":{$key}";
							}
						$res = (($res) && ($this->prepexec("INSERT INTO `{$tablename}` ({$keys}) VALUES ({$vals});", $row)));
						}
					return $res;
					}else{
					$keys = '';
					$vals = '';
					foreach($data as $key => $val){
						if ($keys!=''){
							$keys .= ', ';
							}
						$keys .= "`{$key}`";
						if ($vals!=''){
							$vals .= ', ';
							}
						$vals .= ":{$key}";
						}
					//print_r("INSERT INTO `{$tablename}` ({$keys}) VALUES ({$vals});");
					//print_r($data);
					return $this->prepexec("INSERT INTO `{$tablename}` ({$keys}) VALUES ({$vals});", $data);
					}
				}else{
				return false;
				}
			//////////////
			}
		}
	///////////////////////////////////////////////////////
	function update($tablename = '', $data = array(), $condition = ''){
		if ($condition==''){
			echo '***********WHY THE HELL ARE YOU UPDATING WITHOUT WHERE?????***********';
			}else{
			$vals = array();
			$fields = array();
			foreach($data as $key => $val){
				$fields[] = "{$key} = :{$key}";
				$vals[":{$key}"] = $val;
				}
			$fields = implode(', ', $fields);
			$querystring = "UPDATE {$tablename} SET {$fields} WHERE {$condition};";
			//echo $querystring;
			$prep = $this->pdo->prepare($querystring);
			return $prep->execute($vals);
			}
		}
	///////////////////////////////////////////////////////
	function OLDupdate($tablename = '', $data = array(), $condition = ''){
		if ($condition==''){
			echo '***********WHY THE HELL ARE YOU UPDATING WITHOUT WHERE?????***********';
			}else{
			$tablename = trim($tablename);
			if ($tablename!=''){
				$condition = $this->processconditions($condition);
				$items = '';
				if ((is_array($data))&&(isAssoc($data))&&(count($data))>0){
					foreach($data as $key => $val){
						if ($items!=''){
							$items .= ', ';
							}
						$items .= "`{$key}` = '{$val}'";
						}
					$q = "UPDATE `{$tablename}` SET {$items} WHERE {$condition};";
					//echo "[{$q}]\n";
					$this->query($q);
					//return $this->prepexec("UPDATE `{$tablename}` SET {$items} WHERE {$condition};", $data);
					//}else{
					//return false;
					}
				}
			}
		}
	///////////////////////////////////////////////////////
	function updateorinsert($tablename = '', $data = array(), $condition = ''){
		$row = $this->select($tablename, '*', $condition);
		if(count($row)>0){
			$this->update($tablename, $data, $condition);
			}else{
			$this->insert($tablename, $data);
			}
		}
	///////////////////////////////////////////////////////
	function prepexec($querystring = '', $data = array()){
		$prep = $this->pdo->prepare($querystring);
        //print_r($querystring);
        //print_r($data);
        //print_r($this);
		return $prep->execute($data);
		}
	///////////////////////////////////////////////////////
	function processconditions($conditions = array()){
		$where = '';
		if (is_array($conditions)){
			//conditions are passed as an array; process it before using
			$where = '';
			foreach($conditions as $c){
				if (is_array($c)){
					if (count($c)>1){
						//a valid condition must have at least a key and a value
						if ($where!=''){
							//if this is not the first condition, we need a conjunction (AND, OR)
							if(!isset($c['conj'])){
								if(isset($c['conjunction'])){
									$c['conj'] = $c['conjunction'];
									}else{
									//use the default conjunction, which is AND unless the user sets it otherwise
									$c['conj'] = $this->defaultconditionconjunction;
									}
								}
							$where .= " {$c['conj']} ";
							}
						if (
							(isset($c['key']))
							&&
							(isset($c['val']))
							&&
								(
								(isset($c['op']))
								||
								(isset($c['operator']))
								)
							){
							//all fields are set by name
							//make sure the 'op' field holds a valid operator
							if (!isset($c['op'])){
								if(isset($c['operator'])){
									$c['op'] = $c['operator'];
									}else{
									//touch the field
									$c['op'] = '';
									}
								}
							if (trim($c['op'])==''){
								//use the default conditions operator, which is '=' unless the user sets it otherwise
								$c['op'] = $this->defaultconditionoperator;
								}
							$where .= "`{$c['key']}` {$c['op']} '{$c['val']}'";
							}else{
							//at least one field is not set by name; assume the order: [key] [operator] [value]
							if(count($c)>2){
								$where .= "`{$c[0]}` {$c[1]} '{$c[2]}'";
								}else{
								//only two fields; assume order: [key] [value], use a default operator
								$where .= "`{$c[0]}` {$this->defaultconditionoperator} '{$c[1]}'";
								}
							}
						}else{
						//or else we assume it refers to the default 'id' field
						$where .= "`id` {$this->defaultconditionoperator} '{$c[0]}'";
						}
					}else{
					$where .= "`id` {$this->defaultconditionoperator} '{$c}'";
					}
				}
			}else{
			//conditions are passed as a string; use it as is
			$where = $conditions;
			}
		if ((trim($where)=='')||(trim($where)=='*')){
			$where = '1';
			}
		//echo "{$where}\n<br>";
		return trim($where);
		}
	///////////////////////////////////////////////////////
	function delete($tablename, $conditions = array(), $limit = 0){
		$conditions = $this->processconditions($conditions);
		if ($limit>0){
			$limit = "LIMIT {$limit}";
			}else{
			$limit = '';
			}
		$q = "DELETE FROM {$tablename} WHERE {$conditions}{$limit};";
		//echo "[{$q}]\n";
		$this->query($q);
		}
	///////////////////////////////////////////////////////
	function countrows($tablename = '', $what = 'id', $conditions = array()){
		$res = -1;
		if (trim($tablename)!=''){
			if (trim($what)==''){
				$what = '*';
				}
			if (is_array($conditions)){
				if (count($conditions)==0){
					$conditions = '';
					}
				}
			if (is_string($conditions)){
				if (trim($conditions)==''){
					$conditions = '1';
					}
				}
			//echo "[select count({$what}) from {$tablename} where {$conditions}]";
			$c3 = $this->query("select count({$what}) from {$tablename} where {$conditions}");
			$res = $c3[0]["count({$what})"];
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function rowcount($tablename = '', $what = 'id', $conditions = array()){
		return $this->countrows($tablename, $what, $conditions);
		}
	///////////////////////////////////////////////////////
	}
