<?php
/*
Panglossa go!Johnny PHP library
version 7.0
release 2013-03-20
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Araçatuba - SP - Brazil - 2013
*/
class TA extends TElement {
	/*******************************/
	function __construct(
		$href = '', 
		$text = '', 
		$title = null, 
		$target = null, 
		$rel = null, 
		$ping = null, 
		$media = null, 
		$type = null, 
		$hreflang = null
		){
		$this->init();
		if ($text==''){
			$text=$href;
			}
		$this->p('href', $href);
		$this->p('title', $title);
		$this->p('target', $target);
		$this->p('rel', $rel);
		$this->p('ping', $ping);
		$this->p('media', $media);
		$this->p('type', $type);
		$this->p('hreflang', $hreflang);
		$this->add($text);
		}
	}