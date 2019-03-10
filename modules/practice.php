<?php

if ($this->userid==-1) {
	//no user logged
	$this->addmessage('Sorry, you must be logged in to practice.');
	}else{
	//user ok
	if (isset($this->parameters['toggleselect'])) {
		//select / unselect a course to practice; do nothing else
		$course = $this->db->getrow('user_courses', 'practice', "course = {$this->parameters['toggleselect']} AND user = {$this->userid}");
		if ($course['practice']==1) {
			$newval = 0;
			} else {
			$newval = 1;
			}
		$this->db->update('user_courses', array('practice' => $newval), "user = {$this->userid} AND course = {$this->parameters['toggleselect']}");
		$this->go('practice');
		}else{
		//ok, we are free to continue
		if ($this->hasparm('itemid')) {
			//we are continuing to work on an item
			$itemid = $this->parm('itemid');
			}else{
			//we must select an item to practice
			/////////////////////////////////////////
			/////////////////////////////////////////
			$courseids = array();
			$data = $this->db->select('user_courses', 'course', "practice = 1 AND user = {$this->userid}");
			foreach($data as $row) {
				$courseids[] = $row['course'];
				}
			//print_r($courseids);
			if (count($courseids)==0) {
				$this->adderror('There is no course to practice! Line: ' . __LINE__);
				}else{
				$date = DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s'));
				$date->modify("-1 day");
				$onedayago = $date->format('Y-m-d H:i:s');
				//first, try to get an item that has not been practiced over the last 24hours
				//echo "type > 0 AND user = {$this->userid} AND course IN (" . implode(',', $courseids) . ") AND lastpractice < '{$onedayago}'" . "\n";
				$iteminfo = $this->db->getrow(
					'lesson_items_usage', 
					'*', 
					"type > 0 AND user = {$this->userid} AND course IN (" . implode(',', $courseids) . ") AND lastpractice < '{$onedayago}'", 
					1, 
					'lastused', 
					'asc'
					);
				//print_r($iteminfo);
				if (count($iteminfo)>0) {
					$this->db->update('lesson_items_usage', array('lastpractice' => date('Y-m-d H:i:s')), "id = {$iteminfo['id']}");
					}else{
					//echo "\ntrying again\n";
					//if we fail, then let's get the item that hasn't been practiced the longest
					$iteminfo = $this->db->getrow(
						'lesson_items_usage', 
						'*', 
						"type > 0 AND user = {$this->userid} AND course IN (" . implode(',', $courseids) . ")", 
						1, 
						'lastpractice'
						);
					//update the item so it is not repeated right away
					$this->db->update('lesson_items_usage', array('lastpractice' => date('Y-m-d H:i:s')), "id = {$iteminfo['id']}");
					//print_r($iteminfo);
					}
				if (count($iteminfo)==0) {
					$this->adderror('There is no item to practice! Line: ' . __LINE__);
					}else{
					$itemid = $iteminfo['item'];
					}
				}
			
			/////////////////////////////////////////
			/////////////////////////////////////////
			}
		if ($itemid==-1) {
			//somethiing went wrong: we don't have an item to practice!!!
			$this->adderror('No itemid. Line: ' . __LINE__);
			}else{
			//$item = $this->db->getrow('lesson_items', '*', "id = {$itemid}");
			$iteminfo = $this->db->getrow('lesson_items_usage', '*', "item = {$itemid}");
			
			if (($iteminfo['wrong']==0)||($iteminfo['wrong']==$iteminfo['correct'])) {
				//either no mistakes, or no difference between correct and wrong answers
				$diff = 1;
				}else if ($iteminfo['correct']==0){
				//there are mistakes but no correct answer to balance it
				$diff = 10;
				}else{
				//wrong != 0 AND wrong != correct
				//we have wrong and correct answers, get the proportion
				$diff = $iteminfo['wrong'] / $iteminfo['correct'];
				if ($diff>10) {
					$diff = 10;
					}
				if ($diff < 0.01) {
					$diff = 0.01;
					}
				}
			$iteminfo['diff'] = $diff;
			$iteminfo['pushback'] = floor(($diff * 100));
			$date = DateTime::createFromFormat('Y-m-d',date('Y-m-d'));
			$date->modify("-{$iteminfo['pushback']} day");
			
			$iteminfo['newdate'] = $date->format('Y-m-d') . ' ' . str_pad(mt_rand(0, 23), 2, '0', STR_PAD_LEFT) . ':' . str_pad(mt_rand(0, 59), 2, '0', STR_PAD_LEFT) . ':' . str_pad(mt_rand(0, 59), 2, '0', STR_PAD_LEFT);
			$this->db->update('lesson_items_usage', array('lastused' => $iteminfo['newdate'], 'lastpractice' => date('Y-m-d H:i:s')), "id = {$iteminfo['id']}");
			//print_r($iteminfo);
			require_once('parsedown' . DIRECTORY_SEPARATOR . 'Parsedown.php');
			$item = $this->db->getrow('lesson_items', '*', "id = {$iteminfo['item']}");
			$course = $this->db->getrow('courses', '*', "id = {$item['course']}");
			$tbl = o('tbl_practice', TTable());
			$practicearea = o('practicearea',TDiv());
			$img = '';
			if (trim($course['image'])!=''){
				$img = "<img width=\"200\" src='data:image/png;base64," . base64_encode($course['image']) . "' />";
				}
			$practicearea->add(o('itemtitle', TDiv($item['name'])));
			if (trim($item['image'])!=''){
				$practicearea->add("<img style=\"max-width:500px;\" src='data:image/png;base64," . base64_encode($item['image']) . "' />&nbsp;" . BR);
				}
			if ($item['audio']!='') {
				$practicearea->add("<div id=\"playbtn\"><button id=\"play_btn{$item['id']}\" onclick=\"playPause{$item['id']}();return false;\">▶️</button><audio id=\"listenlagu{$item['id']}\"><source src=\"data:audio/mp3;base64," . base64_encode( $item['audio'] )."\"></audio></div><script>initAudioPlayer{$item['id']}();
	function initAudioPlayer{$item['id']}(){
	var audio = new Audio();
	var aContainer = document.getElementById('listenlagu{$item['id']}');
	audio.src = aContainer.querySelectorAll('source')[0].getAttribute('src');
	audio.load();
	audio.loop = false;
	audio.play();
	
	var playbtn = document.getElementById(\"play_btn{$item['id']}\");
	
	  playbtn.addEventListener(\"click\", playPause{$item['id']}(audio, playbtn));
	}
	
	function playPause{$item['id']}(audio, playbtn){
	    return function () {
	       if(audio.paused){
	         audio.play();
	       } else {
	         audio.pause();
	       } 
	    }
	}</script>");
				}
			$practicearea->add(o('itemcontent', TDiv((new Parsedown())->text($item['content']))));
			if (trim($item['info'])!='') {
				$practicearea->add(o('iteminfo', TDiv($item['info'])));
				}
			if (isset($this->parameters['suggestcorrection'])) {
				
				if (isset($this->parameters['usersuggestion'])) {
					//echo 'aaaaaaaaaaaaaaaa';
					$this->db->insert(
							'user_suggestions', 
							array(
								'target' => 'item', 
								'target_id' => $itemid, 
								'user_id' => $this->userid, 
								'created' => date('Y-m-d H:i:s'), 
								'content' => $this->parm('usersuggestion'), 
								'info' => $this->parm('usercomment')
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
						$this->go('practice', 'm=suggestionsent');
					} else {
					//echo 'eeeeeeeeeeeee';
					//$this->parameters['practiceanswer'] = $this->parm('suggestedanswer');
					$form = TForm();
					$form->add(
						TI('Your suggestion: ') . 
						BR . 
						o('usersuggestion', TMemo($this->parm('suggestedanswer'))) . 
						BR . 
						o('usealternative', TCheckBox('Use this as an alternative', true)) . 
						BR . BR .  
						TI('Comments (optional): ') . 
						BR . 
						o('usercomment', TMemo()) .
						BR);
					$practicearea->add(TP('Suggest a correction for this item'));
					$practicearea->add($form . TA('index.php?c=practice', '[Cancel]'));
					$this->add($practicearea);
					}
				///////////////////////////////////////////////
				} else  if ($this->hasparm('practiceanswer')){
				//collect correct answers
				$answers = $item['extra1'];
				if ($item['extra2']!='') {
					$answers .= "\n" . $item['extra2'];
					}
				$alternatives = $this->db->select('user_alternatives', 'content', "item_id = {$item['id']} AND user_id = {$this->userid}");
				foreach($alternatives as $alt) {
					$answers .= "\n" . $alt['content'];
					}
				///////////////////////////////////////
				if($this->hasparm('feedback')){
					if ($this->parm('feedback', 0)==1) {
						$practicearea->add(o('msg_correctanswer', TDiv('Your answer is correct!' . $this->smiley()))) ;
						}else{
						$practicearea->add(o('msg_wronganswer', TDiv('Sorry, your answer is wrong!' . $this->sad())));	
						}
					$practicearea->add("<script>
							window.history.replaceState('Object', 'Title', 'index.php?c=practice');
							</script>");
					$practicearea->add(HR . TP(TI('Your answer: ') . BR . TTT($this->parm('practiceanswer'))) . TP(TI('Accepted answers: ' . BR . TTT(implode(BR, $this->expand($answers))))));
					$practicearea->add(o('btn_continue', TA('index.php?c=practice', '[Continue]')));
					$practicearea->add("<script>jQuery('#btn_continue').focus();</script>");
					$practicearea->add(HR . o('btn_suggest', TA("index.php?c=practice&itemid={$item['id']}&suggestcorrection=1&suggestedanswer={$this->parameters['practiceanswer']}", '[Suggest&nbsp;Correction]')));
					$tbl->add($img . TP('Course: ' . BR . TB($course['name'])), $practicearea);
					$this->add($tbl);
					} else {
					if ($this->match($this->parm('practiceanswer'), $answers)) {
						$this->updatecorrect($itemid);
						$this->updatecourseusage($course['id'], $item['level'], $item['lesson'], $itemid, 0.987);
						$this->redirect("index.php?c=practice&itemid={$itemid}&feedback=1&practiceanswer={$this->parameters['practiceanswer']}");
						} else {
						$this->updatewrong($itemid);
						$this->redirect("index.php?c=practice&itemid={$itemid}&feedback=-1&practiceanswer={$this->parameters['practiceanswer']}");
						}
					}
				}else{
				switch($item['type']) {
					case CONTENT_TYPE_MEDIA:
						break;
					case CONTENT_TYPE_EXERCISE_TRANSLATION:
						$practicearea->add(HR . TI('Your translation: '));
						break;
					case CONTENT_TYPE_EXERCISE_QUESTION:
						$practicearea->add(HR . TI('Your answer: '));
						break;
					case CONTENT_TYPE_EXERCISE_COMPLETE:
						$practicearea->add(HR . TI('Your solution: '));
						break;
					}
				
				$form = o('practiceform', TForm());
				//$form->addhidden('courseid', $course['id']);
				$form->addhidden('itemid', $item['id']);
				$form->add(o('practiceanswer', TEdit($this->parm('practiceanswer'))) . BR);
				$form->buttonlabel = 'Check';
				$practicearea->add($form);
				$tbl->add($img . TP('Course: ' . BR . TB($course['name'])), $practicearea);
				$this->add($tbl);
				$this->add("<script>jQuery('#practiceanswer').focus();</script>");
				}
			}
		$selectedcourses = '';
		$this->loadcourses();
		foreach($this->mycourses as $course) {
			$img = '';
			if ($course['image']!='') {
				$img = "<img style=\"margin:0;\" height=\"32\" src='data:image/png;base64," . base64_encode($course['image']) . "' />";
				}
			$selectedcourses .= TDiv(o('', TCheckBox($img . $course['name'], ($course['practice']==1)), array('onclick' => "window.location = 'index.php?c=practice&toggleselect={$course['id']}';"))) . ' ';
			}
		$this->add(HR . o('selectedcourses', TGroupBox('Courses to Practice: ', $selectedcourses)));
		}
	}
