<?php
if ($this->isadmin()) {
	$this->loadcourses();
	$this->add(TH4('Course Editor'));
	if (isset($this->parameters['newcoursename'])) {
		$isok = true;
		if (trim($this->parm('newcoursename'))=='') {
			$this->adderror('The course must have a name!');
			$isok = false;
			}
		$image = '';
		if ($_FILES['newcourseimage']['size']>0){
			if ($_FILES['newcourseimage']['size']>1000000){
				$isok = false;
				$this->adderror('Image file must not exceed 1mb.');
				}else{
				if (trim($_FILES['newcourseimage']['name'])!=''){
					$path_parts = pathinfo($_FILES['newcourseimage']['name']);
					$ext = strtolower($path_parts['extension']);
					switch($ext){
						case 'jpg':
						case 'jpeg':
							$image = imagecreatefromjpeg($_FILES['newcourseimage']['tmp_name']);
							imagepng($image, 'uploads/' . $path_parts['filename'] . '.png');
							$image = file_get_contents('uploads/' . $path_parts['filename'] . '.png');
							break;
						case 'gif':
							$image = imagecreatefromgif($_FILES['newcourseimage']['tmp_name']);
							imagepng($image, 'uploads/' . $path_parts['filename'] . '.png');
							$image = file_get_contents('uploads/' . $path_parts['filename'] . '.png');
							break;
						case 'bmp':
							$image = imagecreatefrombmp($_FILES['newcourseimage']['tmp_name']);
							imagepng($image, 'uploads/' . $path_parts['filename'] . '.png');
							$image = file_get_contents('uploads/' . $path_parts['filename'] . '.png');
							break;
						case 'png':
							$image = file_get_contents($_FILES['newcourseimage']['tmp_name']);
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
			$this->db->insert('courses', array(
				'name' => $this->parameters['newcoursename'],
				'language' => $this->parameters['newcourselanguage'],
				'name' => $this->parameters['newcourseinfo'],
				'author' => $this->userid,
				'created' => date('Y-m-d H:i:s'), 
				'uid' => generateuid(),
				'image' => $image
				));
			$this->go('courses/edit');
			}
		}
	$tbl_newcourse = o('tbl_newcourse', TTable());
	$tbl_newcourse->add('Course Name: ', o('newcoursename', TEdit($this->parm('newcoursename'))));
	$newcourselanguage = o('newcourselanguage', TComboBox());
	foreach($this->languages as $language) {
		$newcourselanguage->add($language['id'], $language['name']);
		}
	$newcourselanguage->select($this->parm('newcourselanguage'));
	$tbl_newcourse->add('Target Language: ', $newcourselanguage);
	$tbl_newcourse->add('Course Description: ', o('newcourseinfo', TMemo($this->parm('newcourseinfo'))));
	$tbl_newcourse->add('Course Image: ', o('newcourseimage', TFile()));
	$this->add(TForm($tbl_newcourse));		

	}else{
	$this->go('courses/view');
	}