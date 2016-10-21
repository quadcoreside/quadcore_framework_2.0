<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo Router::webroot('dists/img/site/'.$this->Cfg->read('website_icon')) ?>">
        <title><?php echo isset($title_for_layout) ? $title_for_layout.' - Administration '.$this->Cfg->read('website_name') : 'Administration'; ?></title>
        <link href="<?php echo Router::webroot('dists/admin/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo Router::webroot('dists/admin/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo Router::webroot('dists/admin/css/ionicons.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo Router::webroot('dists/admin/dist/css/AdminLTE.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo Router::webroot('dists/admin/dist/css/skins/_all-skins.min.css') ?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo Router::webroot('dists/admin/plugins/jQuery/jQuery-2.1.4.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo Router::webroot('dists/admin/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo Router::webroot('dists/admin/plugins/slimScroll/jquery.slimscroll.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo Router::webroot('dists/admin/plugins/fastclick/fastclick.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo Router::url('dists/js/angular.min.js') ?>"></script>
        <script src="<?php echo Router::url('dists/js/angular-sanitize.min.js') ?>"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
<body class="skin-blue sidebar-mini">

    <div class="wrapper">
    	<div class="content-wrapper">
    		<?php echo $this->Session->flash(); ?>
        	<?php echo $content_for_layout; ?>
        </div>
	</div>

</body>
</html>
