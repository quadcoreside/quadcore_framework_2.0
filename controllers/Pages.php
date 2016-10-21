<?php
class Pages extends Controller {
	public $perPage = 10;

	function view($slug = null){

		$d['page'] = $this->db->select('*')
								->where('online', 1)
								->where('slug', $slug)
								->get('pages')
								->row();
		
		if(empty($d['page'])){
			$this->e404('Page introuvable');
		}
    	$this->db->query('UPDATE pages SET views=views+1 WHERE id='.$d['page']->id);

    	$this->set($d);
	}

}
