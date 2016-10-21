<div class="container">
<?php $searchEnabled = true; ?>

	<div class="page-header">
		<h1>
			<?php echo $total ?> Annonces
			<a class="btn btn-primary" href="<?php echo Router::url('admin/ads/edit') ?>" style="float:right;">Ajouter</a>
		</h1>
	</div>

	<table class="table table-striped table-hover responsive">
		<thead>
			<tr>
				<th>En ligne ?</th>
				<th>Type</th>
				<th>Nom</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($ads as $k => $v): ?>
				<tr>
					<td><span class="label label-<?php echo ($v->online == 1) ? 'success' : 'danger'; ?>"><?php echo ($v->online ==1) ? 'En ligne' : 'Hors ligne'; ?></span></td>
					<td><?php echo $v->type ?></td>
					<td><?php echo $v->name ?></td>
					<td>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Action<span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo Router::url('admin/ads/edit/'.$v->id) ?>">Editer</a></li>
                                <li><a href="<?php echo Router::url("admin/ads/setonline/{$v->id}") ?>"><?php echo ($v->online ==1) ? 'Désactiver' : 'Activer'; ?></a></li>
                                <li role="separator" class="divider"></li>
                                <li><a onclick="return confirm('Voulez vous vraiment supprimer cette page')" href="<?php echo Router::url('admin/ads/delete/'.$v->id) ?>">Supprimer</a></li>
                            </ul>
                        </div>
                    </td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<?php echo $pagination ?>

</div>