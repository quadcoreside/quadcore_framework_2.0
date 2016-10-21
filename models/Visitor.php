<?php
class Visitor_Model extends Model {

	function visitorLogs() {
	    $visitor = $this->db->select('*')->where('ip', $_SERVER['REMOTE_ADDR'])->get('visitors')->row();

	    if (!empty($visitor)) {
	    	$this->db->where('id', $visitor->id)->update('visitors', array(
	    		'time' => time(),
	    		'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'N/A',
		    ));
	    }else{
	    	require HELPER . DS . 'geoip.php';
	    	$gi = geoip_open(HELPER . DS . 'GeoIP.dat', GEOIP_STANDARD);
       		$country = geoip_country_name_by_addr($gi, $_SERVER['REMOTE_ADDR']);
       		$country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
       		geoip_close($gi);

	    	$this->db->insert('visitors', array(
		    	'ip' => $_SERVER['REMOTE_ADDR'],
	    		'time' => time(),
	    		'country' => $country,
	    		'country_code' => $country_code,
	    		'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'N/A',
	    		'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'N/A',
	    		'date_created' => date('Y-m-d H:i:s')
		    ));
	    }

	}

}
