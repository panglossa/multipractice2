<?php

class TLanguage {
	var $id = -1;
	var $name = '';
	var $name_sort = '';
	var $englishname = '';
	var $created = '2018-01-01 00:00:00';
	var $info = '';
	var $user_id = -1;
	var $code = '';
	
	function __construct($aname = '', $anamesort = '', $anenglishname = '', $acode = '', $someinfo = '', $auser_id = -1){
		$this->name = $aname;
		$this->name_sort = $anamesort;
		$this->englishname = $anenglishname;
		$this->code = $acode;
		$this->info = $someinfo;
		$this->user_id = $auser_id;
		}
	
	}