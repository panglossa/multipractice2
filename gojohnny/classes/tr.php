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
class TTr extends TElement {
	/*******************************/
	function __construct($newcontent = ''){
		parent::__construct();
		if ($newcontent!=''){
			if (!(is_array($newcontent))) {
				$newcontent = func_get_args();
				}
			$this->add($newcontent);
			}
		}
	/*******************************/
	function add($newcontent = ''){
		if ($newcontent!=''){
			if (!(is_array($newcontent))) {
				$newcontent = func_get_args();
				}
			foreach($newcontent as $newitem){
				if((isset($newitem->type))&&((($newitem->type=='td'))||(($newitem->type=='th')))){
					$this->items[] = $newitem;
					}else{
					$this->items[] = TTd($newitem);
					}
				}
			}
		}
	/*******************************/
	}
