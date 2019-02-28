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
class TImg extends TElement {
	////////////////////////////////////////////////
	function __construct($src = '', $alt = '', $width = '', $height = ''){
		parent::__construct();
		$this->shorttag = true;
		if (is_array($src)){
			foreach(array('src', 'alt', 'width', 'height') as $key){
				if(isset($src[$key])){
					$this->p($key, $src[$key]);
					}
				}
			}else{
			foreach(array('src', 'alt', 'width', 'height') as $key){
				$this->p($key, $$key);
				}
			}
		$this->p('title', $this->p('alt'));
		}
	}

class TImgLink extends TImg {
	////////////////////////////////////////////////
	function __construct($src = '', $link = '', $alt = '', $target = '', $width = ''){
		parent::__construct($src, $alt);
		$this->type = 'img';
		$this->url = $link;
		$this->target = $target;
		$this->p('width', $width);
		//$this->p('onclick', "window.location = '{$link}';");
		//$this->style('cursor', 'pointer');
		}
	////////////////////////////////////////////////
	function show(){
		return '<a class="imglink"' 
			. ($this->p('alt')==''?'':" title=\"{$this->properties['alt']}\"") 
			. ($this->target==''?'':" target=\"{$this->target}\"") 
			. " href=\"{$this->url}\">" 
			. parent::show() 
			. "</a>";
		}
	////////////////////////////////////////////////
	}
