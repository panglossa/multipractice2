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
class TDetails extends TElement {
	/*******************************/
	function __construct($content = '', $summary = ''){
		parent::__construct($content);
		$this->summary = $summary;
		}
	/*******************************/
	function getcontent(){
		if (trim($this->summary)!=''){
			$res = "<summary>{$this->summary}</summary>";
			}else{
			$res = '';
			}
		$res .= parent::getcontent();
		return $res;
		}
	/*******************************/
	}
