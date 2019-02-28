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
class TCode extends TElement {
	/*******************************/
	function __construct($content = '', $language = 'php'){
		parent::__construct($content);
		$this->language = $language;
		}
	/*******************************/
	function show(){
		
		if (file_exists(GJ_GESHI)){
			require_once(GJ_GESHI);
			$src = parent::getcontent();
			$geshi = new GeSHi($src, $this->language);
			$geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS);
			$geshi->set_line_style('background-color: white;color:black;font-size:10pt;font-family:inconsolata;', 'background-color: white;color:black;font-size:10pt;font-family:inconsolata;', true);
			$geshi->set_strings_style('color:maroon;font-weight:bold;font-style:italic;', false, 'HARD');
			$geshi->set_strings_style('color:maroon;font-weight:bold;font-style:italic;', false);
			//$geshi->set_regexps_style('font-weight:bold');
			//var_dump($geshi->language_data['STYLES']['STRINGS']);
			//$geshi->set_keyword_group_style(1, 'color: red;', true);
			$this->setID();
			$geshi->set_overall_id($this->p('id'));
			$geshi->set_header_type(GESHI_HEADER_DIV);
			$src = $geshi->parse_code();
			return $src;
			}else{
			$this->type = 'pre';
			return parent::getprefix() . str_replace('<', '&lt;', $this->getcontent()) . $this->getsuffix();
			}
		
		}
	/*******************************/
	}