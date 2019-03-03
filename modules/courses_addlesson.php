<?php
if ($this->isadmin()) {
	$this->loadcourses();
	$this->add(TH4('Course Editor'));
	if ((count($this->c)>3)&&(isset($this->courses[$this->c[2]]))) {
		$course = $this->courses[$this->c[2]];
		$levelid = $this->c[3];
		if (isset($this->parameters['lesson_name'])) {
			if (trim($this->parameters['lesson_name'])=='') {
				$this->adderror("The lesson must have a name!");
				} else {
				$pos = 0;
				$data = $this->db->select('lessons', 'itemorder', "level = {$levelid}");
				foreach($data as $row){
					if($row['itemorder']>$pos) {
						$pos = $row['itemorder'];
						}
					}
				$pos += 1;
				$this->db->insert('lessons', array('title' => $this->parameters['lesson_name'], 'course' => $course['id'], 'level' => $levelid, 'author' => $this->userid, 'created' => date('Y-m-d H:i:s'), 'itemorder' => $pos));
				$this->go("courses/editcontent/{$course['id']}");
				}
			}
		$levels = array();
		$data = $this->db->select('course_levels', '*', "course = {$course['id']}", 0, 'itemorder', 'asc');
		foreach($data as $row) {
			$levels[] = $row;
			}
		$img = '';
		if (trim($course['image'])!=''){
			$img = "<img height=\"50\" src='data:image/png;base64," . base64_encode($course['image']) . "' />&nbsp;";
			}
		$tbl_courseinfo = o('tbl_courseinfo', TTable());
		$tbl_courseinfo->addheader('Course ID:',
			'Course Name:',
			'Target Language:',
			'Course Description:',
			'Course Image:',
			'Created:');
		
		$tbl_courseinfo->add(TTT($course['id']),
			TB($course['name']),
			$this->languages[$course['language']]['name'],
			TI($course['info']),
			$img,
			$course['created']
			);
		$this->add($tbl_courseinfo . HR);
		$this->add(TH6("Add New Lesson"));
		$lst_levels = o('level', TComboBox());
		foreach($levels as $level){
			$lst_levels->add($level['id'], $level['name']);
			}
		$lst_levels->select($levelid);
		$this->add(TForm(TP('Level:&nbsp;' . $lst_levels) .TP('Lesson Name: ' . BR . o('lesson_name', TEdit($this->parm('lesson_name')), array('style' => array('width' => '90%'))))));
		}else{
		$this->go('courses/edit');
		}
	}else{
	$this->go('courses/view');
	}