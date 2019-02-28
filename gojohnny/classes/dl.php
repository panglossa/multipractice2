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
class TDl extends TElement {
	////////////////////////////////////////////////
	function __construct($content){
		$this->init();
		if(is_array($content)){
			foreach($content as $caption => $item){
				$this->add($caption, $item);
				}
			}
		}
	////////////////////////////////////////////////
	function getcontent(){
		$res = '';
		foreach($this->items as $caption => $item){
			$res .= "<dt>{$caption}</dt>\n";
			if(!is_array($item)){
				$item = array($item);
				}
			foreach($item as $subitem){
				$res .= "<dd>{$subitem}</dd>\n";
				}
			}
		return $res;
		}
	////////////////////////////////////////////////
	function add($caption, $subitems){
		$this->items[$caption] = $subitems;
		}
	////////////////////////////////////////////////
	}