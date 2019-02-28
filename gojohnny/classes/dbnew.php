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
class TDB2 {
	var $pdo = null;
	var $type = 'sqlite';
	var $dbname = 'gojohnny.sqlite';
	var $dbhost = 'localhost';
	var $result = null;
	var $connected = false;
	var $server = ''; //used by informix
	var $protocol = 'onsoctcp'; //used by informix
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
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
			$this->result = $e->getMessage();
			$this->connected = false;
			}
		
		return $this->connected;
		}
	///////////////////////////////////////////////////////
	function createtable($table){
		$s = "CREATE TABLE IF NOT EXISTS `{$table->name}` (\n";
		$f = array();
		foreach($table->fields as $field){
			$f[] = $this->dbfieldtostring($field);
			}
		$s .= implode(", \n", $f);
		$s .= "\n);";
		$this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		try {
			$this->pdo->exec($s);
			} catch(PDOException $e) {
    		//echo $e->getMessage();//Remove or change message in production code
			}
		}
	///////////////////////////////////////////////////////
	function createconfigtable(){
		$this->createtable(new TDBConfigTable());
		}
	///////////////////////////////////////////////////////
	function dbfieldtostring($field){
		if (strtolower($field->type)=='int'){
			$field->type = 'INTEGER';
			} 
		$res = "`{$field->name}` {$field->type}";
		if ($field->notnull){
			$res .= ' NOT NULL';
			}
		if ($field->default!=null){
			$res .= " DEFAULT '{$field->default}'";
			}
		if ($field->primary){
			$res .= ' PRIMARY KEY';
			}
		if ($field->autoincrement){
			$res .= ' AUTOINCREMENT';
			}
		if ($field->unique){
			$res .= ' UNIQUE';
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function prepexec($querystring = '', $data = array()){
		$prep = $this->pdo->prepare($querystring);
		return $prep->execute($data);
		}
	///////////////////////////////////////////////////////
	///////////////////////////////////////////////////////
	///////////////////////////////////////////////////////
	///////////////////////////////////////////////////////
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
class TDBTable {
	var $fields = array();
	var $name = '';
	public function __construct(){
		$args = func_get_args();
		if (count($args)>0){
			$this->name = $args[0];
			unset($args[0]);
			if (count($args)>0){
				$this->fields = $args;
				}
			}
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
class TDBConfigTable  extends TDBTable {
	public function __construct(){
		parent::__construct(
			'config',
			new TDBIdField(),
			new TDBField('key', 'VARCHAR(255)', true),
			new TDBField('val', 'TEXT'),
			new TDBField('info', 'TEXT')
			);
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
class TDBField {
	var $name = '';
	var $type = '';
	var $notnull = false;
	var $primary = false;
	var $autoincrement = false;
	var $unique = false;
	var $default = null;
	
	public function __construct($aname, $atype, $isnotnull = false, $defaultvalue = null, $pk = false, $ai = false, $isunique = false){
		$this->name = $aname;
		$this->type = $atype;
		$this->notnull = $isnotnull;
		$this->primary = $pk;
		$this->autoincrement = $ai;
		$this->unique = $isunique;
		$this->default = $defaultvalue;
		}
	}	

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
class TDBIDField extends TDBField {
	public function __construct(){
		parent::__construct('id', 'int', false, null, true, true, false);
		}
	
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
class TDBQuery {
	var $db = null;
	var $select = null;
	var $selectrow = null;
	var $insert = null;
	var $update = null;
	
	public function __construct($adb){
		$this->db = &$adb;
		$this->select = new TDBAction($this->db, 'select');
		$this->selectrow = new TDBAction($this->db, 'selectrow');
		$this->insert = new TDBAction($this->db, 'insert');
		$this->update = new TDBAction($this->db, 'update');
		}
	function insert($tablename = '', $data = array()){
		$this->insert->table = $tablename;
		$this->insert->values = $data;
		return $this->insert->execute();
		}
	
	function select($tablename = '', $what = '*', $conditions = array(), $limit = 0, $order = '', $dir = ''){
		$this->select->table = $tablename;
		$this->select->what = $what;
		$this->select->where = $conditions;
		$this->select->limit = $limit;
		$this->select->order = $order;
		$this->select->dir = $dir;
		return $this->select->execute();
		}
	
	function selectrow($tablename = '', $what = '*', $conditions = array(), $order = '', $dir = ''){
		$this->selectrow->table = $tablename;
		$this->selectrow->what = $what;
		$this->selectrow->where = $conditions;
		$this->selectrow->order = $order;
		$this->selectrow->dir = $dir;
		return $this->selectrow->execute();
		}
		
	function update($tablename = '', $data = array(), $condition = ''){
		$this->update->table = $tablename;
		$this->update->values = $data;
		$this->update->where = $condition;
		return $this->update->execute();
		}
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
class TDBAction {
	var $action = '';
	var $db;
	var $table = '';
	var $where = array();
	var $what = '*';
	var $values = array();
	var $limit = 0;
	var $order = '';
	var $dir = 'ASC';
		
	public function __construct($adb, $anaction = ''){
		$this->action = $anaction;
		$this->db = $adb;
		switch($this->action){
			case 'select':
			case 'selectrow':
				unset($this->values);
				break;
			case 'insert':
			case 'update':
				unset($this->where);
				unset($this->what);
				unset($this->limit);
				unset($this->order);
				unset($this->dir);
				break;
			}
			
		}
	function execute(){
		$fname = "execute_{$this->action}";
		return $this->$fname();
		}
		
	function execute_select(){
		$params = array();
		$s = 'SELECT ';
		if (is_array($this->what)){
			$s .= implode(',', $this->what);
			}else{
			$s .= $this->what;
			}
		$s .= " FROM {$this->table} WHERE ";
		if (is_array($this->where)){
			if (count($this->where)==0){
				$s .= '1';
				}else{
				$clauses = array();
				foreach ($this->where as $field => $clause){
					if (is_array($clause)){
						if (count($clause)>1){
							if (strtoupper($clause[0])=='LIKE'){
								$params[":{$field}"] = "%{$clause[1]}%";
								$clauses[] = "{$field} {$clause[0]} :{$field}";
								}else{
								$params[":{$field}"] = $clause[1];
								$clauses[] = "{$field} {$clause[0]} :{$field}";
								}
							}
						}else{
						$params[":{$field}"] = $clause;
						$clauses[]= "{$field} = :{$field}";
						}
					}
				$s .= implode(' AND ', $clauses);
				}
			}else{
			if (trim($this->where)==''){
				$this->where = '1';
				}
			$s .= $this->where;
			}
		if((!$this->limit===0)&&(!$this->limit=='0')){
			$s .= " LIMIT {$this->limit}";
			}
		if(trim($this->order)!=''){
			$s .= " ORDER BY {$this->order}";
			$this->dir = trim(strtoupper($this->dir));
			if(($this->dir=='ASC')||($this->dir=='DESC')){
				$s .= " {$this->dir}";
				}
			}
		$s .= ';';
		$stmt = $this->db->pdo->prepare($s);
		$stmt->execute($params);
		return $stmt->fetchAll();
		}	
		
	function execute_selectrow(){
		$this->limit = 1;
		$rows = $this->execute_select();
		$res = array();
		foreach($rows as $row){
			$res = $row;
			}
		return $res;
		}	
		
	function execute_insert(){
		$tablename = trim($this->table);
		$data = $this->values;
		if ($tablename!=''){
			if ((is_array($data))&&(count($data)>0)){
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
					return $this->db->prepexec("INSERT INTO `{$tablename}` ({$keys}) VALUES ({$vals});", $data);
					}
				}else{
				return false;
				}
		}	
		
	function execute_update(){
		$params = array();
		$fields = array();
		foreach($this->values as $key => $val){
			$fields[] = "{$key} = :{$key}";
			$params[":{$key}"] = $val;
			}
		$condition = '';
		if (is_array($this->where)){
			if (count($this->where)>0){
				$clauses = array();
				foreach ($this->where as $field => $clause){
					if (is_array($clause)){
						if (count($clause)>1){
							if (strtoupper($clause[0])=='LIKE'){
								$params[":{$field}"] = "%{$clause[1]}%";
								$clauses[] = "{$field} {$clause[0]} :{$field}";
								}else{
								$params[":{$field}"] = $clause[1];
								$clauses[] = "{$field} {$clause[0]} :{$field}";
								}
							}
						}else{
						$params[":{$field}"] = $clause;
						$clauses[]= "{$field} = :{$field}";
						}
					}
				$condition = implode(' AND ', $clauses);				
				}else{
				}
			}else{
			$condition = trim($this->where);
			}
		if ($condition=='') {
			echo '***********WHY THE HELL ARE YOU TRYING TO UPDATE WITHOUT WHERE?????***********';
			}else{
			$fields = implode(', ', $fields);
			$querystring = "UPDATE {$this->table} SET {$fields} WHERE {$condition};";
			return $this->db->prepexec($querystring, $params);
			//return $prep->execute($params);
			}
		}
	
	}