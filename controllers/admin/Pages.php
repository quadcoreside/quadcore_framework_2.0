<?php
class Pages extends Controller {
	function index(){
		$perPage = 20;

		$this->db->select('id,name,views,slug,online,date_created')->where('online >=', 0);
		if (isset($_GET['q']) && !empty($_GET['q'])) {
    		$q = $_GET['q'];
			$this->db->like('name', $q)
					->like('content', $q)
					->like('slug', $q)
					->like('date_created', $q);

		}
		
		$d['pages'] = $this->db->order_by('date_created', 'DESC')->limit($perPage, $perPage * ($this->request->page - 1))->get('pages')->result();

		$d['total'] = $this->db->where('online >=', 0)->count_all_results('pages');
		$this->pagination->setCurrent($this->request->page);
		$this->pagination->setTotal($d['total']);
		$this->pagination->setRPP($perPage);
		$d['pagination'] = $this->pagination->parse();

	    $this->set($d);
	}

	function edit($id = null) {
		if (is_null($id)) {
			$page = $this->db->select('*')->where('online', (0 - $this->Session->read('Admin')->id))->get('pages')->row();
			if(!empty($page)){
				$id = $page->id;
			} else {
				$this->db->insert('pages', array('online' => (0 - $this->Session->read('Admin')->id)));
				$id = $this->db->insert_id();
			}
		}

		$d['id'] = $id;
		if($data = $this->request->data){
			if($this->Form->validates($this->request->data, $this->Page_Model->validatePage)){

				if (empty($this->request->data->date_created)) {
					$this->request->data->date_created = date('Y-m-d H:i:s');
				}

				if (is_numeric($data->id)) {
					$this->db->where('id', $data->id)->update('pages', $data);
				} else {
					$this->db->insert('pages', $data);
					$id = $this->db->insert_id();
				}

				$this->Session->setFlash('La page a bien éte éditer');
				redirect('admin/pages');
			} else {
				$this->Session->setFlash('Merci de corriger vos informations', 'danger');
			}
		} else {
			if($id) {
				$this->request->data = $this->db->select('*')->where('id', $id)->get('pages')->row();
				$d['id'] = $id;
			}
		}

		$this->set($d);
	}

	function delete($id){
		$this->db->delete('pages', array('id' => $id));
		$this->Session->setFlash('La page a bien éte supprimé');
		redirect('admin/pages');
	}

	function set_online($id){
		$item = $this->db->select('online')->where('id', $id)->get('pages')->row();
		if(!empty($item)){
			$on = ($item->online == 0) ? 1 : 0;
			$this->db->where('id', $id)->update('pages', array('online' => $on));
			$msg = ($item->online == 0) ? 'La Page a bien éte mis en ligne' : 'La Page a bien éte mis hors ligne';
			$this->Session->setFlash($msg);	
		}else{
			$this->Session->setFlash('Erreur action non éxecuter');	
		}
		redirect('admin/pages');
	}

}
