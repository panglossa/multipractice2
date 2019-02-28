<?php
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'module.php');
class TModule extends TBaseModule {
	function __construct($aparent = null){
		parent::__construct($aparent);
		//Here the magic happens
		
		$gj = TB('go!Johnny');
		$this->addmain(TJSA("modalajax('index.php?c=ajax')", 'Contact'));
		$this->addmain(
			TH1($this->parent->title)
			, 
			TP("{$gj} is a php class library to help in the building of HTML content while working with object oriented php. Classes are provided for every HTML5 element, as well as for a few handy items such as databases.")
			,
			TP("When using {$gj}, you create a " . TTt('TPage') . " object, add content to it and then render the resulting HTML code. Ex.:")
			,
			TCode("<?php\nrequire_once('gojohnny.php');\n\$page = TPage();\n\$page->addmain(\n	TH1('First Heading'), \n	TP('A paragraph of text.')\n	);\n\$page->render();\n?>")
			,
			TP("A complete HTML5 page will be generated, containing the corresponding " . TTt('&lt;h1>') . " and " . TTt('&lt;p>') . " elements, as specified.")
			,
			TP("A page generated with {$gj} already comes with some useful features to speed up the creation of a webpage. These include:")
			,
			TList(
				'the Blueprint css template, providing a nice visual to your page;'
				, 'the jQuery and jQueryUI libraries, providing essential javascript functionality;'
				, 'a container for modal dialogues, as well as shortcuts to using it with ajax;'
				, 'a database object ready to use, as long as PDO and SQLite are available on your system;'
				, 'other tools like syntax highlighter, markdown notation &amp;c.'
				)
			,
			TP("Every option can be easily change to suit your need or your style.")
			,
			TP("You can always get the latest version at sourceforge:\n")
			,
			TP(
				TA(
					'https://sourceforge.net/projects/gojohnny/', //url 
					TImg('https://sourceforge.net/p/forge/icon?1369932921') . 'https://sourceforge.net/projects/gojohnny/')
				)
			);
			
		//////////////////////////////
		}
	}
?>
