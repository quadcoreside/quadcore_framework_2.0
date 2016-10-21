<?php
class Visitors extends Controller {

	function index() {
		$d = array();
		$perPage = 50;

		$this->db->select('*')->order_by('date_created', 'DESC');
		if (isset($_GET['q']) && !empty($_GET['q'])) {
			$q = $_GET['q'];
			$this->db->like('ip', $q)
					->like('referer', $q)
					->like('user_agent', $q)
					->like('date_created', $q);
		}

		$d['visitors'] = $this->db->get('visitors')->result();

	   	$d['total'] = $this->db->count_all_results('visitors');
		$this->pagination->setCurrent($this->request->page);
		$this->pagination->setTotal($d['total']);
		$this->pagination->setRPP($perPage);
		$d['pagination'] = $this->pagination->parse();

	    $this->set($d);
	}

	function delete($id){
		if ($id == null) { $this->e404(); }
		$this->db->delete('visitors', array('id' => $id));
		$this->Session->setFlash('Visiteur supprimé avec succés');
		redirect('admin/visitors');
	}

	function clears(){
		$this->db->empty_table('visitors');
		$this->db->query("OPTIMIZE TABLE visitors");
		$this->Session->setFlash('Visiteurs vider avec succés');
		redirect('admin/visitors');
	}

}