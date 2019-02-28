<?php
/*
Panglossa go!Johnny PHP library
version 8.0
release 2017-07-05
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Araçatuba - SP - Brazil - 2017
*/
////////////////////////////////////////////////
/** Auxiliary functions.
 *  Generic functions which don't fit in any class or which are too generic and suited to several classes.
 *  A function should be placed here only as a means of last resort. 
 *  Ideal procedure is to place all functions inside class definitions.
 */
/******************************************************/
/******************************************************/
function o($props = array(), $obj = null, $extraprops = array()){
	$res = $obj;
	
	if(is_array($props)){
		foreach($props as $key => $val){
			$res->p($key, $val);
			}
		}else{
		$res->setID($props);
		}
		
	if(count($extraprops)>0){
		foreach($extraprops as $k=>$v){
			$res->p($k, $v);
			}
		}
	return $res;
	}
/******************************************************/
function parse($src = '', $coldel = '|', $rowdel = "\n"){
	/*
	a generic parser, turning a string into a bidimensional array
	*/
	$res = array();
	$src = trim($src);
	if($src!=''){
		$rows = explode($rowdel, $src);
		foreach($rows as $row){
			$cells = explode($coldel, $row);
			$res[] = $cells;
			}
		}
	return $res;
	}
/*****************************************************/
function isAssoc($arr){
	//source: http://stackoverflow.com/questions/173400/php-arrays-a-good-way-to-check-if-an-array-is-associative-or-sequential
	//checks whether an array is associative. 
    //return array_keys($arr) !== range(0, count($arr) - 1);
    foreach(array_keys($arr) as $key) {
	    if (!is_int($key)){
		    return true;
		    }
	    }
    return false;
	}
/*****************************************************/
function ser($data = array()){
	return base64_encode(serialize($data));
	}
/*****************************************************/
function unser($s = ''){
	return unserialize(base64_decode($s));
	}
/*****************************************************/
function currenturl(){
	if(!isset($_SERVER['REQUEST_URI'])){
		$serverrequri = $_SERVER['PHP_SELF'];
		}else{
		$serverrequri = $_SERVER['REQUEST_URI'];
		}
	if(strpos($serverrequri, '?')===false){
		if(trim($_SERVER['QUERY_STRING'])!=''){
			$serverrequri .= "?{$_SERVER['QUERY_STRING']}";
			}
		}
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri; 
	}
/*****************************************************/
function strgetpart($delimiter = ' ', $string = '', $index = 0, $default = ''){
	if((trim($string)=='')or(trim($delimiter)=='')or(!is_numeric($index))){
		return $default;
		}else{
		$parts = explode($delimiter, $string);
		if(isset($parts[$index])){
			return $parts[$index];
			}else{
			return $default;
			}
		}
	}
/*****************************************************/
function str_getpart($delimiter = ' ', $string = '', $index = 0, $default = ''){
	return strgetpart($delimiter, $string, $index, $default);
	}
/*****************************************************/
function str_part($delimiter = ' ', $string = '', $index = 0, $default = ''){
	return strgetpart($delimiter, $string, $index, $default);
	}
/*****************************************************/
function strpart($delimiter = ' ', $string = '', $index = 0, $default = ''){
	return strgetpart($delimiter, $string, $index, $default);
	}
/*****************************************************/
function escapeforjs($s){
	/*
	With information from http://www.javascripter.net/faq/accentedcharacters.htm
	*/
	$accented = array('À',
		'Á',
		'Â',
		'Ã',
		'Ä',
		'Å',
		'Æ',
		'Ç',
		'È',
		'É',
		'Ê',
		'Ë',
		'Ì',
		'Í',
		'Î',
		'Ï',
		'Ð',
		'Ñ',
		'Ò',
		'Ó',
		'Ô',
		'Õ',
		'Ö',
		'Ø',
		'Ù',
		'Ú',
		'Û',
		'Ü',
		'Ý',
		'Þ',
		'ß',
		'à',
		'á',
		'â',
		'ã',
		'ä',
		'å',
		'æ',
		'ç',
		'è',
		'é',
		'ê',
		'ë',
		'ì',
		'í',
		'î',
		'ï',
		'ð',
		'ñ',
		'ò',
		'ó',
		'ô',
		'õ',
		'ö',
		'ø',
		'ù',
		'ú',
		'û',
		'ü',
		'ý',
		'þ',
		'ÿ',
		'Œ',
		'œ',
		'Š',
		'š',
		'Ÿ',
		'ƒ'
		);
	$corrected = array('\xC0',
		'\xC1',
		'\xC2',
		'\xC3',
		'\xC4',
		'\xC5',
		'\xC6',
		'\xC7',
		'\xC8',
		'\xC9',
		'\xCA',
		'\xCB',
		'\xCC',
		'\xCD',
		'\xCE',
		'\xCF',
		'\xD0',
		'\xD1',
		'\xD2',
		'\xD3',
		'\xD4',
		'\xD5',
		'\xD6',
		'\xD8',
		'\xD9',
		'\xDA',
		'\xDB',
		'\xDC',
		'\xDD',
		'\xDE',
		'\xDF',
		'\xE0',
		'\xE1',
		'\xE2',
		'\xE3',
		'\xE4',
		'\xE5',
		'\xE6',
		'\xE7',
		'\xE8',
		'\xE9',
		'\xEA',
		'\xEB',
		'\xEC',
		'\xED',
		'\xEE',
		'\xEF',
		'\xF0',
		'\xF1',
		'\xF2',
		'\xF3',
		'\xF4',
		'\xF5',
		'\xF6',
		'\xF8',
		'\xF9',
		'\xFA',
		'\xFB',
		'\xFC',
		'\xFD',
		'\xFE',
		'\xFF',
		'\u0152',
		'\u0153',
		'\u0160',
		'\u0161',
		'\u0178',
		'\u0192'
		);
	$r = $s;
	for ($i = 0; $i < count($accented); $i++) {
		$r = str_replace($accented[$i], $corrected[$i], $r);
		}
	return $r;
	}
////////////////////////////////////////////////////////////////
function substr_left($s = '', $c = 0){
	$r = '';
	if ((trim($s)!='')&&($c>0)){
		$r = substr($s, 0, $c);
		}
	return $r;
	}
////////////////////////////////////////////////////////////////
function substr_right($s = '', $c = 0){
	$r = '';
	if ((trim($s)!='')&&($c>0)){
		$r = substr($s, "-{$c}");
		}
	return $r;
	}
////////////////////////////////////////////////////////////////
function substrleft($s = '', $c = 0){
	return substr_left($s, $c);
	}
////////////////////////////////////////////////////////////////
function substrright($s = '', $c = 0){
	return substr_right($s, $c);
	}
////////////////////////////////////////////////////////////////
function getCalledClass(){
	if(function_exists('get_called_class')){
		return get_called_class();
		}else{
	    $arr = array(); 
	    $arrTraces = debug_backtrace();
	    foreach ($arrTraces as $arrTrace){
	       if(!array_key_exists("class", $arrTrace)) continue;
	       if(count($arr)==0) $arr[] = $arrTrace['class'];
	       else if(get_parent_class($arrTrace['class'])==end($arr)) $arr[] = $arrTrace['class'];
	    }
	    return end($arr);
	    }
	}
////////////////////////////////////////////////////////////////

?>