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
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_userlanguages() {
		$res = array();
		$this->loadlanguages();
		foreach ($this->mylanguages as $lang) {
			$res[$lang['id']] = $lang;
			}
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_language() {
		$res = array();
		$this->loadlanguages();
		if (isset($this->languages[$this->parm('languageid', -1)])) {
			$res = $this->languages[$this->parm('languageid', -1)];
			}
		echo json_encode($res);
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
	function api_allcourses() {
		$res = array();
		$courses = $this->db->select('courses', '*', '1', 0, 'name', 'asc');
		foreach($courses as $course) {
			$res[$course['id']] = $course;
			}
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_course() {
		$res = array();
		$courses = $this->db->select('courses', '*', "id = {$this->parameters['courseid']}");
		foreach($courses as $course) {
			$res = $course;
			}
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_levels() {
		$res = array();
		$levels = $this->db->select('course_levels', '*', "course = {$this->parameters['courseid']}");
		foreach($levels as $level) {
			$res[$level['id']] = $level;
			}
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_level() {
		$res = array();
		$levels = $this->db->select('course_levels', '*', "id = {$this->parameters['levelid']}");
		foreach($levels as $level) {
			$res = $level;
			}
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_lessons() {
		$res = array();
		$lessons = $this->db->select('lessons', '*', "level = {$this->parameters['levelid']}");
		foreach($lessons as $lesson) {
			$res[$lesson['id']] = $lesson;
			}
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_lesson() {
		$res = array();
		$lessons = $this->db->select('lessons', '*', "id = {$this->parameters['lessonid']}");
		foreach($lessons as $lesson) {
			$res = $lesson;
			}
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_lessonitems() {
		$res = array();
		$items = $this->db->select('lesson_items', '*', "lesson = {$this->parameters['lessonid']}");
		foreach($items as $item) {
			$res[$item['id']]] = $item;
			}
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_lessonitem() {
		$res = array();
		$items = $this->db->select('lesson_items', '*', "id = {$this->parameters['itemid']}");
		foreach($items as $item) {
			$res = $item;
			}
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_allcategories() {
		$res = array();
		$cats = $this->db->select('categories');
		foreach($cats as $cat) {
			$cat['clients'] = array();
			$catusage = $this->db->select('course_category', '*', "category_id = {$cat['id']}");
			foreach($catusage as $ui) {
				$cat['clients'][] = $ui['course_id'];
				}
			$res[$cat['id']] = $cat;
			}
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_category() {
		$res = array();
		$cats = $this->db->select('categories', '*', "id = {$this->parameters['categoryid']}");
		foreach($cats as $cat) {
			$cat['clients'] = array();
			$catusage = $this->db->select('course_category', '*', "category_id = {$cat['id']}");
			foreach($catusage as $ui) {
				$cat['clients'][] = $ui['course_id'];
				}
			$res = $cat;
			}
		echo json_encode($res);
		}
	////////////////////////////////////////////////////
	function api_usage() {
		
		}
	////////////////////////////////////////////////////
	function api_updateusage() {
		
		}
	////////////////////////////////////////////////////
	function api_startcourse() {
		
		}
	////////////////////////////////////////////////////
	function api_leavecourse() {
		
		}
	////////////////////////////////////////////////////
	function login() {
		//if we got to this point, it means the provided username & password are valid
		echo '1'; //  ¯\_(ツ)_/¯
		}
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	}