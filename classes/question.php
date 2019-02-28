<?php

class TQuestion {
	var $id = -1;
	var $question = '';
	var $user_id = -1;
	var $language_id = -1;
	var $created = '2018-01-01 00:00:00';
	var $lastused = '2018-01-01 00:00:00';
	var $info = '';
	var $correct = 0;
	var $incorrect = 0;
	var $type = '';
	var $answer1 = '';
	var $answer2 = '';
	
	function __construct(){
		
		}
		
	}

class TQuestionOpen extends TQuestion {
	function __construct(){
		parent::__construct();
		$this->type = 'open';
		}
	}

class TQuestionYesno extends TQuestion {
	function __construct(){
		parent::__construct();
		$this->type = 'yesno';
		}
	}

class TQuestionTranslate extends TQuestion {
	function __construct(){
		parent::__construct();
		$this->type = 'translate';
		}
	}
