 <?php
class Medias extends Controller{
	public $perPage = 10;

	function index($id = null, $type = null){
		$this->layout = 'admin/layout/modal';
		$perPage = 50;
		if (!is_numeric($id)) {
			$id = (-1 - strlen($id));
		}

		$config['upload_path'] = './images/medias/';
		$config['allowed_types'] = 'jpg|png|jpeg|ico';
		$config['max_size']	= '0';
		$config['max_width'] = '3000';
		$config['max_height'] = '3000';
		$config['max_filename'] = 255;
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);

		if($this->request->data && !empty($this->upload->data())){
			$data = $this->request->data;
			if (strpos($_FILES['file']['type'], 'image') !== false) {

				if (!$this->upload->do_upload('file')) {
					$this->Session->setFlash('Erreur lors du transfert de votre image verfier qu\'il s\'agit bien d\'une image <br>' . $this->upload->display_errors(), 'danger');
					$Ok = false;
				} else { 
					$data_upl = $this->upload->data();
		            $data_upl = array('upload_data' => $this->upload->data()); 
		            $data->file = $data_upl['upload_data']['file_name'];
		        } 
				
				$this->db->insert('medias', array(
					'name' => $data->name,
					'file' => $data->file,
					'item_id' => $id,
					'type' => $type, 
					'date_created' => date('Y-m-d H:i:s'),
				)); 
				$this->Session->setFlash("L'image a bien éte transférer");
			}else{
				$this->Form->errors['file'] = "Le fichier n'est pas une image";
			}
		}

		$conditions = array('item_id' => $id, 'type' => $type);

		$d['images'] = $this->db->select('*')->where('item_id', $id)->where('type', $type)->get('medias')->result();
		$d['item_id'] = $id;
		$d['item_type'] = $type;

	    $config['total_rows'] = $d['total'] = $this->db->where('item_id', $id)->where('type', $type)->count_all_results('medias');
		$config['per_page'] = $perPage;
	    $this->pagination->initialize($config); 
	    $d['pagination'] = $this->pagination->create_links();

	    $this->set($d);
	}

	function delete($id = null){
		$media = $this->db->select('*')->where('id', $id)->get('medias')->row();
		if (file_exists('./images/medias/' . $media->file)) {
			unlink('./images/medias/' . $media->file);
		}
		$this->db->delete('medias', array('id' => $media->id));
		$this->Session->setFlash("Le média a bien éte supprimé");
		redirect('admin/medias/index/'.$media->item_id.'/'.$media->item_type);
	}
}