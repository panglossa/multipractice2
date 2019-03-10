<?php
if ($this->isadmin()) {
	$this->loadcourses();
	$this->add(TH4('Course Editor'));
	//echo '1';
	if ((count($this->c)>2)&&(isset($this->courses[$this->c[2]]))) {
		$course = $this->courses[$this->c[2]];
		////////////////////////////////////////////////
		if (isset($this->parameters['reorderlevel'])) {
			$levelid = $this->parm('level', -1);
			if ($levelid>-1) {
				$levels = array();
				$data = $this->db->select('course_levels', '*', "course = {$course['id']}", 0, 'itemorder', 'asc');
				$p = 10;
				foreach($data as $row){
					$diff = 0;
					if ($row['id']==$levelid) {
						if ($this->parameters['reorderlevel']=='up') {
							$diff = -15;
							} else{
							$diff = 15;
							}
						}
					$this->db->update('course_levels', array('itemorder' => ($p+$diff)), "id = {$row['id']}");
					$p += 10;
					}
				}
			$this->go("courses/editcontent/{$course['id']}");
			}

		if (isset($this->parameters['reorderlesson'])) {
			$levelid = $this->parm('level', -1);
			$lessonid = $this->parm('lesson', -1);
			if (($levelid>-1)&&($lessonid>-1)) {
				$lessons = array();
				$data = $this->db->select('lessons', '*', "course = {$course['id']} AND level = {$levelid}", 0, 'itemorder', 'asc');
				$p = 10;
				foreach($data as $row){
					$diff = 0;
					if ($row['id']==$lessonid) {
						if ($this->parameters['reorderlesson']=='up') {
							$diff = -15;
							} else{
							$diff = 15;
							}
						}
					$this->db->update('lessons', array('itemorder' => ($p+$diff)), "id = {$row['id']}");
					$p += 10;
					}
				}
			$this->go("courses/editcontent/{$course['id']}");
			}
		////////////////////////////////////////////////
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
		$levels = array();
		$data = $this->db->select('course_levels', '*', "course = {$course['id']}", 0, 'itemorder', 'asc');
		foreach($data as $row){
			$levels[$row['id']] = $row;
			}
		$lessons = array();
		$data = $this->db->select('lessons', '*', "course = {$course['id']}", 0, 'itemorder', 'asc');
		foreach($data as $row){
			$lessons[$row['id']] = $row;
			}
		$tbl_coursecontent = o('tbl_coursecontent', TTable());
		$tbl_coursecontent->addheader('Level ' . o('btn_addlevel', TA("index.php?c=courses/addlevel/{$course['id']}", '[+]&nbsp;Add&nbsp;Level')), 'Lessons');
		$i = 1;
		foreach($levels as $level){
			$lstlessons = TOL();
			foreach($lessons as $lesson){
				if ($lesson['level']==$level['id']) {
					$lstlessons->add(
						TA("index.php?c=courses/editcontent/{$course['id']}&reorderlesson=up&level={$level['id']}&lesson={$lesson['id']}", '↑') . '&nbsp;' . TA("index.php?c=courses/editcontent/{$course['id']}&reorderlesson=down&level={$level['id']}&lesson={$lesson['id']}", '↓')
						. '&nbsp;' . TA("index.php?c=courses/editlesson/{$course['id']}/{$level['id']}/{$lesson['id']}", '[' . $lesson['title'] . '] [...]'));
					}
				}
			$lstlessons->add('&nbsp;'. TA("index.php?c=courses/addlesson/{$course['id']}/{$level['id']}", TI('[+]&nbsp;Add&nbsp;Lesson')));
			$tbl_coursecontent->add($i . '. ' . TB($level['name']) . '&nbsp;' . TA("index.php?c=courses/renamelevel/{$course['id']}/{$level['id']}", TI('[Rename]')) . BR . TA("index.php?c=courses/editcontent/{$course['id']}&reorderlevel=up&level={$level['id']}", '↑') . '&nbsp;' . TA("index.php?c=courses/editcontent/{$course['id']}&reorderlevel=down&level={$level['id']}", '↓'), $lstlessons);
			$i++;
			}
		$this->add($tbl_coursecontent);
		}else{
		$this->go('courses/edit');
		}
	}else{
	$this->go('courses/view');
	}