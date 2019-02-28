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
class TFile extends TInput {
	/*******************************/
	function __construct($caption = ''){
		parent::__construct('');
		$this->properties['accept'] =  array();
		$this->accept = &$this->properties['accept'];
		$this->label = $caption;
		$this->type = 'input';
		$this->p('type', 'file');
		}
	/*******************************/
	function show(){
		$this->setID();
		if (is_array($this->properties['accept'])){
			$this->properties['accept'] = trim(implode(',', $this->properties['accept']));
			}
		if (trim($this->label)!=''){
			$label = "<label for=\"{$this->properties['id']}\">" . $this->label . '</label>';
			}else{
			$label = '';
			}
		return parent::show() . $label;
		}
	/*******************************/
	}
