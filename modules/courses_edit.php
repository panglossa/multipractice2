<?php
if ($this->isadmin()) {
	$this->loadcourses();
	$this->add(TH4('Course Editor'));
	if (count($this->c)>2) {
		if (isset($this->courses[$this->c[2]])) {
			$course = $this->courses[$this->c[2]];
			if (isset($this->parameters['togglecat'])) {
				$coursecats = $this->db->select('course_category', '*', "category_id = {$this->parameters['togglecat']} AND course_id = {$course['id']}");  
				if (count($coursecats)>0) {
					$this->db->delete('course_category', "category_id = {$this->parameters['togglecat']} AND course_id = {$course['id']}");
					} else{
					$this->db->insert('course_category', array('course_id' => $course['id'], 'category_id' => $this->parameters['togglecat']));
					}
				$this->go("courses/edit/{$course['id']}");
				}else {
				$itemcount = 0;
				$data = $this->db->select('lesson_items', 'count(*) as itemcount', "course = {$course['id']}");
				foreach($data as $row) {
					$itemcount = $row['itemcount'];
					}
					
				$lessoncount = 0;
				$data = $this->db->select('lessons', 'count(*) as lessoncount', "course = {$course['id']}");
				foreach($data as $row) {
					$lessoncount = $row['lessoncount'];
					}
					
				$usercount = 0;
				$data = $this->db->select('user_courses', 'count(*) as usercount', "course = {$course['id']}");
				foreach($data as $row) {
					$usercount = $row['usercount'];
					}
				
				$tbl_courseedit = o('tbl_courseedit', TTable());
				$tbl_courseedit->add('Course ID: ', TTT($course['id']));
				$tbl_courseedit->add('Course Name: ', TB($course['name']));
				$tbl_courseedit->add('Target Language: ', $this->languages[$course['language']]['name']);
				$tbl_courseedit->add('Course Description: ', TI($course['info']));
				$img = '';
				if (trim($course['image'])!=''){
					$img = "<img height=\"100\" src='data:image/png;base64," . base64_encode($course['image']) . "' />&nbsp;";
					}
				$tbl_courseedit->add('Course Image: ', $img);
				$tbl_courseedit->add('Created: ', $course['created']);
				$tbl_courseedit->add('Content: ', TB($itemcount) . ($itemcount<2?' item':' items') . ' organised in ' . TB($lessoncount) . ($lessoncount<2?' lesson':' lessons') . '.');
				$tbl_courseedit->add('Users: ', TB($usercount) . ($usercount==1?' person':' people') . ' currently using this course.');
				$categories = $this->db->select('categories', '*', 1, 0, 'name');
				$coursecats = $this->db->select('course_category', '*', "course_id = {$course['id']}");
				$selectedcats = TDiv();
				foreach($categories as $cat) {
					$isselected = false;
					foreach($coursecats as $cc) {
						if ($cc['category_id']==$cat['id']) {
							$isselected = true;
							}
						}
					$selectedcats->add('<nobr>' . o('', TCheckBox($cat['name'], $isselected), array('onclick' => "window.location = 'index.php?c=courses/edit/{$course['id']}&togglecat={$cat['id']}';")) . '</nobr>');
					}
				$tbl_courseedit->add('Categories: ', $selectedcats);
				$this->add($tbl_courseedit);
				$tbl_courseedittoolbar = o('tbl_courseedittoolbar', TTable());
				$tbl_courseedittoolbar->add(
					TA("index.php?c=courses/editinfo/{$course['id']}", 'Edit Course Info'), 
					TA("index.php?c=courses/editcontent/{$course['id']}", 'Edit Course Content'), 
					TA("index.php?c=courses/remove/{$course['id']}", 'Remove This Course')
					);
				$this->add(HR . $tbl_courseedittoolbar);
				}
			} else {
			$this->go('courses/edit');
			}
		} else{
		$lst_courses = TList();
		foreach($this->courses as $c) {
			if ($c['author']==$this->userid) {
				$lst_courses->add(TA("index.php?c=courses/edit/{$c['id']}", $c['name']));
				}
			}
		$this->add(o('btn_createcourse', TA("index.php?c=courses/create", '[Create a New Course]')));
		$this->add(TP('Courses created by you:'));
		$this->add($lst_courses);
		}
	}else{
	$this->go('courses/view');
	}
