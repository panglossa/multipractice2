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
class TLoginForm extends TForm {
	/*******************************/
	function __construct(){
		parent::__construct();
		$this->type = 'form';
		$table = TTable();
		$table->add(array('Username:&nbsp;', o('loginusername', TEdit())));
		$table->add(array('Password:&nbsp;', o('loginpassword', TPassword())));
		$this->add($table);
		}
	}


class TVerticalLoginForm extends TForm {
	/*******************************/
	function __construct(){
		parent::__construct();
		$this->type = 'form';
		$table = TTable();
		$table->add(array('Username:&nbsp;'));
		$table->add(array(o('loginusername', TEdit())));
		$table->add(array('Password:&nbsp;'));
		$table->add(array(o('loginpassword', TPassword())));
		$this->add($table);
		}
	}
	
	