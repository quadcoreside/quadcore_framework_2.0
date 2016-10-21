<?php
class Ad_Model extends Model
{
	var $validateAd = array(
		'name' => array(
				array('rule' => 'notEmpty','message' => 'Vous devez préciser un nom')
				),
		'type' => array(
				array('rule' => 'notEmpty','message' => 'Veuillez remplir le type'),
				),
		'content' => array(
				array('rule' => 'notEmpty','message' => 'Veuillez entrez du conteunu')
				),
	);

	function getAd($type){
	    $condition = array('online' => 1, 'type' => $type );

		$ad = $this->db->select('*')->where('online', 1)->where('type', $type)->order_by('current_count', 'DESC')->get('ads')->row();
		if (!empty($ad)) {
			$this->db->query('UPDATE ads SET current_count=current_count+1 WHERE id='. $ad->id);
		}

		return $ad;
	}

}
