<?php
/*
	This file is for setting options for the go!Johnny class library.
	Application settings should be configured in the config.php file.
	*/
$options = array(
	//Any constants used by go!Johnny can be defined here.
	//Ex.: 'GJ_PATH_LOCAL' => dirname(__FILE__)
	'GJ_USEGJFONTS' => false
	, 'GJ_USETIDY' => true
	, 'GJ_AUTOID' => true
	
	);
foreach($options as $key => $val){
	if(!defined($key)){
		define($key, $val);
		}
	}
?>
