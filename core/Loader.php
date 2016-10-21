<?php
class Loader {
	
	protected $Ctrl;

	function __construct()  {
		$this->Ctrl =& get_instance();

	    foreach (Conf::$autoload['models'] as $key => $value) {
	    	$this->model($value);
	    }

	    foreach (Conf::$autoload['helpers'] as $key => $value) {
	    	$this->helper($key, $key);
	    }

	    foreach (Conf::$autoload['libraries'] as $key => $value) {
	    	$this->library($key, strtolower($value));
	    }

	    //If hook enable
	    if (Conf::$hook && isset(Conf::$hooks['pre_load'])) {
	    	foreach (Conf::$hooks['pre_load'] as $key => $value) {
		    	$this->hook($value['class'], $value['method'], $value['params']);
		    }
	    }
	    log_message('info', 'Autoload All Class Initialized');
    	log_message('info', 'Loader Class Initialized');
    }

    static function controller($request) {
		$file = (ROOT.DS.'controllers'.DS) . ($request->RR['dir'] . DS . $request->RR['controller']) .'.php';

		if (!file_exists($file)) {
			if (Conf::$debug > 0) {
				debug('File not exist as Ctrl: "' . $request->url . '".');
			}
			return FALSE;		
		}

		require $file;

		$name = ucfirst($request->controller);
	    $controller = new $name($request);

		return $controller;
	}
	
	public function view($path, $view_vars = array()) {
		$path = str_replace('/', DS, ltrim($path, '/'));
		$file = (ROOT.DS.'views'.DS) . $path.'.php';

		if (!file_exists( $file )) {
			die('Error View Load: File not found: "' . $path . '".');
		}

		$this->Ctrl->view = $file;

		if (!empty($view_vars)) {
			$this->Ctrl->set($view_vars);
		}
	}

	public function model($name){
		$name = str_replace('/', DS, $name);
		$file = (ROOT.DS.'models'.DS) . $name.'.php';

		if (file_exists($file)) {
			require_once $file;
		} else {
			die('Error Model not found "' . $file . '"');
		}

		$as_name = ucfirst(strtolower($name)) . '_Model';

		if(!isset($this->Ctrl->$as_name)){
			$this->Ctrl->$as_name = new $as_name();
		} else {
			die('Error Model Load: Name arleady defined: "' . $as_name . '".');
		}
	}

	public function helper($name, $as_name = null){
		$name = str_replace('/', DS, $name);
		$file = (ROOT.DS.'helpers'.DS) . $name.'.php';

		if (file_exists($file)) {
			require_once $file;
		} else {
			die('Error Helper not found "' . $file . '"');
		}

		$as_name = (is_null($as_name)) ? $name : $as_name;

		if(!isset($this->Ctrl->$as_name)){
			$this->Ctrl->$as_name = new $name();
		} else {
			die('Error Helper Load: Name arleady defined: "' . $as_name . '".');
		}
	}

	public function library($name, $config){
		$name = str_replace('/', DS, $name);
		$file = (ROOT.DS.'libraries'.DS) . $name.'.php';

		if (file_exists($file)) {
			require_once $file;
		} else {
			die('Error Library not found "' . $file . '"');
		}

		$name = strtolower($name);

		if(!isset($this->Ctrl->$name)){
			$this->Ctrl->$name = new $name($config);
		} else {
			die('Error Library Load: Name arleady defined: "' . $name . '".');
		}
	}

	static function language($path, $as_name = null){
		$path = str_replace('/', DS, $path);
		$file = (ROOT.DS.'language'.DS.Conf::$language.DS) . $path . '.php';

		include $file;
	}

	public function hook($hook_name, $run_method_name = null, $params = array()){
		$hook_name = str_replace('/', DS, $hook_name);
		$file = (ROOT.DS.'hooks'.DS) . $hook_name.'.php';

		if (file_exists($file)) {
			require_once $file;
		} else {
			die('Error Hook not found "' . $file . '"');
		}

		$hook = new $hook_name($this->Ctrl);

		call_user_func_array(array($hook, $run_method_name), $params);
	}

}