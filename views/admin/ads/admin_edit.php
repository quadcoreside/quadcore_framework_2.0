<div class="container">

	<h1 class="page-header">Editer une annonce</h1>
	
	<form action="<?php echo Router::url('admin/ads/edit/'.$id); ?>" method="post" autocomplete="off">
	
		<?php echo $this->Form->input('id', 'hidden'); ?>
		<?php echo $this->Form->input('name', 'Nom', array('required' => '')); ?>
		<?php echo $this->Form->options('type', 'Taille de l\'annonce', array('required' => ''), $type) ?>
		<?php echo $this->Form->input('online', 'En ligne', array('type' => 'checkbox', 'required' => '')); ?>
		<?php echo $this->Form->input('content', 'Conteunu', array('type' => 'textarea', 'rows' => 10, 'required' => '')); ?>
			
		<button type="submit" value="Valider" class="btn btn-primary"> Valider</button>

	</form>

</div>