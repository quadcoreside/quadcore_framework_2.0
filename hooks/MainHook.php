<?php

class MainHook extends Hook
{
	
	public function run() {

		if ($this->Controller->request->prefix == 'admin') {
			if($this->Controller->Session->isLoggedAdm()){
				$this->Controller->layout = 'admin/layout/default';
			} else {

				$this->Controller->layout = null;	
				$req = $this->Controller->request;
				if($req->controller != 'Users' || $req->action != 'login'){
					$this->Controller->redirect('admin/users/login');
				}

			}
		}
		else
		{
			
			if($this->Controller->Cfg->read('website_status') == 0){
				$this->Controller->layout = null;
				$this->Controller->siteLocked();
			}
			
			$this->Controller->Visitor_Model->visitorLogs();
		}

	}

}