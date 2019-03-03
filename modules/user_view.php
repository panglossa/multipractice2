<?php
if ($this->userid==-1) {
	$this->redirect('index.php');
	} else{
	$data = $this->db->select('users', '*', "id = {$this->userid}");
	$user = array();
	foreach ($data as $row) {
		$user = $row;
		}
	$data = $this->db->select('lesson_items_usage', 'count(*) as numitems', "user = {$this->userid}");
	foreach($data as $row){
		$user['numitems'] = $row['numitems'];
		}
	$data = $this->db->select('lesson_items_usage', 'sum(correct) as allcorrect, sum(wrong) as allwrong', "user = {$this->userid}");
	$c = 0;
	$w = 0;
	foreach($data as $row){
		$c = $row['allcorrect'];
		$w = $row['allwrong'];
		}
	$this->add(o('btn_edituser', TA('index.php?c=user/edit', '[Edit]')));
	$table = o('userinfo', TTable());
	$table->add('User Name: ', $user['name']);
	$table->add('Email: ', $user['email']);
	$table->add('Total XP: ', number_format($user['xp'], 2));
	$table->add('Studied Items: ', $user['numitems']);
	$table->add('Correct Answers: ', $c);
	$table->add('Wrong Answers: ', $w);
	
	$this->add($table);
	}