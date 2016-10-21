<div class="container">

  <div class="page-header">
        <h2>
          <?php echo $total ?> utilisateurs admin
          <a class="btn btn-primary" href="<?php echo Router::url('admin/account/edit') ?>" style="float:right;">Ajouter</a>
        </h2>
  </div>
  <?php $adm_level = array(1 => 'Super Admin', 2 => 'Admin Normal') ?>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Email</th>
        <th>Droit</th>
        <th>Derniere</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($admins as $k => $v): ?>
        <tr>
          <td><?php echo $v->email ?></td>
          <td><?php echo isset($adm_level[$v->law]) ? $adm_level[$v->law] : $v->law ?></td>
          <td><?php echo $v->date_last ?></td>
          <td>
              <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Action<span class="caret"></span></button>
                  <ul class="dropdown-menu">
                      <li><a href="<?php echo Router::url("admin/account/edit/{$v->id}") ?>">Editer</a></li>
                      <li><a onclick="return confirm('Voulez vous vraiment supprimer cette utilisateur')" href="<?php echo Router::url('admin/users/deleteadm/'.$v->id) ?>">Supprimer</a></li>
                  </ul>
              </div>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

  <?php echo $pagination ?>

</div>
