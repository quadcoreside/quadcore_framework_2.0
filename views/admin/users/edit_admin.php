<div class="container">
<h1>Editer Admin</h1>
<hr/>
	<div class="row">
		<form action="<?php echo Router::url('admin/account/edit/'.$id) ?>" method="post" autocomplete="off">
		    <div class="col-md-6 col-sm-6">
		    	<?php echo $this->Form->input('id', 'hidden'); ?>
		        <?php echo $this->Form->input('username', "Nom d'utilisateur"); ?>
		        <?php echo $this->Form->input('email', 'Email'); ?>
		        <div class="form-group">
                    <label>Niveau droit:</label>
                    <select name="law" class="form-control">
	                    <?php if (isset($this->request->data->law)): ?>
	                        <option value="<?php echo $this->request->data->law ?>"><?php echo (isset($admin_level[$this->request->data->law])) ? $admin_level[$this->request->data->law] : $this->request->data->law ?></option>
	                    <?php endif ?>
                        <option value="2">Admin Normal</option>
                        <option value="1">Super Admin</option>
                    </select>
                </div>
		    </div>
		    <div class="col-md-6 col-sm-6">
		        <a onclick="genRandPass()" style="float:right;" ><b>Generer</b></a>
		        <?php echo $this->Form->input('password', 'Mot de passe', array('type' => 'password')); ?>
		        <span class="help-block" id="output_gen"></span>
		        <?php echo $this->Form->input('password_confirm', 'Mot de passe confirmation', array('type' => 'password')); ?>
		    </div>
		    <div class="col-md-12">
				<div class="form-group">
		            <input type="submit" class="btn btn-success" value="Valider">
		        </div>
			</div>
		</form>
	</div>

</div>

<script type="text/javascript">
	function genRandPass(){
		$("#output_gen").html('Generer: <b>' + Math.random().toString(36).substring(7) + '</b>');
	}
</script>