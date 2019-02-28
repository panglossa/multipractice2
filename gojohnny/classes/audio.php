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
class TAudio extends TElement {
	/*******************************/
	function __construct($src = '', $autoplay = false, $loop = false, $controls = true, $preload = 'none', $mediagroup = '', $crossorigin = ''){
		$this->init();
		if (is_array($src)){
			foreach(array('src', 'autoplay', 'loop', 'controls', 'preload', 'mediagroup', 'crossorigin') as $key){
				if (isset($src[$key])){
					$this->p($key, $src[$key]);
					}
				}
			}else{
			foreach(array('src', 'autoplay', 'loop', 'controls', 'preload', 'mediagroup', 'crossorigin') as $key){
				$this->p($key, $$key);
				}
			}
		}	
	}
