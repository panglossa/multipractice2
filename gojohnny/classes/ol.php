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
class TOl extends TElement {
	////////////////////////////////////////////////
	function __construct($items = array()){
		parent::__construct();
		if (is_array($items)){
			foreach($items as $item){
				$this->add($item);
				}
			}else{
			foreach(func_get_args() as $arg){
				foreach(explode("\n", trim($arg)) as $item){
					$this->add($item);
					}
				}
			}
		}
	////////////////////////////////////////////////
	function getcontent(){
		$res = '';
		foreach($this->items as $item){
			if((is_object($item))&&(isset($item->type))&&($item->type=='li')){
				$res .= $item;
				}else if(trim($item)!=''){
				$res .= "<li>{$item}</li>\n";
				}
			}
		return $res;
		}
	}

class TOrderedList extends TOL {
	/*******************************/
	function init(){
		parent::init();
		$this->type = 'ol';
		}
	/*******************************/
	}