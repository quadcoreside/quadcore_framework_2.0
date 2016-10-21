<?php
class Dashboard extends Controller
{
	public $perPage = 50;

    function index(){
	    $admin_id = $this->Session->read('Admin')->id;

		$gdpData = '';
		$countryCount = $this->db->query('SELECT `country_code`, Count(1) AS DistCount FROM `url_injectables` GROUP BY `country_code`', true)->result();
		
		foreach ($countryCount as $k => $v){
	      $gdpData .= '"'.$v->country_code.'": '.$v->DistCount.',';
	    }
	    $d['gdpData'] = $gdpData;

	    $d['inboxs'] = $this->db->where('viewed', 0)->count_all_results('inboxs');
	    $d['urls'] = $this->db->count_all_results('urls');
	    $d['url_injectables'] = $this->db->count_all_results('url_injectables');
	    $d['proxy_lives'] = $this->db->where('live', 1)->count_all_results('proxy');

	    $d['title_for_layout'] = 'Tableuax de bord';

	    $this->load->view('admin/dashboard', $d);
    }

}
