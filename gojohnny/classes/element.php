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

class TElement {
	var $items = array();
	var $properties = array(
		'id' => null, 
		'style' => array()
		);
	var $uid;
	var $type = 'element';
	var $named = false;
	var $shorttag = false;
	var $gjversion = '8.0';
	/*******************************/
	function init(){
		$this->type = strtolower(substr(get_class($this), 1));
		$this->uid = md5(uniqid(rand(), TRUE));//assign a unique random id
		$this->setclass();//assign a provisional class from its php class name
		}
	/*******************************/
	function __construct(){
		$this->init();
		if (func_num_args()>0){
			//add to items anything passed on creation
			foreach(func_get_args() as $arg){
				$this->add($arg);
				}
			}
		}
	/*******************************/
	function setclass($cname = null){
		$ok = GJ_AUTOCLASS;
		$cname==trim($cname);
		if ($cname!=''){
			$this->p('class', $cname);
			}else{
			//no class name specified
			if($ok){
				//use PHP class name as a default
				$cname = get_class($this);
				}
			}
		}
	/*******************************/
	function add($content = ''){
		if(!is_array($content)){
			$content = func_get_args();
			}
		foreach($content as $item){
			$this->items[] = trim($item);
			}
		}
	/*******************************/
	function p($aproperty = null, $avalue = null, $extra = null /*used for style properties*/){
		/*
		This function always returns the value of the property indicated in the first parameter, 
		so it can be used both for setting and for getting a property.
		*/
		
		if($aproperty!=null){
			//we have something
			$aproperty = trim($aproperty);
			if(trim($aproperty)=='style'){
				//style is an array
				if ($avalue!==null){
					//we have some value
					if(is_array($avalue)){
						//we are passing one or more style rules
						foreach($avalue as $k => $v){
							$this->properties['style'][$k] = trim($v);
							}
						}else{
						$avalue = trim(strtolower($avalue));
						//$avalue here represents the css property to which a value will be assigned
						//$extra here contains the value to be assigned to a property
						if($extra==null){
							//clear a property
							if(isset($this->properties['style'][$avalue])){
								unset($this->properties['style'][$avalue]);
								}
							return '';
							}else{
							//set the value
							$this->properties['style'][$avalue] = $extra;
							}
						}
					}else{
					return '';
					}
				}else{
				//an ordinary property
				if ($avalue!==null){
					//we have a value
					$this->properties[$aproperty] = $avalue;
					if($aproperty=='id'){
						//we are setting the id of this object
						$this->named = true;
						}
					}
				if(isset($this->properties[$aproperty])){
					return trim($this->properties[$aproperty]);
					}else{
					return '';
					}
				}
			}else{
			return '';
			}
		}
	/*******************************/
	function style($key = null, $val = null){
		//a shortcut to $this->p('style'...
		return $this->p('style', $key, $val);
		}
	/*******************************/
	function setID($id=null){
		if ($id!==null){
			//we have a new id
			$this->p('id', trim($id));
			}else{
			//no new id indicated, use default
			if (isset($this->properties['id'])){
				//object already has an id, leave it alone!
				}else{
				//no current id, no id indicated, set it to the default if allowed
				$this->p('id', $this->getvarname());
				}
			}
		}
	/*******************************/
	function getvarname(){
		$res = '';
		foreach($GLOBALS as $k => $v){
			if(
				   (is_object($v))
				&&(isset($v->uid))
				&&($v->uid==$this->uid)
				){
				$res = $k;
				}
			}
		//it was not possible to get the php variable name,
		//generate an id based on class name and unique id.
		if ((trim($res)=='')&&(GJ_AUTOID==true)) {
			$res = $this->p('class');
			if ($res==''){
				$res = get_class($this);
				}
			$res .= "_{$this->uid}";
			}
		return $res;
		}
	/*******************************/
	function getprefix(){
		$res = '<' . $this->type . $this->getproperties();
		if($this->shorttag!=true){
			$res .= ">";
			}
		return $res;
		}
	/*******************************/
	function getcontent(){
		$res = '';
		if(!$this->shorttag){
			foreach ($this->items as $item){
				if (is_array($item)){
					foreach ($item as $subitem){
						$res .= trim($subitem);
						}
					}else{
					if($item!=null){
						$res .= trim($item);
						}
					}
				}
			}
		return $res;
		}
	/*******************************/
	function getsuffix(){
		if($this->shorttag){
			return '>';
			}else{
			return "</{$this->type}>";
			}
		}
	/*******************************/
	function prefix(){//just a shortcut
		return $this->getprefix();
		}
	/*******************************/
	function content(){//just a shortcut
		return $this->getcontent();
		}
	/*******************************/
	function suffix(){//just a shortcut
		return $this->getsuffix();
		}
	/*******************************/
	function show(){
		$this->setID();
		return $this->getprefix()
			. $this->getcontent()
			. $this->getsuffix();
		}
	/*******************************/
	function render(){
		return $this->show();
		}
	/*******************************/
	public function __toString(){
		return $this->show();
		}
	/*******************************/
	function processstyle(){
		//turn $this->properties['style'] from array to string
		$style = '';
		if (isset($this->properties['style'])){
			if (is_array($this->properties['style'])){
				foreach($this->properties['style'] as $key => $value){
					$style .= "{$key}:{$value}; ";
					}
				}else if (is_string($this->properties['style'])){
				$style = trim($this->properties['style']);
				}
			}
		$this->properties['style'] =  $style;
		}
	/*******************************/
	function getproperties(){
		$res = '';
		$this->processstyle();//turn $this->properties['style'] from array to string
		foreach($this->properties as $key => $value){
			if(is_array($value)){
				$value = implode(',', $value);
				}
			if($value!=''){
				if($value===true){
					$res .= " {$key}";
					}else{
					$value = trim($value);
					if($value!=''){
						$res .= " {$key}=\"{$value}\"";
						}
					}
				}
			}
		return $res;
		}
	/*******************************/
	function unsetproperty($p = ''){
		unset($this->properties[$p]);
		}
	/*******************************/
	function unp($p = ''){
		$this->unsetproperty($p);
		}
	/*******************************/
	function unsetID(){
		$this->p('id', '');//unsetproperty('id');
		$this->named = true;
		}
	/*******************************/
	function unsetclass(){
		$this->unsetproperty('class');
		}
	/*******************************/
	function addtext($s) {
		if ((defined('PARSEDOWN'))&&(file_exists(PARSEDOWN))) {
			require_once(PARSEDOWN);
			$s = (new Parsedown())->text($s);
			}else{
			$s = "<p>{$s}</p>";
			}
		$this->add($s);
		}
	/*******************************/
	}
?>