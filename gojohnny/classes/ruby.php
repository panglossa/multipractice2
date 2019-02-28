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
class TRuby extends TElement {
	////////////////////////////////////////////////
	function __construct($item, $translit = ''){
		$this->init();
		if(is_array($item)){
			foreach($item as $subitem => $tr){
				$this->add($subitem, $tr);
				}
			}else{
			$this->add($item, $translit);
			}
		}
	////////////////////////////////////////////////
	function getcontent(){
		$res = '';
		foreach($this->items as $item => $transliteration){
			$res .= "{$item} <rp>(</rp><rt>{$transliteration}</rt><rp>)</rp>\n";
			}
		return $res;
		}
	////////////////////////////////////////////////
	function add($item, $translit){
		$this->items[$item] = $translit;
		}
	////////////////////////////////////////////////
	}
