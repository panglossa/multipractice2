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
class TBlockQuote extends TElement {
	/*******************************/
	function __construct($content = '', $cite = ''){
		$this->uid = md5(uniqid(rand(), TRUE));//assign a unique random id
		$this->setclass();//assign a provisional class from its php class name
		$this->add($content);
		$this->p('cite', $cite);
		}
	/*******************************/
	}
