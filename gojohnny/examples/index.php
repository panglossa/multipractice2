<?php
require_once('options.php');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'gojohnny.php');
$page = TPage('go!Johnny - examples');
$page->add(TH1($page->title));
$page->add(
	TP('Here you can find a few examples showing how to use the ' . TB('go!Johnny!') . ' class library.')
	. TP('This page itself is an example of how to create a page, add some paragraphs of text and a list of files.')
	); 

$page->add(TFileList('.', 'php', 'example_'));
$page->add(TH3('Source-code of this page') . 
	TCode(file_get_contents(basename(__FILE__))));
$page->render();
?>