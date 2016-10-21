<?php
class Users extends Controller
{
	public $perPage = 10;
	public $upload_path = './images/profile/';
	
	function login() {
		if ($this->Session->isLoggedAdm()) {
			redirect('admin/dashboard');
		}
		$this->load->model('Admin');
		$d = array();
		
		if($this->request->data) {

			if($this->Form->validates($this->request->data, $this->Admin_Model->validateLogin)){
				$data = $this->request->data;
				$admin = $this->db->select('*')->where('email', $data->email)
												->where('password', sha1($data->password))
												->get('admins')
												->row();
				if(!empty($admin) && $admin->active = 1) {
					$data = array(
						'ip_last' => $_SERVER['REMOTE_ADDR'], 
						'date_last' => date('Y-m-d H:i:s')
					);
					$this->db->where('id', $admin->id)->update('admins', $data);
					$this->Session->write('Admin', $admin);
					redirect('admin/dashboard');
					
					if(isset($_GET['redire']) && is_string($_GET['redire'])){
						redirect(urldecode($_GET['redire']));
					}else{
						redirect('admin/dashboard');
					}

				}else{
					$this->request->data->password = '';
					$this->Session->setFlash('Votre Email ou Mot de passe est incorecte.', 'danger');
				}
			}
		}
		$this->load->view('admin/users/login', $d);
	}

	function my_account(){
		$d = array();
		$this->load->model('Admin');
		$this->load->model('User');
		$d['admin'] = $this->db->select('*')->where('id', $this->Session->read('Admin')->id)->get('admins')->row();

		if(!empty($this->input->get('unset'))){
			if($this->input->get('unset') == 'picture'){
				$path = $this->upload_path . $d['admin']->picture;
				if(file_exists($path) && $d['admin']->picture != 'default.png'){
					unlink($path);
				}
				$this->db->where('id', $d['admin']->id)->update('admins', array('picture' => 'default.png'));
				redirect('admin/users/my_account');
			}
		}

		if($this->request->data){
			$data = $this->request->data;
			
			if($this->Form->validates($data, $this->Admin_Model->validateAccount)){
				$Ok = true;

				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size']	= '0';
				$config['max_width'] = '3000';
				$config['max_height'] = '3000';
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

			            if(file_exists($path) && $d['admin']->picture != 'default.png'){
							unlink($path);
						}

						$this->db->where('id', $d['admin']->id)->update('admins', array('picture' => $data_upl['upload_data']['file_name']));
			        } 
				}

				$this->db->where('id', $d['admin']->id)->update('admins', array(
					'name' => $data['name'],
					'last_name' => $data['last_name'],
				));
				$admin = $this->db->select('*')->where('id', $this->Session->read('Admin')->id)->get('admins')->row();
				$this->Session->write('Admin', $admin);
				if($Ok){
					$this->Session->setFlash('Vos informations on bien éte pris en compte');
				}
			}else{
				$this->Session->setFlash('Merci de corriger vos informations', 'danger');
			}

			if($data['password_old']){
				if($this->Form->validates($data, $this->Admin_Model->validatePassword)){
					if(sha1($data['password_old']) == sha1($d['admin']->password)){
						$this->db->where('id', $d['admin']->id)->update('admins', array('password' => $data['password']));
						$this->Session->setFlash('Votre mot de passe à bien éte changer');
					}else{
						$this->Session->setFlash('Votre mot de passe actuel est incorecte', 'danger');
					}
				}
			}

			$d['admin'] = $this->db->select('*')->where('id', $this->Session->read('Admin')->id)->get('admins')->row();
		}
		$this->template->load('admin/users/my_account', $d);
	}

	function index() {
		$d = array();
		
		$this->load->view('admin/users/index', $d);
	}

	function edit($id = null){
		if ($this->Session->read('Admin')->law != 1){
			$this->e404();
		}
		$this->load->model('Admin');

		$d['id'] = $id;
		if($this->request->data){
			$data = $this->request->data;
			if($this->Form->validates($data, $this->Admin_Model->validateAdminRegister)) {
				$Ok = true;
				if(empty($id)) {
					if($data['password']){
						if(!$this->Form->validates($data, $this->Admin->validatePassword)) {
							$Ok = false;
							$this->Session->setFlash('Veuillez coriger les erreur du mot de passe', 'danger');
						}
					}else{
						$Ok = false;
						$this->Session->setFlash('Vous devez entrez un mot de passe pour cette utilisateur', 'danger');
						$this->Session->setFlash("Un generateur de mot passe est a votre disposition, vous n'aurez qu'a copier ce mot de passe.", 'info');
					}
				}

				if($Ok){
					$action = '';
					$admin_level = array(1 => 'Admin Normal', 2 => 'Super Admin');
					$data['law'] = (isset($admin_level[$data['law']])) ? $data['law'] : 2;
					$data['law'] = ($this->Session->read('Admin')['law'] == 1) ? $data['law'] : 2;

					$reqAdm = array(
						'email' => $data['email'],
						'username' => $data['username'],
						'law' => $data['law'],
						'date_last' => date('Y-m-d H:i:s'), 
						'date_created' => date('Y-m-d H:i:s'), 
						'ip' => $this->input->ip_address(),
						'ip_last' => $this->input->ip_address(),
					);

					$this->db->insert('admins', $reqAdm);
					$id = $this->db->insert_id();

					if($data['password']) {
						if($this->Form->validates($data, $this->Admin->validatePassword)){
							$this->db->where('id', $id)->update('admins', array('password' => sha1($data['password'])));
							$this->Session->setFlash('Le mot de passe à bien éte changer');
						}
					}
				}
				$this->Session->setFlash('Utilisateur admin a bien éte éditer');
				redirect('admin/users');
			}else{
				$this->Session->setFlash('Merci de corriger vos informations', 'danger');
			}
		}else{
			if($id){
				$admin = $this->db->select('*')->where('id', $id)->get('admins')->row();
				$this->request->data = $admin;
				$this->request->data->password = '';
				$d['id'] = $id;
			}
		}
		$d['admin_level'] = array(1 => 'Super Admin', 2 => 'Admin Normal');
		$this->load->view('admin/users/edit', $d);
	}

	function logout(){
		unset($_SESSION['Admin']);
		$this->Session->setFlash('Vous êtes maintenant déconnecté');
		redirect('admin/admins/login');
	}

}
