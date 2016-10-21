<?php
class Dispatcher
{
	var $request;

	function __construct() {
		$this->request = new Request();
		$Security = new Security();
		$this->request->url = $Security->sanitize_filename($this->request->url, true);

		$this->request->RR = Router::resolveRoute($this->request->url, $this->request);
		
		if (!$this->request->RR['success']) {
			$this->notFound('Page introuvable');
		}

		Router::parse($this->request->url, $this->request);

		$controller = Loader::controller($this->request);
		log_message('info', 'Dispatcher Class Initialized');

		if (!$controller) {
			if (Conf::$debug > 0) {
				debug('File, Controller, Method respective not found.');
			}	
			$this->notFound('Page introuvable');
		} else {
			$controller->Security =& $Security;
		}

		$action = $this->request->action;

		if(!in_array($action, array_diff(get_class_methods($controller), get_class_methods('Controller')))){
			if (Conf::$debug > 0) {
				$this->notFound('Le Controller: '.strip_tags($this->request->controller).'<br> Pas de methode: '. strip_tags($action));
			}else{
				$this->notFound('Page introuvable');
			}
		}

		if (Conf::$hook && isset(Conf::$hooks['after_load'])) {
	    	foreach (Conf::$hooks['after_load'] as $key => $value) {
		    	$controller->load->hook($value['class'], $value['method'], $value['params']);
		    }
	    }

		call_user_func_array(array($controller, $action), $this->request->params);
		
		if ($controller->is_render) {
			$controller->render();
		}
	}

	function notFound($message) {		
		header("HTTP/1.1 404 Not Found");
		$controller = new Controller($this->request);
		$controller->e404($message);
		exit;
	}
}
