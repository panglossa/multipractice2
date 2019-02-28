<?php
class TMultiPracticeApi extends TMultiPractice {
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	function __construct(){
		parent::__construct();
		/*
		$this->username = '';
		$this->userid = -1;
		$this->configdb = TDB(
			$this->config->db_configdb, 
			$this->config->db_mode
			);
		$this->db = TDB(
			$this->config->db_database, 
			$this->config->db_mode
			);
		$this->config->db = &$this->configdb;
		$this->config->readdb();*/
		//$this->languages = $this->db->select('languages', '*', "user_id = -1 OR user_id = {$this->userid}", 0, 'LOWER(name), englishname');
		switch ($this->parm('action')){
			case 'fetch':
				echo json_encode($this->api_fetchquestion($this->parm('username'), $this->parm('password'), $this->parm('id')));
				break;
			case 'session':
				//echo json_encode($this->api_session($this->parm('username'), $this->parm('password')));
				//print_r($this->parameters);
				echo json_encode($this->api_session($this->parm('username'), $this->parm('password'), $this->parm('language', -1)));
				break;
			case 'update':
				$this->api_updatequestion($this->parm('username'), $this->parm('password'), $this->parm('id'), $this->parm('iscorrect', 0));
				break;
			case 'edit':
				$this->api_editquestion($this->parm('username'), $this->parm('password'), $this->parm('id'), $this->parm('question'), $this->parm('answer1'), $this->parm('answer2'), $this->parm('info'), $this->parm('language')); 
				break;
			case 'touch':
				$this->api_touchquestion($this->parm('username'), $this->parm('password'), $this->parm('id'));
				break;
			case 'login':
				echo $this->api_login($this->parm('username'), $this->parm('password'));
				break;
			case 'languages':
				echo json_encode($this->api_languages($this->parm('username'), $this->parm('password'), $this->parm('selected', 1)));
				break;
			case 'questions':
				echo json_encode($this->api_questions($this->parm('username'), $this->parm('password'), $this->parm('type', 'open'), $this->parm('language')));
				break;
			case 'addquestion':
				$this->api_addquestion($this->parm('username'), $this->parm('password'), $this->parm('language'), $this->parm('type'), $this->parm('question'), $this->parm('answer1'), $this->parm('answer2'), $this->parm('info')); 
				break;
			case 'languageicon':
				$this->api_languageicon($this->parm('code'));
				break;
			}
		}
	////////////////////////////////////////////////////	
	////////////////////////////////////////////////////
	function api_addquestion($username, $password, $language, $type, $question, $answer1, $answer2, $info){
		if($this->api_checkcredentials($username, $password)){
			if (($language>-1)&&(trim($question)!='')&&(trim($type)!='')){
				$pastdate = date('Y-m-d H:i:s', mktime(
					mt_rand(0, 23), 
					mt_rand(0, 59), 
					mt_rand(0, 59), 
					mt_rand(1, 12), 
					mt_rand(0, 30), 
					mt_rand(2009, 2017)));
				$data = array(
					'question' => $question,
					'user_id' => $this->userid,
					'language_id' => $language,
					'info' => $info,
					'lastused' => $pastdate,
					'created' => date('Y-m-d H:i:s'),
					'answer1' => $answer1,
					'answer2' => $answer2,
					'type' => $type
					);
				$this->db->insert("questions_user_{$this->userid}", $data);
				}
			}
		}
	////////////////////////////////////////////////////
	function api_questions($username, $password, $type, $languageid){
		$res = array();
		if($this->api_checkcredentials($username, $password)){
			$data = $this->db->select(
				"questions_user_{$this->userid}", 
				'id, question, language_id', 
				"active = 1 AND type = '{$type}' AND language_id = {$languageid}"
				);
			foreach($data as $row){
				$row['language_name'] = '';
				foreach($this->languages as $language){
					if ($language['id']==$row['language_id']){
						$row['language_name']==$language['name'];
						}
					}
				$res[] = $row;
				}
			}
		return $res;
		}
	////////////////////////////////////////////////////
	function api_languages($username, $password, $selected){
		$res = array();
		if($this->api_checkcredentials($username, $password)){
			if ($selected==1){
				foreach($this->userlanguages as $language){
					if ($language['id']!=-1){
						unset($language['language_id']);
						$res[] = $language;
						}
					}
				}else{
				foreach($this->languages as $language){
					if ($language['id']!=-1){
						$res[$language['id']] = $language;
						}
					}
				$res = $this->languages;
				}
			}
		return $res;
		}
	////////////////////////////////////////////////////
	function api_languages_BAK($username, $password, $selected){
		$res = array();
		if($this->api_checkcredentials($username, $password)){
			if ($selected==1){
				$mylangs = $this->db->select('selectedlanguages', '*', "user_id = {$this->userid}");
				foreach($this->languages as $language){
					foreach($mylangs as $mine){
						if ($mine['language_id']==$language['id']){
							$res[] = $language;
							}
						}
					}
				}else{
				foreach($this->languages as $language){
					$res[] = $language;
					}
				}
			}
		//return array('languages' => $res);
		//print_r($res);
		return $res;
		}	
	////////////////////////////////////////////////////
	function api_languageicon($code){
		
		$filename = "media/{$code}.png";
		if (file_exists($filename)){
			require_once(CLASS_PATH . 'simpleimage.php');
			$image = new SimpleImage();
			$image->load($filename);
			$image->resizeToHeight(48);
			header("Content-type: image/png");
			header("Accept-Ranges: bytes");
			header('Content-Length: ' . filesize($filename));
			header("Last-Modified: Fri, 03 Mar 2004 06:32:31 GMT");
			//readfile($filename);
			$image->output();
			
			}else{
			echo "File {$filename} not found.";
			}
		}
	////////////////////////////////////////////////////
	function api_touchquestion($username, $password, $id){
		if($this->api_checkcredentials($username, $password)){
			$nowish = date('Y-m-d H:i:s', mktime(
					date('H'), 
					mt_rand(0, date('i')), 
					mt_rand(0, date('s')), 
					date('n'), 
					date('j'), 
					date('Y')));
			$this->db->update(
				"questions_user_{$this->userid}", 
				array('lastused' => $nowish), 
				"id = {$id}"
				);
			}
		}
	////////////////////////////////////////////////////	
	function api_fetchquestion($username, $password, $id = ''){
		$res = array();
		if($this->api_checkcredentials($username, $password)){
			$data = $this->db->select("questions_user_{$this->userid}", '*', "id = {$id}");
			foreach($data as $row){
				$res = $row;
				}
			$res['language_name'] = '';
			foreach($this->languages as $language){
				if ($res['language_id']==$language['id']) {
					$res['language_name'] = $language['name'];
					$res['language_code'] = $language['code'];
					}
				}
			}
		return $res;
		}
	////////////////////////////////////////////////////
	function api_session_BAK($username, $password, $language = -1){
		$res = array();
		if($this->api_checkcredentials($username, $password)){
			$res =  $this->getquestion($language);
			$res['language_name'] = '';
			foreach($this->languages as $language){
				if ($res['language_id']==$language['id']){
					if ((trim($language['englishname'])!='') && ($language['englishname']!=$language['name'])){
						$language['name'] = "{$language['name']} ({$language['englishname']})";
						}
					$res['language_name'] = $language['name'];
					}
				}
			}
		return $res;
		}
	////////////////////////////////////////////////////	
	////////////////////////////////////////////////////
	function api_session($username, $password, $language = -1){
		$res = array();
		if($this->api_checkcredentials($username, $password)){
			$res =  $this->getquestion($language);
			//print_r($res);
			$res['language_name'] = '';
			$res['language_code'] = '';
			foreach($this->languages as $language){
				if ($res['language_id']==$language['id']){
					$res['language_name'] = $language['name'];
					$res['language_code'] = $language['code'];
					}
				}
			$res['answer1'] = implode("\n", $this->expand_options($res['answer1']));
			$res['answer2'] = implode("\n", $this->expand_options($res['answer2']));
			//print_r($res);
			}
		
		return $res;
		}
	////////////////////////////////////////////////////	
	function api_updatequestion($username, $password, $id, $iscorrect){
		if($this->api_checkcredentials($username, $password)){
			$question = $this->fetchquestion($id);
			$updatedinfo = array();
			switch ($iscorrect){
				case -1:
					$updatedinfo['incorrect'] = $question['incorrect'] + 1;
					$updatedinfo['lastused'] = date('Y-m-d H:i:s', mktime(
						date('H'), 
						mt_rand(0, date('i')), 
						mt_rand(0, date('s')), 
						date('n'), 
						date('j'), 
						date('Y') - 1));
					break;
				case 0:
					$updatedinfo['incorrect'] = $question['incorrect'] + 1;
					$updatedinfo['lastused'] = date('Y-m-d H:i:s', mktime(
						date('H'), 
						mt_rand(0, date('i')), 
						mt_rand(0, date('s')), 
						date('n'), 
						date('j') - 1, 
						date('Y')));
					break;
				case 1:
					$updatedinfo['correct'] = $question['correct'] + 1;
					$updatedinfo['lastused'] = date('Y-m-d H:i:s', mktime(
						date('H'), 
						mt_rand(0, date('i')), 
						mt_rand(0, date('s')), 
						date('n'), 
						date('j'), 
						date('Y')));
					break;
				}
			$this->db->update(
				"questions_user_{$this->userid}", 
				$updatedinfo, 
				"id = {$id}"
				);
			}
		}
	////////////////////////////////////////////////////	
	function api_editquestion($username, $password, $id, $question, $answer1, $answer2, $info, $language){
		//echo "username = $username, password = $password, id = $id, question = $question, answer1 = $answer1, answer2 = $answer2, info = $info, language = $language";
		if($this->api_checkcredentials($username, $password)){
			//$question = $this->fetchquestion($id);
			$data = array(
				'question' => $question,
				'answer1' => $answer1,
				'answer2' => $answer2,
				'info' => $info,
				'language_id' => $language
				);
			$this->db->update(
				"questions_user_{$this->userid}", 
				$data, 
				"id = {$id}"
				);
				
			}
		}
	////////////////////////////////////////////////////	
	function api_login($username, $password){
		if($this->api_checkcredentials($username, $password)){
			return '1';
			}else{
			return '0';
			}
		}
	////////////////////////////////////////////////////
	function api_checkcredentials($username, $password){
		$res = false;
		if ((trim($username)!='')&&(trim($password)!='')){
			$users = $this->db->select('users', '*', "name LIKE '{$username}'");
			foreach ($users as $user) {
				if (($user['name']==$username) && ($user['password']==$password)) {
					$this->userid = $user['id'];
					$this->username = $user['name'];
					$res = true;
					$this->addxp();
					//$this->loadlanguages();
					}
				}
			}
		return $res;
		}
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	}