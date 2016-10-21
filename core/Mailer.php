<?php
require HELPER . DS . 'php_mailer' . DS . 'PHPMailerAutoload.php';
class Mailer
{
	public $config = array();
	public $controller;

	public function __construct($controller){
		$this->controller = $controller;
	}

	function send($to, $subject, $body, $from, $from_name = 'QuadCore CMS EE'){
		if($this->controller->Cfg->read('smtp_online') == 1) {
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug = 0;  
			$mail->SMTPAuth = true;
			$mail->Priority = 3; 
			$mail->SMTPSecure = $this->controller->Cfg->read('smtp_secure');
			$mail->Host = $this->controller->Cfg->read('smtp_host');
			$mail->Port = $this->controller->Cfg->read('smtp_port');
			$mail->Username = $this->controller->Cfg->read('smtp_user');
			$mail->Password = $this->controller->Cfg->read('smtp_password');       
			$mail->FromName = $from_name;
			$mail->from = $from;
			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->AddAddress($to);
			$mail->isHTML(true);
			$mail->Send();
		}else{
			if(empty($from_name)) {
				$from_name = $this->controller->Cfg->read('website_name');
			}
			$headers = 'From: '.trim($from_name).' <'.$this->controller->Cfg->read('website_email').'>' . "\r\n";
            $headers = 'MIME-version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8'. "\r\n";
			mail($to, $subject, $body, $headers);
		}
		return true;
	}
	function sendRapport($subject, $body){
		$to = $this->controller->Cfg->read('website_report');
		$subject = $subject . ' | ' . $this->controller->Cfg->read('website_name');
		$body = $body . $this->getInfos();
		if($this->controller->Cfg->read('smtp_online') == 1) {
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug = 0;  
			$mail->SMTPAuth = true;
			$mail->Priority = 3; 
			$mail->SMTPSecure = $this->controller->Cfg->read('smtp_secure');
			$mail->Host = $this->controller->Cfg->read('smtp_host');
			$mail->Port = $this->controller->Cfg->read('smtp_port');
			$mail->Username = $this->controller->Cfg->read('smtp_user');
			$mail->Password = $this->controller->Cfg->read('smtp_password');       
			$mail->FromName = $this->controller->Cfg->read('website_name');
			$mail->from = $this->controller->Cfg->read('website_name');
			$mail->Subject = $subject;
			$mail->Body = $body;
			$emails = explode(',', $to);
			foreach ($emails as $k => $to) {
				$mail->AddAddress($to);
			}
			$mail->isHTML(true);
			$mail->Send();
		}else{
			$headers = 'From: '.trim($this->controller->Cfg->read('website_name')).' <'.$this->controller->Cfg->read('website_email').'>' . "\r\n";
            $headers = 'MIME-version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8'. "\r\n";
			mail($to, $subject, $body, $headers);
		}
		return true;
	}
	protected function getInfos() {
		$var = '<hr/><pre>';
		$var .= '<h3>SERVER</h3>';
		$var .= print_r($_SERVER, true);
		$var .= '<h3>SESSION</h3>';
		$var .= print_r($_SESSION, true);
		$var .= '<h3>POST</h3>';
		$var .= print_r($_POST, true);
		$var .= '<h3>GET</h3>';
		$var .= print_r($_GET, true);
		$var .= '</pre>';
		return $var;
	}

	function loadMail($file, $vars = array()) {
		$path = ROOT . DS . 'view' . DS . 'templates' . DS . 'mail' . DS . $file;

		if (file_exists($path)) {
			$mailContent = file_get_contents($path);
			$vars += array(
				'%WEBSITEURL%' => $this->controller->Cfg->read('webRouter::url')
			);

			foreach($vars as $k => $v) {
				while (strpos($mailContent, $k) !== false) {
				    $mailContent = str_replace($k, $v, $mailContent);
				}
			}

			return $mailContent;

		}else{
			debug('Error template mail file not found ' . $file);
			die('<h3>Error template mail file not found<h3/>');
		}
	}
}
