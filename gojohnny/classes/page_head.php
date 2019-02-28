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
class TPageHead extends TElement {
	var $title = '';
	var $icon = GJ_DEFAULTICON;
	var $js = array();
	var $css = array();
	var $script = array();
	var $style = array();
	var $charset = GJ_CHARSET;
	var $meta = null;
	var $base = '';//this variable is stored in a <base> element together with the $target variable below.
	var $target = '';//this is stored in a <base> element together with the following $base variable above.
	var $jquery = '';
	var $keywords = array();
	/*******************************/
	function __construct($title = '', $icon = null){
		$this->meta = new TMeta();
		$this->charset = &$this->meta->charset;
		$this->title = $title;
		if ($icon==null){
			$icon = GJ_PATH_WEB . GJ_DEFAULTICON;
			}
		$this->icon = $icon;
		$this->init();
		$this->scripts = &$this->script;
		$this->keywords = &$this->meta->items['name']['keywords'];
		//$this->script(s) refers to javascript code added directly to the head of the page;
		//$this->js refers to javascript files (*.js) referenced in the head of the page
		//any of these, as well as $this->css, can be set as a string or as an array
		}
	/*******************************/
	function init(){
		if (GJ_BASECSS!=''){
			$this->css[] = GJ_BASECSS;
			}
		//jQuery must be obtained separately from http://jquery.com; the version you want to use with g!J must be placed in the lib/jquery folder with the standard jquery.js filename. To do otherwise you must include the file manually
		if(GJ_JQUERY!=''){
			$this->js[] = GJ_JQUERY;
			}
		if((GJ_JQUERYUI_CSS!='')&&(GJ_JQUERYUI_JS!='')){
			$this->js[] = GJ_JQUERYUI_JS;
			$this->css[] = GJ_JQUERYUI_CSS;
			}
		if (GJ_USEGJCSS) {
			$this->css[] = GJ_PATH_WEB . DIRECTORY_SEPARATOR . 'gojohnny.css';
			}
		if (GJ_USEGJFONTS){
			$this->css[] = GJ_PATH_WEB . DIRECTORY_SEPARATOR . 'fonts.css.php?path=' . urlencode(GJ_PATH_WEB . DIRECTORY_SEPARATOR . 'fonts');
			}
		if (GJ_USEGJJS){
			$this->js[] = GJ_PATH_WEB . DIRECTORY_SEPARATOR . 'gojohnny.js';
			}
		}
	/*******************************/
	function resetcss(){
		$this->css = array();
		}
	/*******************************/
	function resetjs(){
		$this->js = array();
		}
	/*******************************/
	function getbase(){
		$res = '';
		$this->base = trim($this->base);
		$this->target = trim($this->target);
		if(($this->base!='')||($this->target!='')){
			$res .= '<base ';
			if($this->base!=''){
				$res .= "href=\"{$this->base}\"";
				}
			if($this->target!=''){
				$res .= "target=\"{$this->target}\"";
				}
			$res .= '>';
			}
		return $res;
		}
	/*******************************/
	function gettitle(){
		return "<title>{$this->title}</title>\n";
		}
	/*******************************/
	function geticon(){
		$this->icon = trim($this->icon);
		if($this->icon!=''){
			return "<link rel=\"icon\" href=\"{$this->icon}\" type=\"image/x-icon\" />\n";
			}else{
			return '';
			}
		}
	/*******************************/
	function getcss(){
		$res = '';
		if(is_array($this->css)){
			foreach($this->css as $css){
				$res .= "<link rel=\"stylesheet\" media = \"all\" href=\"{$css}\" />\n";
				}
			}else if((is_string($this->css))&&(trim($this->css)!='')) {
			$res .= "<link rel=\"stylesheet\" media = \"all\" href=\"{$this->css}\" />\n";
			}
		return $res;
		}
	/*******************************/
	function getjs(){
		$res = '';
		if(is_array($this->js)){
			foreach($this->js as $js){
				$res .= "<script src=\"{$js}\"></script>\n";
				}
			}else if((is_string($this->js))&&(trim($this->js)!='')) {
			$res .= "<script src=\"{$this->js}\"></script>\n";
			}
		return $res;
		}
	/*******************************/
	function getstyle(){
		$res = '';
		if(is_array($this->style)){
			if(count($this->style)>0){
				if(isAssoc($this->style)){
					foreach($this->style as $element => $rules){
						$item = '';
						if(is_array($rules)){
							if(isAssoc($rules)){
								foreach($rules as $key => $val){
									$item .= "{$key}: {$val};\n";
									}
								}else{
								foreach($rules as $rule){
									$item .= "{$rule};\n";
									}
								}
							}else{
							$item = $rules;
							}
						if($item!=''){
							$res .= $element . ' {' . "\n" . $item . "\n" . '}' . "\n";
							}
						}
					}else{
					foreach($this->style as $rule){
						$res .= "{$rule}\n";
						}
					}
				}
			}else{
			$res = $this->style;
			}
		if($res!=''){
			$res = str_replace(';;', ';', $res);
			$res = "<style>\n{$res}\n</style>\n";
			}
		return $res;
		}
	/*******************************/
	function getscripts(){
		$res = '';
		if(is_array($this->script)){
			foreach ($this->script as $item){
				$res .= "{$item}\n";
				}
			}else{
			$res = $this->script;	
			}
		if(trim($res)!=''){
			$res = "<script>\n{$res}\n</script>\n";
			}
		return $res;
		}
	/*******************************/
	function show(){
		$res = "<head>\n<!-- starting page head section -->\n"
		. $this->getbase()
		. $this->meta
		. $this->gettitle()
		. $this->geticon()
		. $this->getcss()
		. $this->getstyle()
		. $this->getjs()
		. $this->getscripts()
		. "\n<!-- finishing page head section -->\n</head>\n";
		return $res;
		}
	/*******************************/
	}

?>