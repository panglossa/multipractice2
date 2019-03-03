<?php
require_once('parsedown' . DIRECTORY_SEPARATOR . 'Parsedown.php');
			

if (($this->userid>-1)&&(count($this->c)>3)) {
	//user is logged, url has the expected number of parts
	$this->loadcourses();
	$courseid = $this->c[1];
	$levelid = $this->c[2];
	$lessonid = $this->c[3];
	$thisisthelastitem = false;
	$itemid = $this->parm('itemid', -1);
	$previousitemid = -1;
	$nextitemid = -1;
	$baseurl = "index.php?c=study/{$courseid}/{$levelid}/{$lessonid}";
	if ($itemid==-1) {
		$data = $this->db->select('user_courses', '*', "course = {$courseid} AND user = {$this->userid}");
		//check last item the user has studied
		foreach ($data as $row) {
			if (($row['level']==$levelid)&&($row['lesson']==$lessonid)) {
				//but this only makes sense if we are at the same lesson!
				$itemid = $row['lessonitem'];
				}
			}
		}
	
	if (isset($this->mycourses[$courseid])) {
		//course id is valid
		$this->loadclass('coursedisplay');
		$course = $this->mycourses[$courseid];
		$level = array();
		$lesson = array();
		$item = array();
		//get level info
		$data = $this->db->select('course_levels', '*', "id = {$levelid} AND course = {$courseid}");
		foreach($data as $row){
			$level = $row;
			}
		//get lesson info
		$data = $this->db->select('lessons', '*', "id = {$lessonid} AND course = {$courseid} AND level = {$levelid}");
		foreach($data as $row){
			$lesson = $row;
			}
		//get lesson items & usage info
		$lessonitems = array();
		$itemusage = $this->db->select('lesson_items_usage', 'id, item, user, course', "course = {$courseid} AND user = {$this->userid}");
		$lst_lessonitems = o('lst_lessonitems', TList());
		$data = $this->db->select('lesson_items', '*', "course = {$courseid} AND level = {$levelid} AND lesson = {$lessonid}", 0, 'itemorder', 'ASC');
		$last = -1;
		$checklastitem = -1;
		foreach($data as $row){
			$checklastitem = $row['id'];//after the loop, it will contain the id of the last item
			$usageid = -1;
			$lessonitems[$row['id']] = $row;
			if ((count($item)==0)||($row['id']==$itemid)) {
				//if we haven't selected an item yet, OR if this is the requested item
				$item = $row;
				}
			if (($itemid==-1)&&(count($item)>0)) {
				//for some reason we selected an item; update $itemid accordingly
				$itemid = $item['id'];
				}
			$status = ITEM_STATUS_NEW;//initially, assume user hasn't studied this item yet
			if ($last==$itemid){
				//if the item of the previous iteration was the selected item,
				$nextitemid = $row['id'];
				//then the item in this iteration is marked as the next in the lesson
				}
			
			foreach($itemusage as $iu) {
				if ($iu['item']==$row['id']) {
					//check if the item in this iteration has already been studied
					$status = ITEM_STATUS_USED;
					}
				if ($iu['item']==$item['id']) {
					//check if the selected item has already been studied
					$usageid = $iu['id'];
					}
				}
			if ($row['id']==$itemid) {
				//the item in the current iteration is the selected item
				$status = ITEM_STATUS_CURRENT;
				$previousitemid = $last;
				//so, the item in the previous iteration is the previous item in the lesson
				}
			
			$last = $row['id']; //to be used in the next iteration
			
			switch ($status) {
				case ITEM_STATUS_NEW:
					//$lst_lessonitems->add(TA("{$baseurl}&itemid={$row['id']}", $row['name']));
					$lst_lessonitems->add($row['name']);
					break;
				case ITEM_STATUS_CURRENT:
					$lst_lessonitems->add(TA("{$baseurl}&itemid={$row['id']}", TB($row['name'])));
					break;
				case ITEM_STATUS_USED:
					$lst_lessonitems->add(TA("{$baseurl}&itemid={$row['id']}", TI($row['name'])));
					break;
				}
			}//end foreach($data as $row){
		//////////////////////////////////////////////////////
		if ($checklastitem==$itemid){
			$thisisthelastitem = true;
			}
		$alternative = '';
		$altdata = $this->db->select('user_alternatives', 'content', "item_id = {$itemid} AND user_id = {$this->userid}");
		foreach($altdata as $altdatarow) {
			$alternative .= "\n" . $altdatarow['content'];
			}
		if (trim($alternative)!='') {
			$item['extra1'] .= $alternative;
			
			}
		//print_r($this->expand($this->noaccents($item['extra1'])));
		$nextitemok = false;
		foreach($itemusage as $iu) {
			if ($iu['item']==$nextitemid){
				$nextitemok = true;
				}
			}
		$this->updatecourseusage($courseid, $levelid, $lessonid, $itemid);
		if ($usageid==-1) {
			$this->db->insert('lesson_items_usage', array('item' => $itemid, 'user' => $this->userid, 'course' => $courseid, 'lastused' => date('Y-m-d H:i:s')));
			} else {
			$this->db->update('lesson_items_usage', array('lastused' => date('Y-m-d H:i:s')), "id = {$usageid}");
			}
		$this->add( o('courses', TDiv(new  TCourseDisplay($course))));
		$this->add(
			o('lessonitemheader', TTable(TA("index.php?c=courses/view/{$courseid}/{$levelid}#level{$levelid}", "Level: {$level['name']}"), "Lesson: {$lesson['title']}")));
		$lessoncontent = o('lessonitemmain', TDiv());
		
		if ($this->parm('suggestcorrection')==1) {
			if (isset($this->parameters['usersuggestion'])) {
				$this->db->insert(
					'user_suggestions', 
					array(
						'target' => 'item', 
						'target_id' => $itemid, 
						'user_id' => $this->userid, 
						'created' => date('Y-m-d H:i:s'), 
						'content' => $this->parameters['usersuggestion'], 
						'info' => $this->parameters['usercomment']
						)
					);
				if ($this->parm('usealternative')==1) {
					$this->db->insert(
						'user_alternatives', 
						array(
							'item_id' => $itemid, 
							'user_id' => $this->userid,
							'content' => $this->parameters['usersuggestion'],
							'created' => date('Y-m-d H:i:s')
							)
						);
					}
				$this->redirect("{$baseurl}&itemid={$itemid}&m=suggestionsent");
				} else {
				$form = TForm();
				$form->add(
					TI('Your suggestion: ') . 
					BR . 
					o('usersuggestion', TMemo($this->parm('myanswer'))) . 
					o('usealternative', TCheckBox('Use this as an alternative', true)) . 
					BR . BR .  
					TI('Comments (optional): ') . 
					BR . 
					o('usercomment', TMemo()) .
					BR);
				$lessoncontent->add(
					TP(TI('Suggest a correction for the item: '))
					. TP(TB((new Parsedown())->text($item['content'])))
					. $form
					);
				}
		}else{
		if ($item['image']!='') {
			$lessoncontent->add("<img style=\"max-width:500px;\" src='data:image/png;base64," . base64_encode($item['image']) . "' />" . BR);
			}
		if ($item['audio']!='') {
			$lessoncontent->add("<div id=\"playbtn\"><button id=\"play_btn\" onclick=\"playPause()\">▶️</button> <audio id=\"listenlagu\"><source src=\"data:audio/mp3;base64," . base64_encode( $item['audio'] )."\"></audio></div><script>   initAudioPlayer();

    function initAudioPlayer(){
      var audio = new Audio();
      var aContainer = document.getElementById('listenlagu');
      // assign the audio src
      audio.src = aContainer.querySelectorAll('source')[0].getAttribute('src');
      audio.load();
      audio.loop = false;
      //audio.play();

      // Set object references
      var playbtn = document.getElementById(\"play_btn\");

        // Add Event Handling
        playbtn.addEventListener(\"click\", playPause(audio, playbtn));
      }

      // Functions
      function playPause(audio, playbtn){
          return function () {
             if(audio.paused){
               audio.play();
               
             } else {
               audio.pause();
               
             } 
          }
      }</script>");
			}
		$lessoncontent->add((new Parsedown())->text($item['content']));
		if ($item['info']!='') {
			$lessoncontent .= TP($item['info']);
			}
		switch($item['type']){
			case CONTENT_TYPE_MEDIA:
				$nextitemok = true;
				break;
			case CONTENT_TYPE_EXERCISE_TRANSLATION:
				if (isset($this->parameters['feedback'])) {
					if ($this->parm('feedback', 'wrong')=='correct') {
						$lessoncontent .= o('msg_correctanswer', TDiv('Your answer is correct!' . $this->smiley()));
						//$nextitemok = true;
						} else {
						$lessoncontent .= o('msg_wronganswer', TDiv('Sorry, your answer is wrong!' . $this->sad())) . TP(o('btn_tryagain', TA("{$baseurl}&itemid={$itemid}", '[Try&nbsp;Again]')));
						}
					$acceptedanswers = implode(BR, $this->expand($item['extra1']));
					$lessoncontent .=   TP(TI('Your Answer Was: ') . BR . TTT($this->parm('usertranslation', '[blank]'))) . TP(TI('Accepted Answer(s): ' . BR . TTT($acceptedanswers))) . TA("{$baseurl}&itemid={$itemid}&suggestcorrection=1&myanswer={$this->parameters['usertranslation']}", '[Suggest&nbsp;Correction]');
					$lessoncontent .= "<script>
					jQuery('#btn_tryagain').focus();
					window.history.replaceState('Object', 'Title', 'index.php?c={$this->parameters['c']}&itemid={$itemid}');
					</script>";
					
					} else if (isset($this->parameters['usertranslation'])) {
					
					if ($this->match($this->parameters['usertranslation'], $item['extra1'])) {
						$this->updatecorrect($itemid);
						$this->touchitem($courseid, $nextitemid);
						$this->updatecourseusage($courseid, $levelid, $lessonid, $itemid, 0.987);
						$this->redirect("{$baseurl}&itemid={$itemid}&feedback=correct&usertranslation={$this->parameters['usertranslation']}");
						} else{
						$this->updatewrong($itemid);
						
						$this->redirect("{$baseurl}&itemid={$itemid}&feedback=wrong&usertranslation={$this->parameters['usertranslation']}");
						}
					
					} else {
					$form = o('frm_translation', TForm());
					$form->buttonlabel = 'Check my answer';
					$form->add(TI('Your Translation: ') . BR . o('usertranslation', TEdit($this->parm('usertranslation'))) . BR);
					$lessoncontent .= $form;
					$lessoncontent .= "<script>
					jQuery('#usertranslation').focus();
					</script>";
					$correctanswer = o('correctanswer', TDiv(implode(BR, $this->expand($item['extra1'])) . TP(TA("{$baseurl}&itemid={$itemid}", '[OK]'))));
					$lessoncontent .= o('showcorrectanswer', TA("javascript:showcorrectanswer();", '[Show&nbsp;Correct&nbsp;Translation]')) . $correctanswer;
					}
				break;
			case CONTENT_TYPE_EXERCISE_QUESTION:
				break;
			case CONTENT_TYPE_EXERCISE_COMPLETE:
				break;
			}
			}
		$lessonnav = '';//TDiv();
		if (!$nextitemok) {
			$nextitemid = -1;
			}
		if ($previousitemid!=-1) {
			$lessonnav .= o('btn_previousitem', TA("{$baseurl}&itemid={$previousitemid}", '&lt;[Previous&nbsp;Item]&lt;')) . BR;
			}
		if ($nextitemid!=-1) {
			$lessonnav .= o('btn_nextitem', TA("{$baseurl}&itemid={$nextitemid}", '&gt;[Next&nbsp;Item]&gt;'));
			if ($this->parm('feedback', 'wrong')=='correct') {
				$lessonnav .= "<script>
					jQuery('#btn_nextitem').focus();
					</script>"; 
					}
			}
		if ($thisisthelastitem) {
			$lessonnav .= o('backtolevel', TA("index.php?c=courses/view/{$courseid}/{$levelid}#level{$levelid}", "Back&nbsp;to&nbsp;Level: {$level['name']}")); 
			}
		$this->add( 
			o('lesson_main', TTable($lst_lessonitems,
			TH6($item['name']) . 
				$lessoncontent,
				$lessonnav
				)
				)
			);
		}else{
		$this->redirect("index.php?c=courses/view/{$courseid}");
		}
	} else {
	$this->redirect('index.php?c=courses');
	}
