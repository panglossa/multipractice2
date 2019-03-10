<?php

$general = TDiv();
$mine = TDiv();
$lb_courses = TList();

$this->loadcourses();
$i = 1;
foreach($this->courses as $c) {
	if ($i<=20) {
		$img = '';
		if (trim($c['image'])!=''){
			$img = "<img height=\"32\" src='data:image/png;base64," . base64_encode($c['image']) . "' />&nbsp;";
			}
		$lb_courses->add($img . $c['name']);
		}
	$i++;
	}
if (count($this->courses)>20) {
	$lb_courses->add(TI('... and more'));
	}
$general->add(TH4('Currently Available Courses') . $lb_courses);

if ($this->userid>-1) {
	$lb_mycourses = TList();
	foreach($this->mycourses as $c) {
		$img = '';
		if (trim($c['image'])!=''){
			$img = "<img height=\"32\" src='data:image/png;base64," . base64_encode($c['image']) . "' />&nbsp;";
			}
		$lb_mycourses->add($img . $c['name']);
		}
	if (count($lb_mycourses->items)>0) {
		$mine->add(TH4('Your Current Courses') . $lb_mycourses);
		}
	}


$this->add(o('home_courses', TTable(array(array($general, $mine)))));