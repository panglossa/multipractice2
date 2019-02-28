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
class TContactForm extends TForm {
	/*******************************/
	function __construct(
		$items = array(
			'name' => 'Name: ',
			'phone' => 'Phone: ',
			'email' => 'Email: ',
			'web' => 'Website: ',
			'message' => 'Your Message: '
			)
		){
		parent::__construct();
		$this->type = 'form';
		$table = TTable();
		foreach($items as $id => $label){
			$input = '';
			if ($id=='message'){
				$input = o($id, TMemo());
				}else{
				$input = o($id, TEdit());
				}
			$table->add(array($label, $input));
			}
		$this->add($table);
		}
	}