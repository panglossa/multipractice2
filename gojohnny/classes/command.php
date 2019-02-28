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
class TCommand extends TElement {
	/*******************************/
	function __construct($label = '', $icon = '', $type = 'command'){
		parent::__construct();
		foreach(array('label', 'icon', 'type') as $id){
			$this->p($id, $$id);
			}
		}
	/*******************************/
	}
