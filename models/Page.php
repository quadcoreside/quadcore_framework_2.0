<?php
class Page_Model extends Model {
	
	function getPages($conditions = array()) {
		$conditions += array('online' => 1);
		$this->db->select('id,name,slug');
		foreach ($conditions as $k => $v) {
			$this->db->where($k, $v);
		}
		return $this->db->get('pages')->result();
	}

	var $validatePage = array(
		'name' => array(
				array('rule' => 'notEmpty','message' => 'Vous devez préciser un titre')
				),
		'slug' => array(
				array('rule' => '([a-z0-9\-]+)','message' => "L'url n'est pas valide"),
				array('rule' => 'notDuplicate', 'model' => 'Pages', 'message' => "Cette url est dêja utilisé"),
				array('rule' => 'notEmpty','message' => 'Veuillez remplir l\'url'),
				),
		'online' => array(
				array('rule' => 'notEmpty','message' => ''),
				),
		'content' => array(
				array('rule' => 'notEmpty','message' => 'Veuillez entrez du conteunu')
				),
	);
	var $validatePostMin = array(
		'name' => array(
				array('rule' => 'notEmpty','message' => 'Vous devez préciser un titre')
				),
		'online' => array(
				array('rule' => 'notEmpty','message' => ''),
				),
		'content' => array(
				array('rule' => 'notEmpty','message' => 'Veuillez entrez du conteunu')
				),
	);
	var $validateQuestion = array(
		'name' => array(
				array('rule' => 'notEmpty','message' => 'Vous devez préciser un titre')
				),
		'online' => array(
				array('rule' => 'notEmpty','message' => ''),
				),
		'content' => array(
				array('rule' => 'notEmpty','message' => 'Veuillez entrez du conteunu')
				),
	);
}
