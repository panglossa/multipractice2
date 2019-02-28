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
if(!class_exists('TInput')){
	require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'input.php');
	}
class TRadio extends TInput {
	/*******************************/
	function __construct($label = '', $group = '', $checked = false){
		parent::__construct();
		$this->label = $label;
		$this->type = 'input';
		$this->p('type', 'radio');
		$this->p('name', $group);
		$this->p('checked', $checked);
		}
	/*******************************/
	function show(){
		$this->setID();
		$this->p('value', $this->p('id'));
		return parent::show() . "<label for=\"{$this->properties['id']}\">" . $this->label . '</label>';
		}
	/*******************************/
	}
