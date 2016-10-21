<?php
class Home extends Controller {

    function index() {
		$d = array();
		$d['sliders'] = $this->db->select('*')
								->where('type', 'slider')
								->where('online', 1)
								->get('site_statics')
								->result();

		$gdpData = '';
		$countryCount = $this->db->query('SELECT `country_code`, Count(1) AS DistCount FROM `url_injectables` GROUP BY `country_code`', true)->result();
		
		foreach ($countryCount as $k => $v){
			if (!empty($v->country_code))
	      	$gdpData .= '"'.$v->country_code.'": '. (($v->DistCount / 100) * count($countryCount)) .',';
	    }

	    $d['url_injectables'] = $this->db->count_all_results('url_injectables');
	    $d['gdpData'] = $gdpData;
	    
	   	if (!$this->Session->read('csrf')) {
	   		$this->Session->write('csrf', random_string('alnum', 17));
	   	}

      	$this->load->view('home', $d);
    }

    function faq() {
		$d = array();
		$d['questions'] = $this->db->select('*')
								->where('online', 1)
								->get('questions')
								->result();


      	$this->load->view('faq', $d);
    }

}
