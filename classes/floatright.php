<?php
class TFloatRight extends TDiv {
	function getprefix(){
		$this->style('float', 'right');
		$this->type = 'div';
		return parent::getprefix();
		}
	}
	
function TFloatRight () {
	$class = new ReflectionClass('TFloatRight');
	$instance = $class->newInstanceArgs(func_get_args());
	return $instance;
	}
	
?>