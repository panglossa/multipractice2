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
//some classes used only by this class
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'table_colspan.php');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'table_rowspan.php');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'table_head.php');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'table_body.php');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'table_foot.php');
////////////////////////////////////////////////////////////////////////////////////////
class TTable extends TElement {
	/*******************************/
	function __construct($newcontent = ''){
		parent::__construct();
		$this->caption = '';
		$this->thead = new TTHead();
		$this->tbody = new TTBody();
		$this->tfoot = new TTFoot();
		$this->head = &$this->thead;
		$this->body = &$this->tbody;
		$this->foot = &$this->tfoot;
		$this->items = &$this->tbody->items;
		if ($newcontent!=''){
			if (!(is_array($newcontent))) {
				if ((isset($newcontent->type))&&($newcontent->type=='tr')) {
					//no further action necessary 
					}else{
					$newcontent = func_get_args();
					}
				}
			$this->add($newcontent);
			}
		}
	/*******************************/
	function add($newcontent = ''){
		if ($newcontent!=''){
			//we have something
			if (!(is_array($newcontent))) {
				if ((isset($newcontent->type))&&($newcontent->type=='tr')) {
					//we have a TTr (table row) object
					$newcontent = array($newcontent);
					}else{
					//we have items passed freely, pack them in an array
					$newcontent = func_get_args();
					}
				}
			if (count($newcontent)>0){
				//we have at least one item
				if ((is_array($newcontent[0]))||(((isset($newcontent[0]->type))&&($newcontent[0]->type=='tr')))) {
					//we have a series of rows, not single items
					foreach($newcontent as $newrow){
						$this->addrow($newrow);
						}
					}else{
					//we have single items of one single row
					$this->addrow($newcontent);
					}
				}
			
			}
		}
	/*******************************/
	function addrow($newcontent = ''){
		if ($newcontent!=''){
			//We have something
			$newrow = '';
			if (is_array($newcontent)) {
				if (count($newcontent)>0){
					//we have items as an array, just make a row out of it
					$newrow = TTr($newcontent);
					}
				}else{
				//not an array
				if ((isset($newcontent->type))&&($newcontent->type=='tr')) {
					//we already have a TTr (table row) object
					$newrow = $newcontent;
					}else{
					//we have items passed freely, pack them in an array and make a row out of it
					$newrow = TTr(func_get_args());
					}
				}
			if ($newrow!=''){
				$this->tbody->items[] = $newrow;
				}
			}
		}
	/*******************************/
	function getcaption(){
		if($this->caption!=''){
			return "<caption>{$this->caption}</caption>";
			}else{
			return '';
			}
		}
	/*******************************/
	function getcontent(){
		return $this->getcaption() . $this->head . $this->foot . $this->body;
		}
	/*******************************/
	function parse($text, $coldelimiter = '|', $rowdelimiter = "\n"){
		$text = trim($text);
		if($text!=''){
			foreach(explode($rowdelimiter, trim($text)) as $row){
				$this->addrow(explode($coldelimiter, trim($row)));
				}
			}
		}
	/*******************************/
	function addheader($items = array()){
		if(!is_array($items)){
			$items = func_get_args();
			}
		$row = TTr();
		foreach($items as $item){
			$row->add(TTh($item));
			}
		$this->addrow($row);
		}
	/*******************************/
	/*******************************/
	}