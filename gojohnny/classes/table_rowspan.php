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

////////////////////////////////////////////////
class TRowSpan extends TTD {
	/*******************************/
	function __construct($span = 2, $content = ''){
		parent::__construct($content);
		$this->type = 'td';
		$this->p('rowspan', $span);
		}
	/*******************************/
	}
////////////////////////////////////////////////
?>