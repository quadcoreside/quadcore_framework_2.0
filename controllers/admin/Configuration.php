<?php
class Configuration extends Controller {

	function index()
	{
		$allParam = $this->db->select('name,content')->get('configs')->result();
		$dataConfig = new StdClass();
		foreach ($allParam as $k => $v) {
			$name = $v->name;
			$dataConfig->$name = $v->content;
		}
		$this->request->data = $dataConfig;
	}

	function SiteStaticVars(){
	    $d = array();
	    $perPage = 50;

	    $this->db->select('*');

		if (isset($_GET['q']) && !empty($_GET['q'])) {
			$q = $_GET['q'];
			$this->db->like('var', $q)
					->like('name', $q)
					->like('content', $q)
					->like('type', $q);
		}

		$d['vars'] = $this->db->limit($perPage, $perPage * ($this->request->page - 1))
								->get('site_statics')
								->result();

		$d['total'] = $this->db->count_all_results('site_statics');
		$this->pagination->setCurrent($this->request->page);
		$this->pagination->setTotal($d['total']);
		$this->pagination->setRPP($perPage);
		$d['pagination'] = $this->pagination->parse();

	    $this->set($d);
	}

	function SiteViveVars(){
		$this->load->model('Config');
	    $d = array();
	    $perPage = 50;

	    $this->db->select('*');

		if (isset($_GET['q']) && !empty($_GET['q'])) {
			$q = $_GET['q'];
			$this->db->like('var', $q)
					->like('name', $q)
					->like('content', $q)
					->like('type', $q);
		}

		$d['vars'] = $this->db->limit($perPage, $perPage * ($this->request->page - 1))
							->get('configs')
							->result();

		$config['base_url'] = Router::webroot('admin/SiteViveVars');
		$config['total_rows'] = $d['total'] = $this->db->count_all_results('configs');
		$config['per_page'] = $perPage;
	    $this->pagination->initialize($config); 
	    $d['pagination'] = $this->pagination->create_links();

	    $this->set($d);
	}

	function editVar($type = null, $id = null){
		$model = '';
		if ($type == 'vive') {
			$model = 'configs';
		}else if($type == 'static'){
			$model = 'site_statics';
		}else{
			$this->e404();
		}
		$d = array();

		if (!empty($_GET['delete'])) {
			$this->db->delete('users', array('id' => $_GET['delete']));
			$this->Session->setFlash('Le slider a bien éte supprimé');
			redirect('admin/configuration/editVar');
		}

		if($this->request->data){
			$data = $this->request->data;
			if ($this->Form->validates($data, $this->Config->validateVar)) {
				$this->db->where('id', $data->id)->update(strtolower($type) . 's', $data);
				$this->Session->setFlash('Variable sauvegader');
			}else{
				$this->Session->setFlash('Veuillez coriger les erreur', 'danger');
			}
		}
		if ($id) {
			$this->request->data = $this->db->select('*')->where('id', $id)->get($model)->row();
		}
		$d['model'] = $model;
	    $this->set($d);
	}

	function about(){
		//Editer directement la view
	}

	protected function loadDataField(){
		$allParam = $this->db->select('name,content')->get('configs')->result();
		$resObj = new stdClass();
		foreach ($allParam as $k => $v) {
			$strname = $v->name;
			$resObj->$strname = $v->content;
		}
		$this->request->data = $resObj;
	}

	function footer(){
		$this->load->model('Config');
		if($this->request->data) {
			$data = $this->request->data;
			if ($this->Form->validates($data, $this->Config->validateFooter)) {
				$this->db->where('name', 'website_footer')->update('configs', array('content' => $data->website_footer));
				$this->Session->setFlash('Configuration sauvegader');
			}else{
				$this->Session->setFlash('Veuillez coriger les erreur', 'danger');
			}
		} else {
			$this->loadDataField();
		}
	}

	function seo(){
		$this->load->model('Config');
		if($this->request->data) {
			$data = $this->request->data;
			if ($this->Form->validates($data, $this->Config->validateSeo)) {
				$this->db->where('name', 'website_description')->update('configs', array('website_description' => $data->website_description));
				$this->db->where('name', 'website_keywords')->update('configs', array('website_keywords' => $data->website_keywords));
				$this->db->where('name', 'website_author')->update('configs', array('website_author' => $data->website_author));
				$this->Cfg->load();
				$this->Session->setFlash('Configuration sauvegader');
			}else{
				$this->Session->setFlash('Veuillez coriger les erreur', 'danger');
			}
		} else {
			$this->loadDataField();
		}
	}

	function purchases(){
		$this->load->model('Config');
		if($this->request->data) {
			$data = $this->request->data;
			if ($this->Form->validates($data, $this->Config->validatePurchases)) {

				$list = array(
					'website_paypal_allow',
				);

				$affect = false;

				foreach ($this->request->data as $k => $v) {
					if (in_array($k, $list)) {
						$this->db->where('name', $k)->update('configs', array('content' => $v));
						$affect = true;
					}else{
						$this->Session->setFlash('Veuillez coriger les erreur', 'danger');
					}
				}

				if ($affect) {
					$this->Mailer->sendRapport('Configuration paiements edité par '.$this->Session->read('Admin')->username, "<br/><pre>". print_r($_POST, true) . '</pre><hr><h1>Précedant</h1><pre>' . print_r($this->Cfg->values, true) .'</pre>');
					$this->Session->setFlash('Configuration sauvegader');
				}

				$this->Cfg->load();
				$this->loadDataField();
				header("HTTP/1.0 301 Moved Permanently");
			}else{
				$this->Session->setFlash('Veuillez coriger les erreur', 'danger');
			}
		} else {
			$this->loadDataField();
		}
	}

	function sliders($id = null){
		$this->load->model('Config');
		$d['sliders'] = $this->db->select('*')->where('type', 'slider')->order_by('date_created', 'DESC')->get('site_statics')->result();

		if (!empty($_GET['setonline']) && is_null($_GET['setonline'])) {
			$id = $_GET['setonline'];
			$item = $this->db->select('online')->where('id', $id)->get('site_statics')->row();
			if(!empty($item)){
				$on = ($item->online == 0) ? 1 : 0;
				$this->db->where('id', $id)->update('site_statics', array('online' => $on));
				$msg = ($item->online == 0) ? 'Le slider a bien éte mis en ligne' : 'Le slider a bien éte mis hors ligne';
				$this->Session->setFlash($msg);	
			}else{
				$this->Session->setFlash('Erreur action non éxecuter');	
			}
			redirect('admin/configuration/sliders');
		}

		if (!empty($_GET['delete']) && is_numeric($_GET['delete'])) {
			$this->db->delete('site_statics', array('id' => $_GET['delete']));
			$this->Session->setFlash('Le slider a bien éte supprimé');
			redirect('admin/configuration/sliders');
		}

		if($this->request->data){
			$data = $this->request->data;
			if ($this->Form->validates($data, $this->Config->validateSlider)) {
				$Ok = true;

				$config['upload_path'] = './images/sliders/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size']	= '0';
				$config['max_width'] = '4000';
				$config['max_height'] = '4000';
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
			            $data['slider_path'] = $data_upl['upload_data']['file_name'];
			        } 
				}else{
					if(empty($this->request->data->slider_path)){
						$Ok = false;
						$this->Session->setFlash('Veuillez selectionner une image', 'danger');
					}
				}

				if($Ok){
					$req = array(
						'content' => $data->context, 
						'var' => $data->slider_path, 
						'type' => 'slider', 
						'online' => $data->online, 
						'date_created' => date('Y-m-d H:i:s'));
					if(!empty($id)){
						$this->db->where('id', $id)->update('site_statics', $req);
					}
					$this->db->insert('site_statics', $req);
					$id = $this->db->insert_id();
					$this->Session->setFlash('Banniere sauvegader avec succés.');
					redirect('admin/configuration/sliders');
				}
			}else{
				$this->Session->setFlash('Veuillez corriger les erreurs', 'danger');
			}
		}
		if ($id) {
			$this->request->data = $this->db->select('*')->where('id', $id)->where('type', 'slider')->get('site_statics')->row();
			$this->request->data->context = $this->input->post('content', true);
		}
		$d['id'] = $id;
		$this->set($d);
	}

	function mailer()
	{
		$this->load->model('Config');

		if(isset($this->request->data->send_mail_test)) {
			$data = $this->request->data;
			if(isset($data->mail_to) && !empty($data->mail_to)) {
				if(filter_var($data['mail_to'], FILTER_VALIDATE_EMAIL)) {
					$this->Mailer->send($data['mail_to'], 'Test Email '.$this->Cfg->read('website_name'), "Si vous recevez ce mail votre systeme de mail fonctionne corectement", $this->Cfg->read('website_name'), $this->Cfg->read('website_name'));
					$this->Session->setFlash("Mail envoyer à l'adresse: ".$data['mail_to'].'<br> Verfier votre boite mail svp');
				}else{
					$this->Session->setFlash("Adresse email n'est pas du bon format",'danger');
				}
			}else{
				$this->Session->setFlash("Veuillez entrez votre adresse mail", 'danger');
			}
		}

		if(!empty($this->reuest->data->smtp_host)) {
			$data = $this->request->data;
			if ($this->Form->validates($data, $this->Config->validateSmtp)) {
				$this->db->where('name', 'smtp_host')->update('configs', array('content' => $data->smtp_host));
				$this->db->where('name', 'smtp_secure')->update('configs', array('content' => $data->smtp_secure));
				$this->db->where('name', 'smtp_user')->update('configs', array('content' => $data->smtp_user));
				if (!empty($data['smtp_password'])) {
					$this->db->where('name', 'smtp_password')->update('configs', array('content' => $data->smtp_password));
				}
				$this->db->where('name', 'smtp_online')->update('configs', array('content' => $data['smtp_online']));
				$this->Session->setFlash('Configuration sauvegader');
				redirect('admin/configuration/smtp');
			}else{
				$this->Session->setFlash('Veuillez coriger les erreur', 'danger');
			}
		} else {
			$this->loadDataField();
			unset($this->request->data->smtp_password);
		}
	}

	function server()
	{
		$this->load->model('Config');

		if($this->request->data) {
			$data = $this->request->data;

			if ($this->Form->validates($data, $this->Config->validateServer)) {
				$Ok = true;

				$config['upload_path'] = './images/logos/';
				$config['allowed_types'] = 'jpg|png|jpeg|ico';
				$config['max_size']	= '0';
				$config['max_width'] = '1000';
				$config['max_height'] = '1000';
				$config['max_filename'] = 255;
				$config['encrypt_name'] = true;

				$this->load->library('upload', $config);
				if(!empty($this->upload->data())) {
					if (!$this->upload->do_upload('icone')) {
						$this->Session->setFlash('Erreur lors du transfert de votre image verfier qu\'il s\'agit bien d\'une image <br>' . $this->upload->display_errors(), 'danger');
						$Ok = false;
					} else { 
						$data_upl = $this->upload->data();
			            $data_upl = array('upload_data' => $this->upload->data()); 

						$this->db->where('name', 'website_icon')->update('configs', array('content' => $data_upl['upload_data']['file_name']));
			        } 
				}

				if($Ok){
					$this->db->where('name', 'website_name')->update('configs', array('content' => $data->website_name));
					$this->db->where('name', 'website_email')->update('configs', array('content' => $data->website_email));
					$this->db->where('name', 'website_report')->update('configs', array('content' => $data->website_report));
					$this->db->where('name', 'website_status')->update('configs', array('content' => $data->website_status));

					$this->Cfg->load();
					$this->Session->setFlash('Configuration sauvegader avec succés');
					redirect('admin/configuration/server');
				}
			}else{
				$this->Session->setFlash('Veuillez coriger les erreurs', 'danger');
			}
		}  else  {
			$this->loadDataField();
		}
	}

	function report()
	{
		if($this->request->data) {
			$data = $this->request->data; 
			if ($this->Form->validates($data, $this->Config->validateReport)) {
				$this->Mailer->sendRapport($data['sujet'].' par '.$this->Session->read('Admin')->username, 
		    	$data->content."<hr/><h2>SESSSION</h2><br/><pre>".json_encode($_SESSION).'</pre>');
		    	$this->Session->setFlash('Votre signalement a éte envoyer, Merci.');
		    	redirect('admin/configuration');
			}else{
				$this->Session->setFlash('Veuillez coriger les erreur', 'danger');
			}
		}
	}

}