<?php
if ($this->isadmin()) {
	$this->loadcourses();
	$this->add(TH4('Lesson Editor'));
	if ((count($this->c)>4)&&(isset($this->courses[$this->c[2]]))) {
		require_once('parsedown' . DIRECTORY_SEPARATOR . 'Parsedown.php');
		$itemtype = array(
			CONTENT_TYPE_MEDIA => '[text]', 
			CONTENT_TYPE_EXERCISE_TRANSLATION => '[translation exercise]',
			CONTENT_TYPE_EXERCISE_QUESTION => '[question]',
			CONTENT_TYPE_EXERCISE_COMPLETE => '[sentence to complete]'
			);
		$course = $this->courses[$this->c[2]];
		$levelid = $this->c[3];
		$lessonid = $this->c[4];
		///////////////////////////////////////////////////
		if (isset($this->parameters['lessonnewtitle'])) {
			if (trim($this->parameters['lessonnewtitle'])=='') {
				$this->adderror('The lesson title must not be blank!');
				
				} else {
				$this->db->update('lessons', array('title' => $this->parameters['lessonnewtitle']), "id = {$lessonid}");
				$this->go("courses/editlesson/{$course['id']}/{$levelid}/{$lessonid}");
				}
			}
		///////////////////////////////////////////////////
		if ((isset($this->parameters['parentlevel']))&&($this->parameters['parentlevel']>-1)) {
			$this->db->update('lessons', array('level' => $this->parameters['parentlevel']), "id = {$lessonid}");
			$this->db->update('lesson_items', array('level' => $this->parameters['parentlevel']), "lesson = {$lessonid}");
			$this->go("courses/editlesson/{$course['id']}/{$this->parameters['parentlevel']}/{$lessonid}");
			}
		///////////////////////////////////////////////////
		if (isset($this->parameters['reorderitem'])) {
			$itemid = $this->parm('itemid');
			$items = array();
			$data = $this->db->select('lesson_items', 'id', "lesson = {$lessonid}", 0, 'itemorder', 'asc');
			$p = 10;
			foreach($data as $row){
				$diff = 0;
				if ($row['id']==$itemid) {
					if ($this->parameters['reorderitem']=='up'){
						$diff = -15;
						}else{
						$diff = 15;
						}
					}
				$this->db->update('lesson_items', array('itemorder' => ($p+$diff)), "id = {$row['id']}");
				$p += 10;
				}
			$this->go("courses/editlesson/{$course['id']}/{$levelid}/{$lessonid}");
			}
		///////////////////////////////////////////////////
		$lesson = array();
		$data = $this->db->select('lessons', '*', "id = {$lessonid}");
		foreach($data as $row) {
			$lesson = $row;
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
			TA("index.php?c=courses/editcontent/{$course['id']}", TB($course['name'])),
			$this->languages[$course['language']]['name'],
			TI($course['info']),
			$img,
			$course['created']
			);
		$items = $this->db->select('lesson_items', '*', "course = {$course['id']} AND level = {$levelid} AND lesson = {$lessonid}", 0, 'itemorder', 'asc');
		$this->add($tbl_courseinfo . HR);
		
		$this->add(TH4("Lesson: {$lesson['title']}"));
		$this->add(o('btn_edititemcancel', TA("index.php?c=courses/editcontent/{$course['id']}", '[Back&nbsp;to&nbsp;Course]')));
		$this->add(o('btn_addlessonitem', TA("index.php?c=courses/addlessonitem/{$course['id']}/{$levelid}/{$lessonid}", '[+]&nbsp;Add&nbsp;Lesson&nbsp;Item')));
		$form = TForm();
		$form->buttonlabel = 'Change';
		$parentlevel = o('parentlevel', TComboBox());
		$levels = $this->db->select('course_levels', '*', "course = {$course['id']}", 0, 'itemorder', 'asc');
		foreach($levels as $l){
			$parentlevel->add($l['id'], $l['name']);
			}
		$parentlevel->select($lesson['level']);
		$form->add('This lesson belongs to the level: ' . $parentlevel);
		$this->add($form);
		
		$form2 = TForm();
		$form2->buttonlabel = 'Rename';
		$form2->add('Lesson Title: ' . o('lessonnewtitle', TEdit($lesson['title'])));
		$this->add($form2);
		$this->add(TA("index.php?c=courses/editlesson/{$course['id']}/{$levelid}/{$lessonid}&showmedia=1", '[Show Images &amp; Audio]'));
		$this->add(TP('This lesson has ' . count($items)  . ' items:'));
		$tbl_lessonitems = o('tbl_lessonitems', TTable());
		$tbl_lessonitems->addheader('#', 'Type', 'Name', 'Audio &amp; Image', 'Content', 'Info', 'Extra1', 'Extra2', 'Created', '&nbsp;');
		$i = 1;
		foreach($items as $item){
			$audio = '';
			if (($item['audio']!='')&&($this->parm('showmedia')==1)) {
			$audio = "<div id=\"playbtn_{$item['id']}\"><button id=\"play_btn_{$item['id']}\" onclick=\"playPause_{$item['id']}()\">▶️</button> <audio id=\"listenlagu_{$item['id']}\"><source src=\"data:audio/mp3;base64," . base64_encode( $item['audio'] )."\"></audio></div><script>   initAudioPlayer_{$item['id']}();

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
      }</script>";
			}
			$image = '';
			if ((trim($item['image'])!='')&&($this->parm('showmedia')==1)) {
				$image = "<img style=\"max-width:300px;\" src='data:image/png;base64," . base64_encode($item['image']) . "' />";
				}
			
			$tbl_lessonitems->add(
				o("item_{$item['id']}", TDiv($i++ . '&nbsp;' . TA("index.php?c=courses/editlesson/{$course['id']}/{$levelid}/{$lessonid}&reorderitem=up&itemid={$item['id']}", '↑') . '&nbsp;' . TA("index.php?c=courses/editlesson/{$course['id']}/{$levelid}/{$lessonid}&reorderitem=down&itemid={$item['id']}", '↓'))), 
				$itemtype[$item['type']], 
				$item['name'], 
				"{$audio}{$image}", 
				(new Parsedown())->text($item['content']), 
				$item['info'], 
				$item['extra1'], 
				$item['extra2'], 
				$item['created'], 
				TA("index.php?c=courses/edititem/{$course['id']}/{$levelid}/{$lessonid}/{$item['id']}#tbl_edititem", '[...]', 'Edit This Item') . '&nbsp;' . TA("index.php?c=courses/removeitem/{$course['id']}/{$levelid}/{$lessonid}/{$item['id']}", '[x]', 'Remove This Item')
				);
			}
		$this->add($tbl_lessonitems);
		$this->add(o('btn_edititemcancel2', TA("index.php?c=courses/editcontent/{$course['id']}", '[Back&nbsp;to&nbsp;Course]')));
		$this->add(o('btn_addlessonitem2', TA("index.php?c=courses/addlessonitem/{$course['id']}/{$levelid}/{$lessonid}", '[+]&nbsp;Add&nbsp;Lesson&nbsp;Item')));		
		}
	}