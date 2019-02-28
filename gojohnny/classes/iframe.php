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
class TIframe extends TElement {
	////////////////////////////////////////////////
	function __construct($src = '', $width = 0, $height = 0){
		$this->init();
		if(is_array($src)){
			foreach(array('height', 'mozallowfullscreen', 'webkitallowfullscreen', 'mozapp', 'mozbrowser', 'name', 'remote', 'sandbox', 'seamless', 'srcdoc', 'width') as $key){
				if (isset($src[$key])){
					$this->p($key, $src[$key]);
					}
				}
			}else{
			$this->p('src', $src);
			$this->p('width', $width);
			$this->p('height', $height);
			}
		}
	////////////////////////////////////////////////
	function getcontent(){
		return '';
		}
	////////////////////////////////////////////////
	}
