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
class TCenter extends TP {
	function init(){
		parent::init();
		foreach(func_get_args() as $arg){
			$this->add($arg);
			}
		$this->p('style', 'text-align:center;');
		}
	}
