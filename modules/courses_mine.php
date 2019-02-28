<?php
$this->loadclass('coursedisplay');
$this->loadcourses();
$mycourses = o('courses', TDiv());

foreach($this->mycourses as $course){
	$mycourses->add(new TCourseDisplay($course));
	}

$this->add(TH2("My Courses") . $mycourses);