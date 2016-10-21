<?php
class Hook
{
	public $Controller;

	function __construct() {
		$this->Controller =& get_instance();
	}

}