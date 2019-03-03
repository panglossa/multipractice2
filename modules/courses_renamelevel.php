<?php
if ($this->isadmin()) {
	$this->loadcourses();
	$this->add(TH4('Course Editor'));
	if ((count($this->c)>3)&&(isset($this->courses[$this->c[2]]))) {
		$course = $this->courses[$this->c[2]];
		$levelid = $this->c[3];
		if (isset($this->parameters['rename_level'])) {
			if (trim($this->parameters['rename_level'])=='') {
				$this->adderror('The name of the level must not be blank!');
				}else{
				$this->db->update('course_levels', array('name' => $this->parameters['rename_level']), "id = {$levelid}");
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

		$level = array();
		$data = $this->db->select('course_levels', '*', "id = {$levelid}");
		foreach($data as $row){
			$level = $row;
			}
		$this->add(TH6("Level: {$level['name']}"));
		$this->add(TP('Rename this level to: '));
		$this->add(TForm(o('rename_level', TEdit($this->parm('rename_level', $level['name'])), array('style' => array('width' => '90%'))) . BR));
		}else{
		$this->go('courses/edit');
		}
	}else{
	$this->go('courses/view');
	}

