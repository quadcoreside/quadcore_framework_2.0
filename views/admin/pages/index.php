<div class="container-fluid">

<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h1>
				<?php echo $total ?> Pages
			</h1>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-2">
		<div class="form-group">
			<a class="btn btn-primary btn-block" href="<?php echo Router::url('admin/pages/edit') ?>">Ajouter</a>
		</div>
		<ul class="list-group">
			<li class="list-group-item active disabled"><a>Pages</a></li>
			<li class="list-group-item"><a href="<?php echo Router::url('admin/questions') ?>">Question</a></li>
			<li class="list-group-item"><a href="<?php echo Router::url('admin/post_mins') ?>">Post mini</a></li>
		</ul>
	</div>
	<div class="col-md-8">

		<table class="table table-striped table-hover responsive">
			<thead>
				<tr>
					<th>En ligne ?</th>
					<th>Url</th>
					<th>Titre</th>
	                <th>Courant</th>
	                <th>Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($pages as $k => $v): ?>
					<tr>
						<td><span class="label <?php echo ($v->online == 1) ? 'label-success' : 'label-danger'; ?>"><?php echo ($v->online == 1) ? 'En ligne' : 'Hors ligne'; ?></span></td>
						<td><?php echo $v->slug ?></td>
						<td><?php echo $v->name ?></td>
						<td><?php echo $v->views ?></td>
						<td><?php echo $v->date_created ?></td>
						<td>
	                        <div class="btn-group">
	                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
	                            <ul class="dropdown-menu">
	                                <li><a href="<?php echo Router::url("admin/pages/edit/{$v->id}") ?>">Editer</a></li>
	                                <?php if ($v->online ==1): ?>
	                                	<li><a <?php echo ($v->online ==0) ? 'disabled=""' : '' ?> href="<?php echo Router::url("pages/view/id:{$v->id}/slug:$v->slug") ?>" target="_blanc">Voir</a></li>
	                                <?php endif ?>
	                                <li role="separator" class="divider"></li>
	                                <li><a href="<?php echo Router::url("admin/pages/setonline/{$v->id}") ?>"><?php echo ($v->online ==1) ? 'Désactiver' : 'Activer'; ?></a></li>
	                                <li><a onclick="return confirm('Voulez vous vraiment supprimer cette page')" href="<?php echo Router::url('admin/pages/delete/'.$v->id) ?>">Supprimer</a></li>
	                            </ul>
	                        </div>
	                    </td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		<?php echo $pagination ?>
	</div>
</div>

</div>