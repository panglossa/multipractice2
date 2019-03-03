<?php
if ($this->isadmin()) {
	$this->loadcourses();
	$this->add(TH4('Course Editor'));
	if ((count($this->c)>2)&&(isset($this->courses[$this->c[2]]))) {
		$course = $this->courses[$this->c[2]];
		if (isset($this->parameters['level_name'])) {
			if (trim($this->parameters['level_name'])=='') {
				$this->adderror('The name of the level must not be blank!');
				}else{
				$this->db->insert('course_levels', array('course' => $course['id'], 'name' => $this->parameters['level_name']));
				$this->go("courses/editcontent/{$course['id']}");
				}
			
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

		$this->add(TH6("Add New Level"));
		$this->add(TP('Level Name: '));
		$this->add(TForm(o('level_name', TEdit($this->parm('level_name')), array('style' => array('width' => '90%'))) . BR));
		}else{
		$this->go('courses/edit');
		}
	}else{
	$this->go('courses/view');
	}

