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

class TTablePart extends TElement {
	/*******************************/
	function __construct(){
		parent::__construct();
		/*valid content:
		-one or more items (either strings or go!Johnny objects
		-an array of items, representing a single table row
		-an bidimensional array representing several table rows
		*/
		$this->add(func_get_args());
		}
	/*******************************/
	function add(){
		
		}
	/*******************************/
	function addrow($rowitems = array()){
		if((is_object($rowitems)&&(isset($rowitems->type))&&($rowitems->type=='tr'))){
			//no action required
			}else if (is_array($rowitems)){
			//we have an array
			$rowitems = new TTR($rowitems);
			}else{
			//we have one item or several items
			$rowitems = new TTR(func_get_args());
			}
		$this->items[] = $rowitems;
		}
	/*******************************/
	function show(){
		if(count($this->items)>0){
			return parent::show();
			}else{
			return '';
			}
		}
	/*******************************/
	}
?>