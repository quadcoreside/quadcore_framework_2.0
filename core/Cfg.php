<?php
class Cfg {
	
	static $controller;
	static $values = array();

	public function __construct(){
		self::$controller =& get_instance();
	}

	public function set($keys, $value = null){
		if (is_array($keys)) {
			self::$values += $keys;
		} else {
			self::$values[$keys] = $value;
		}
	}

	public static function read($key){
		if(isset(self::$values[$key])){
			return self::$values[$key];
		}else{
			return 'N/A';
		}
	}

	public function load(){
		$vars = self::$controller->db->select('name,content')->get('configs')->result();
		$r = array();
		foreach ($vars as $k => $v) {
			$r += array($v->name => $v->content);
		}
		if(empty($r['webRouter::url']) || !isset($r['webRouter::url'])){
			$r['webRouter::url'] = 'http://' . $_SERVER['SERVER_NAME'];
		}if(empty($r['website_name'])){
			$r['website_name'] = 'QuadCore ENgineering CMS';
		}
		$this->set($r);
	}

}