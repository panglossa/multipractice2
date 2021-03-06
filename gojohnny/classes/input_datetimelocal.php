<?php
/*
Panglossa go!Johnny PHP library
version 7.0
release 2017-07-05
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Arašatuba - SP - Brazil - 2017
*/
if(!class_exists('TInput')){
	require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'input.php');
	}
class TDateTimeLocal extends TInput {
	/*******************************/
	function __construct($value = null){
		parent::__construct();
		if ($value==null){
			$value = date(GJ_DATEFORMAT) . 'T' . date(GJ_TIMEFORMAT) . 'Z';
			}
		$this->p('value', $value);
		$this->type = 'input';
		$this->p('type', 'datetime-local');
		}
	/*******************************/
	}
