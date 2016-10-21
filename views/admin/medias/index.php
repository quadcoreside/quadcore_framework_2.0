<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE10">
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />

<div style="padding-left:15px;">
	
	<h2 class="header"><?php echo $total . ' Images' ?></h2>
	<table class="table">
		<thead>
			<tr>
				<th></th>
				<th>Titre</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($images as $k => $v): ?>
				<tr>
					<td>
	       				<div class="image" data-src="<?php echo Router::url('images/medias/'.$v->file) ?>">
							<img src="<?php echo Router::url('images/medias/'.$v->file) ?>" height="65" widht="60">
						</div>
					</td>
					<td><div class="image" data-src="<?php echo Router::url('images/medias/'.$v->file) ?>"><?php echo $v->name ?></div></td>
					<td>
						<a onclick="return confirm('Voulez vous vraiment supprimer cette image')" href="<?php echo Router::url('admin/medias/delete/'.$v->id) ?>">Supprimer</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<?php echo $pagination ?>

	<div class="page-header">
		<h1>Ajouter une image</h1>
	</div>

	<form action="<?php echo Router::url('admin/medias/index/' . $item_id . '/' . $item_type) ?>" method="post" enctype="multipart/form-data">
		<?php echo $this->Form->input('file', 'Image', array('type' => 'file')) ?>
		<?php echo $this->Form->input('name', 'Titre') ?>
		<div class="actions">
			<input class="btn btn-primary" type="submit" value="Envoyer">
		</div>
	</form>

</div>

<script type="text/javascript">
	$(document).on("click","div.image",function(event){
		var args = top.tinymce.activeEditor.windowManager.getParams();
		win = (args.window);
		input = (args.input);
		top.tinymce.activeEditor.windowManager.getParams().oninsert($(this).data('src'));
		top.tinymce.activeEditor.windowManager.close();
	});
</script>