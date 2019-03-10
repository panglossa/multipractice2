<?php
ob_start("ob_gzhandler");
require_once('consts.php');
require_once('options.php');
require_once(GJ_PATH_LOCAL . '/gojohnny.php');
require_once('tools.php');
require_once(CLASS_PATH . 'multipractice.php');
require_once(CLASS_PATH . 'floatright.php');
require_once(CLASS_PATH . 'floatleft.php');
$page = new TMultiPractice();
$page->add(o('timer', TDiv(
'<div id="showtm" >00:00:00</div>
<button id="btnStart" onclick="startChr()">Start</button>
<button id="btnStop" name="btnStop" onclick="stopChr()">Stop</button>
<button id="btnReset" name="btnReset" onclick="resetChr()">Reset</button>
<script>restorechron();</script>
')));
$page->render();
ob_flush();
?>

