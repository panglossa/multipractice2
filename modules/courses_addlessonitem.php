<?php
if ($this->isadmin()) {
	$this->loadcourses();
	$this->add(TH4('Lesson Editor'));
	if ((count($this->c)>4)&&(isset($this->courses[$this->c[2]]))) {
		$itemtype = array(
			CONTENT_TYPE_MEDIA => '[text]', 
			CONTENT_TYPE_EXERCISE_TRANSLATION => '[translation exercise]',
			CONTENT_TYPE_EXERCISE_QUESTION => '[question]',
			CONTENT_TYPE_EXERCISE_COMPLETE => '[sentence to complete]'
			);
		$course = $this->courses[$this->c[2]];
		$levelid = $this->c[3];
		$lessonid = $this->c[4];
		/////////////////////////////////////////////////////////
		if (isset($this->parameters['edititem_name'])) {
			$isok = true;
			if (trim($this->parameters['edititem_name'])=='') {
				$this->adderror('You must provide a name/title for this item.');
				$isok = false;
				}
			if (trim($this->parameters['edititem_content'])=='') {
				$this->adderror('You must provide some content for this item!');
				$isok = false;
				}
			//////////////////////////////////////////////////
			$image = '';
			if ($_FILES['edititem_image']['size']>0){
				if ($_FILES['edititem_image']['size']>1000000){
					$isok = false;
					$this->adderror('Image file must not exceed 1mb.');
					}else{
					if (trim($_FILES['edititem_image']['name'])!=''){
						$path_parts = pathinfo($_FILES['edititem_image']['name']);
						$ext = strtolower($path_parts['extension']);
						switch($ext){
							case 'jpg':
							case 'jpeg':
								$image = imagecreatefromjpeg($_FILES['edititem_image']['tmp_name']);
								imagepng($image, 'uploads/' . $path_parts['filename'] . '.png');
								$image = file_get_contents('uploads/' . $path_parts['filename'] . '.png');
								break;
							case 'gif':
								$image = imagecreatefromgif($_FILES['edititem_image']['tmp_name']);
								imagepng($image, 'uploads/' . $path_parts['filename'] . '.png');
								$image = file_get_contents('uploads/' . $path_parts['filename'] . '.png');
								break;
							case 'bmp':
								$image = imagecreatefrombmp($_FILES['edititem_image']['tmp_name']);
								imagepng($image, 'uploads/' . $path_parts['filename'] . '.png');
								$image = file_get_contents('uploads/' . $path_parts['filename'] . '.png');
								break;
							case 'png':
								$image = file_get_contents($_FILES['edititem_image']['tmp_name']);
								break;
							default:
								$isok = false;
								$this->adderror('Image must be jpg/jpeg, gif, bmp or png.');
								break;
							}
						}
					}
				}
			//////////////////////////////////////////////////
			$audio = '';
			if ($_FILES['edititem_audio']['size']>0){
				if ($_FILES['edititem_audio']['size']>1000000){
					$isok = false;
					$this->adderror('Audio file must not exceed 1mb.');
					}else{
					$audio = file_get_contents($_FILES['edititem_audio']['tmp_name']);
					}
				}
			//////////////////////////////////////////////////
			if ($isok) {
				$items = $this->db->select('lesson_items', 'itemorder', "lesson = {$lessonid}");
				$pos= 0;
				foreach($items as $i){
					if ($i['itemorder']>$pos) {
						$pos = $i['itemorder'];
						}
					}
				$pos++;
				$data = array(
					'name' => $this->parameters['edititem_name'],
					'lesson' => $lessonid,
					'type' => $this->parameters['edititem_type'],
					'content' => $this->parameters['edititem_content'],
					'info' => $this->parameters['edititem_info'],
					'level' => $levelid,
					'course' => $course['id'],
					'extra1' => $this->parameters['edititem_extra1'],
					'extra2' => $this->parameters['edititem_extra2'],
					'uid' => generateuid(),
					'itemorder' => $pos,
					'created' => date('Y-m-d H:i:s')
					);
				if ($this->parm('edit_removeimage', 0)==1) {
					$data['image'] = '';
					}else{
					if ($image!=''){
						$data['image'] = $image;
						}
					}
				if ($this->parm('edit_removeaudio', 0)==1) {
					$data['audio'] = '';
					}else{
					if ($audio!=''){
						$data['audio'] = $audio;
						}
					}
				$this->db->insert('lesson_items', $data);
				//$this->go("courses/edititem/{$course['id']}/{$levelid}/{$lessonid}/{$itemid}");
				//$this->go("courses/editlesson/{$course['id']}/{$levelid}/{$lessonid}#footer");
				$this->go("courses/addlessonitem/{$course['id']}/{$levelid}/{$lessonid}&m=lessonitemadded");
				}
			}
		
		/////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////
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
		foreach($data as $row) {
			$level = $row;
			}
		$lesson = array();
		$data = $this->db->select('lessons', '*', "id = {$lessonid}");
		foreach($data as $row) {
			$lesson = $row;
			}
		$this->add(TH4("Level: {$level['name']} .::. Lesson: {$lesson['title']}"));
		$this->add(o('btn_edititemcancel', TA("index.php?c=courses/editlesson/{$course['id']}/{$levelid}/{$lessonid}", '[Back&nbsp;to&nbsp;Lesson]')));
		$this->add(TH5("Add New Item to Lesson {$lesson['title']}"));
		$tbl_edititem = o('tbl_edititem', TTable());
		$lst_type = o('edititem_type', TComboBox());
		foreach($itemtype as $key => $val){
			$lst_type->add($key, $val);
			}
		$lst_type->select($this->parm('edititem_type'));
		$tbl_edititem->add('Item Type: ', $lst_type, '&nbsp;');
		$tbl_edititem->add('Item Name: ', o('edititem_name', TEdit($this->parm('edititem_name'))), 'A title to appear in lesson summaries.');
		$tbl_edititem->add('Main Content: ', o('edititem_content', TMemo($this->parm('edititem_content'))), 'You can use Parsedown formatting <br/>(' . o('', TA('https://parsedown.org/'), array('target' => 'blank')) . ').<br/>1. *italics*, _italics_<br/> 2. **bold**, __bold__<br/>3.~~strikethrough~~<br/>4.ordered lists, like this one<br/><br/>*unordered<br/>*lists<br/>..*sub-lists<br/>..*![](image.url "Images")');
		$tbl_edititem->add('Info: ', o('edititem_info', TMemo($this->parm('edititem_info'))), "'Info' may be any relevant information about the content, such as: grammatical explanation, exercise instruction, transcription or pronunciation, examples &amp;c.");
		$tbl_edititem->add(o('lbl_extra1', TSpan('Extra1: ')), o('edititem_extra1', TMemo($this->parm('edititem_extra1'))), TRowSpan(2, "The use of 'extra' fields varies according to the type of item. It can be just additional relevant information about a topic, examples, reference keys &amp;c.<br/>However, in translation and question exercises, they usually contain the answers that will be used to evaluate the student. </br>In <b>translation exercises</b>, extra1 contains the <b>acceptable translations</b>; </br>in <b>open questions</b>, extra1 contains most common <b>acceptable answers</b>;</br> in <b>yes-no exercises</b>, <b>extra1</b> contains acceptable <b>affirmative answers</b>, while <b>extra2</b> contains acceptable <b>negative answers</b>."));
		$tbl_edititem->add(o('lbl_extra2', TSpan('Extra2: ')), o('edititem_extra2', TMemo($this->parm('edititem_extra2'))));
		$tbl_edititem->add('Image: ', o('edititem_image', TFile()) . BR . '(max.: 1mb)', '&nbsp;');
		$tbl_edititem->add('Audio: ', o('edititem_audio', TFile()) . BR . '(max.: 1mb)', '&nbsp;');
		$this->add(TForm($tbl_edititem));
		$this->add(o('btn_edititemcancel2', TA("index.php?c=courses/editlesson/{$course['id']}/{$levelid}/{$lessonid}", '[Back&nbsp;to&nbsp;Lesson]')));
		}else{
		$this->go('courses/edit');
		}
	}else{
	$this->go('courses/view');
	}












