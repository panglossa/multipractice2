<?php

if (isset($this->c[2])) {
	$flnm = 'courses_view_single.php';
	} else{
	$flnm = 'courses_view_all.php';
	}
$this->fetchmodule($flnm);