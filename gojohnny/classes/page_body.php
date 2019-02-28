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
class TPageBody extends TElement{
	var $items = array();
	/*******************************/
	function show(){ 
		$res = "<body>\n<!-- starting page body section -->\n";
		foreach($this->items as $id => $item){
			//if there is a user defined id (anything other than 'BODY_ITSELF'),
			//we build a container div with this id
			//else, we add the content directly to the <body> of the page.
			//a default container div named 'main' is generated automatically,
			//this can be turned off by defining GJ_AUTOMAIN as false before calling the library.
			if($id=='BODY_ITSELF'){
				$res .= $item;
				}else{
				if(!is_object($item)){
					$item = new TDiv($item);
					}
				$item->setID($id);
				if (($id=='main')&&(strpos(GJ_BASECSS, 'bootstrap')!==false)){
					$item->setclass('container-fluid');
					}
				$res .= $item;
				}
			}
		$res .= "\n<!-- finishing page body section -->\n</body>\n";
		return $res;
		}
	/*******************************/
	/*******************************/
	/*******************************/
	}
?>