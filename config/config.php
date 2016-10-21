<?php
class Conf {

	static $debug = 3;

	static $base_url = 'http://localhost/quadcore_framework_2.0/';

    static $default_controller = 'home';

    static $language = 'english';

    static $database_active_group = 'default';
    static $database = array();

    static $autoload = array();

    static $hooks = array();
    static $hook = TRUE;

    static $charset = 'UTF-8';

    static $csrf_protection = FALSE;
    static $csrf_token_name = 'csrf_test_name';
    static $csrf_cookie_name = 'csrf_cookie_name';
    static $csrf_expire = 7200;
    static $csrf_regenerate = TRUE;
    static $csrf_exclude_uris = array();
}

Conf::$database['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'laygacy',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (Conf::$debug > 0),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
