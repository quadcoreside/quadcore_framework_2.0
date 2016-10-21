<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo Router::url('images/profiles/'.$this->Session->read('Admin')->picture) ?>" class="img-circle"/>
      </div>
      <div class="pull-left info">
        <p><?php echo $this->Session->read('Admin')->username ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Rechercher..." />
        <span class="input-group-btn">
          <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="treeview">
        <a href="<?php echo Router::url("admin/dashboard") ?>">
          <i class="fa fa-dashboard"></i><span>Tableau de bord</span>
        </a>
      </li>
      <li>
        <a href="<?php echo Router::url("admin/pages") ?>">
          <i class="fa fa-file-text"></i><span>Pages</span>
        </a>
      </li>
      <li class="treeview">
        <a href="<?php echo Router::url("admin/configuration") ?>">
          <i class="fa fa-wrench"></i><span>Configuration</span><span class="fa arrow"></span>
          <ul class="treeview-menu">
              <li>
                  <a href="<?php echo Router::url('admin/configuration/sliders'); ?>">Sliders</a>
              </li>
              <li>
                  <a href="<?php echo Router::url('admin/configuration/footer'); ?>">Footer</a>
              </li>
              <li>
                  <a href="<?php echo Router::url('admin/configuration/seo'); ?>">Réferencement</a>
              </li>
              <li>
                  <a href="<?php echo Router::url('admin/configuration/purchases'); ?>">Achats</a>
              </li>
              <li>
                  <a href="<?php echo Router::url('admin/configuration/mailer'); ?>">Mailer</a>
              </li>
              <li>
                  <a href="<?php echo Router::url('admin/configuration/server'); ?>">Serveur</a>
              </li>
              <li>
                  <a href="<?php echo Router::url('admin/configuration/SiteViveVars'); ?>">Variables Vive</a>
              </li>
              <li>
                  <a href="<?php echo Router::url('admin/configuration/SiteStaticVars'); ?>">Variables Static</a>
              </li>
              <li>
                  <a href="<?php echo Router::url('admin/configuration/report'); ?>">Signaler un bug</a>
              </li>
          </ul>
        </a>
      </li>
      <li>
        <a href="<?php echo Router::url("admin/visitors") ?>">
          <i class="fa fa-users"></i><span>Visiteurs</span>
        </a>
      </li>
      <li>
        <a target="_site_view" href="<?php echo Router::url("") ?>">
          <i class="fa fa-play"></i><span>Voir le site</span>
        </a>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
