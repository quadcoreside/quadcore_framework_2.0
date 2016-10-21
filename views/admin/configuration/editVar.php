<div class="container">

    <h1 class="header">Edit: "<?php echo ($model == 'site_statics') ? $this->request->data->type : $this->request->data->name ?>"</h1>

    <form action="" method="post" >
        <?php echo $this->Form->input('id', 'hidden'); ?>
        <?php echo $this->Form->input('content', 'Conteunu', array('type' => 'textarea', 'rows' => 5, 'class' => 'NoWysiwyg')); ?>
        <?php if ($model == 'site_statics'): ?>
        	<?php echo $this->Form->input('var', 'Var', array('type' => 'textarea', 'rows' => 3)); ?>
        	<?php echo $this->Form->input('date_created', 'Date', array()); ?>
        <?php endif ?>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
    
</div>
