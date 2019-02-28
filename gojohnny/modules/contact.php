<?php
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'module.php');
class TModule extends TBaseModule {
	function __construct($aparent = null){
		parent::__construct($aparent);
		//Here the magic happens
		$this->addmain(
			TH1($this->parent->title)
			, 
			TP("Contact Us")
			);
		if ($this->received('email', 'message')){
			$this->add("Thanks, {$this->parameters['email']}! Your message was sent!");
			}else{
			$this->add(TContactForm(array('email' => 'Email: ', 'message' => 'Your Message: ')));
			}
		/*TForm(
			TTable(array(
				array('Name: ', o('name', TEdit($this->parent->parm('name'))))
				,
				array('Email: ', o('email', TEdit()))
				,
				array('Phone: ', o('phone', TEdit()))
				))
			));*/
		//////////////////////////////
		}
	}
?>
