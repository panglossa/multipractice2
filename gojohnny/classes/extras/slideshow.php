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
class TSlideShow extends THtml {
	var $type = 'html';
//	var $slides = array();
	////////////////////////////////////////////////////////////////////////
	function __construct($title = '', $content = array(), $icon = GJ_DEFAULTICON){
		parent::__construct($title, '', $icon);
		$this->add(TH1($title));
		if (is_array($content)){
			foreach($content as $item){
				$this->add($item);
				}
			}else if (is_string($content)){
			$this->add($content);
			}
		}
	////////////////////////////////////////////////////////////////////////
	function add($content){
		$this->slides[] = $content;
		//print_r($this->slides);
		}
	////////////////////////////////////////////////////////////////////////
	function show(){
		if (!(is_array($this->css))){
			$this->css = array();
			}
		$this->css[] = 'slideshow.css';
		$source = '<textarea id="source">';
		$first = true;
		
		foreach($this->slides as $slide){
			if (!$first){
				$source .= "\n\n---\n\n";
				}
			$source .= $slide;
			$first = false;
			}
		$source .= "\n\n---\n\n<i>Slideshow created with <a href=\"https://github.com/gnab/remark\">remarkjs</a></i>.";
		$source .= '</textarea>';
		$this->items = array($source, "    <script src=\"https://remarkjs.com/downloads/remark-latest.min.js\">
    </script>
    <script>
      var slideshow = remark.create();
    </script>
");
		$res = parent::show();
		return $res;
		}
	////////////////////////////////////////////////////////////////////////
	function processmodule(){
		}
	////////////////////////////////////////////////////////////////////////
	function addmodulecontent(){
		}
	////////////////////////////////////////////////////////////////////////
	function addmodalarea(){
		}
	////////////////////////////////////////////////////////////////////////
	}
