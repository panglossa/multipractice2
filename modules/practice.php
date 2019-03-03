<?php
if ($this->userid==-1) {
	$this->addmessage('Sorry, you must be logged in to practice.');
	}else{
	if (isset($this->parameters['toggleselect'])) {
		$course = $this->db->getrow('user_courses', 'practice', "course = {$this->parameters['toggleselect']}");
		if ($course['practice']==1) {
			$newval = 0;
			} else {
			$newval = 1;
			}
		$this->db->update('user_courses', array('practice' => $newval), "user = {$this->userid} AND course = {$this->parameters['toggleselect']}");
		//$this->go('practice');
		}	
	$recentitems = array_unique(array_filter(explode(',', $this->parm_session('recentpracticeditems'))));
	$item = array();
	$itemid = -1;
	
	$course = array();
	
	if ($this->hasparm('itemid')) {
		$itemid = $this->parm('itemid');
		
		}else{
		//////////////////////////////////////////////////
		//Select an item to be practiced
		//check if there is anything to practice
		$data = $this->db->select('lesson_items_usage', 'count(*) as numitems', "user = {$this->userid} AND type >" . CONTENT_TYPE_MEDIA);
		$c = -1;
		foreach($data as $row){
			$c = $row['numitems'];
			}
		if ($c>0) {
			//Select a course
			$courseinfo = $this->db->getrow('user_courses', 'course', "user = {$this->userid} AND practice = 1", 1, 'RAND()');
			if (count($courseinfo)>0) {
				$course = $this->db->getrow('courses', '*', "id = {$courseinfo['course']}");
				}
			$candidates = $this->db->select('lesson_items_usage', '*, 2*wrong-correct as diff', "course = {$course['id']} AND user = {$this->userid} AND type > " . CONTENT_TYPE_MEDIA, 0, 'diff desc, lastused  asc');
			if (count($candidates)==0) {
				$this->adderror('Something went wrong; please try again.');
				}else{
				$item = array();//just to be sure... unnecessary, actually
				foreach($candidates as $cand) {
					if ((count($recentitems)==0)||(!in_array($cand['item'], $recentitems))) {
						$itemid = $cand['item'];
						}
					if ($itemid>-1) {
						break;
						}
					}
				if ($itemid>-1) {
					if (count($recentitems)>=10) {
						$x = array_shift($recentitems);
						}
					$recentitems[] = $itemid;
					$_SESSION['recentpracticeditems'] = implode(',', $recentitems);
					}
				}
			if ($itemid==-1) {
				//reload
				$this->go('practice');
				}
			}else{
			$this->adderror("There is nothing to practice! :(");
			}
		//////////////////////////////////////////////////
		//////////////////////////////////////////////////
		//////////////////////////////////////////////////
		//////////////////////////////////////////////////
		}
	if ($itemid>-1) {
		$item = $this->db->getrow('lesson_items', '*', "id = {$itemid}");
		$course = $this->db->getrow('courses', '*', "id = {$item['course']}");
		$tbl = o('tbl_practice', TTable());
		$practicearea = o('practicearea',TDiv());
		$img = '';
		if (trim($course['image'])!=''){
			$img = "<img width=\"200\" src='data:image/png;base64," . base64_encode($course['image']) . "' />";
			}
		$practicearea->add(o('itemtitle', TDiv($item['name'])));
		if ($item['image']!='') {
			$practicearea->add(itemimage($item['image']) . BR);
			}
		if ($item['audio']!='') {
			$practicearea->add(audiobutton($item['audio']));
			}
		$practicearea->add(o('itemcontent', TDiv($item['content'])));
		if (trim($item['info'])!='') {
			$practicearea->add(o('iteminfo', TDiv($item['info'])));
			}
		//////////////////////////////////////////////////
		//Check suggestions
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
