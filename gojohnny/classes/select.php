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
class TSelect extends TElement {
	/*******************************/
	function __construct($content = array(), $del = ':', $sep = "\n"){
		parent::__construct();
		$this->selected = array();
		if (is_array($content)){
			if (count($content)>0){
				if (isAssoc($content)){
					foreach($content as $key => $val){
						$this->items[$key] = $val;
						}
					}else{
					foreach($content as $item){
						$this->items[$item] = $item;
						}
					}
				if(!is_array($del)){
					$del = array(trim($del));
					}
				if(count($del)>0){
					foreach($del as $s){
						$this->select($s);
						}
					}
				}
			}else if (is_string($content)){
			foreach(explode($sep, trim($content)) as $line){
				$parts = explode($del, trim($line));
				array_walk($parts, 'trim');
				if(count($parts>1)){
					$this->items[$parts[0]] = $parts[1];
					}else{
					$this->items[$parts[0]] = $parts[0];
					}
				
				if(count($parts)>2){
					if(strtolower(trim($parts[2]))=='selected'){
						$this->select($parts[0]);
						}
					}
					
				}
			}
		}
	/*******************************/
	function import($data = array(), $id = 'id', $text = 'name'){
		foreach($data as $row){
			$this->add($row[$id], $row[$text]);
			}
		}
	/*******************************/
	function selectbyid($id){
		$this->selected[] = $id;
		$this->selected = array_unique($this->selected);
		}
	/*******************************/
	function selectbytext($s){
		foreach($this->items as $key => $val){
			if($val==$s){
				$this->selectbyid($key);
				}
			}
		}
	/*******************************/
	function select($what = '', $by = 'id'){
		if($by!='id'){
			$this->selectbytext($what);
			}else{
			$this->selectbyid($what);
			}
		}
	/*******************************/
	function add($key, $text, $selected = false, $group = null){
		if($group==null){
			$key = trim($key);
			$text = trim($text);
			if($text==''){
				$text==$key;
				}
			$this->items[$key] = $text;
			}else{
			if((!isset($this->items[$group]))or(!is_array($this->items[$group]))){
				$this->items[$group] = array('label' => $group, 'items' => array());
				}
			$this->items[$group]['items'][$key] = $text;
			}
		if($selected===true){
			$this->select($key);
			}
		}
	/*******************************/
	function addmulti($items = array()){
		foreach($items as $item){
			$key = '';
			$text = '';
			$sel = false;
			$g = null;
			if(count($item)>0){
				$key = $item[0];
				if(count($item)>1){
					$text = $item[1];
					if(count($item)>2){
						$sel = $item[2];
						if(count($item)>3){
							$g = $item[3];
							}
						}
					}
				}
			if($key!=''){
				if($text==''){
					$text = $key;
					}
				$this->add($key, $text, $sel, $g);
				}
			}
		}
	/*******************************/
	function addgroup($key, $text){
		$key = trim($key);
		$text = trim($text);
		if($text==''){
			$text==$key;
			}
		$this->items[$key] = array('label' => $text, 'items' => array());
		}
	/*******************************/
	function getcontent(){
		$res = '';
		foreach($this->items as $key => $val){
			if (is_array($val)){
				$res .= "<optgroup label=\"{$val['label']}\">";
  				foreach($val['items'] as $subkey => $subval){
	  				$res .= "<option";
					if ($this->isselected($subkey)){
						$res .= " selected";
						}
					$res .= " value=\"{$subkey}\">{$subval}</option>\n";
	  				}
	  			$res .= "</optgroup>";
				}else{
				$res .= "<option";
				if ($this->isselected($key)){
					$res .= " selected";
					}
				$res .= " value=\"{$key}\">{$val}</option>\n";
				}
			}
		return $res;
		}
	/*******************************/
	function isselected($id){
		$res = false;
		foreach($this->selected as $key){
			if($key==$id){
				$res = true;
				}
			}
		return $res;
		}
	/*******************************/
	function itemscount(){
		$c = 0;
		foreach($this->items as $key => $val){
			if(is_array($val)){
				$c++;
				foreach($val['items'] as $si){
					$c++;
					}
				}else{
				$c++;
				}
			}
		return $c;
		}
	/*******************************/
	function getprefix(){
		$this->type = 'select';
		if (!isset($this->properties['name'])){
			$this->p('name', $this->p('id'));
			}
		if(!isset($this->properties['size'])){
			$this->p('size', $this->itemscount());
			}
		return parent::getprefix();
		}
	/*******************************/
	}
////////////////////////////////////////////
//Just an alias
class TListBox extends TSelect {
	function getprefix(){
		$this->type = 'select';
		return parent::getprefix();
		}
	}

////////////////////////////////////////////
//Another alias, but a bit different
class TComboBox extends TSelect {
	function getprefix(){
		$this->type = 'select';
		$this->p('size', 1);
		$this->p('multiple', false);
		return parent::getprefix();
		}
	}

