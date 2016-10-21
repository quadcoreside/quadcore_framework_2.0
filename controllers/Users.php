<?php
class Users extends Controller {	
	function login() {
		if($this->Session->isLogged()){
			redirect('home');
		}
		$this->tryActivation();
		$d = array();

		if(!empty($_POST)) {
			$password = sha1($this->request->data->password);

			$this->load->model('User');
			if($this->Form->validates($this->request->data, $this->User_Model->validateLogin)){
				$data = $this->request->data;

				$user = $this->db->select('*')
								->where('email', $data->email)
								->where('password', $password)
								->get('users')
								->row();

				if(!empty($user) && $user->active == 1){
					$data = array(
						'ip_last' => $_SERVER['REMOTE_ADDR'],
						'date_last' => date('Y-m-d H:i:s'), 
					);
					$this->db->where('id', $user->id)->update('users', $data); 
					$this->Session->write('User', $user);

					if(isset($_GET['redire']) && is_string($_GET['redire'])){
						redirect(urldecode($_GET['redire']));
					}else{
						redirect('home');
					}

				} else if (!empty($user) && $user->active == 0){
					$this->Session->setFlash("Votre compte n'est pas activer.", 'danger');

					if($this->Session->read('sended_mail_activation') == false) {
						$order = $this->db->select('*')
											->where('type', 'activation')
											->where('user_id', $user->id)
											->get('order_accounts')
											->row();

						$url_token = Router::url('users/login/'.'?confirm_token='.$order->token);
		                $this->sendMailActivation($user, $url_token);
						$this->Session->write('sended_mail_activation', true);
					} else {
						$this->Session->setFlash("Un mail d'activation vous a éte renvoyez récemment, à l'adresse électronique indiquée lors de l'inscription.
		                                        <em><b>(Pensez à vérifier vos spams ou courriers indésirables, junk, si vous ne voyez pas ce mail dans votre boîte de réception)</b></em>
		                                        <br/>Une fois que ceci est fait, vous n'aurez plus qu'à vous connecter.</p>", 'info');	
					}

				} else if (!empty($user) && $user->active == 2) {

					$this->Session->setFlash('Votre compte a été cloturer.', 'warning');

				} else {
					if (empty($user)) {
						$this->Session->setFlash('Votre E-mail ou mot de passe est incorecte.', 'danger');
					}
				}
			}
		}
		$this->set($d);
	}

	protected function tryActivation() {
		if(isset($_GET['confirm_token']) && !empty($_GET['confirm_token'])) {
			$token = $_GET['confirm_token'];
			$order = $this->db->select('*')
						->where('type', 'activation')
						->where('token', $token)
						->get('order_accounts')
						->row();
			if(!empty($order)) {
				$data = array(
					'active' => 1, 
					'ip_last' => $this->input->ip_address(),
					'date_last' => date('Y-m-d H:i:s'), 
				);
				$this->db->where('id', $order->user_id)->update('users', $data); 
				$this->db->delete('order_accounts', array('id' => $order->id));
				$this->Session->write('User', $user);

				$this->Session->setFlash('Votre compte a été activer avec succés.');
				redirect('users/login');
			} else {
				$this->Session->setFlash("Le lien n'existe pas ou plus, veuillez vous connectez.", 'danger');
				redirect('users/login');
			}
		}
	}

	protected function sendMailActivation($user, $url_token) {
		$message = $this->mailer->loadMail('account_activation.html', array(
        	'%USERNAME%' => $user->username,
        	'%LINK%' => $url_token,
        ));
        $sujet = 'Activation de Compte | ' . $this->Cfg->read('website_name');
        $this->mailer->send($user->email, $sujet, $message, $this->Cfg->read('website_name'), $this->Cfg->read('website_name'));

        $this->Session->setFlash("Un mail d'activation vous a éte renvoyez, à l'adresse électronique indiquée lors de l'inscription.
                                <em><b>(Pensez à vérifier vos spams ou courriers indésirables, junk, si vous ne voyez pas ce mail dans votre boîte de réception)</b></em>
                                <br/>Une fois que ceci est fait, vous n'aurez plus qu'à vous connecter.</p>", 'info');
	}
	
	function register() {
		if($this->Session->isLogged()) redirect('');

		$d = array();
		$this->load->helper('ReCaptcha');
		if(isset($_POST['g-recaptcha-response'])) {
            if($this->ReCaptcha->check($_POST['g-recaptcha-response'])) {
				$this->load->model('User');

				if($this->Form->validates($this->request->data, $this->User_Model->validateRegister)) {
					$data = $this->request->data;
					$password = sha1($data->password);
		            $token = random_string('alnum', 66);

		            $user = array(
		            	'username' =>  $data->username,
		            	'email' => $data->email,
		            	'password' => $password,
		            	'name' => ucfirst(strtolower($data->name)),
		            	'last_name' => ucfirst(strtolower($data->last_name)),
		            	'date_birth' => $data->date_birth,
		            	'country' => $data->country,
		            	'picture' => 'default.png',
		            	'active' => 0,
		            	'ip_last' => $_SERVER['REMOTE_ADDR'],
		            	'ip' => $_SERVER['REMOTE_ADDR'],
		            	'date_last' => date('Y-m-d H:i:s'),
		            	'date_created' => date('Y-m-d H:i:s')
		            );

					$this->db->insert('users', $user);
						$user->id = $this->db->insert_id();
						$data = array(
							'token' => $token, 
							'user_id' => $user->id, 
							'type' => 'activation'
						);
						$this->db->insert('order_accounts', $data);
						$url_token = Router::url('users/login' . '?confirm_token=' . $token, true);
		                $this->sendMailActivation($user, $url_token);
		                $this->Session->setFlash("<h4>Votre inscription a bien éte pris en compte.</h4>
	                							Un Mail d'activation a été envoyé à " . $user->email . "
		                                        <em><b>(Pensez à vérifier vos spams ou courriers indésirables, junk, si vous ne voyez pas ce mail dans votre boîte de réception)</b></em>
		                                        <br/>Une fois que ceci est fait, vous n'aurez plus qu'à vous connecter.</p>", 'info');
						redirect('users/login');
				} else {
					$this->Session->setFlash('Merci de corriger vos informations', 'danger');
				}
			} else {
            	$this->Session->setFlash('Veuillez prouvez que vous n\'êtes pas un robot.', 'danger');
            }
        }
        $this->set($d);
	}

	function forgot() {
		if($this->Session->isLogged()) redirect('');

		$d = array();
		if(isset($_POST['g-recaptcha-response'])) {
			$this->load->helper('ReCaptcha');
            if($this->ReCaptcha->check($_POST['g-recaptcha-response'])) {
				$this->load->model('User');

				if($this->Form->validates($this->request->data, $this->User_Model->validateForgot)) {
					$data = $this->request->data;
					$user = $this->db->select('*')
									->where('email', $data->email)
									->get('users')
									->row();

					if (!empty($user)) {
						$order = $this->db->select('*')->where('user_id', $user->id)->where('type', 'password_forgot')->get('order_accounts')->row();
						$token = random_string('alnum', 99);

						if (empty($order)) {
							$this->db->insert('order_accounts', array('token' => $token, 'user_id' => $user->id, 'type' => 'password_forgot', 'time' => time()));
						}else{
							$this->db->where('id', $order->id)->update('order_accounts', array('token' => $token, 'time' => time()));
						}
						
						$url_token = Router::url('users/password_reset' . '?reset_token=' . $token, true);

		                $message = $this->mailer->loadMail('password_forgot.html', array(
		                	'%USERNAME%' => $user->username,
		                	'%LINK%' => $url_token,
		                ));

		                $sujet = 'Mot de passe oublié | ' . $this->Cfg->read('website_name');
		                $this->mailer->send($user->email, $sujet, $message, $this->Cfg->read('website_name'), $this->Cfg->read('website_name'));

		                $this->Session->setFlash("Un Mail de régeneration de votre mot de passe vous a été envoyé à l'adresse électronique.<em><b>(Pensez à vérifier vos spams ou courriers indésirables, junk, si vous ne voyez pas ce mail dans votre boîte de réception)</b></p>", 'info');

		                redirect('users/login');
					} else {
						$this->Session->setFlash('Cette Adresse Email n\'est pas inscrit.', 'danger');
					}
				}
			}
            else {
            	$this->Session->setFlash('Veuillez prouvez que vous n\'êtes pas un robot.', 'danger');
            }
        }

        $this->set($d);
	}

	function password_reset() {
		if($this->Session->isLogged()) redirect('');

		if (isset($_GET['reset_token']) && !empty($_GET['reset_token'])) {
			$this->load->model('User');

			$order = $this->db->select('*')
								->where('token', $_GET['reset_token'])
								->where('type', 'password_forgot')
								->get('order_accounts')
								->row();

			if(!empty($order)) {
				if ((time() - $order->time) < (1 * 24 * 60 * 60)) {
					$user = $this->db->select('*')
									->where('id', $order->user_id)
									->get('users')
									->row();
					
					if(!empty($user)) {
						if(isset($_POST['g-recaptcha-response'])) {
            				$this->load->library('recaptcha');
            				if($this->recaptcha->check($_POST['g-recaptcha-response'])) {
								if($this->Form->validates($this->request->data, $this->User_Model->validatePassword)){
									$data = $this->request->data;
									$this->db->where('id', $user->id)->update('users', array('password' => sha1($data->password)));
									$this->db->delete('order_accounts', array('id' => $order->id));
									$this->Session->setFlash('<b>Votre mot de passe a bien été changer.<b>');
									redirect('users/login');
								} else {
									$this->Session->setFlash('Erreur veuillez remplir coréctement les champs', 'danger');
								}
							} else {
				            	$this->Session->setFlash('Veuillez prouvez que vous n\'êtes pas un robot.', 'danger');
				            }
				        }
					} else {
						$this->Session->setFlash('Erreur utilisateur non trouvé', 'danger');
					}
					
				}else{
					$this->db->delete('order_accounts', array('id' => $order->id));
					$this->Session->setFlash("La validié de l'url à expirer, veuillez recommencer la procedure.", 'danger');
					redirect('users/forgot');
				}
			} else {
				$this->Session->setFlash('Page non trouver', 'danger');
				redirect('users/forgot');
			}
			$this->template->load('users/password_reset', $d);
		} else {
			redirect('users/forgot');
		}
	}

	function my_account(){
		if(!$this->Session->isLogged()){
			$this->e404();
		}
		$d = array();
		$this->load->model('User');
		$d['user'] = $this->db->select('*')->where('id', $this->Session->read('User')->id)->get('users')->row();

		if(!empty($_GET['unset'])){
			if($_GET['unset'] == 'picture'){
				$path = $this->upload_path . $d['user']->picture;
				if(file_exists($path) && $d['user']->picture != 'default.png'){
					unlink($path);
				}
				$this->db->where('id', $d['user']->id)->update('users', array('picture' => 'default.png'));
				redirect('users/my_account');
			}
		}

		if($this->request->data){
			if($this->Form->validates($this->request->data, $this->User_Model->validateAccount)) {
				$data = $this->request->data;
				$Ok = true;

				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size']	= '0';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';
				$config['max_filename'] = 255;
				$config['encrypt_name'] = true;

				$this->load->library('upload', $config);
				if(!empty($this->upload->data())) {
					if (!$this->upload->do_upload('file')) {
						$this->Session->setFlash('Erreur lors du transfert de votre image verfier qu\'il s\'agit bien d\'une image <br>' . $this->upload->display_errors(), 'danger');
						$Ok = false;
					} else { 
						$data_upl = $this->upload->data();
			            $data_upl = array('upload_data' => $this->upload->data()); 

			            if(file_exists($path) && $d['user']->picture != 'default.png'){
							unlink($path);
						}

						$this->db->where('id', $d['user']->id)->update('users', array('picture' => $data_upl['upload_data']['file_name']));
			        } 
				}

				$this->db->where('id', $d['user']->id)->update('users', array(
					'name' => $data->name,
					'last_name' => $data->last_name,
				));
				$user = $this->db->select('*')->where('id', $this->Session->read('User')->id)->get('users')->row();
				$this->Session->write('User', $user);
				if($Ok){
					$this->Session->setFlash('Vos informations on bien éte pris en compte');
				}
			}else{
				$this->Session->setFlash('Merci de corriger vos informations', 'danger');
			}

			if($data->password_old){
				if($this->Form->validates($data, $this->User_Model->validatePassword)){
					if(sha1($data->password_old) == sha1($d['user']->password)){
						$this->db->where('id', $d['user']->id)->update('users', array('password' => $data['password']));
						$this->Session->setFlash('Votre mot de passe à bien éte changer');
					}else{
						$this->Session->setFlash('Votre mot de passe actuel est incorecte', 'danger');
					}
				}
			}

			$d['user'] = $this->db->select('*')->where('id', $this->Session->read('User')->id)->get('users')->row();
		}
		$this->set($d);
	}

	function logout() {
		if($this->Session->isLogged()){
			$this->Session->unwrite('User');
			$this->Session->setFlash('Vous êtes maintenant déconnecté.');
		}
		redirect('home');
	}
}
