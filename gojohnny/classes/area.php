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
class TArea extends TElement {
	/*******************************/
	function __construct($shape = 'rect', $coords = '', $href = '', $alt = '', $target = '', $rel = '', $ping = '', $media = '', $type = '', $hreflang = ''){
		$this->init();
		if (is_array($shape)){
			foreach(array('shape', 'rect', 'coords', 'href', 'alt', 'target', 'rel', 'ping', 'media', 'type', 'hreflang') as $key){
				if (isset($shape[$key])){
					if(is_array($shape[$key])){
						$shape[$key] = implode(',', $shape[$key]);
						}
					$this->p($key, $shape[$key]);
					}
				}
			}else{
			if (is_array($coords)){
				$coords = implode(',', $coords);
				}
			foreach(array('shape', 'rect', 'coords', 'href', 'alt', 'target', 'rel', 'ping', 'media', 'type', 'hreflang') as $key){
				$this->p($key, $$key);
				}
			}
		}
	/*******************************/
	}