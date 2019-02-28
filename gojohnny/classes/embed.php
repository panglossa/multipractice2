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
class TEmbed extends TElement {
	/*******************************/
	function __construct($src = '', $type = '', $width = 0, $height = 0){
		parent::__construct();
		$this->shorttag = true;
		if (is_array($src)){
			foreach(array('src', 'type', 'width', 'height') as $item){
				if(isset($src[$item])){
					$this->p($item, $src[$item]);
					}
				}
			}else{
			foreach(array('src', 'type', 'width', 'height') as $item){
				$this->p($item, $$item);
				}
			}
		}
	}