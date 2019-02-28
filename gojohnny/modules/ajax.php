<?php
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'module.php');
class TModule extends TBaseModule {
	function __construct($aparent = null){
		parent::__construct($aparent);
		//Here the magic happens
		$this->add("Hey you!!!");
		//////////////////////////////
		}
	}
?>
