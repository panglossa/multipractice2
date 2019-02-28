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
class TVideo extends TElement {
	var $subtitles = array();
	var $captions = array();
	var $descriptions = array();
	var $chapters = array();
	var $metadata = array();
	/*******************************/
	function __construct($src = '', $poster = '', $width = 0, $height = 0, $autoplay = false, $loop = false, $muted = false, $controls = true, $preload = 'none', $crossorigin = ''){
		$this->init();
		if (is_array($src)){
			foreach(array('src', 'poster', 'width', 'height', 'autoplay', 'loop', 'muted', 'controls', 'preload', 'crossorigin') as $key){
				if (isset($src[$key])){
					$this->p($key, $src[$key]);
					}
				}
			}else{
			foreach(array('src', 'poster', 'width', 'height', 'autoplay', 'loop', 'muted', 'controls', 'preload', 'crossorigin') as $key){
				$this->p($key, $$key);
				}
			}
		}
	/*******************************/
	function addsubtitle($src = '', $lang = 'en', $label){
		if (($src!='')&&($lang!='')){
			if($label==''){
				$label = $lang;
				}
			$this->subtitles[$src]=array('lang' => $lang, 'label' => $label);
			}
		}
	/*******************************/
	function getcontent(){
		$res = '';
		if($this->p('src')!=''){
			$res .= "<a href=\"{$this->properties['src']}\">{$this->properties['src']}</a>\n";
			foreach(array('subtitles', 'captions', 'descriptions', 'chapters', 'metadata') as $item){
				foreach($this->$item as $src => $info){
					$res .= "<track kind=\"{$item}\" src=\"{$src}\" srclang=\"{$info['lang']}\" label=\"{$info['label']}\">\n";
					}
				}
			}
		return $res;
		}
	/*******************************/
	/*******************************/
	}
