<?php

class TMultiPractice extends THtml {
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	function __construct(){
		parent::__construct();
		$this->username = '';
		$this->userid = -1;
		$this->userxp = 0;
		$this->db = TDB(
			$this->config->db_database, 
			$this->config->db_mode,
			$this->config->db_user, 
			$this->config->db_password
			);
		$this->config->db = &$this->db;
		$this->config->readdb();
		$this->checkuser();
		$this->loadlanguages();
		$this->courses = array();
		
		if (!isset($this->parameters['keepsession'])){
			$this->icon = $this->config->icon;
			$this->css  = $this->config->css;
			$this->js   = $this->config->js;
			$this->title = "{$this->config->title} v.{$this->config->version}";
			$this->initmodule();
			$this->add(o('logoimage', TImg(MEDIA_PATH . 'multipractice_logo.png'), array('onclick' => "window.location = 'index.php'")), 'mainlogo');
			$this->add(TH1($this->title));
			if ($this->userid==-1) {
				$login = 'Log in ' . TVerticalLoginForm() . TP(TA('index.php?c=user/new', 'Register New User'));
				}else{
				$login = '';	
				}
			$this->add($this->mainmenu() . $login, 'mainmenu');
			$this->checkmessage();
			$this->loadmodule();
			$this->add(o('footer', TFooter($this->mainmenu())));
			}
			
		}
	////////////////////////////////////////////////////
	function initmodule(){
		$this->module='';
		$this->action = '';
		$this->objectid = '';
		if (isset($this->config->defaultmodule)){
			$this->module = $this->config->defaultmodule;
			}
		if (isset($this->c[0])) {
			$this->module = $this->c[0];
			}
		if (isset($this->c[1])) {
			$this->action = $this->c[1];
			}
		if (isset($this->c[2])) {
			$this->objectid = $this->c[2];
			}
		if ($this->module==''){
			$this->module = 'home';
			}
		$istakingtest = false;
		if ($this->userid>-1) {
			if ($this->module!='tests'){
				$data = $this->db->select('tests_active', '*', "user = {$this->userid}");
				foreach($data as $row){
					if ($row['user'] = $this->userid) {
						$istakingtest = true;
						}	
					}
				}
			}
		if ($istakingtest){
			$this->module = 'tests';
			}			
		}
	////////////////////////////////////////////////////
	function loadmodule(){
		$flnm = MODULES_PATH . "{$this->module}.php";
		//Real action starts here: 
		if (file_exists($flnm)) {
			require_once($flnm);
			}else{
			$this->adderror("O módulo requisitado (<tt>{$this->module}</tt>) não existe.");
			}
		}
	////////////////////////////////////////////////////
	function mainmenu(){
		$menu = TList();
		if ($this->userid>-1) {
			$menu->add(TA('index.php?c=courses/mine', 'My Courses'));
			$menu->add(TA('index.php?c=practice', 'Practice!'));
			$menu->add(HR);
			}
		$menu->add(TA('index.php?c=courses/view', 'All Courses'));
		$menu->add(TA('index.php?c=tests', 'Tests'));
		$menu->add(HR);
		if ($this->userid>-1) {
			$menu->add(TA('index.php?c=settings', 'Settings'));
			}
		return $menu;
		}
	////////////////////////////////////////////////////
	function loadcourses(){
		$this->courses = array();
		$this->mycourses = array();
		$this->authoredcourses = array();
		$this->categories = array();
		$data = $this->db->select('categories', '*', '1', 0, 'name', 'asc');
		foreach($data as $row){
			$this->categories[$row['id']] = $row;
			}
		$order = $this->parm('order', 'started');
		$usercourses = $this->db->select('user_courses', '*', "user = {$this->userid}", 0, $order);
		if ($order=='started'){
			$order = 'created';
			}
		$allcourses = $this->db->select('courses', '*', 1, 0, $order);
		foreach($allcourses as $course) {
			$course['level'] = -1;
			$course['lesson'] = -1;
			$course['started'] = '';
			$course['xp'] = 0;
			$course['lastused'] = '';
			$levels = array();
			$leveldata = $this->db->select('course_levels', 'id', "course = {$course['id']}");
			foreach($leveldata as $l){
				$levels[] = -1;
				}
			$course['levels'] = $levels;
			$this->courses[$course['id']] = $course;
			if ($course['author']==$this->userid){
				$this->authoredcourses[$course['id']] = $course;
				}
			}
		if ($this->userid>-1) {
			foreach($usercourses as $uc) {
				if (isset($this->courses[$uc['course']])) {
					$course = $this->courses[$uc['course']];
					$course['level'] = $uc['level'];
					$course['lesson'] = $uc['lesson'];
					$course['started'] = $uc['started'];
					$course['xp'] = $uc['xp'];
					$course['lastused'] = $uc['lastused'];
					$course['practice'] = $uc['practice'];
					$levels = array();
					$leveldata = $this->db->select('course_levels', 'id', "course = {$course['id']}", 0, 'itemorder', 'asc');
					$completed = $this->db->select('course_levels_completed', 'level_id, completed', "user_id = {$this->userid} AND course_id = {$course['id']}");
					foreach($leveldata as $l){
						$status = -1;
						if ($l['id']==$course['level']) {
							$status = 0;
							} else {
							foreach($completed as $lc){
								if ($lc['level_id']==$l['id']) {
									if ($lc['completed']>$course['lastused']) {
										$course['lastused'] = $lc['completed'];
										}
									$status = 1;
									}
								}
							}
						$levels[] = $status;
						}
					$course['levels'] = $levels;
					$this->mycourses[$course['id']] = $course;
					}
				}			
			}
		}
	////////////////////////////////////////////////////

	function checkmessage(){
		if (isset($this->parameters['m'])) {
			$message = '';
			$data = $this->db->select('messages', '*', "tag LIKE '{$this->parameters['m']}'");
			foreach($data as $row){
				$message = $row['message'];
				}
			$this->addmessage($message);
			$this->add("<script>window.history.replaceState('Object', 'Title', 'index.php?c={$this->parameters['c']}');</script>");
			}
		}
	////////////////////////////////////////////////////
	function addxp($x = 0){
		if ($this->userid>-1){
			$userdata = array();
			$data = $this->db->select('users', '*', "id = {$this->userid}");
			foreach($data as $row){
				if ($row['id']==$this->userid) {
					$userdata = $row;
					}
				}
			if (count($userdata)>2){
				if ($x==0){
					//$x = (rand(1, 500) / 1750 );
					$x = (rand(1, 500) / 12345 );
					//echo "[{$x}]";
					}
				$userdata['xp'] += $x;
				$this->db->update('users', array('xp' => $userdata['xp']), "id = {$this->userid}");
				}
			}
		}
	////////////////////////////////////////////////////
	function addcoursexp($courseid = -1, $x = 0){
		if (($this->userid>-1)&&($courseid>-1)) {
			if ($x==0){
				$x = (rand(1, 500) / 1750 );
				//echo "[{$x}]";
				}
			$currentxp = -1;
			$data = $this->db->select('user_courses', 'xp', "course = {$courseid} AND user = {$this->userid}");
			foreach($data as $r){
				$currentxp = $r['xp'];
				}
			$this->db->update('user_courses', array('xp' => $currentxp + $x), "course = {$courseid} AND user = {$this->userid}");
			}
		}
	////////////////////////////////////////////////////
	function updatecourseusage($courseid = -1, $level = -1, $lesson = -1, $lessonitem = -1, $xp = 0){
		if (($this->userid>-1)&&($courseid>-1)) {
			if ($xp==0){
				$xp = (rand(1, 500) / 1750 );
				//echo "[{$x}]";
				}
			$currentxp = -1;
			foreach($this->db->select('user_courses', 'xp', "course = {$courseid} AND user = {$this->userid}") as $r){
				$currentxp = $r['xp'];
				}
			$data = array(
				'xp' => $currentxp + $xp,
				'lastused' => date('Y-m-d H:i:s')
				);
			if ($level>-1){
				$data['level'] = $level;
				}
			if ($lesson>-1){
				$data['lesson'] = $lesson;
				}
			if ($lessonitem>-1){
				$data['lessonitem'] = $lessonitem;
				}
			$this->db->update('user_courses', $data, "course = {$courseid} AND user = {$this->userid}");
			}
		}
	////////////////////////////////////////////////////
	function checkuser(){
		$this->username = '';
		$this->userid = -1;
		$this->userxp = 0;
		if ($this->module=='logout') {
			//someone is trying to log out
			//echo 'logout';
			//$this->addxp(0.01);
			$_SESSION['username']='';
			$_SESSION['userid']='';
			$_SESSION['password']='';
			$this->addmessage("Logged out successfully.");
			$this->redirect('./index.php');
			}else if ((isset($this->parameters_post['loginusername']))&&(isset($this->parameters_post['loginpassword']))){
			//someone is trying to log in
			//echo 'login';
			$userdata = array();
			$data = $this->db->select('users', '*', "name LIKE '{$this->parameters['loginusername']}'");
			//print_r($data);
			foreach($data as $row){
				//print_r($row);
				if (count($row)>2){
					if (($row['name']==$this->parameters_post['loginusername'])&&(password_verify($this->parameters_post['loginpassword'], $row['password']))) {
						$userdata = $row;
						}
					}
				}
			if (count($userdata)>2){
				//login ok
				$this->username = $userdata['name'];
				$this->userid = $userdata['id'];
				$this->userxp = floor($userdata['xp']);
				$this->addxp(0.09);
				$_SESSION['username']=$row['name'];
				$_SESSION['userid']=$row['id'];
				$_SESSION['password']=$row['password'];
				$this->addmessage("Logged in successfully.");
				$this->redirect('./index.php');
				}else{
				//you shall not pass
				$this->adderror("The provided login information isn't correct; please try again.");
				}
			}else if (
			(
				(isset($_SESSION['username']))
				&&
				(isset($_SESSION['password']))
				&&
				(isset($_SESSION['userid']))
				)
			&&
			(
				(trim($_SESSION['username'])!='')
				&&
				(trim($_SESSION['password'])!='')
				&&
				(trim($_SESSION['userid'])!='')
				)
			) {
			//echo 'normal';
			//normal page load
			$userdata = array();
			foreach($this->db->select('users', '*', "id = {$_SESSION['userid']}") as $row){
				if (($row['name']==$_SESSION['username'])&&($row['id']==$_SESSION['userid'])&&($row['password']==$_SESSION['password'])) {
					$userdata = $row;
					}
				}
			if (count($userdata)>2){
				//user credentials ok
				$this->username = $userdata['name'];
				$this->userid = $userdata['id'];
				$this->userxp = floor($userdata['xp']);
				$this->addxp(0.05);
				$_SESSION['username']=$row['name'];
				$_SESSION['userid']=$row['id'];
				$_SESSION['password']=$row['password'];
				}
			}
		if ($this->username==''){
			
			}else{
			$adminlink = '';
			if ($this->isadmin()){
				$adminlink = '&nbsp' . TA("index.php?c=admin", '[Admin&nbsp;Panel]');
				}
			
			$this->add(
				TP(
					'Logged in as&nbsp;' 
					. TA('index.php?c=user/edit', TB(TTt($this->username))) 
					. '&nbsp;('
					. $this->userxp . 'xp)&nbsp;'  
					. TA('index.php?c=logout', '[Log&nbsp;out]') . $adminlink
					)
				);
			}
		
		}
	////////////////////////////////////////////////////
	function isadmin(){
		$res = false;
		//print_r($this->config);
		foreach(explode(',', $this->config->admin) as $adminid){
			if ($adminid == $this->userid){
				$res = true;
				}
			}
		return $res;
		}
	////////////////////////////////////////////////////
	function loadaction(){
		if ($this->action==''){
			$this->action = 'view';
			}
		$flnm = MODULES_PATH . "{$this->module}_{$this->action}.php";
		if (file_exists($flnm) ){
			require_once($flnm);
			}else{
			$this->adderror("The file <tt>{$flnm}</tt> does not exist.");
			}
		}
	////////////////////////////////////////////////////
	function button($url, $label, $hint = ''){
		if ($hint==''){
			$hint = $label;
			}
		$a = TA("index.php?c={$url}", $label, $hint);
		$a->p('class', 'buttonlink');
		return $a;
		}
	////////////////////////////////////////////////////
	function loadlanguages(){
		$this->languages = array();
		$this->languages[-1] = array('id' => '-1', 'name' => '', 'englishname' => '', 'code' => '');
		$langs = $this->db->select('languages', '*', "1", 0, 'name_sort');
		foreach($langs as $language){
			if (($language['englishname']!='')&&($language['name']!=$language['englishname'])) {
				$language['name'] = "{$language['name']} ({$language['englishname']})";
				}
			$this->languages[$language['id']] = $language;
			}
		$this->userlanguages = array();
		$mylangs = $this->db->select(
			"selectedlanguages left join languages on selectedlanguages.language_id = languages.id",
			'selectedlanguages.language_id, selectedlanguages.user_id, languages.*',
			"selectedlanguages.user_id = {$this->userid}",
			0,
			'languages.name_sort',
			'asc'
			);
		$this->userlanguages[-1] = array('id' => -1, 'language_id' => -1, 'name' => 'All Languages', 'englishname' => '');
		foreach($mylangs as $language){
			if (($language['englishname']!='')&&($language['name']!=$language['englishname'])) {
				$language['name'] = "{$language['name']} ({$language['englishname']})";
				}
			$this->userlanguages[$language['id']] = $language;
			}		
		}
	////////////////////////////////////////////////////
	function addcourse($title, $info, $language, $imagedata, $levelcount = 0, $lessoncount = 0){
		$uid = generateuid();
		$this->db->insert('courses', array(
			'name' => $title,
			'language' => $language,
			'info' => $info,
			'author' => $this->userid,
			'created' => date('Y-m-d H:i:s'),
			'uid' => $uid,
			'image' => $imagedata
			));
			
		if ($levelcount>0){
			$courseid = -1;
			foreach($this->db->select('courses', '*', "uid = '{$uid}'") as $r){
				$courseid = $r['id'];
				}
			if ($courseid>-1){
				for ($i=1; $i<=$levelcount; $i++){
					$this->addlevel(numberToRomanRepresentation($i), '', '', $courseid);
					}
				if ($lessoncount>0){
					$lessonnumber = 1;
					$levels = $this->db->select('course_levels', 'id', "course = {$courseid}");
					foreach($levels as $level){
						for ($i=1; $i<=$lessoncount; $i++){
							$this->addlesson("Lesson {$lessonnumber}", '', $courseid, $level['id']);
							$lessonnumber++;
							}
						}
					}
				}
			}
			/*
		$newcourseid = -1;
		foreach($this->db->select('courses', '*', "uid = '{$uid}'") as $r){
			$newcourseid = $r['id'];
			}
		if ($newcourseid==-1){
			$this->adderror("Something went wrong!");
			}else{
			$this->db->insert('user_courses', array(
				'user' => $this->userid,
				'course' => $newcourseid,
				'started' => date('Y-m-d H:i:s')
				));
			}*/
		}
	////////////////////////////////////////////////////
	function addlevel($title, $info, $imagedata, $courseid){
		$uid = generateuid();
		$order = -1;
		foreach($this->db->select('course_levels', 'itemorder', "course = {$courseid}") as $r){
			if ($r['itemorder']>$order){
				$order = $r['itemorder'];
				}
			}
		$order++;
		$data = array(
			'course' => $courseid,
			'name' => $title,
			'info' => $info,
			'created' => date('Y-m-d H:i:s'),
			'uid' => $uid,
			'itemorder' => $order
			);
		if (trim($imagedata)!=''){
			$data['image'] = $imagedata;
			}
		$this->db->insert('course_levels', $data);
		}
	////////////////////////////////////////////////////
	function addlesson($title, $info, $courseid, $levelid){
		$uid = generateuid();
		$order = -1;
		foreach($this->db->select('lessons', 'itemorder', "course = {$courseid} AND level={$levelid}") as $r){
			if ($r['itemorder']>$order){
				$order = $r['itemorder'];
				}
			}
		$order++;
		$data = array(
			'course' => $courseid,
			'level' => $levelid,
			'title' => $title,
			'info' => $info,
			'created' => date('Y-m-d H:i:s'),
			'uid' => $uid,
			'author' => $this->userid,
			'itemorder' => $order
			);
			//print_r($data);
		$this->db->insert('lessons', $data);
		}
	////////////////////////////////////////////////////
	function transfer($language, $course){
		//transfer plain sentences (old format) to a new course
		//be sure to use this only with an empty course already populated with levels and lessons
		//to do: optimise data insertion
		$starttime = microtime(true);
		$lessons = array();
		$i = 0;
		foreach($this->db->select('lessons', '*', "course = {$course}") as $lesson){
			$lessons[$i] = $lesson;
			$i++;
			}
		$sentences = $this->db->select('questions_user_2', '*', "language_id = {$language} AND type = 'translate'");
		$lessoncount = count($lessons);
		$sentencecount = count($sentences);
		$limit = intdiv($sentencecount, $lessoncount);
		//$this->add("{$sentencecount} / {$lessoncount} = {$limit}");
		$lessonindex = 0;
		$c = 1;
		foreach($sentences as $sentence){
			if ($lessonindex<$lessoncount){
				$this->db->insert('lesson_items', array(
					'name' => '[Translation Exercise]',
					'lesson' => $lessons[$lessonindex]['id'],
					'course' => $lessons[$lessonindex]['course'],
					'level' => $lessons[$lessonindex]['level'],
					'content' => $sentence['question'],
					'info' => $sentence['info'],
					'type' => CONTENT_TYPE_EXERCISE_TRANSLATION,
					'extra1' => $sentence['answer1'] 
					));
				//$this->add("Adding sentence {$sentence['id']} to lesson {$lessons[$lessonindex]['id']}<br/>");
				$c++;
				if ($c>$limit){
					$c = 1;
					$lessonindex++;
					}
				}
			
			}
		/*
		foreach($data as $r){
			$this->db->insert('lesson_items', array(
				'name' => '[Translation Exercise]',
				'lesson' => $lesson,
				'course' => $course,
				'level' => $level,
				'content' => $r['question'],
				'type' => CONTENT_TYPE_EXERCISE_TRANSLATION,
				'extra1' => $r['answer1']
				));
			}*/
		
		echo microtime(true) - $starttime . ' seconds elapsed';	
		}
	////////////////////////////////////////////////////
	function match($text, $model){
		$res = false;
		if (trim($text)!=''){
			$text = $this->noaccents($this->cleartext($text));
			foreach($this->expand_options($this->noaccents($model)) as $line){
				if ($this->cleartext($line)==$text){
					$res = true;
					}
				}
			}
		return $res;
		}
	////////////////////////////////////////////////////
	function expand($model){
		return 'bla bla bla bla bla';
		}
	////////////////////////////////////////////////////
	function expand_options($s){
		$res = array();
		$res[] = '';
		$tmp = array();
		$orlines = explode("\n", str_replace('_', ' ', $s));
		foreach ($orlines as $line){
			$line = trim($line);
			if ($line!=''){
				if ((strpos($line, '[')!==false)&&(strpos($line, '|')!==false)&&(strpos($line, ']')!==false)){
					$pos1 = strpos($line, '[');
					$pos2 = strpos($line, '|');
					$pos3 = strpos($line, ']');
					while (($pos1!==false)&&($pos2!==false)&&($pos3!==false)) {
						$part1 = substr($line, 0, $pos1);
						$options = explode('|', substr($line, $pos1 + 1, $pos3-$pos1-1));
						$line = substr($line, $pos3 + 1);

						$pos1 = strpos($line, '[');
						$pos2 = strpos($line, '|');
						$pos3 = strpos($line, ']');
						$tmp = array();
						if (count($res)==0){
							$res[] = $part1;
							}else{
							foreach($res as $item){
								foreach($options as $option){
									$tmp[] = "{$item}{$part1}{$option}";
									}
								}
							}
						$res = $tmp;
						}
					$tmp = array();
					if (count($res)==0){
						$tmp[] = $line;
						}else{
						foreach($res as $item){
							$tmp[] = "{$item}{$line}";
							}
						}
					$res = $tmp;
					}else{
					$res[] = $line;
					}
				} 
			}
		return $res;
		}
	////////////////////////////////////////////////////
	function noaccents($string) {
		if ( !preg_match('/[\x80-\xff]/', $string) ) return $string;
    	$chars = array(
    // Decompositions for Latin-1 Supplement
    chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
    chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
    chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
    chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
    chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
    chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
    chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
    chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
    chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
    chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
    chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
    chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
    chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
    chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
    chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
    chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
    chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
    chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
    chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
    chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
    chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
    chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
    chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
    chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
    chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
    chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
    chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
    chr(195).chr(191) => 'y',
    // Decompositions for Latin Extended-A
    chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
    chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
    chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
    chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
    chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
    chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
    chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
    chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
    chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
    chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
    chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
    chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
    chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
    chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
    chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
    chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
    chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
    chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
    chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
    chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
    chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
    chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
    chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
    chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
    chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
    chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
    chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
    chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
    chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
    chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
    chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
    chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
    chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
    chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
    chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
    chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
    chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
    chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
    chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
    chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
    chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
    chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
    chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
    chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
    chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
    chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
    chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
    chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
    chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
    chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
    chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
    chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
    chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
    chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
    chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
    chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
    chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
    chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
    chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
    chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
    chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
    chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
    chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
    chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
    );

    	$string = strtr($string, $chars);
    	return $string;
		}
	////////////////////////////////////////////////////
	function cleartext($s){
		$res = trim(strtolower($s));
		$dirt = array("\n", "\r", ' ', '	', ',', '.', '<', '>', ';', ':', '/', '?', '°', '-', '_', '=', '+', '§', '{', '[', 'ª', ']', '}', 'º', '|', '\\', "'", '"', '!', '@', '#', '$', '%', '&', '*', '(', ')' );
		$res = str_replace($dirt, '', $res);
		return $res;
		}
	////////////////////////////////////////////////////
	function updatecorrect($itemid){
		$correctcount = -1;
		$courseid = -1;
		foreach($this->db->select('lesson_items_usage', 'course, correct', "item={$itemid} AND user = {$this->userid}") as $r){
			$correctcount = $r['correct'];
			$courseid = $r['course'];
			}
		if ($correctcount==-1){
			$data = $this->db->select('lesson_items', 'course', "id = {$itemid}");
			foreach($data as $r){
				$courseid = $r['course'];
				}
			$this->db->insert('lesson_items_usage', array('item' => $itemid, 'user' => $this->userid, 'course' => $courseid, 'lastused' => date('Y-m-d H:i:s'), 'correct' => 1, 'wrong' => 0));
			}else{
			$this->db->update('lesson_items_usage', array('lastused' => date('Y-m-d H:i:s'), 'correct' => $correctcount+1), "item = {$itemid} AND user = {$this->userid}");
			}
		}
	////////////////////////////////////////////////////
	function updatewrong($itemid){
		$wrongcount = -1;
		$courseid = -1;
		foreach($this->db->select('lesson_items_usage', 'course, wrong', "item={$itemid} AND user = {$this->userid}") as $r){
			$wrongcount = $r['wrong'];
			$courseid = $r['course'];
			}
		$pastdate = date('Y-m-d H:i:s', mktime(
			date('H'), /* hour */
			mt_rand(0, date('i')), /* minute */ 
			mt_rand(0, date('s')),  /* second */
			date('n'),  /* month */
			mt_rand(1, date('j')),  /* day */
			date('Y'))); /* year */
		if ($wrongcount==-1){
			$data = $this->db->select('lesson_items', 'course', "id = {$itemid}");
			foreach($data as $r){
				$courseid = $r['course'];
				}
			$this->db->insert('lesson_items_usage', array('item' => $itemid, 'user' => $this->userid, 'course' => $courseid, 'lastused' => $pastdate, 'correct' => 0, 'wrong' => 1));
			}else{
			$this->db->update('lesson_items_usage', array('lastused' => $pastdate, 'wrong' => $wrongcount+1), "item = {$itemid} AND user = {$this->userid}");
			}
		}
	////////////////////////////////////////////////////
	function touchitem($courseid, $itemid) {
		$data = $this->db->select('lesson_items_usage', 'id', "course = {$courseid} AND user = {$this->userid} AND item = {$itemid}");
		if (count($data)>0) {
			$id = -1;
			foreach($data as $row) {
				$id = $row['id'];
				}
			$this->db->update('lesson_items_usage', array('lastused' => date('Y-m-d H:i:s')), "id = {$id} AND course = {$courseid} AND user = {$this->userid} AND item = {$itemid}");
			}else{
			$this->db->insert('lesson_items_usage', array('item' => $itemid, 'user' => $this->userid, 'course' => $courseid, 'lastused' => date('Y-m-d H:i:s')));
			}
		}
	////////////////////////////////////////////////////
	function updatelevel($levelid, $level_title, $level_info, $level_image, $courseid){
		if (($levelid>-1)&&($courseid>-1)&&(trim($level_title)!='')){
			//echo '1';
			$data = array(
				'name' => $level_title,
				'info' => $level_info
				);
			if ($level_image!=''){
				$data['image'] = $level_image;
				}
			//print_r($data);
			$this->db->update('course_levels', $data, "id = {$levelid} AND course = {$courseid}");
			}
		}
	////////////////////////////////////////////////////
	function updatelesson($lessonid, $courseid, $lesson_title){
		if (($lessonid>-1)&&($courseid>-1)&&(trim($lesson_title)!='')){
			$this->db->update('lessons', array('title' => $lesson_title), "id = {$lessonid} AND course = {$courseid}");
			}
		}
	////////////////////////////////////////////////////
	function addlessonitem($courseid, $levelid, $lessonid, $item_name, $item_content, $item_type, $item_extra1, $item_extra2, $item_info){
		if (($courseid>-1)&&($levelid>-1)&&($lessonid>-1)&&(trim($item_name)!='')&&(trim($item_content)!='')) {
			$item_order = -1;
			$orders = $this->db->select('lesson_items', 'itemorder', "lesson = {$lessonid} AND level = {$levelid} AND course = {$courseid}");
			foreach($orders as $o){
				if ($o['itemorder']>$item_order){
					$item_order = $o['itemorder'];
					}
				}
			$item_order++;
			$item_uid = generateuid();
			$this->db->insert('lesson_items', array(
				'name' => $item_name,
				'lesson' => $lessonid,
				'type' =>  $item_type,
				'content' =>  $item_content,
				'info' =>  $item_info,
				'level' =>  $levelid,
				'course' =>  $courseid,
				'extra1' =>  $item_extra1,
				'extra2' =>  $item_extra2,
				'itemorder' => $item_order ,
				'uid' => $item_uid,
				'created' =>  date('Y-m-d H:i:s')
				));
			}
		}
	////////////////////////////////////////////////////
	function fetchquestion($questionid = -1){
		$question = array(/*
			'id' => -1, 
			'type' => 'translate', 
			'info' => '', 
			'answer1' => '', 
			'answer2' => '', 
			'language_id' => -1, 
			'language_name' => '', 
			'language_code' => '', 
			'type_label' => '', 
			'correct' => 0, 
			'incorrect' => 0*/
			);
		$data = $this->db->select('lesson_items', '*', "id = {$questionid}");
		if (count($data>0)){
			foreach($data as $row){
				$question = $row;
				}
			}
		return $question;
		}

	////////////////////////////////////////////////////
	function getquestion($courseid = -1){
		$question = array(/*
			'id' => -1, 
			'type' => 'translate', 
			'info' => '', 
			'answer1' => '', 
			'answer2' => '', 
			'language_id' => -1, 
			'language_name' => '', 
			'language_code' => '', 
			'type_label' => '', 
			'correct' => 0, 
			'incorrect' => 0*/
			);
		$condition = "user = {$this->userid}";
		if ($courseid>-1){
			$condition .= " AND course = {$courseid}";
			}
		$usage = $this->db->select('lesson_items_usage', '*', $condition, 0, 'lastused', 'asc');
		$item = array();
		$course = array();
		foreach($usage as $r){
			if (count($item)==0){
				if (isset($this->mycourses[$r['course']])){
					$item = $r;
					$course = $this->mycourses[$r['course']];
					}
				}
			}
		if ((count($item)>0)&&(count($course)>0)) {
			$data = $this->db->select('lesson_items', '*', "id = {$item['item']} AND course = {$item['course']}");
			if (count($data>0)){
				foreach($data as $row){
					$question = $row;
					
					}
				}
			}
		return $question;
		}	
	////////////////////////////////////////////////////
	function coursehaspractice($courseid){
		$res = false;
		$isusercourse = false;
		$data = $this->db->select('user_courses', 'course', "user = {$this->userid} AND course = {$courseid}");
		foreach ($data as $row){
			if ($row['course'] == $courseid){
				$isusercourse = true;
				}
			}
		$hasusage = false;
		$data = $this->db->select('lesson_items_usage', 'course', "user = {$this->userid} AND course = {$courseid}");
		foreach ($data as $row){
			if ($row['course'] == $courseid){
				$hasusage = true;
				}
			}
		$res = (($isusercourse)&&($hasusage));
		return $res;
		}
	////////////////////////////////////////////////////
	function coursesearch($s = ''){
		//echo $s;
		$s = strtolower(trim($s));
		$res = array();
		$exact = array();
		$initial = array();
		$partial = array();
		
		$data = $this->db->select('courses', '*', "name LIKE '%{$s}%'");
		//print_r($data);
		foreach($data as $c){
			if (strpos($this->noaccents($this->cleartext($c['name'])), $s)!==false) {
				$res[$c['id']] = $c;
				}
			}		
		return $res;
		}		
	////////////////////////////////////////////////////
	function updatelessonitem($itemid, $lessonid, $levelid, $courseid, $item_name, $item_type, $item_content, $item_extra1, $item_extra2, $item_info, $item_order){
		$item = array();
		$data = $this->db->select('lesson_items', '*', "id = {$itemid}");
		foreach($data as $r){
			$item = $r;
			}
		if (count($item)>0){
			if (($item['course']==$courseid)&&($item['level']==$levelid)&&($item['lesson']==$lessonid)) {
				if (trim($item_name)!=''){
					$data = array(
						'name' => trim($item_name),
						'type' => $item_type,
						'content' => trim($item_content),
						'extra1' => trim($item_extra1),
						'extra2' => trim($item_extra2),
						'info' => trim($item_info),
						'itemorder' => $item_order
						);
					$this->db->update('lesson_items', $data, "id = {$itemid} AND lesson = {$lessonid} AND level = {$levelid} AND course = {$courseid}");
					}
				}
			}
		}
	////////////////////////////////////////////////////
	function removelessonitem($courseid, $levelid, $lessonid, $itemid){
		$item = array();
		$data = $this->db->select('lesson_items', '*', "id = {$itemid}");
		foreach($data as $r){
			$item = $r;
			}
		if (count($item)>0){
			if (($item['course']==$courseid)&&($item['level']==$levelid)&&($item['lesson']==$lessonid)) {
				$this->db->delete('lesson_items', "id = {$itemid}");
				}
			}
		
		}
	////////////////////////////////////////////////////
	function removelesson($courseid, $levelid, $lessonid){
		$item = array();
		$data = $this->db->select('lessons', '*', "id = {$lessonid}");
		foreach($data as $r){
			$item = $r;
			}
		if (count($item)>0){
			if (($item['course']==$courseid)&&($item['level']==$levelid)) {
				$lessonitems = $this->db->select('lesson_items', 'id', "lesson = {$lessonid}");
				foreach($lessonitems as $li){
					$this->db->delete('lesson_items_usage', "item = {$li['id']}");
					}
				$this->db->delete('lesson_items', "lesson = {$lessonid}");
				$this->db->delete('lessons', "id = {$lessonid}");
				}
			}
		
		}
	////////////////////////////////////////////////////
	function addtest($title, $course, $info){
		if ((trim($title)!='')&&($course>-1)) {
			$this->db->insert('tests', array('title' => $title, 'course' => $course, 'info' => $info, 'author' => $this->userid, 'created' => date('Y-m-d H:i:s'))) ;
			}
		}
	////////////////////////////////////////////////////
	function fetchmodule($flnm){
		if (file_exists(MODULES_PATH . $flnm)) {
			require_once(MODULES_PATH . $flnm);
			} else {
			$this->adderror("The file " . TTT(MODULES_PATH . $flnm) . " does not exist.");
			}
		}
	////////////////////////////////////////////////////
	function loadclass($name){
		$flnm = CLASS_PATH . $name . '.php';
		if (file_exists($flnm)) {
			require_once($flnm);
			}else{
			$this->adderror('Class ' . TTT($name) . ' not found.');
			}
		}
	////////////////////////////////////////////////////
	function smiley() {
		$faces = array('😀', '😁', '😃', '😄', '😅', '😆', '😇', '😉', '😊', '😋', '😌', '😍', '😎', '😏', '🙂', '🙃', '😸', '😺', '😻', '😽', '😽');
		return $faces[rand(0, count($faces)-1)];
		}
	////////////////////////////////////////////////////
	function sad(){
		$faces = array('😐','😑','😒','😓','😔','😕','😖','😞','😟','😢','😣','😤','😥','😦','😧','😨','😩','😪','😫','😭','😮','😯','😰','😱','😲','😾','😿','🙀','🙀');
		return $faces[rand(0, count($faces)-1)];
		}
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	}

