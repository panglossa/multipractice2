<?php
if ($this->isadmin()) {
	$this->loadcourses();
	$this->add(TH4('Course Editor'));
	//echo '1';
	if ((count($this->c)>2)&&(isset($this->courses[$this->c[2]]))) {
		//echo '2';
		$course = $this->courses[$this->c[2]];
		if (isset($this->parameters['editcoursename'])) {
			$isok = true;
			$image = '';
			if (trim($this->parameters['editcoursename'])=='') {
				$isok = false;
				$this->adderror('The course must have a name!');
				}
			if ($_FILES['editcourseimage']['size']>0){
				if ($_FILES['editcourseimage']['size']>1000000){
					$isok = false;
					$this->adderror('Image file must not exceed 1mb.');
					}else{
					if (trim($_FILES['editcourseimage']['name'])!=''){
						$path_parts = pathinfo($_FILES['editcourseimage']['name']);
						$ext = strtolower($path_parts['extension']);
						switch($ext){
							case 'jpg':
							case 'jpeg':
								$image = imagecreatefromjpeg($_FILES['editcourseimage']['tmp_name']);
								imagepng($image, 'uploads/' . $path_parts['filename'] . '.png');
								$image = file_get_contents('uploads/' . $path_parts['filename'] . '.png');
								break;
							case 'gif':
								$image = imagecreatefromgif($_FILES['editcourseimage']['tmp_name']);
								imagepng($image, 'uploads/' . $path_parts['filename'] . '.png');
								$image = file_get_contents('uploads/' . $path_parts['filename'] . '.png');
								break;
							case 'bmp':
								$image = imagecreatefrombmp($_FILES['editcourseimage']['tmp_name']);
								imagepng($image, 'uploads/' . $path_parts['filename'] . '.png');
								$image = file_get_contents('uploads/' . $path_parts['filename'] . '.png');
								break;
							case 'png':
								$image = file_get_contents($_FILES['editcourseimage']['tmp_name']);
								break;
							default:
								$isok = false;
								$this->adderror('Image must be jpg/jpeg, gif, bmp or png.');
								break;
							}
						}
					}
				}
			if ($isok) {
				$data = array(
					'name' => $this->parm('editcoursename'),
					'language' => $this->parm('editcourselanguage'),
					'info' => $this->parm('editcourseinfo')
					);
				if (trim($image)!='') {
					$data['image'] = $image;
					}
				$this->db->update('courses', $data, "id = {$course['id']}");
				$this->go("courses/edit/{$course['id']}");
				}
			}
		$tbl_courseedit = o('tbl_courseedit', TTable());
		$tbl_courseedit->add('Course ID: ', TTT($course['id']) . '&nbsp;' . TI('(The course ID cannot be changed.)'));
		$tbl_courseedit->add('Course Name: ', o('editcoursename', TEdit($this->parm('editcoursename', $course['name']))));
		$editcourselanguage = o('editcourselanguage', TComboBox());
		//$editcourselanguage->add('what', 'aaaaaaaaa');
		foreach($this->languages as $language) {
			$editcourselanguage->add($language['id'], $language['name']);
			}
		$editcourselanguage->select($this->parm('editcourselanguage', $course['language']));
		$tbl_courseedit->add('Target Language: ', $editcourselanguage);
		$tbl_courseedit->add('Course Description: ', o('editcourseinfo', TMemo($this->parm('editcourseinfo', $course['info']))));
		$img = '';
		if (trim($course['image'])!=''){
			$img = "<div style=\"font-style:italic;float:right\">Current Image: <img height=\"100\" src='data:image/png;base64," . base64_encode($course['image']) . "' /></div>";
			}
		$tbl_courseedit->add('Course Image: ', o('editcourseimage', TFile()) . ' ' . $img);
		$this->add(TForm($tbl_courseedit . TA("index.php?c=courses/edit/{$course['id']}", '[Back]')));		
		}else{
		//echo '3';
		$this->go('courses/edit');
		}
	}else{
	//echo '4';
	$this->go('courses/view');
	}