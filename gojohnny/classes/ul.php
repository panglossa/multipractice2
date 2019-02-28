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
class TUl extends TElement {
	////////////////////////////////////////////////
	function __construct($items = array(), $key = 'id', $condition = array()){
		parent::__construct();
		if (is_array($items)){
			//foreach($items as $item){
			//	$this->add($item);
			//	}
			$this->import($items, $key, $condition);
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
	////////////////////////////////////////////////
	function import($data = array(), $key = 'id', $condition = array()) {
		/*
		$condition should be something like this:
		array(
			'key' => 'id',
			'is' => '>',
			'val' => -1
			)
			*/
		if ((is_array($data))&&(count($data)>0)) {
			foreach($data as $row){
				$isok = true;
				if ((is_array($condition))&&(count($condition)>2)) {
					if ((isset($condition['key']))&&(isset($condition['val']))) {
						$op = '';
						if (isset($condition['op'])) {
							$op = $condition['op'];
							} else if (isset($condition['operator'])) {
							$op = $condition['operator'];
							} else if (isset($condition['operation'])) {
							$op = $condition['operation'];
							} else if (isset($condition['is'])) {
							$op = $condition['is'];
							}
						if ($op!='') {
							switch(strtolower($op)) {
								case '!=':
								case '<>':
									$isok = ($row[$condition['key']] != $condition['val']);
									break;
								case '>':
									$isok = ($row[$condition['key']] > $condition['val']);
									break;
								case '<':
									$isok = ($row[$condition['key']] < $condition['val']);
									break;
								case '>=':
									$isok = ($row[$condition['key']] >= $condition['val']);
									break;
								case '<=':
									$isok = ($row[$condition['key']] <= $condition['val']);
									break;
								case '=':
								case '==':
								case 'like':
									$isok = ($row[$condition['key']] == $condition['val']);
									break;
								case 'contain':
								case 'contains':
								case 'include':
								case 'includes':
								case 'has':
									$isok = (strpos($row[$condition['key']], $condition['val'])!==false);
									break;
								case 'exclude':
								case 'excludes':
								case 'x':
									$isok = (strpos($row[$condition['key']], $condition['val'])===false);
									break;
								}
							}
						}
					}
				//echo "{$condition['key']} {$op} {$condition['val']}\n<br>\n";	
				if ($isok) {
					$this->add($row[$key]);
					}
				}
			}
		}
	////////////////////////////////////////////////
	////////////////////////////////////////////////
	}

class TList extends TUL {
	/*******************************/
	function init(){
		parent::init();
		$this->type = 'ul';
		}
	/*******************************/
	}