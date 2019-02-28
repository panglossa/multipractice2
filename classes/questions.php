<?php

class TQuestionsDeprecated {
	var $db;
	var $language = -1;
	var $userid = -1;
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	function __construct($adb, $userid = -1, $alanguage = -1){
		$this->db = $adb;
		$this->userid = $userid;
		$this->language = $alanguage;
		}
	////////////////////////////////////////////////////
	function fetch($type = 'open'){
		$res = $this->db->select("questions_{$type}", '*', "language = {$this->language} AND user_id = {$this->userid}", 0, 'lastused', 'ASC');
		return $res;
		}
	////////////////////////////////////////////////////
	function fetchopen(){
		return fetch('open');
		}
	////////////////////////////////////////////////////
	function fetchtranslate(){
		return fetch('translate');
		}
	////////////////////////////////////////////////////
	function fetchyesno(){
		return fetch('yesno');
		}
	////////////////////////////////////////////////////
	function add($type = 'open', $question = '', $answers = array(), $info = ''){
		if (trim($question)!='') {
			$data = array(
				'question' => $question, 
				'info' => $info, 
				'created' => date('Y-m-d H:i:s'), 
				'lastused' => date('Y-m-d H:i:s'),
				'user_id' => $this->userid,
				'language_id' => $this->language
				);
			switch ($type){
				case 'open':
					$data['correctanswer'] = $answers['correct'];
					$data['wronganswer'] = $answers['wrong'];
					break;
				case 'translate':
					$data['answer'] = implode('|', $answers);
					break;
				case 'yesno':
					$data['answer_yes'] = $answers['yes'];
					$data['answer_no'] = $answers['no'];
					break;
				}
			$this->db->insert("questions_{$type}", $data);
			}
		}
	////////////////////////////////////////////////////
	function addopen($question = '', $correctanswer = '', $wronganswer = '', $info = '') {
		$this->add('open', $question, array('correctanswer' => $correctanswer, 'wronganswer' => $wronganswer), $info);
		}
	////////////////////////////////////////////////////
	function addtranslate($question = '', $answer = '', $info = '') {
		if (is_array($answer)){
			$this->add('translate', $question, $answer, $info);
			}else{
			$this->add('translate', $question, array($answer), $info);
			}
		}
	////////////////////////////////////////////////////
	function addyesno($question = '', $answer_yes = '', $answer_no = '', $info = '') {
		$this->add('yesno', $question, array('answer_yes' => $answer_yes, 'answer_no' => $answer_no), $info);
		}
	////////////////////////////////////////////////////
	function remove($type = 'open', $id = -1) {
		$this->db->query("delete from questions_{$type} where id = {$id} AND user_id = {$this->userid};");
		}
	////////////////////////////////////////////////////
	function count_open(){
		$c1 = $this->db->query('select count(id) from questions_open');
		return $c1[0]['count(id)'];
		}
	////////////////////////////////////////////////////
	function count_translate(){
		$c1 = $this->db->query('select count(id) from questions_translate');
		return $c1[0]['count(id)'];
		}
	////////////////////////////////////////////////////
	function count_yesno(){
		$c1 = $this->db->query('select count(id) from questions_yesno');
		return $c1[0]['count(id)'];
		}
	////////////////////////////////////////////////////
	function countall(){
		return $this->count_open() + $this->count_translate() + $this->count_yesno();
		}
	////////////////////////////////////////////////////
	function countown(){
		$c1 = $this->db->query("select count(id) from questions_open where user_id={$this->userid}");
		$c2 = $this->db->query("select count(id) from questions_translate where user_id={$this->userid}");
		$c3 = $this->db->query("select count(id) from questions_yesno where user_id={$this->userid}");
		return $c1[0]['count(id)'] + $c2[0]['count(id)'] + $c3[0]['count(id)'];
		}
	////////////////////////////////////////////////////
	function countpublic(){
		$c1 = $this->db->query('select count(id) from questions_open where user_id=-1');
		$c2 = $this->db->query('select count(id) from questions_translate where user_id=-1');
		$c3 = $this->db->query('select count(id) from questions_yesno where user_id=-1');
		return $c1[0]['count(id)'] + $c2[0]['count(id)'] + $c3[0]['count(id)'];
		}
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	}