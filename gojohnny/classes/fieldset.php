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
class TFieldSet extends TElement {
	/*******************************/
	function __construct($caption = '', $content = ''){
		parent::__construct($content);
		$this->caption = $caption;
		}
	/*******************************/
	function getcontent(){
		$legend = trim($this->caption);
		if($legend!=''){
			$legend = "<legend>{$legend}</legend>";
			}
		return $legend . parent::getcontent();
		}
	/*******************************/
	function disabled($state = true){
		$this->p('disabled', $state);
		}
	/*******************************/
	}
////////////////////////////////////////////
//Just an alias
class TGroupBox extends TFieldSet {
	function getprefix(){
		$this->type = 'fieldSet';
		return parent::getprefix();
		}
	}

