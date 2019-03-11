<?php
class TMultiPracticeApi extends TMultiPractice {
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	function __construct(){
		parent::__construct();
		if (($this->api_checkuser())&&($this->parm('action')!='')) {
			$function = "api_{$this->parameters['action']}";
			$this->$function();
			}
		}
	////////////////////////////////////////////////////
	function api_checkuser(){
		$res = false;
		$username = trim($this->parm('username'));
		$password = trim($this->parm('password'));
		if (($username!='')&&($password!='')) {
			$data = $this->db->select('users', '*', "name LIKE '%{$username}%'");
			foreach ($data as $row) {
				if ($row['name']==$username) {
					if (password_verify($password, $row['password'])) {
						$this->username = $row['name'];
						$this->userid = $row['id'];
						return true;
						}
					}
				}
			}
		return $res;
		}
	////////////////////////////////////////////////////
	function api_alllanguages() {
		$res = array();
		$this->loadlanguages();
		foreach ($this->languages as $lang) {
			$res[$lang['id']] = $lang;
			}
		return $res;
		}
	////////////////////////////////////////////////////
	function api_userlanguages() {
		$res = array();
		$this->loadlanguages();
		foreach ($this->mylanguages as $lang) {
			$res[$lang['id']] = $lang;
			}
		return $res;
		}
	////////////////////////////////////////////////////
	function api_language() {
		$res = array();
		$this->loadlanguages();
		if (isset($this->languages[$this->parm('languageid', -1)])) {
			$res = $this->languages[$this->parm('languageid', -1)];
			}
		return $res;
		
		}
	////////////////////////////////////////////////////
	function api_image() {
		$data = array();
		$imgfile = 'media/book.jpg';
		switch($this->parameters['what']) {
			case 'course':
				$data = $this->db->getrow('courses', 'image', "id = {$this->parameters['courseid']}");
				break;
			case 'level':
				$data = $this->db->getrow('course_levels', 'image', "id = {$this->parameters['levelid']}");
				break;
			case 'language':
				$code = $this->db->getrow('languages', 'code', "id = {$this->parameters['languageid']}");
				if (count($code)>0) {
					$lgimgfile = "media/icons/{$code['code']}.png";
					if (file_exists($lgimgfile)) {
						$imgfile = $lgimgfile;
						}
					}
				break;
			}
		if (count($data)>0) {
			header("Content-type: image/png");
			print $data['image'];
			exit;
			//echo "<img height=\"100\" src='data:image/png;base64," . base64_encode($data['image']) . "' />&nbsp;";
			}else{
			require_once(CLASS_PATH . 'simpleimage.php');
			$image = new SimpleImage();
			$image->load($imgfile);
			$image->resizeToHeight(48);
			header("Content-type: image/png");
			header("Accept-Ranges: bytes");
			header('Content-Length: ' . filesize($imgfile));
			header("Last-Modified: Fri, 03 Mar 2004 06:32:31 GMT");
			$image->output();
			}
		}
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	}