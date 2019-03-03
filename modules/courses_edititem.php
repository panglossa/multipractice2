<?php
if ($this->isadmin()) {
	$this->loadcourses();
	$this->add(TH4('Lesson Editor'));
	if ((count($this->c)>5)&&(isset($this->courses[$this->c[2]]))) {
		$itemtype = array(
			CONTENT_TYPE_MEDIA => '[text]', 
			CONTENT_TYPE_EXERCISE_TRANSLATION => '[translation exercise]',
			CONTENT_TYPE_EXERCISE_QUESTION => '[question]',
			CONTENT_TYPE_EXERCISE_COMPLETE => '[sentence to complete]'
			);
		$course = $this->courses[$this->c[2]];
		$levelid = $this->c[3];
		$lessonid = $this->c[4];
		$itemid = $this->c[5];
		/////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////
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
				$data = array(
					'name' => $this->parameters['edititem_name'],
					'type' => $this->parameters['edititem_type'],
					'content' => $this->parameters['edititem_content'],
					'info' => $this->parameters['edititem_info'],
					'extra1' => $this->parameters['edititem_extra1'],
					'extra2' => $this->parameters['edititem_extra2']
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
				$this->db->update('lesson_items', $data, "id = {$itemid}");
				//$this->go("courses/edititem/{$course['id']}/{$levelid}/{$lessonid}/{$itemid}");
				$this->go("courses/editlesson/{$course['id']}/{$levelid}/{$lessonid}#item_{$itemid}");
				}
			}
		/////////////////////////////////////////////////////////
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
		$item = array();
		$data = $this->db->select('lesson_items', '*', "id = {$itemid}");
		foreach($data as $row) {
			$item = $row;
			}
		$this->add(TH4("Level: {$level['name']} .::. Lesson: {$lesson['title']}"));
		$this->add(o('btn_edititemcancel', TA("index.php?c=courses/editlesson/{$course['id']}/{$levelid}/{$lessonid}", '[Back&nbsp;to&nbsp;Lesson]')));
		$this->add(TH5("Item: {$item['name']} ({$itemtype[$item['type']]})"));
		$tbl_edititem = o('tbl_edititem', TTable());
		$lst_type = o('edititem_type', TComboBox());
		foreach($itemtype as $key => $val){
			$lst_type->add($key, $val);
			}
		$audio = '[none]';
		if ($item['audio']!='') {
			$audio = "<div id=\"playbtn_{$item['id']}\"><button id=\"play_btn_{$item['id']}\" onclick=\"playPause_{$item['id']}();return false;\">▶️</button> <audio id=\"listenlagu_{$item['id']}\"><source src=\"data:audio/mp3;base64," . base64_encode( $item['audio'] )."\"></audio></div><script>   initAudioPlayer_{$item['id']}();

 function initAudioPlayer_{$item['id']}(){
   var audio_{$item['id']} = new Audio();
   var aContainer_{$item['id']} = document.getElementById('listenlagu_{$item['id']}');
   // assign the audio src
   audio_{$item['id']}.src = aContainer_{$item['id']}.querySelectorAll('source')[0].getAttribute('src');
   audio_{$item['id']}.load();
   audio_{$item['id']}.loop = false;
   //audio_{$item['id']}.play();

   // Set object references
   var playbtn_{$item['id']} = document.getElementById(\"play_btn_{$item['id']}\");

     // Add Event Handling
     playbtn_{$item['id']}.addEventListener(\"click\", playPause_{$item['id']}(audio_{$item['id']}, playbtn_{$item['id']}));
   }

   // Functions
   function playPause_{$item['id']}(audio_{$item['id']}, playbtn_{$item['id']}){
       return function () {
          if(audio_{$item['id']}.paused){
            audio_{$item['id']}.play();
            
          } else {
            audio_{$item['id']}.pause();
            
          } 
       }
   }</script>" . o('edit_removeaudio', TCheckBox('Remove current audio', false));
			}
		$image = '[none]';
		if (trim($item['image'])!='') {
			$image = "<img style=\"max-width:300px;\" src='data:image/png;base64," . base64_encode($item['image']) . "' />" . o('edit_removeimage', TCheckBox('Remove current image', false));
			}
		$lst_type->select($this->parm('edititem_type', $item['type']));
		$tbl_edititem->add('Item Type: ', $lst_type, '&nbsp;');
		$tbl_edititem->add('Item Name: ', o('edititem_name', TEdit($this->parm('edititem_name', $item['name']))), 'A title to appear in lesson summaries.');
		$tbl_edititem->add('Main Content: ', o('edititem_content', TMemo($this->parm('edititem_content', $item['content']))), 'You can use Parsedown formatting <br/>(' . o('', TA('https://parsedown.org/'), array('target' => 'blank')) . ').<br/>1. *italics*, _italics_<br/> 2. **bold**, __bold__<br/>3.~~strikethrough~~<br/>4.ordered lists, like this one<br/><br/>*unordered<br/>*lists<br/>..*sub-lists<br/>..*![](image.url "Images")');
		$tbl_edititem->add('Info: ', o('edititem_info', TMemo($this->parm('edititem_info', $item['info']))), "'Info' may be any relevant information about the content, such as: grammatical explanation, exercise instruction, transcription or pronunciation, examples &amp;c.");
		$tbl_edititem->add(o('lbl_extra1', TSpan('Extra1: ')), o('edititem_extra1', TMemo($this->parm('edititem_extra1', $item['extra1']))), TRowSpan(2, "The use of 'extra' fields varies according to the type of item. It can be just additional relevant information about a topic, examples, reference keys &amp;c.<br/>However, in translation and question exercises, they usually contain the answers that will be used to evaluate the student. </br>In <b>translation exercises</b>, extra1 contains the <b>acceptable translations</b>; </br>in <b>open questions</b>, extra1 contains most common <b>acceptable answers</b>;</br> in <b>yes-no exercises</b>, <b>extra1</b> contains acceptable <b>affirmative answers</b>, while <b>extra2</b> contains acceptable <b>negative answers</b>."));
		$tbl_edititem->add(o('lbl_extra2', TSpan('Extra2: ')), o('edititem_extra2', TMemo($this->parm('edititem_extra2', $item['extra2']))));
		$tbl_edititem->add('Image: ', o('edititem_image', TFile()) . BR . '(max.: 1mb)', 'Current Image: ' . BR . $image);
		$tbl_edititem->add('Audio: ', o('edititem_audio', TFile()) . BR . '(max.: 1mb)', 'Current Audio: ' . BR . $audio);
		$this->add(TForm($tbl_edititem));
		$this->add(o('btn_edititemcancel2', TA("index.php?c=courses/editlesson/{$course['id']}/{$levelid}/{$lessonid}", '[Back&nbsp;to&nbsp;Lesson]')));
		}else{
		$this->go('courses/edit');
		}
	}else{
	$this->go('courses/view');
	}