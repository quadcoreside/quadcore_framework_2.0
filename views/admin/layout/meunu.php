<?php
  include 'meunu_left.php';

  $notifications = $this->Notification_Model->getMenuNotifications();
  $tasks = $this->Task_Model->getMenuTasks();
  $nbr_notifications = count($notifications);
  $nbr_tasks = count($tasks);
?>

<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo Router::url('admin/dashboard') ?>" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>SQ</b>G</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Lay</b>Gacy</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <?php if ($nbr_notifications > 0): ?>
              <span class="label label-warning"><?php echo $nbr_notifications ?></span>
            <?php endif ?>
          </a>
          <ul class="dropdown-menu">
            <li class="header">Vous avez <?php echo $nbr_notifications ?> notifications</li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <?php foreach ($notifications as $k => $v): ?>
                  <li>
                    <a>
                      <i class="<?php echo $v->icone_class ?>"></i> <?php echo $v->content ?>
                    </a>
                  </li>
                <?php endforeach ?>
              </ul>
            </li>
            <li class="footer"><a href="<?php echo Router::url('admin/notifications') ?>">Voir Tout</a></li>
          </ul>
        </li>

        <li class="dropdown tasks-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <i class="fa fa-flag-o"></i>
            <?php if ($nbr_tasks > 0): ?>
              <span class="label label-danger"><?php echo $nbr_tasks ?></span>
            <?php endif ?>
          </a>
          <ul class="dropdown-menu">
            <li class="header">Vous avez <?php echo $nbr_tasks ?> taches</li>
            <li>
              <!-- inner menu: contains the actual data -->
              <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
              <?php foreach ($tasks as $k => $v): ?>
                <li>
                  <a href="#">
                    <h3>
                      <?php echo $v->name ?>
                      <small class="pull-right"><?php echo $v->pourcentage ?>%</small>
                    </h3>
                    <p class="xs"><?php echo ($v->status) ?></p>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-aqua" role="progressbar" aria-valuenow="<?php echo $v->pourcentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $v->pourcentage ?>%">
                        <span class="sr-only"><?php echo $v->pourcentage ?>% Completer</span>
                      </div>
                    </div>
                  </a>
                </li>
                <?php endforeach ?>
              </ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 188.679px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
            </li>
            <li class="footer">
              <a href="<?php echo Router::url('admin/tasks') ?>">Voir toutes les taches</a>
            </li>
          </ul>
        </li>

        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo Router::url('images/profiles/'.$this->Session->read('Admin')->picture) ?>" class="user-image" alt="<?php echo $this->Session->read('Admin')->username ?>" />
            <span class="hidden-xs"><?php echo $this->Session->read('Admin')->username ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <p>
                <?php echo $this->Session->read('Admin')->username ?>
                <small>Dérniere connexion: <?php echo date('H:i d/m/Y', strtotime($this->Session->read('Admin')->date_last)) ?></small>
              </p>
            </li>

            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php echo Router::url('admin/users/my_account') ?>" class="btn btn-default btn-flat">Mon compte</a>
              </div>
              <div class="pull-right">
                <a href="<?php echo Router::url('admin/users/logout') ?>" class="btn btn-default btn-flat">Déconnexion</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
