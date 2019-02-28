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
class TRecordTable extends TTable {
	var $action = 'display';
	var $object = null;
	var $type = 'table';
	var $map = array();
	var $sources = array();
	
	function __construct($anobject = null, $amap = array(), $anaction = 'display', $datasources = array()){
		parent::__construct();
		$this->type = 'table';
		$this->object = $anobject;
		$this->map = $amap;
		$this->action = $anaction;
		$this->sources = $datasources;
		$this->p('border', '1');
		}
	
	function getcontent(){
		if ($this->object!=null){
			foreach($this->map as $field => $label){
				if (isset($this->object->$field)){
					if ($this->action == 'display'){
						if (isset($this->sources[$field])) {
							if ((isset($this->sources[$field][$this->object->$field]))) {
								$this->add($label, $this->sources[$field][$this->object->$field]);
								}else{
								$this->add($label, $this->object->$field);
								}
							}else{
							$this->add($label, $this->object->$field);
							}
						} else if (($this->action == 'edit')||($this->action == 'new')) {
						if (isset($this->sources[$field])) {
							if ((isset($this->sources[$field][$this->object->$field]))) {
								$lst = o("{$this->action}_{$field}", TComboBox());
								foreach($this->sources[$field] as $key => $val){
									$lst->add($key, $val);
									}
								$lst->select($this->object->$field);
								$this->add($label, $lst);
								}else{
								$this->add($label, $this->object->$field);
								}
							}else{
							$this->add($label, o("{$this->action}_{$field}", TEdit( $this->object->$field)));
							}
						}
					}
				}
			}
		
		return parent::getcontent();
		}
	}