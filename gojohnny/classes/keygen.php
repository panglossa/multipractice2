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
class TKeyGen extends TElement {
	/*******************************/
	function __construct($challenge = '', $keytype='RSA', $keyparams = ''){
		parent::__construct();
		$this->p('challenge', $challenge);
		$this->p('keytype', $keytype);
		$this->p('keyparams', $keyparams);
		}
	/*******************************/
	function getprefix(){
		if(!isset($this->properties['name'])){
			$this->p('name', $this->p('id'));
			}
		return parent::getprefix();
		}
	/*******************************/
	}
