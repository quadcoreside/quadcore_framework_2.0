<?php
class Session
{
	function __construct(){
		if(!isset($_SESSION)){
			session_start();
		}
	}

	public function setFlash($message, $type = 'success'){
		$_SESSION['flash'] = array(
			'message' => $message,
			'type' => $type
		);
	}

	public function flash() {
		if(isset($_SESSION['flash']['message'])) {
			$html = '<div class="alert alert-'.$_SESSION['flash']['type'].'" id="msg-alert" style="margin-top:15px; margin-bottom:15px;">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						'.$_SESSION['flash']['message'].'
					</div>';
			$_SESSION['flash'] = array();
			return $html;
		}
	}

	public function write($key, $value = null){
		if (is_array($key)) {
			$_SESSION += $key;
		} else {
			$_SESSION[$key] = $value;
		}
	}

	public static function read($key = null) {
		if($key){
			if(isset($_SESSION[$key])){
				return $_SESSION[$key];
			} else {
				return false;
			}
		}else{
			return $_SESSION;
		}
	}

	public function unset_userdata($key)
	{
		if (is_array($key)) {
			foreach ($key as $k) {
				unset($_SESSION[$k]);
			}
			return;
		}
		unset($_SESSION[$key]);
	}

	public function makeToken()
    {
        $max_time = 60 * 60 * 24; //1 day
        $csrf_token = self::read('csrf_token');
        $stored_time = self::read('csrf_token_time');

        if ($max_time + $stored_time <= time() || empty($csrf_token)) {
            $this->write('csrf_token', md5(uniqid(rand(), true)));
            $this->write('csrf_token_time', time());
        }

        return self::read('csrf_token');
    }

    public function isTokenValid($name = 'token')
    {
        return @$_REQUEST[$name] === $this->read('csrf_token');
    }

	static function isLogged(){
		if(isset($_SESSION['User']->id)){
			return true;
		}else{
			return false;
		}
	}

	static function isLoggedAdm(){
		if(isset($_SESSION['Admin']->id)){
			return true;
		}else{
			return false;
		}
	}



}