<?php
if(count($this->c)>2) {
	$this->loadcourses();
	if (isset($this->courses[$this->c[2]])) {
		$course = $this->courses[$this->c[2]];
		if ($this->parm('confirm', 0)==1) {
			$notyet = true;
			$data = $this->db->select('user_courses', 'id, course', "user = {$this->userid} AND course = {$course['id']}");
			foreach($data as $row) {
				if ($row['course']==$course['id']) {
					$notyet = false;
					}
				}
			if ($notyet) {
				$now = date('Y-m-d H:i:s');
				$this->db->insert('user_courses', array(
					'user' => $this->userid,
					'course' => $course['id'],
					'started' => $now,
					'lastused' => $now,
					'xp' => 0.001
					));
				}
			$this->redirect('index.php?c=courses/mine');
			} else {
			$this->loadclass('coursedisplay');
			$this->add(o('courses', TDiv(new TCourseDisplay($course))));
			$this->add(TP('Do you really want to start this course?'));
			$this->add(
				o(
					'yesno', 
					TTable(
						TA("index.php?c=courses/start/{$course['id']}&confirm=1", '[Yes,&nbsp;I&nbsp;want&nbsp;to&nbsp;start&nbsp;this&nbsp;course]'), 
						TA('index.php?c=courses', 'Cancel')
						)
				));
			}
		} else {
		$this->redirect('index.php?c=courses');
		}
	} else {
	$this->redirect('index.php?c=courses');
	}