<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="<?php echo Router::webroot('images/logos/'.$this->Cfg->read('website_icon')) ?>">
    <title><?php echo isset($title_for_layout) ? $title_for_layout.' - Administration' : '..: Administration :..'; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?php echo Router::webroot('dists/admin/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo Router::webroot('dists/admin/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo Router::webroot('dists/admin/css/ionicons.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo Router::webroot('dists/admin/dist/css/AdminLTE.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo Router::webroot('dists/admin/dist/css/skins/_all-skins.min.css') ?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo Router::webroot('dists/admin/plugins/jQuery/jQuery-2.1.4.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo Router::webroot('dists/admin/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo Router::webroot('dists/admin/plugins/slimScroll/jquery.slimscroll.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo Router::webroot('dists/admin/plugins/fastclick/fastclick.min.js') ?>" type="text/javascript"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue sidebar-mini <?php echo isset($page_class) ? $page_class : '' ?>">
    <div class="wrapper">
      <?php include 'meunu.php'; ?>
      <div class="content-wrapper">
        <div class="container">
          <?php echo $this->Session->flash(); ?>
        </div>
        <?php echo $content_for_layout; ?>
      </div>
    </div>
    
    <script src="<?php echo Router::webroot('dists/admin/dist/js/app.min.js') ?>" type="text/javascript"></script>
    <script type="text/javascript">
      $("#msg-alert").fadeTo(5000, 500).slideUp(500, function(){
          $("#msg-alert").alert('close');
      });
    </script>
  </body>
</html>