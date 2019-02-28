<?php
require_once('options.php');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'gojohnny.php');
$page = TPage('go!Johnny - examples');
$page->add(TH1($page->title));
$page->add(TA('index.php', 'Back'));
$page->add(
	TP('')
	); 
$page->add(TH3('Source-code of this page') . 
	TCode(file_get_contents(basename(__FILE__))));
$page->render();
?>