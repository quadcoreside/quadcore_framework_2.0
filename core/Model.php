<?php
class Model
{
	public $table = null;
	public $primaryKey = 'id';

	function __construct()
	{
		if($this->table === null){
            $this->table = strtolower(get_class($this)).'s';
        }
        $this->db = &DB($params = '');

        log_message('info', 'Model Class Initialized');
	}
}
