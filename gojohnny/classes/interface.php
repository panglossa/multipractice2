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
class TInterface extends TElement {
	var $state = 'display';
	var $data = array();
	var $parent = null;
	var $errors = array();
	/*******************************/
	function __construct($data = array(), $parent = null){
		parent::__construct();
		if (is_array($data)){
			$this->items = $data;
			}
		$this->parent = $parent;
		}
	/*******************************/
	function displaytable(){
		$res = TTable();
		$res->setID($this->p('id') . '_content');
		foreach($this->items as $item){
			$row = array($item['label'], $item['value']);
			$res->add($row);
			}
		return $res;
		}
	/*******************************/
	function newform(){
		$res = TForm();
		$tbl = TTable();
		$tbl->setID('tbl_' . $this->p('id') . '_new');
		foreach($this->items as $item){
			$itemid = "{$item['id']}_new";
			switch($item['input']){
				case 'list':
				case 'select':
				case 'listbox':
				case 'combo':
				case 'combobox':
					$input = o($itemid, TSelect());
					foreach($item['items'] as $key => $val){
						$input->add($key, $val);
						}
					$input->select($this->parent->parm($itemid));
					if (($item['input']=='combo')||($item['input']=='combobox')) {
						$input->p('size', 1);
						$input->p('multiple', false);
						}
					break;
				case 'memo':
					$input = o($itemid, TMemo($this->parent->parm($itemid)));
					break;
				default: 
					$input = o($itemid, TEdit($this->parent->parm($itemid)));
				}
			$row = array($item['label'], $input);
			$tbl->add($row);
			}
		
		$res->add($tbl);
		return $res;
		}
	/*******************************/
	function editform(){
		$res = TForm();
		$tbl = TTable();
		$tbl->setID('tbl_' . $this->p('id') . '_edit');
		foreach($this->items as $item){
			$itemid = "{$item['id']}_edit";
			switch($item['input']){
				case 'list':
				case 'select':
				case 'listbox':
				case 'combo':
				case 'combobox':
					$input = o($itemid, TSelect());
					foreach($item['items'] as $key => $val){
						$input->add($key, $val);
						}
					$input->select($this->parent->parm($itemid, $item['value']));
					if (($item['input']=='combo')||($item['input']=='combobox')) {
						$input->p('size', 1);
						$input->p('multiple', false);
						}
					break;
				case 'memo':
					$input = o($itemid, TMemo($this->parent->parm($itemid, $item['value'])));
					break;
				default: 
					$input = o($itemid, TEdit($this->parent->parm($itemid, $item['value'])));
				}
			$row = array($item['label'], $input);
			$tbl->add($row);
			}
		
		$res->add($tbl);
		return $res;
		}
	/*******************************/
	function validateinput(){
		$res = true;
		$datasent = false;
		$this->errors = array();
		foreach($this->items as $item){
			$itemid = "{$item['id']}_{$this->state}";
			if (isset($this->parent->parameters[$itemid])) {
				$datasent = true;
				}
			if (isset($item['require'])){
				$problem = '';
				$isok = true;
				switch($item['require']){
					case 'not empty':
						$problem = ' must not be empty';
						if (trim($this->parent->parm($itemid, $item['value']))==''){
							$isok = false;
							}
						break;
					case '=':
						$problem = " must be equal to {$item['require2']}";
						if ($this->parent->parm($itemid, $item['value'])!=$item['require2']) {
							$isok = false;
							}
						break;
					case '>':
						if (($item['input']=='list')||($item['input']=='select')||($item['input']=='listbox')||($item['input']=='combo')||($item['input']=='combobox')) {
							$problem = " must be selected";
							}else{
							$problem = " must be bigger than {$item['require2']}";
							}
						if ($this->parent->parm($itemid, $item['value'])<=$item['require2']) {
							$isok = false;
							}
						break;
					case '<':
						$problem = " must be less than {$item['require2']}";
						if ($this->parent->parm($itemid, $item['value'])>=$item['require2']) {
							$isok = false;
							}
						break;
					case '>=':
						$problem = " must not be less than {$item['require2']}";
						if ($this->parent->parm($itemid, $item['value'])<$item['require2']) {
							$isok = false;
							}
						break;
					case '<=':
						$problem = " must not be bigger than {$item['require2']}";
						if ($this->parent->parm($itemid, $item['value'])>$item['require2']) {
							$isok = false;
							}
						break;
					}
				if (!$isok){
					$this->errors[] = "{$item['label']} {$problem}.";
					$res = false;
					}
				}
			}
		if (!$datasent){
			$res = false;
			$this->errors = array();
			}
		return $res;
		}
	/*******************************/
	function getcontent(){
		if ($this->state=='edit'){
			return $this->editform();
			}else if ($this->state=='new'){
			return $this->newform();
			}else{
			return $this->displaytable();
			}
		}
	/*******************************/
	function getitem($itemid){
		$res = '';
		foreach($this->items as $item){
			if ($item['id']==$itemid){
				$res = $this->parent->parm("{$itemid}_{$this->state}", $item['value']);
				}
			}
		return $res;
		}
	/*******************************/
	/*******************************/
	/*******************************/
	/*******************************/
	}
	
