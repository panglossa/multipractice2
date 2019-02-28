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
class TForm extends TElement {
	/*******************************/
	function __construct($content = '', $action = null, $buttonlabel = 'OK'){
		parent::__construct();
		if (trim($action)=='') {
			$action = currenturl();
			}
		$this->p('action', $action);
		$this->p('accept-charset', GJ_CHARSET);
		$this->p('method', GJ_DEFAULTFORMMETHOD);
		$this->p('autocomplete', GJ_DEFAULTFORMAUTOCOMPLETE);
		$this->p('enctype', GJ_DEFAULTFORMENCTYPE);
		$this->p('novalidate', false);
		$this->buttonlabel = $buttonlabel;
		$this->button = '';
		if (is_array($content)){
			foreach($content as $row){
				$this->add($row);
				}
			}else{
			$this->add($content);
			}
		}
	/*******************************/
	function submitlink($caption = 'OK', $fields = array()){
		$res = '';
		if(trim($caption)==''){
			$caption = $this->buttonlabel;
			}
		if(!is_array($fields)){
			$fields = array(trim($fields));
			}
		$this->setID();
		if (count($fields)>0){
			$fields = "'" . implode("', '", $fields) . "'";
			$res = TJSA("submitform('{$this->properties['id']}', [{$fields}]);", $caption);
			}else{
			$res = TJSA("submitform('{$this->properties['id']}');", $caption);
			}
		return $res;
		}
	/*******************************/
	function addsubmitlink($caption = 'OK', $fields = array()){
		if(!is_array($fields)){
			$fields = array(trim($fields));
			}
		$this->button = $this->submitlink($caption, $fields);
		}
	/*******************************/
	function show(){
		if ($this->button == ''){
			$this->button = TSubmit($this->buttonlabel);
			}
		$this->add($this->button);
		return parent::show();
		}
	/*******************************/
	function addhidden($key, $val){
		if ($key!=''){
			$this->items[] = o($key, THidden($key, $val));
			}
		}
	/*******************************/
	}
	
class TTableForm extends TForm {
	var $table = null;
	/*******************************/
	function __construct($content = '', $action = null, $buttonlabel = 'OK'){
		$this->table = TTable();
		parent::__construct($content, $action, $buttonlabel);
		$this->type = 'form';
		}
	/*******************************/
	function add(){
		$this->table->add(func_get_args());
		}
	/*******************************/
	function show(){
		if ($this->button == ''){
			$this->button = TSubmit($this->buttonlabel);
			}
		$this->items[] = $this->table;
		return parent::show();
		}
	/*******************************/
	/*******************************/
	}