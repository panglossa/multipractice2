<?php
$this->loadclass('coursedisplay');
$course = array();
$this->loadcourses();

//check all courses first
foreach($this->courses as $c){
	if ($c['id']==$this->c[2]) {
		$course = $c;
		}
	}
//if user is taking this course, supersede generic information
foreach($this->mycourses as $c){
	if ($c['id']==$this->c[2]) {
		$course = $c;
		}
	}

if (count($course)>0) {
	$mycourses = o('courses', TDiv());
	$mycourses->add(new TCourseDisplay($course));
	$this->add($mycourses);
	$this->add(TH5('Modules'));
	$levels_container = o('levels_container', TDiv());
	$levelsdata = $this->db->select('course_levels', '*', "course = {$course['id']}", 0, 'itemorder', 'asc');
	$completed = $this->db->select('course_levels_completed', 'level_id, completed', "user_id = {$this->userid} AND course_id = {$course['id']}");
	foreach($levelsdata as $level) {
		$levelimage = '';
		if (trim($level['image'])!=''){
			$levelimage = "<img height=\"100\" src='data:image/png;base64," . base64_encode($level['image']) . "' />&nbsp;" . BR;
			}else{
			$levelimage = "<img height=\"100\" src=\"media/book.jpg\" />&nbsp;" . BR;
			}
		$levelcontent = '';
		$levelcontent .= $levelimage; 
		if ((isset($this->c[3]))&&($this->c[3]==$level['id'])) {
			$lessons = TList();
			$leveldata = $this->db->select('course_levels', '*', "id = {$this->c[3]}");
			$level = array();
			foreach ($leveldata as $row){
				$level = $row;
				}
			$lessonsdata = $this->db->select('lessons', '*', "course = {$this->c[2]} AND level = {$this->c[3]}", 0, 'itemorder');
			foreach($lessonsdata as $row){
				if (isset($this->mycourses[$course['id']])) {
				$lessons->add(TA("index.php?c=study/{$course['id']}/{$level['id']}/{$row['id']}", $row['title'], 'Study this lesson'));
					}else{
					$lessons->add($row['title']);
					}
				}
			$levelcontent .= TI('Content:') . $lessons;
			}
		$completedstatus = '';
		foreach ($completed as $ci) {
			if ($ci['level_id']==$level['id']) {
				$completedstatus = '[Level Completed ✔]';
				}
			}
		$levels_container->add(TSpan(o("level{$level['id']}", TDiv(TH4($level['name']) . TP('&nbsp;' . $level['info']) . $levelcontent . $completedstatus), array('class' => 'course_level', 'onclick' => "window.location = 'index.php?c=courses/view/{$course['id']}/{$level['id']}#level{$level['id']}';"))) . '&nbsp; &nbsp;');
		}
	$this->add($levels_container);
	}else{
	$this->adderror("Course not found.");
	}