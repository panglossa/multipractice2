<?php
$this->loadcourses();
if (($this->parm('itemid', -1)>0)&&($this->parm('courseid', -1)>0)) {
	//we are working on a specific, selected item
	$selectedcourses = '';
	foreach($this->mycourses as $course) {
		$img = '';
		if ($course['image']!='') {
			$img = "<img height=\"32\" src='data:image/png;base64," . base64_encode($course['image']) . "' />";
			}
		$selectedcourses .= o('', TCheckBox($img . $course['name'], ($course['practice']==1)), array('onclick' => "window.location = 'index.php?c=practice&toggleselect={$course['id']}';")) ;
		}
	$this->add(o('selectedcourses', TGroupBox('Courses to Practice: ', $selectedcourses)));
	$recentitems = array_unique(array_filter(explode(',', $this->parm_session('recentpracticeditems'))));
	$courseid = $this->parm('courseid');
	$course = $this->mycourses[$courseid];
	$itemid = $this->parm('itemid');
	$item = array();
	$data = $this->db->select('lesson_items', '*', "id = {$itemid}");
	foreach ($data as $row) {
		$item = $row;
		}
	$alternative = '';
	$altdata = $this->db->select('user_alternatives', 'content', "item_id = {$itemid} AND user_id = {$this->userid}");
	foreach($altdata as $altdatarow) {
		$alternative .= "\n" . $altdatarow['content'];
		}
	if (trim($alternative)!='') {
		$item['extra1'] .= $alternative;
		}
	$tbl = o('tbl_practice', TTable());
	$practicearea = o('practicearea',TDiv());
	$img = '';
	if (trim($course['image'])!=''){
		$img = "<img width=\"200\" src='data:image/png;base64," . base64_encode($course['image']) . "' />";
		}
	$practicearea->add(o('itemtitle', TDiv($item['name'])));
	$practicearea->add(o('itemcontent', TDiv($item['content'])));
	if (trim($item['info'])!='') {
		$practicearea->add(o('iteminfo', TDiv($item['info'])));
		}
	if (isset($this->parameters['suggestcorrection'])) {
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
				$this->redirect('index.php?c=practice&m=suggestionsent');
			} else {
			$this->parameters['practiceanswer'] = $this->parm('myanswer');
			$form = TForm();
			$form->add(
				TI('Your suggestion: ') . 
				BR . 
				o('usersuggestion', TMemo($this->parm('myanswer'))) . 
				BR . 
				o('usealternative', TCheckBox('Use this as an alternative', true)) . 
				BR . BR .  
				TI('Comments (optional): ') . 
				BR . 
				o('usercomment', TMemo()) .
				BR);
			$practicearea->add(TP('Suggest a correction for this item'));
			$practicearea->add($form);
			}
		}else{
		if (isset($this->parameters['feedback'])) {
			if ($this->parameters['feedback']==1) {
				$practicearea->add(o('msg_correctanswer', TDiv('Your answer is correct!' . $this->smiley()))) ;
				} else {
				$practicearea->add(o('msg_wronganswer', TDiv('Sorry, your answer is wrong!' . $this->sad())));	
				}
			$practicearea->add("<script>
						window.history.replaceState('Object', 'Title', 'index.php?c=practice');
						</script>");
			} else{
			$recentitems[] = $itemid;
			if (count($recentitems)>10){
				array_shift($recentitems);
				}
			$_SESSION['recentpracticeditems'] = implode(',', $recentitems);
			if ($this->match($this->parm('practiceanswer'), $item['extra1'])) {
				$this->updatecorrect($itemid);
				$this->updatecourseusage($courseid, $item['level'], $item['lesson'], $itemid, 0.987);
				
				$this->redirect("index.php?c=practice&courseid={$courseid}&itemid={$itemid}&feedback=1&practiceanswer={$this->parameters['practiceanswer']}");
				
				}else{
				$this->updatewrong($itemid);
				$this->redirect("index.php?c=practice&courseid={$courseid}&itemid={$itemid}&feedback=-1&practiceanswer={$this->parameters['practiceanswer']}");
				}
			}
		}
	$practicearea->add(HR . TP(TI('Your translation: ') . BR . TTT($this->parm('practiceanswer'))) . TP(TI('Accepted translations: ' . BR . TTT(implode(BR, $this->expand_options($item['extra1']))))));
	$practicearea->add(o('btn_continue', TA('index.php?c=practice', '[Continue]')));
	$practicearea->add("<script>jQuery('#btn_continue').focus();</script>");
	$practicearea->add(HR . o('btn_suggest', TA("index.php?c=practice&courseid={$courseid}&itemid={$itemid}&suggestcorrection=1&myanswer={$this->parameters['practiceanswer']}", '[Suggest&nbsp;Correction]')));
	$tbl->add($img . TP('Course: ' . BR . TB($course['name'])), $practicearea);
	$this->add($tbl);
	//$this->add("<script>jQuery('#practiceanswer').focus();</script>");
	///////////////////////////////////////////////////////////////////////////
	} else {
	//we are starting to work on a new item
	$selectedcourses = '';
	if (isset($this->parameters['toggleselect'])) {
		if (isset($this->mycourses[$this->parameters['toggleselect']])) {
			if ($this->mycourses[$this->parameters['toggleselect']]['practice']==1) {
				$newval = 0;
				} else {
				$newval = 1;
				}
			$this->db->update('user_courses', array('practice' => $newval), "user = {$this->userid} AND course = {$this->parameters['toggleselect']}");
			}
		$this->redirect('index.php?c=practice');
		}
	$countdata = $this->db->select('lesson_items_usage GROUP BY course', 'course,COUNT(*) as count');
	$courseids = array();
	foreach($this->mycourses as $course) {
		$img = '';
		if ($course['image']!='') {
			$img = "<img height=\"32\" src='data:image/png;base64," . base64_encode($course['image']) . "' />";
			}
		if ($course['practice']==1) {
			//practice only the selected courses
			foreach($countdata as $countrow) {
				if (($countrow['course']==$course['id'])&&($countrow['count']>5)) {
					//and only if we have studied at least five items 
					$courseids[] = $course['id'];
					}
				} 
			
			}
		$selectedcourses .= o('', TCheckBox($img . $course['name'], ($course['practice']==1)), array('onclick' => "window.location = 'index.php?c=practice&toggleselect={$course['id']}';")) ;
		}
	$this->add(o('selectedcourses', TGroupBox('Courses to Practice: ', $selectedcourses)));
	
	if (count($courseids)>0) {
		$recentitems = array_unique(array_filter(explode(',', $this->parm_session('recentpracticeditems'))));
		if (count($recentitems)>0) {
			$notin = ' AND item NOT IN (' . implode(', ', $recentitems) . ')';
			} else {
			$notin = '';
			}
		$courseid = $courseids[mt_rand(0, count($courseids)-1)];
		$allitems = $this->db->select('lesson_items_usage', '*, 2*wrong-correct as diff', "type > 0 AND user = {$this->userid} AND course = {$courseid} {$notin}", 1, 'diff desc, lastused  asc');
		if (count($allitems)==0) {
			$allitems = $this->db->select('lesson_items_usage', '*, 2*wrong-correct as diff', "type > 0 AND user = {$this->userid} AND course = {$courseid}", 1, 'diff desc, lastused  asc');
			}
		//print_r($allitems);
		if (count($allitems)==0) {
			//something went very wrong, let's try again:
			$try = $this->parm('try', 0);
			if ($try>5) {
				$this->adderror("Something went wrong, we can't retrieve any items to practice." . BR . "courseid = {$courseid}" . BR . 'courseids: ' . implode(', ', $courseids));
				} else {
				$try++;
				$this->redirect("index.php?c=practice&try={$try}");
				}
			}else{
			$item = array();
			$itemindex = -1;
			foreach($allitems as $row){
				$itemindex = $row['item'];
				}
			$data = $this->db->select('lesson_items', '*', "id = {$itemindex}");
			foreach ($data as $row) {
				$item = $row;
				}
			$course = $this->mycourses[$courseid];
			$tbl = o('tbl_practice', TTable());
			$practicearea = o('practicearea',TDiv());
			$img = '';
			if (trim($course['image'])!=''){
				$img = "<img width=\"200\" src='data:image/png;base64," . base64_encode($course['image']) . "' />";
				}
			$practicearea->add(o('itemtitle', TDiv($item['name'])));
			$practicearea->add(o('itemcontent', TDiv($item['content'])));
			if (trim($item['info'])!='') {
				$practicearea->add(o('iteminfo', TDiv($item['info'])));
				}
			$practicearea->add(HR . TI('Your translation: '));
			$form = o('practiceform', TForm());
			$form->addhidden('courseid', $courseid);
			$form->addhidden('itemid', $itemindex);
			$form->add(o('practiceanswer', TEdit($this->parm('practiceanswer'))) . BR);
			$form->buttonlabel = 'Check';
			$practicearea->add($form);
			$tbl->add($img . TP('Course: ' . BR . TB($course['name'])), $practicearea);
			$this->add($tbl);
			$this->add("<script>jQuery('#practiceanswer').focus();</script>");
			}
		} else {
		$this->addmessage('There is nothing to practice!' . BR . 'Take some lessons from your selected courses and try again.');
		}
	}