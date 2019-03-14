<?php
if ($this->isadmin()) {
	$this->loadcourses();
	$this->add(TH4('Course Editor'));
	if ($this->parm('newcat', -1)==1) {
		if (isset($this->parameters['newcatname'])) {
			if (trim($this->parameters['newcatname'])=='') {
				$this->adderror('The category name must not be blank.');
				} else {
				$isused = false;
				$data = $this->db->select('categories', 'name'); 
				foreach($data as $row) {
					if (strtolower(trim($row['name']))==strtolower(trim($this->parameters['newcatname']))) {
						$isused = true;
						}
					}
				if ($isused) {
					$this->adderror("The name <tt>{$this->parameters['newcatname']}</tt> is already in use. Please choose a different name for your new category.");
					} else {
					$this->db->insert('categories', array('name' => $this->parameters['newcatname'], 'created' => date('Y-m-d H:i:s')));
					$this->go('courses/edit');
					}
				}
			} else {
			$this->add(TForm(TP('New Category Name: ') . TP(o('newcatname', TEdit($this->parm('newcatname')))) . TA('index.php?c=courses/edit', '[Cancel]')));
			}
		} else{
		if (count($this->c)>2) {
			if (isset($this->courses[$this->c[2]])) {
				$course = $this->courses[$this->c[2]];
				if (isset($this->parameters['togglecat'])) {
					$coursecats = $this->db->select('course_category', '*', "category_id = {$this->parameters['togglecat']} AND course_id = {$course['id']}");  
					if (count($coursecats)>0) {
						$this->db->delete('course_category', "category_id = {$this->parameters['togglecat']} AND course_id = {$course['id']}");
						} else{
						$this->db->insert('course_category', array('course_id' => $course['id'], 'category_id' => $this->parameters['togglecat']));
						}
					$this->go("courses/edit/{$course['id']}");
					}else {
					$itemcount = 0;
					$data = $this->db->select('lesson_items', 'count(*) as itemcount', "course = {$course['id']}");
					foreach($data as $row) {
						$itemcount = $row['itemcount'];
						}
						
					$lessoncount = 0;
					$data = $this->db->select('lessons', 'count(*) as lessoncount', "course = {$course['id']}");
					foreach($data as $row) {
						$lessoncount = $row['lessoncount'];
						}
						
					$usercount = 0;
					$data = $this->db->select('user_courses', 'count(*) as usercount', "course = {$course['id']}");
					foreach($data as $row) {
						$usercount = $row['usercount'];
						}
					
					$tbl_courseedit = o('tbl_courseedit', TTable());
					$tbl_courseedit->add('Course ID: ', TTT($course['id']));
					$tbl_courseedit->add('Course Name: ', TB($course['name']));
					$tbl_courseedit->add('Target Language: ', $this->languages[$course['language']]['name']);
					$tbl_courseedit->add('Course Description: ', TI($course['info']));
					$img = '';
					if (trim($course['image'])!=''){
						$img = "<img height=\"100\" src='data:image/png;base64," . base64_encode($course['image']) . "' />&nbsp;";
						}
					$tbl_courseedit->add('Course Image: ', $img);
					$tbl_courseedit->add('Created: ', $course['created']);
					$tbl_courseedit->add('Content: ', TB($itemcount) . ($itemcount<2?' item':' items') . ' organised in ' . TB($lessoncount) . ($lessoncount<2?' lesson':' lessons') . '.');
					$tbl_courseedit->add('Users: ', TB($usercount) . ($usercount==1?' person':' people') . ' currently using this course.');
					$categories = $this->db->select('categories', '*', 1, 0, 'name');
					$coursecats = $this->db->select('course_category', '*', "course_id = {$course['id']}");
					$selectedcats = TDiv();
					foreach($categories as $cat) {
						$isselected = false;
						foreach($coursecats as $cc) {
							if ($cc['category_id']==$cat['id']) {
								$isselected = true;
								}
							}
						$selectedcats->add('<nobr>' . o('', TCheckBox($cat['name'], $isselected), array('onclick' => "window.location = 'index.php?c=courses/edit/{$course['id']}&togglecat={$cat['id']}';")) . '</nobr>');
						}
					$tbl_courseedit->add('Categories: ', $selectedcats);
					$this->add($tbl_courseedit);
					$tbl_courseedittoolbar = o('tbl_courseedittoolbar', TTable());
					$tbl_courseedittoolbar->add(
						TA("index.php?c=courses/editinfo/{$course['id']}", 'Edit Course Info'), 
						TA("index.php?c=courses/editcontent/{$course['id']}", 'Edit Course Content'), 
						TA("index.php?c=courses/remove/{$course['id']}", 'Remove This Course')
						);
					$this->add(HR . $tbl_courseedittoolbar);
					}
				} else {
				$this->go('courses/edit');
				}
			} else {
			$pnl_courses = o('pnl_courses', TDiv());
			$pnl_categories = o('pnl_categories', TDiv());
			$lst_courses = TList();
			foreach($this->courses as $c) {
				if ($c['author']==$this->userid) {
					$img = '';
					if (trim($c['image'])!=''){
						$img = "<img height=\"32\" src='data:image/png;base64," . base64_encode($c['image']) . "' />&nbsp;";
						}
					$lst_courses->add(TA("index.php?c=courses/edit/{$c['id']}", "{$img}{$c['name']}"));
					}
				}
			$pnl_courses->add(o('btn_createcourse', TA("index.php?c=courses/create", '[Create a New Course]')));
			$pnl_courses->add(TH5('Courses created by you:'));
			$pnl_courses->add($lst_courses);
			$pnl_categories->add(o('btn_createcategory', TA("index.php?c=courses/edit&newcat=1", '[Create a New Category]')));
			$pnl_categories->add(TH5('Categories'));
			
			$lst_categories = TList();
			$cats = $this->db->select('categories', '*', 1, 0, 'name');
			$rel = $this->db->select('course_category');
			foreach($cats as $cat){
				$c = 0;
				foreach($rel as $r){
					if ($r['category_id']==$cat['id']) {
						$c++;
						}
					}
				$lst_categories->add($cat['name'] . '&nbsp;' . TI(" ({$c} courses)"));
				}
			$pnl_categories->add($lst_categories);
			$this->add(TTable($pnl_courses, $pnl_categories));
			}
		}
	}else{
	$this->go('courses/view');
	}
