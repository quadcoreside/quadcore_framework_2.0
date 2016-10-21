<?php
class Controller {
	
	private static $instance;
	
	public $request;
	public $vars = array();
	public $layout = 'layout/default';

	public $is_render = true;
	public $rendered = false;
	public $view = null;

	public $json = false;

	function __construct($request = null){
		self::$instance =& $this;

		$this->request = $request;
		$this->load = new Loader();
		$this->db = &DB();

	    $this->Cfg = new Cfg();
	    $this->Cfg->load();

		$this->Session = new Session();
	    $this->Lang = new Lang();
	    $this->Form = new Form();

	    log_message('info', 'Controller Class Initialized');
	}

	public function set($keys, $value = null) {
		if (is_array($keys)) {
			$this->vars += $keys;
		} else {
			$this->vars[$keys] = $value;
		}
	}

	function e404($message = 'Page Introuvable'){
		header("HTTP/1.0 404 Not Found");
		$this->set('message', $message);
		$this->load->view('errors/404');
		$this->render();
		die();
	}

	function errno($msg = 'Access denied'){
		header("HTTP/1.0 404 Not Found");
		echo json_encode(array('error' => $msg));
	}

	function siteLocked(){
		header("HTTP/1.0 500 Site locked");
		$this->load->view('errors/disabled');
		$this->render();
		exit;
	}

	function request($controller, $action, $params = array()){
		require_once ROOT.DS.'controller'.DS.$controller.'.php';
		$c = new $controller();
		return call_user_func_array(array($c, $action), $params);
	}

	function redirect($url, $code = null){
		if($code == 301){
			header("HTTP/1.0 301 Moved Permanently");
		}
		if (substr($url, 0, 4) === "http") {
			header("Location: {$url}");
		} else {
			header("Location: ".Router::url($url));
		}
		exit;
	}

	function tokenCheck() {
		if (isset($_REQUEST['token']) && !empty($_REQUEST['token'])) {
			if ($this->Session->isTokenValid('token')) {
				return true;
			} else {
				$this->e404('Jeton disparut');
				exit;
			}
		} else {
			$this->e404('Jeton inexistant');
			exit;
		}
	}

	function antixss($str) {
		return htmlentities(strip_tags($str), ENT_QUOTES, 'UTF-8');
	}

    public function postOption($options, $item, $staut)
    {
    	$arr = explode(',', $options);
    	if($staut == 1) {
    		if(!in_array($item, $arr)) {
    			$arr[] = $item;
    		}
    	} else {
    		$i = array_search($item, $arr);
			if ($i !== false) {
				unset($arr[$i]);
			}
    	}
    	return $arr;
    }

    public function json() {
		$this->json = true;
		Conf::$debug = 0;
	}

    public function render() {
		if($this->rendered) {
			return ;
		}
		if ($this->json) {
			Conf::$debug = 0;
			ob_start();
			//header('Content-Type: application/json');
			if (!empty($this->vars)) {
				echo json_encode($this->vars);
			}
			$this->rendered = true;
		} 
		else 
		{
			$view = '';
			extract($this->vars);

			if (!is_null($this->view)) {

				$view = $this->view;

			} else {
				$path = ($this->request->RR['dir'] . strtolower($this->request->RR['controller']) . DS . $this->request->RR['action']);
				$path = str_replace('/', DS, trim($path, DS));
				$view = (ROOT.DS.'views'.DS) . $path .'.php';

				if (!file_exists($view)) {
					die('Error: View file not found' . $view . '<br> You can also set view null if you not would use view');
				}
			}

			ob_start();

			require ( $view );

			$content_for_layout = ob_get_contents();
			ob_clean();
			
			ob_start();

			if (!is_null($this->layout)) {
				if (empty($this->layout)) {
					die('Error layout activate and layout file empty');
				}

				require (ROOT.DS.'views'.DS) . $this->layout.'.php';

			} else {
				echo $content_for_layout;
			}

			$this->rendered = true;
		}
	}

	public static function &get_instance()
	{
		return self::$instance;
	}

}
