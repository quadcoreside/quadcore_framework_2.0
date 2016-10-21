<?php
class Request
{
	public $url;
	public $RR;

	public $page = 1;
	public $prefix = false;
	public $data = false;

	function __construct()
	{
		$url = current(explode('?', $_SERVER['REQUEST_URI']));
		$this->url = (BASE_URL == DS) ? $url : str_replace(BASE_URL , "" ,  $url);

		if (isset($_GET['page'])) {
			if(is_numeric($_GET['page'])){
				if($_GET['page'] > 0){
					$this->page = round($_GET['page']);
				}
			}
		}

		if(!empty($_POST)){
			$this->data = new stdClass();
			foreach ($_POST as $k => $v) {
				if (is_string($v)) {
					$this->data->$k = $v;
			    }
			}
		}
	}
}
