<?php
/*
	This file is for configuring application settings.
	Options for the go!Johnny class library should be set in the config.php file.

	"$this" here refers to the TConfig class object. After loading these data it will create a member variable referencing each of these keys, so, for instance, for the key 'title' there will be a variable $this->title referencing it, and so on.

	Values indicated here will be overridden by those found in the `config` database table.

	*/
///////////////////////////////////////////////////////////////
/*
	Settings which depend on the current server.
	*/
//assuming WAMP/LAMP in localhost:

$this->data = array(
	/*
	General Settings
	*/
	'gojohnny' => GJ_PATH_LOCAL,/* REQUIRED!!! */
	/*
	Database access:
	*/
	'db_mode' => 'mysql' /* 'sqlite' */, 
	'db_database' => 'multipractice2' /*'data' . DIRECTORY_SEPARATOR . 'mp_main.sqlite' */ ,
	'db_user' => 'root',
	'db_password' => '1218635'
	);
///////////////////////////////////////////////////////////////
/*
	Settings common to all environments
	*/
$this->data['icon'] = 'media/multipractice_icon_64.ico';
$this->data['css'] = array(
	'https://fonts.googleapis.com/css?family=Imprima&amp;subset=latin-ext' 
	, 'multipractice.css'
	);
	
$this->data['js'] = array(
	GJ_PATH_WEB . '/lib/jquery/jquery.js'
	, GJ_PATH_WEB . '/gojohnny.js'
	, 'multipractice.js'
	);
$this->data['title'] = 'MultiPractice';
$this->data['version'] = '2.0';
$this->data['dateformat'] = 'Y-m-d';
///////////////////////////////////////////////////////////////
?>
