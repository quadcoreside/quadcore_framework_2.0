<?php
class Router {
	static $routes = array();
	static $prefixes = array();

	static function resolveRoute($url, $request) {
		$request_route = array(
			'dir' => '',
			'controller' => '',
			'action' => '',
			'params' => array(),
			'success' => false
		);
		$url = trim($url, '/');
		$url = preg_replace('/\s+/', '', $url);

		if (empty($url)) {
			$request_route['controller'] = ucfirst(Conf::$default_controller);
			$request_route['action'] = 'index';
			$request_route['success'] = true;
			return $request_route;
		} else {
			//BUILD REAL ROUTE
			$match = false;
			foreach (Router::$routes as $v) {
				if(!$match && preg_match($v['redirreg'], $url, $match)){
					$url = $v['origin'];
					foreach ($match as $k => $v) {
						$url = str_replace(':'.$k, $v, $url);
					}
					$match = true;
				}
			}
		}

		$segments = array();
		$segments = explode('/', $url);
		//debug($segments);// path / detected

		//If try direct access not prefixe
		if (in_array($segments[0], array_values(self::$prefixes))) {
			if (Conf::$debug > 3) {
				debug('Prefixes bypass detected => ' . $segments[0]);
			}
			$request_route['success'] = true;
			return $request_route;
		}

		//Replace with prefixe folder
		foreach (self::$prefixes as $key_prefixe => $real_name) {
			if (strpos($segments[0], $key_prefixe) !== false) {
				$segments[0] = str_replace($key_prefixe, $real_name, $segments[0]);
				$request->prefix = $real_name;

				if (Conf::$debug > 3) {
					debug('Prefixes detected => ' . $segments[0] . ' replaced by real');
				}
				break;
			}
		}

		$i = 0;
		foreach ($segments as $index => $value) {
			$controller = ucfirst($value);
			$folders = array_slice($segments, 0, $i);
			$dir = implode(DS, $folders);
			$dir = !empty($dir) ? $dir . DS : $dir;
			$path_check = (ROOT.DS.'controllers'.DS) . $dir . $controller . '.php';

			if (file_exists( $path_check )) {
				//debug('OK EXISTE => ' . $path_check);

				$request_route['dir'] = $dir;
				$request_route['controller'] = $controller;

				$action = @array_slice($segments, $i+1, $i+2)[0];
				if (empty($action)) {
					$action = 'index';
				}
				$request_route['action'] = $action;

				$params = @array_slice($segments, $i+2, count($segments));
				$request_route['params'] = $params;

				$request_route['success'] = true;

				//debug($request_route);
				break;
			}
			$i++;
		}

		return $request_route;
	}

	static function parse($url, $request){
		$url = trim($url, '/');

		if(empty($url)){
			$url = Router::$routes[0]['url'];
		}

		$request->controller = $request->RR['controller'];
		$request->action = $request->RR['action'];
		$request->params = $request->RR['params'];

		log_message('info', 'Router Class Initialized');

		return true;
	}

	static function connect($redir, $url){
		$r = array();
		$r['params'] = array();
		$r['url'] = $url;

		$r['originreg'] = preg_replace('/([a-z0-9]+):([^\/]+)/', '${1}:(?P<${1}>${2})', $url);
		$r['originreg'] = str_replace('/*', '(?P<args>/?.*)', $r['originreg']);
		$r['originreg'] = '/^' . str_replace('/', '\/', $r['originreg']) . '$/';

		$r['origin'] = preg_replace('/([a-z0-9]+):([^\/]+)/', ':${1}', $url);
		$r['origin'] = str_replace('/*', ':args:', $r['origin']);

		$params = explode('/', $url);
		foreach ($params as $k => $v) {
			if(strpos($v, ':')){
				$p = explode(':', $v);
				$r['params'][$p[0]] = $p[1];
			}
		}

		$r['redirreg'] = $redir;
		$r['redirreg'] = str_replace('/*', '(?P<args>/?.*)', $r['redirreg']);
		foreach ($r['params'] as $k => $v) {
			$r['redirreg'] = str_replace(":$k" , "(?P<$k>$v)", $r['redirreg']);
		}
		$r['redirreg'] = '/^' . str_replace('/', '\/', $r['redirreg']) . '$/';

		$r['redir'] = preg_replace('/:([a-z0-9]+)/', ':${1}:', $redir);
		$r['redir'] = str_replace('/*', ':args:', $r['redir']);
		
		self::$routes[] = $r;
	}

	static function url($url = '', $relative = false){
		trim($url, '/');
		foreach (self::$routes as $v) {
			if(preg_match($v['originreg'], $url, $match)){
				$url = $v['redir'];
				foreach ($match as $k => $w) {
					$url = str_replace(":$k:", $w, $url);
				}
			}
		}
		foreach (self::$prefixes as $k => $v) {
			if(strpos($url, $v) === 0){
				$url = str_replace($v, $k, $url);
			}
		}

		if ($relative) {
			return trim(Conf::$base_url, '/').str_replace('//', '/', '/'.$url);
		} else {
			return str_replace('//', '/', BASE_URL.'/'.$url);
		}
	}

	static function prefix($url, $prefixe) {
		self::$prefixes[$url] = $prefixe;
	}

	static function webroot($url, $relative = false){
		trim($url, '/');
		if ($relative) {
			return trim(Conf::$base_url, '/').str_replace('//', '/', '/'.$url);
		} else {
			return str_replace('//', '/', BASE_URL.'/'.$url);
		}
	}

}
