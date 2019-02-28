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
class TInput extends TElement {
	/*******************************/
	function __construct($content = ''){
		parent::__construct();
		$this->p('type', GJ_DEFAULTINPUTTYPE);
		$this->shorttag = true;
		$this->p('value', $content);
		$this->suggestions = array();
		}
	/*******************************/
	function show(){
		$this->setID();
		if (!isset($this->properties['name'])){
			$this->p('name', $this->p('id'));
			}
		$sl = '';//suggestions list
		if (count($this->suggestions)>0){
			$this->p('list', $this->p('id') . '_suggestions');
			$sl = '<datalist id="' . $this->p('id') . '_suggestions">';
			foreach($this->suggestions as $sug){
				$sl .= "<option value=\"{$sug}\">";
				}
			$sl .= '</datalist>';
			}
		return parent::show() . $sl;
		}
	/*******************************/
	function disabled($val = true){
		$this->p('disabled', $val);
		}
	/*******************************/
	function required($val = true){
		$this->p('required', $val);
		}
	/*******************************/
	}