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
if(!class_exists('TInput')){
	require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'input.php');
	}
class TImage extends TInput {
	//Not to be confused with TImg !
	/*******************************/
	function __construct($src = '', $alt = null){
		parent::__construct();
		$this->type = 'input';
		$this->p('type', 'image');
		$this->p('src', $src);
		if($alt==null){
			$alt = $src;
			}
		$this->p('alt', $alt);
		}
	/*******************************/
	}
