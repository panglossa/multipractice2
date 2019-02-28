<?php

class TCourseDisplay extends TTable {
	function __construct($course = array()){
		parent::__construct();
		$this->type = 'table';
		$this->courseid = $course['id'];
		$img = '';
		if (trim($course['image'])!=''){
			$img = "<img height=\"100\" src='data:image/png;base64," . base64_encode($course['image']) . "' />&nbsp;";
			}
		$tbl_levels = o("tbl_levels_{$course['id']}", TTable(), array('class' => 'level_meter'));
		$completedinfo = array();
		$course['lastaccess'] = $course['lastused'];
		foreach($course['levels'] as $l){
			switch($l){
				case -1:
				$completedinfo[] = o("levelinfo_{$l['id']}", TDiv('&nbsp;'), array('class' => 'levelnotdone'));
					break;
				case 0:
					$completedinfo[] = o("levelinfo_{$l['id']}", TDiv('&nbsp;'), array('class' => 'currentlevel'));
					break;
				case 1:
					$completedinfo[] = o("levelinfo_{$l['id']}", TDiv('&nbsp;'), array('class' => 'levelcompleted'));
					break;
				}
			}
		$tbl_levels->add($completedinfo);
		$this->setID("tbl_course_{$course['id']}");
		$this->p('class', 'coursedisplay');
		$this->p('onclick', "viewcourse({$course['id']});");
		$userinfo = '';
		if (($course['started']!='')&&($course['lastaccess']!='')&&($course['xp']>0)) {
			$userinfo = "Started: {$course['started']}<BR/>Last Access: {$course['lastaccess']}<br/>". number_format($course['xp'], 0) . '&nbsp;xp' . HR . o('', TA("index.php?c=courses/leave/{$course['id']}", '[Leave Course]'), array('class' => 'buttonlink'));
			} else {
			$userinfo = o('', TA("index.php?c=courses/start/{$course['id']}", '[Start This Course]'), array('class' => 'buttonlink'));
			}
		$this->add(
			$img, 
			TB($course['name']) . BR .  TI($course['info']) . $tbl_levels ,
			$userinfo);
		}
		
	function show(){
		$res = TA("index.php?c=courses/view/{$this->courseid}", $this->getprefix() . $this->getcontent() . $this->getsuffix());
		return("{$res}");
		}
	}



