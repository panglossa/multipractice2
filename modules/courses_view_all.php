<?php
$this->loadclass('coursedisplay');
$this->loadcourses();

$mycourses = o('courses', TDiv());
$category = $this->parm('category', -1);
if ($category>0) {
	$catcourses = $this->db->select('course_category', 'course_id', "category_id = {$category}");
	}
foreach($this->courses as $course){
	$isok = true;
	if ($category>0) {
		$isok = false;
		foreach($catcourses as $cc){
			if($cc['course_id']==$course['id']) {
				$isok = true;
				}
			}
		}
	if ($isok){
		if (isset($this->mycourses[$course['id']])) {
			$course = $this->mycourses[$course['id']];
			}
		$mycourses->add(new TCourseDisplay($course));
		}
	}

$this->add(TH2("All Available Courses"));
$lst_categories = o('categories', TList());
$lst_categories->add(TI('Categories: '));
if ($category>0) {
	$lst_categories->add(TA("index.php?c=courses/view&category=-1", "[All]"));
	} else{
	$lst_categories->add(TA("index.php?c=courses/view&category=-1", TB("[All]")));
	}
foreach($this->categories as $cat){
	if ($cat['id']==$category){
		$lst_categories->add(TA("index.php?c=courses/view&category={$cat['id']}", TB("[{$cat['name']}]")));
		}else{
		$lst_categories->add(TA("index.php?c=courses/view&category={$cat['id']}", "[{$cat['name']}]"));
		}
	}
$this->add($lst_categories);
$this->add($mycourses);