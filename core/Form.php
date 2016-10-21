<?php
class Form
{
	protected $Controller;
	public $errors;

	public function __construct(){
		$this->Controller =& get_instance();
	}

	public function input($name, $label, $options = array(), $value = ''){
		$error = false;
		$classError = '';
		if(isset($this->errors[$name])){
			$error = $this->errors[$name];
			$classError = 'has-error';
		}else{
			$classError = '';
		}

		if(isset($this->Controller->request->data->$name)){
			$value = $this->Controller->request->data->$name;
		}

		if($label == 'hidden'){
			return '<input type="hidden" name="'.$name.'" value="'.$value.'">';
		}


		$html = '<div class="form-group '.$classError.'">
					<label class="control-label" for="input'.$label.'">'.$label.':</label>';

		$class = (isset($options['class'])) ? 'form-control '.$options['class'] : 'form-control';
		$attr = ' ';
		foreach ($options as $k => $v){
			if (!in_array($k, array('type', 'class', 'name_file', 'icon'))) {
				$attr .= " $k=\"$v\"";
			}
		}

		if (isset($options['icon'])) {
			$html .= '<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-'.$options['icon'].'"></i></span>';
		}

		$options['type'] = isset($options['type']) ? $options['type'] : null;
		switch ($options['type']) {
			case 'email':
				$html .= '<input class="'.$class .'" type="email" id="input'.$label.'" name="'.$name.'" value="'.$this->Controller->antixss($value).'" '.$attr.'>';
				break;

			case 'password':
				$html .= '<input class="input-file '.$class .'" type="password" id="input'.$label.'" name="'.$name.'" value="'.$this->Controller->antixss($value).'" '.$attr.'>';
				break;

			case 'textarea':
				$value = (isset($options['un_wrap']) && $options['un_wrap'] == true) ? nl2br($value) : $value;
				$html .= '<textarea class="'.$class .'" id="input'.$label.'" onfocus="" name="'.$name.'" '.$attr.'>'.htmlspecialchars($value).'</textarea>';
				break;

			case 'checkbox':
				$html .= '<input class="'.$class .'" type="hidden" name="'.$name.'" id="input'.$name.'" value="0">
					<input type="checkbox" name="' . $name . '"  value="1" '. (empty($value) ? '' : 'checked=""' ) .' '.$attr.'>';
				break;

			case 'file':		
				$html = '<div class="input-group">
		                <span class="input-group-btn">
		                    <span class="btn btn-primary btn-file">
		                        Parcourir… <input name="'.$name.'" type="file" '.$attr.'>
		                    </span>
		                </span>
		                <input type="text" class="form-control" value="'.(isset($options['name_file']) ? $options['name_file'] : '').'" readonly="">
	            	</div>';
				break;
			
			default:
				$html .= '<input class="'.$class .'" type="text" id="input'.$label.'" name="'.$name.'" value="'.$this->Controller->antixss($value).'" '.$attr.'>';
				break;
		}

		if (isset($options['icon'])) {
			$html .= '</div>';
		}

		if($error){
			$html.= '<ul class="parsley-errors-list filled"><li class="parsley-required">'.$error.'</li></ul>';
		}

		if (!in_array($options['type'], array('file'))) {
			$html .= '</div>';
		}

		return $html;
	}

	public function options($name, $label, $options = array(), $items = array(), $value = ''){
		$error = false;
		$classError = '';
		if(isset($this->errors[$name])){
			$error = $this->errors[$name];
			$classError = 'has-error';
		}

		$html = '<div class="form-group '.$classError.'">
					<label>'.$label.': </label>';
		
		if(isset($options['deleter'])){
			$attr = ' ';
			foreach ($options['deleter'] as $k => $v){
				$attr .= " $k=\"$v\"";
			}
			$html .= '<a class="pull-right"'.$attr.'><span class="glyphicon glyphicon-remove-circle"></span></a>';
		}

		if(isset($options['adder'])){
			$attr = ' ';
			foreach ($options['adder'] as $k => $v){
				if (!in_array($k , array('placeholder'))) {
					$attr .= " $k=\"$v\"";
				}
			}
			$html .= '<div class="form-group input-group" height="20">';
			$html .= '	<input class="form-control" id="input'.$name.'" type="text" placeholder="'.$options['adder']['placeholder'].'">
						<span class="input-group-btn">
							<button class="btn btn-primary" type="button" '.$attr.'><i class="glyphicon glyphicon-plus"></i>
		          		</span>
		          	</div>';
		}

		$html .= '<div class="form-group">';
        $html .= '<select class="form-control" id="input'.$name.'" name="'.$name.'">';
                foreach ($items as $k => $v) {

                	$selected = '';
                	if (isset($this->Controller->request->data->$name)) {
	                	if (isset($v->id) && $v->id == $this->request->data->$name || isset($v['id']) && $v['id'] == $this->Controller->request->data->$name) {
	                		$selected = 'selected ';
	                	}
                	}

                	$value_o = '';
                	if (isset($v->id)) {
                		$value_o = $v->id;
                	}else if (isset($v['id'])) {
                		$value_o = $v['id'];
                	}else{
                		debug('No option found');
                		debug($items);
                	}

					$name_o = '';
					if (isset($v->name)) {
                		$name_o = $v->name;
                	}else if (isset($v['name'])) {
                		$name_o = $v['name'];
                	}else{
                		debug('No option found');
                		debug($items);
                	}

                	$html .= '<option '.$selected.'value="'.$value_o.'"" >'.$name_o.'</option>';
                }
        $html .= '</select></div>';

        if($error){
			$html.= '<span class="help-block danger">'.$error.'</span>';
		}

        $html .= '</div>';
        return $html;
	}

	function validates($data, $validateCert){
		$errors = array();
		foreach ($validateCert as $k => $v) {
			if(!isset($data->$k)){
				$errors[$k] = $v[0]['message'];
			}else{
				foreach ($v as $key => $value) {
					switch ($value['rule']) {
						case 'notEmpty':
							if(empty($data->$k)){
								$errors[$k] = $value['message'];
							}
							break;

						case 'notNull':
							if($data->$k == null){
								$errors[$k] = $value['message'];
							}
							break;
							
						case 'comparer':
							$nv = $value['comparant'];
							if($data->$k != $data->$nv){
								$errors[$k] = $value['message'];
								$errors[$value['comparant']] = '';
							}
							break;

						case 'limit-length':
							if (isset($value['min'])) {
								$nv = $value['min'];
								if(strlen($data->$k) < $nv){
									$errors[$k] = $value['message'];
								}
							} if (isset($value['max'])) {
								$nv = $value['max'];
								if(strlen($data->$k) > $nv){
									$errors[$k] = $value['message'];
								}
							}
							break;

						case 'email':
							if (!filter_var($data->$k, FILTER_VALIDATE_EMAIL)) {
								$errors[$k] = $value['message'];
							}
							break;

						case 'notDuplicate':
							$tableName = $value['model'];
							$conditions = array($k => $data->$k);
							$blackListWord = array('message', 'model', 'rule');
							foreach ($value as $ke => $val) {
								if(!in_array($ke, $blackListWord)){
									$conditions += array($ke => $val);
								}
							}
							$this->Controller->db->select('*');
							foreach ($conditions as $n => $v) {
								 $this->Controller->db->where($n, $v);
							}
							$row = $this->Controller->db->get($tableName)->row();
							if(!empty($row)) {
								if (isset($data->id)) {
									if($row->id != $data->id){
										$errors[$k] = $value['message'];
									}
								}else{
									$errors[$k] = $value['message'];
								}
							}
							break;

						default:
							if(!preg_match('/^'.$value['rule'].'$/', $data->$k)){
								$errors[$k] = $value['message'];
							}
							break;
					}
				}
			}
		}
		$this->errors = $errors;
		if(isset($this->Form)){
			$this->Form->errors = $errors;
		}
		if(empty($errors)){
			return true;
		}
		return false;
	}

}
