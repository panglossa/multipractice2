<?php
class TFloatLeft extends TDiv {
	function getprefix(){
		$this->style('float', 'left');
		$this->type = 'div';
		return parent::getprefix();
		}
	}
	
function TFloatLeft () {
	$class = new ReflectionClass('TFloatLeft');
	$instance = $class->newInstanceArgs(func_get_args());
	return $instance;
	}
	
?>