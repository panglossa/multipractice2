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
class TH extends TElement {
	/*******************************/
	function init(){
		parent::init();
		$this->type = 'h1';
		}
	/*******************************/
	}

class TH1 extends TH {
	}

class TH2 extends TH {
	/*******************************/
	function init(){
		parent::init();
		$this->type = 'h2';
		}
	/*******************************/
	}

class TH3 extends TH {
	/*******************************/
	function init(){
		parent::init();
		$this->type = 'h3';
		}
	/*******************************/
	}

class TH4 extends TH {
	/*******************************/
	function init(){
		parent::init();
		$this->type = 'h4';
		}
	/*******************************/
	}

class TH5 extends TH {
	/*******************************/
	function init(){
		parent::init();
		$this->type = 'h5';
		}
	/*******************************/
	}

class TH6 extends TH {
	/*******************************/
	function init(){
		parent::init();
		$this->type = 'h6';
		}
	/*******************************/
	}
