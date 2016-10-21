<div class="container">
<h1>Mon compte</h1>
<hr/>

	<div class="row">
		<form action="<?php echo Router::url('admin/account') ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
		    <div class="col-md-6 col-sm-6">
		        <?php echo $this->Form->input('username', 'Nom d\'utilisateur', array(), $admin->username); ?>
		        <?php echo $this->Form->input('email', 'Email', array('disabled' => ''), $admin->email); ?>
		    </div>
		    <div class="col-md-6 col-sm-6">
		        <?php echo $this->Form->input('password_old', 'Mot de passe actuel', array('type' => 'password')); ?>
		        <?php echo $this->Form->input('password', 'Nouveaux mot de Passe', array('type' => 'password')); ?>
		        <?php echo $this->Form->input('password_confirm', 'Confirmer votre nouveaux Mot de passe', array('type' => 'password')); ?>
		    </div>
		    <div class="col-md-3">
				<div class="form-group">
		            <input type="submit" class="btn btn-success" value="Valider">
		        </div>
			</div>
		</form>
	</div>

</div>