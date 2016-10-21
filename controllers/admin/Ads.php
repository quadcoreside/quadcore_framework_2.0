<?php
class Ads extends Controller {
	public $perPage = 30;
	public $typeSize  = array(
		//array('id' => 'adaptable', 'name' => 'Adaptable Taille automatique'), 
		array('id' => 'leaderboard', 'name' => 'Leaderboard 728 x 90'),
		array('id' => 'skyscraper', 'name' => 'Skyscraper 120 x 600'),
		array('id' => 'skyscraper_large', 'name' => 'Skyscraper large 300 x 600'),
		/*array('id' => 'grand_rectangle', 'name' => 'Grand rectangle 336 x 280'),
		array('id' => 'grand_banner_mobile', 'name' => 'Grande bannière pour mobile 320 x 100'),
		array('id' => 'moyen_rectangle', 'name' => 'Rectangle moyen 300 x 250'),*/
	);

	/*
	* ADMIN
	*/

	function index() {
		$d = array();
		$perPage = 50;

		$this->db->select('*')->order_by('date_created', 'DESC');
		if (!empty($this->input->get('q'))) {
			$q = $_GET['q'];
			$this->db->like('name', $q)
					->like('type', $q)
					->like('content', $q);
		}

		$d['ads'] = $this->db->limit($perPage, $perPage * ($this->request->page - 1))->get('ads')->result();

	   
		$d['total'] = $this->db->count_all_results('ads');
		$this->pagination->setCurrent($this->request->page);
		$this->pagination->setTotal($d['total']);
		$this->pagination->setRPP($perPage);
		$d['pagination'] = $this->pagination->parse();

	    $this->set($d);
	}

	function edit($id = null){
		$this->load->model('Ad');
		$d = array();

		if($this->request->data) {
			if($this->Form->validates($this->request->data, $this->Ad_Model->validateAd)){
				$data = $this->request->data;
				$data['date_created'] = date('Y-m-d H:i:s');
				if (!empty($data['id'])) {
					$this->db->where('id', $data['id'])->update('ads', $data);
				} else {
					$this->db->insert('ads', $data);
				}
				$this->Session->setFlash("L'annonce a bien éte éditer");
				$id = $this->db->insert_id();
				redirect('admin/ads/index');
			}else{
				$this->Session->setFlash('Merci de corriger vos informations', 'danger');
			}
		}else{
			if($id){
				$this->request->data = $this->db->select('*')->where('id', $id)->get('ads')->row();
				$d['id'] = $id;
			}
		}

		$d['type'] = $this->typeSize;
		$d['id'] = $id;
		$this->set($d);
	}

	function delete($id = null){
		$this->db->delete('ads', array('id' => $id));
		$this->Session->setFlash('L\'annonce a bien éte supprimé');
		redirect('admin/ads');
	}

	function setonline($id){
		$item = $this->db->select('online')->where('id', $id)->get('ads')->row();
		if(!empty($item)){
			$on = ($item->online == 0) ? 1 : 0;
			$this->db->where('id', $id)->update('ads', array('online' => $on));
			$msg = ($item->online == 0) ? 'L\'annonce a bien éte mis en ligne' : 'L\'annonce a bien éte mis hors ligne';
			$this->Session->setFlash($msg);	
		}else{
			$this->Session->setFlash('Erreur action non éxecuter');	
		}
		redirect('admin/ads');
	}

}