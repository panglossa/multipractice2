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
class THtml extends TElement {
	var $doctype = '<!DOCTYPE html>';
	var $type = 'html';//just a standard library property
	var $head;//a TPageHead object representing the <head> section of the page
	var $body;//a TPageBody object representing the <body> section of the page
	var $lang = 'en';
	var $dir='ltr';
	var $id = '';
	var $parameters = array();//container for parameters passed to the url
	var $parameters_get = array();//container for GET parameters passed to the page
	var $parameters_post = array();//container for POST parameters passed to the page
	var $css = array();//css file(s) to be linked
	var $js = array();//js file(s) to be linked
	var $style = array();//style to be added to the <head> section of the page
	var $script = array();
	var $title = '';//the page title
	var $icon = '';//a 'favicon' to be displayed e.g. in the address bar or in the browser tab
	var $base = '';//base address for the page
	var $target = '';//default target for links
	var $meta = null;
	var $charset = GJ_CHARSET;
	var $application_name = '';
	var $applicationname = '';
	var $author = '';
	var $description = '';
	var $generator = '';
	var $keywords = array();
	var $content_language = '';
	var $contentlanguage = '';
	var $content_type = '';
	var $contenttype = '';
	var $default_style = '';
	var $defaultstyle = '';
	var $refresh = '';
	var $c = array();
	var $command = array();//contains parameters passed to the 'c' parameter in the form: c=command/subcommand/subsubcommand/&c.
	var $scriptsafter = false;//whether or not to add all js files at the end of the page, to improve loading time
	var $properties = array();
	var $config = null;
	var $modulename = 'home';
	var $module = '';
	////////////////////////////////////////////////////////////////////////
	function __construct($title = '', $content = '', $icon = GJ_DEFAULTICON){
		session_start();
		require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'page_meta.php');
		require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'page_head.php');
		require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'page_body.php');
		$this->properties['lang'] = '';
		$this->properties['dir'] = '';
		$this->properties['id'] = '';
		$this->lang = &$this->properties['lang'];
		$this->dir = &$this->properties['dir'];
		$this->id = &$this->properties['id'];
		$this->getparameters();
		$this->config = TConfig();
		if (isset($this->config->title)){
			$title = $this->config->title;
			}
		if (isset($this->config->icon)){
			$icon = $this->config->icon;
			}
		$this->head = new TPageHead($title, $icon);
		if (isset($this->config->css)){
			$this->head->css = $this->config->css;
			}
		if (isset($this->config->js)){
			$this->head->js = $this->config->js;
			}
		$this->body = new TPageBody();
		$this->meta = &$this->head->meta;
		$this->charset = &$this->head->meta->charset;
		$this->title = &$this->head->title;
		$this->icon = &$this->head->icon;
		$this->js = &$this->head->js;
		$this->style = &$this->head->style;
		$this->script = &$this->head->script;
		$this->css = &$this->head->css;
		$this->items = &$this->body->items;
		$this->keywords = &$this->head->meta->items['name']['keywords'];
		if ($content!=''){
			$this->add($content);
			}
		if (GJ_AUTOLOADMODULE){
			$this->processmodule();
			}
		}
	////////////////////////////////////////////////////////////////////////
	function processmodule(){
		$this->modulename = GJ_DEFAULTMODULE;
		if (count($this->c)>0){
			$this->modulename = $this->c[0];
			}
		if ($this->modulename!=''){
			$modulefilename = 'modules' . DIRECTORY_SEPARATOR . "{$this->modulename}.php";
			if (file_exists($modulefilename)){
				require_once($modulefilename);
				$this->module = new TModule($this);
				}else{
				$this->adderror("Module [{$this->modulename}] not found.");
				$this->modulename  = '';
				}
			}
		}
	////////////////////////////////////////////////////////////////////////
	function adderror($txt){
		$this->add(o(array('class' => 'error'), TDiv($txt)));
		}
	////////////////////////////////////////////////////////////////////////
	function addmessage($txt){
		$this->add(o(array('class' => 'message'), TDiv($txt)));
		}
	////////////////////////////////////////////////////////////////////////
	function received(){
		$res = true;
		foreach (func_get_args() as $param){
			if (!(isset($this->parameters[$param]))) {
				$res = false;
				}
			}
		return $res;
		}
	////////////////////////////////////////////////////////////////////////
	function receivedany(){
		$res = false;
		foreach (func_get_args() as $param){
			if (isset($this->parameters[$param])) {
				$res = true;
				}
			}
		return $res;
		}
	////////////////////////////////////////////////////////////////////////
	function getparameters(){
		foreach($_REQUEST as $key => $val){
			$this->parameters[$key] = $val;
			}
		foreach($_GET as $key => $val){
			$this->parameters_get[$key] = $val;
			}
		foreach($_POST as $key => $val){
			$this->parameters_post[$key] = $val;
			}
		$this->command = array();
		if(isset($this->parameters['c'])){
			$this->command = explode('/', $this->parameters['c']);
			}
		$this->c = &$this->command;
		}
	////////////////////////////////////////////////////////////////////////
	function parm($id, $default = null){
		if(isset($this->parameters[$id])){
			return $this->parameters[$id];
			}else{
			return $default;
			}
		}
	////////////////////////////////////////////////////////////////////////
	function sessionparm($id, $default = null){
		$res = $default;
		if (isset($_SESSION[$id])){
			$res = $_SESSION[$id];
			}
		if(isset($this->parameters[$id])){
			$res = $this->parameters[$id];
			}
		$_SESSION[$id] = $res;
		return $res;
		}
	////////////////////////////////////////////////////////////////////////
	function parm_post($id, $default = null){
		if(isset($this->parameters_post[$id])){
			return $this->parameters_post[$id];
			}else{
			return $default;
			}
		}
	////////////////////////////////////////////////////////////////////////
	function parm_get($id, $default = null){
		if(isset($this->parameters_get[$id])){
			return $this->parameters_get[$id];
			}else{
			return $default;
			}
		}
	////////////////////////////////////////////////////////////////////////
	function parm_session($id, $default = null){
		if (isset($_SESSION[$id])){
			return $_SESSION[$id];
			}else {
			return $default;
			}
		}
	////////////////////////////////////////////////////////////////////////
	function getprefix(){
		return $this->doctype . "\n<html>\n";
		}
	////////////////////////////////////////////////////////////////////////
	function getcontent(){
		if ($this->scriptsafter){
			//You can choose to load .js files after the page content has been loaded.
			$this->body->add($this->head->getjs());
			$this->body->add($this->head->getscripts());
			$this->head->js = array();
			$this->head->script = array();
			}
		if ($this->modulename=='ajax'){
			$this->head->js = array();
			$this->head->css = array();
			}
		$res = $this->head . $this->body;
		return $res;
		}
	////////////////////////////////////////////////////////////////////////
	function addmain(){
		foreach(func_get_args() as $item){
			$this->additem($item);
			}
		}
	////////////////////////////////////////////////////////////////////////
	function add($content = array(), $where = null){
		if (!is_array($content)){
			$content = array($content);
			}
		foreach($content as $item){
			$this->additem($item, $where);
			}
		}
	////////////////////////////////////////////////////////////////////////
	function additem($content = '', $where = null){
		$content = "\n{$content}\n";
		if($where==null){
			if(GJ_AUTOMAIN){
				//auto generate a 'main' div to hold orphan items.
				if ($this->modulename=='ajax'){
					$where = 'ajaxmain';
					}else{ 
					$where = 'main';
					}
				}else{
				//include orphan items right in the main body.
				$where = 'BODY_ITSELF';
				}
			}
		if($where == 'BODY_ITSELF'){
			if(!isset($this->body->items[$where])){
				$this->body->items[$where] = '';
				}
			//include orphan items right in the main body.
			$this->body->items[$where] .= $content;
			}else{
			//include 'parented' items to a suitable div
			$classname = 'T' . GJ_PAGECONTAINERTYPE;
			if(!class_exists($classname)){
				$classname = substr($classname, 1);
				if(!class_exists($classname)){
					$classname = 'TDiv';
					}
				}
			if(!isset($this->body->items[$where])){
				$this->body->items[$where] = new $classname();
				}
			if(is_object($this->body->items[$where])){
				$this->body->items[$where]->add($content);
				}else if(is_string($this->body->items[$where])){
				$this->body->items[$where] .= $content;
				}
			}
		}
	////////////////////////////////////////////////////////////////////////
	function addmodalarea(){
		if ($this->modulename!='ajax'){
			$this->add(
				o(
					array('id' => 'modal_close', 'onclick' => "\$('#modal').hide();"), 
					new TImg('media/cancel.png', 'Fechar')
					) 
				. 
				o(
					'modal_content', 
					new TDiv(
						new TImg('media/wait.gif')
						)
					)
				. 
				"<script>\$('#modal').click(function() { \$('#modal').hide();}); \$('#modal').hide();</script>", 
				'modal'
				);
			}
		}
	////////////////////////////////////////////////////////////////////////
	function addmodulecontent(){
		if (isset($this->module->sections)){
			foreach($this->module->sections as $where => $item){
				if (!isset($this->items[$where])){
					$this->items[$where] = o($where, TDiv());
					}
				$this->items[$where]->add($item);
				}
			if ($this->modulename=='ajax') {
				if (!isset($this->items['ajaxmain'])){
					$this->items['ajaxmain'] = o('ajaxmain', TDiv());
					}
				foreach($this->items['main']->items as $item){
					$this->items['ajaxmain']->add($item);
					}
				unset($this->items['main']);
				}
			}
		}
	////////////////////////////////////////////////////////////////////////
	function show(){
		$this->addmodalarea();
		$this->addmodulecontent();		
		$res = parent::show();
		
		if ((GJ_USETIDY)&&(class_exists('Tidy'))){
		//if (GJ_USETIDY){	
			$config = array(
				'char-encoding' => $this->charset,
				'indent' => TRUE,
				'output-xhtml' => true,
				'wrap' => 150, 
				'new-blocklevel-tags' => 'progress meter details summary command header section article footer aside menu' // This option in necessary for enabling HTML5 new elements! 
				);
			//$tidy = tidy_parse_string($res, $config);
			$tidy = new Tidy();
			$tidy->parseString($res, $config, 'utf8');
			$tidy->cleanRepair();
			$res = $tidy;
			
			}else{
			$res = str_replace("><", ">\r\n<", $res);
			}
		return $res;
		}
	function render(){
		if ((!headers_sent())&&(GJ_SENDHEADERS==true)){
			header('Content-Type:text/html; charset=' . $this->charset);
			}
		echo $this->show();
		}
	////////////////////////////////////////////////////////////////////////
	function output(){
		$this->render();
		}
	////////////////////////////////////////////////////////////////////////
	function load($src, $where = 'main', $type = null){
		if (file_exists($src)){
			$txt = file_get_contents($src);
			if ($type==null){
				if (strpos(strtolower($src) . '|', '.txt|')!==false) {
					$type = 'txt';
					}else if (
						(strpos(strtolower($src) . '|', '.htm|')!==false)
						||
						(strpos(strtolower($src) . '|', '.html|')!==false)
						) {
					$type = 'html';
					}
				}
			if ($type =='html'){
				$this->add($txt, $where);
				}else{
				if ((GJ_MARKDOWN!='')&&(file_exists(GJ_MARKDOWN))){
					require_once(GJ_MARKDOWN);
					$this->add(Markdown($txt), $where);
					}
				}
			}
		}
	////////////////////////////////////////////////////////////////////////
	function redirect($url){
		$this->add("<script>window.location = '{$url}';</script>");
		}
	////////////////////////////////////////////////////////////////////////
	}
class TPage extends THtml {
	var $type = 'html';
	}
?>