<?php

/*
Panglossa go!Johnny PHP library
version 8.0
release 2017-07-05
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Ara�atuba - SP - Brazil - 2017
*/
////////////////////////////////////////////////
////////////////////////////////////////////////
//error_reporting(E_ALL ^ E_STRICT);
if (PHP_MAJOR_VERSION >= 7) {
    set_error_handler(function ($errno, $errstr) {
       return strpos($errstr, 'Declaration of') === 0;
    }, E_WARNING);
}
ini_set('display_errors', true);
error_reporting(E_ALL & ~E_STRICT);

////////////////////////////////////////////////
$configfile = 'gojohnny_config.php';
if (file_exists($configfile)){
	require_once($configfile);
	}

$serverpath = 'http://' . $_SERVER['HTTP_HOST'];
$gjwebpath = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
$gjwebpath = $serverpath . '/' . $gjwebpath[count($gjwebpath)-1];
$systempath = dirname(__FILE__);

foreach(array(
	'br' => '<br>',
	'BR' => '<br>',
	'hr' => '<hr>',
	'HR' => '<hr>',
	'GJ_PATH_LOCAL' => dirname(__FILE__), //internal path to the go!Johnny library; used by php
	'GJ_PATH_WEB' => $gjwebpath, //external path to the go!Johnny library; used by css and javascript
	'GJ_CHARSET' => 'utf-8',
	'GJ_DATEFORMAT' => 'Y-m-d',
	'GJ_TIMEFORMAT' => 'H:i:s',
	'GJ_SENDHEADERS' => true,
	'GJ_USEGJFONTS' => false, //include some nice free fonts
	'GJ_USETIDY' => false,
	'GJ_AUTOCLASS' => false,
	'GJ_AUTOID' => true,
	'GJ_AUTOMAIN' => true,
	'GJ_PAGECONTAINERTYPE' => 'div',
	'GJ_USEMATHML' => false,
	'GJ_SHORTCUTS' => true,
	'GJ_OPENGRAPH_METATAGS' => false,
	'GJ_DEFAULTICON' => "{$gjwebpath}/media/gj_32.ico",
	'GJ_DEFAULTFORMMETHOD' => 'POST',
	'GJ_DEFAULTFORMAUTOCOMPLETE' => 'on',
	'GJ_DEFAULTFORMENCTYPE' => 'multipart/form-data',
	'GJ_DEFAULTINPUTTYPE' => 'text',
	'GJ_USEGJCSS' => true,
	'GJ_USEGJJS' => true,
	'GJ_AUTOLOADMODULE' => false,
	'GJ_DEFAULTMODULE' => 'home'
	) as $name => $val){
	if(!defined($name)){
		define($name, $val);//Define only if not already defined in gojohnny_config.php
		}
	}
	/* 
	3rd party libraries
	*/
foreach(array(
	'GJ_BASECSS' => GJ_PATH_WEB . DIRECTORY_SEPARATOR . 'lib/blueprint/screen.css',
	'GJ_JQUERY' => GJ_PATH_WEB . DIRECTORY_SEPARATOR . 'lib/jquery/jquery-3.2.1.min.js',
	'GJ_JQUERYUI_CSS' => GJ_PATH_WEB . DIRECTORY_SEPARATOR . 'lib/jquery-ui-1.12.1/jquery-ui.css',
	'GJ_JQUERYUI_JS'  => GJ_PATH_WEB . DIRECTORY_SEPARATOR . 'lib/jquery-ui-1.12.1/jquery-ui.js',
	'GJ_MARKDOWN' => GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'markdown_extra_1.2.8' . DIRECTORY_SEPARATOR . 'markdown.php',
	'GJ_GESHI' => GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'geshi' . DIRECTORY_SEPARATOR . 'geshi.php'
	) as $name => $val){
	if(!defined($name)){
		define($name, $val);
		}
	}
	

////////////////////////////////////////////////
/** Auxiliary functions.
 *  Generic functions which don't fit in any class or which are too generic and suited to several classes.
 *  A function should be placed here only as a means of last resort. 
 *  Ideal procedure is to place all functions inside class definitions.
 */
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'functions.php');

////////////////////////////////////////////////
////////////////////////////////////////////////
/** Load all classes.
 *  All the files in the /class subfolder are automatically included.
 *  Each file declares one class or, in a few special cases, more than one.
 */
//The TElement base class must be declared first, for almost all other elements descend from it.
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR  . 'element.php');
//Load remaining classes
foreach(array(
	'address'
	, 'p'
	, 'div'
	, 'article'
	, 'aside'
	, 'b'
	, 'bdi'
	, 'canvas'
	, 'caption'
	, 'del'
	, 'dfn'
	, 'em'
	, 'figure'
	, 'figurecaption'
	, 'footer'
	, 'header'
	, 'hgroup'
	, 'h1'
	, 'h2'
	, 'h3'
	, 'h4'
	, 'h5'
	, 'h6'
	, 'i'
	, 'ins'
	, 'kbd'
	, 'legend'
	, 'mark'
	, 'nav'
	, 'pre'
	, 'q'
	, 's'
	, 'samp'
	, 'section'
	, 'small'
	, 'span'
	, 'strong'
	, 'sub'
	, 'sup'
	, 'td'
	, 'th'
	, 'tt'
	, 'u'
	, 'var'
	) as $item){
	eval("class T{$item} extends TElement { }\n");
	}
foreach(array(
	'page'
	, 'a'
	, 'abbr'
	, 'area'
	, 'audio'
	, 'bdo'
	, 'blockquote'
	, 'br'
	, 'button'
	, 'center'
	, 'cite'
	, 'code'
	, 'command'
	, 'comment'
	, 'config'
	, 'data'
	, 'datalist'
	, 'db'
	, 'details'
	, 'dl'
	, 'embed'
	, 'fieldset'
	, 'filelist'
	, 'form'
	, 'hr'
	, 'iframe'
	, 'img'
	, 'input'
	, 'input_checkbox'
	, 'input_color'
	, 'input_date'
	, 'input_datetime'
	, 'input_datetimelocal'
	, 'input_email'
	, 'input_file'
	, 'input_hidden'
	, 'input_image'
	, 'input_month'
	, 'input_number'
	, 'input_password'
	, 'input_radio'
	, 'input_range'
	, 'input_reset'
	, 'input_search'
	, 'input_submit'
	, 'input_tel'
	, 'input_text'
	, 'input_time'
	, 'input_url'
	, 'input_week'
	, 'interface'
	, 'jsa'
	, 'keygen'
	, 'label'
	, 'menu'
	, 'meter'
	, 'object'
	, 'ol'
	, 'output'
	, 'progress'
	, 'ruby'
	, 'select'
	, 'table'
	, 'recordtable'
	, 'textarea'
	, 'tr'
	, 'ul'
	, 'video'
	, 'wbr'
	) as $item){
	require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . "{$item}.php");
	}

foreach(array(
	'contactform'
	, 'loginform'
	, 'slideshow'
	) as $item){
	require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'extras'  . DIRECTORY_SEPARATOR . "{$item}.php");
	}

////////////////////////////////////////////////
	
if(GJ_SHORTCUTS){
	foreach(get_declared_classes() as $classname){
		//create a function for each class
		//thus we can avoid using the keyword 'new' for object creation
		/*
		I know we shouldn't have functions with the same names as classes
		and I know that avoiding the use of a keyword is wrong
		and I know that using eval() is "wrong" (please note the quotation marks)
		but it works for me and you can disable it anytime if it bothers you:
		just define GJ_SHORTCUTS as false, or, more simply, don't use this feature.
		*/
		$c = new ReflectionClass($classname);
		if(($c->hasproperty('gjversion'))&&($c->hasMethod('__construct'))){//make sure it is a go!Johnny class
			$constructor = $c->getMethod('__construct');
			$parms = $constructor->getParameters();
			$parameters = '';
			foreach($parms as $p){
				if(trim($parameters)!=''){
					$parameters .= ', ';
					}
				$parameters .= "\$" . $p->getName();
				}
			eval("function {$classname}(){\n"
			. "	\$class = new ReflectionClass('{$classname}');\n"
			. "	\$instance = \$class->newInstanceArgs(func_get_args());\n"
			. "	return \$instance;\n"
			. "	}\n");
			}
		}
	}	
////////////////////////////////////////////////
?>