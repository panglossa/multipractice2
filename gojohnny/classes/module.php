<?php
/*
Panglossa go!Johnny PHP library
version 8.0
release 2017-07-05
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Araçatuba - SP - Brazil - 2017
*/

class TBaseModule {
	var $filename = 'modules/home.php';
	var $sections = array();
	var $parent = null;
	var $name = 'home';
	var $db = null;
	var $table = '';
	var $url = 'index.php?c=home';
	var $parameters = array();
	/*******************************/
	function __construct($aparent = null){
		if($aparent!=null){
			$this->parent = &$aparent;
			$this->parameters = &$this->parent->parameters;
			if (isset($this->parent->db)){
				$this->db = &$this->parent->db;
				}
			//if there is a customized module (plugin), load it
			//$this->name = $this->parent->modulename;
			$this->table = $this->name;
			$this->url = "index.php?c={$this->name}";
			$this->filename = "modules/{$this->name}.php";
			}
		}
	/*******************************/
	function add($what = '', $where = 'main'){
		if ((is_object($what))and(isset($what->printable))){
			$what = "{$what}";
			}
		if(trim($where)==''){
			$where = 'main';//required
			}
		if(isset($this->sections[$where])){
			$this->sections[$where] .= $what;
			}else{
			$this->sections[$where] = $what;
			}
		}
	/*******************************/
	function addmain(){
		foreach(func_get_args() as $item){
			$this->add($item);
			}
		}
	/*******************************/
	public function __toString(){
		$res = '';
		foreach($this->sections as $s){
			$res .= $s;
			}
		return $res;
		}
	/*******************************/
	function adderror($s){
		$this->add(o(array('class' => 'error'), TDiv($s)));
		}
	/*******************************/
	function addwarning($s){
		$this->add(o(array('class' => 'warning'), TDiv($s)));
		}
	/*******************************/
	function received(){
		$res = true;
		foreach (func_get_args() as $param){
			if (!(isset($this->parent->parameters[$param]))) {
				$res = false;
				}
			}
		return $res;
		}
	/*******************************/
	/*******************************/
	/*******************************/
	/*******************************/
	}
?>