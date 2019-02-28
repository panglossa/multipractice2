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
class TFileList extends TElement {
	/*******************************/
	function __construct($directory = '.', $extensions = '*', $filter = '', $showpath = false, $container = 'ul'){
		parent::__construct();
		$this->type = 'div';
		$this->files = array();
		$this->filter = strtolower($filter);
		$this->showpath = $showpath;
		$this->container = trim($container);
		if($this->container==''){
			$this->container = 'ul';
			}
		if(!is_array($extensions)){
			$extensions = explode(',', $extensions);
			}
		$this->ext = array();
		foreach($extensions as $e){
			$this->ext[] = str_replace('..', '.', ".{$e}");
			}
		$this->directory = $directory;
		if(is_dir($this->directory)){
	        if ($handle = opendir($this->directory)) {
	            while (false !== ($file = readdir($handle))) {
	                if (($file != ".")&&($file != "..")) {
		                foreach($this->ext as $e){
	                    	$p = strpos(strtolower("{$file}|"), strtolower("{$e}|"));
	                    	if (($p!==false)||($e=='.*')){
		                    	if (($this->filter=='')||(strpos(strtolower($file), $this->filter)!==false)){
		                    		$this->add($file);
		                    		}
		                    	}
		                    }
	                    }
	                }
	            closedir($handle);
	            }
			}
		}
	/*******************************/
	function add($filename){
		$this->files[] = "{$this->directory}/{$filename}";
		if($this->showpath){
			$this->items[$filename] = TA("{$this->directory}/{$filename}");
			}else{
			$this->items[$filename] = TA("{$this->directory}/{$filename}", basename($filename));
			}
		}
	/*******************************/
	function show(){
		$classname = "t{$this->container}";
		$res = new $classname('');
		foreach($this->items as $item){
			$res->add($item);
			}
		return $res->show();
		}
	/*******************************/
	}