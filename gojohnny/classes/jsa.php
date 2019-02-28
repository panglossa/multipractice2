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
class TJSA extends TA{
	function __construct($script = '', $text = '', $title = null, $target = null, $rel = null, $ping = null, $media = null, $type = null, $hreflang = null){
		parent::__construct('javascript:void(0);', $text, $title, $target, $rel, $ping, $media, $type, $hreflang);
		$this->type = 'a';
		$this->p('onclick', $script);
		}
	}