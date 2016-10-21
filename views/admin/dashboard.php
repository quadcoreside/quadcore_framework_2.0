<link rel="stylesheet" href="<?php echo Router::webroot('dists/admin/plugins/jvectormap/jquery-jvectormap-2.0.3.css') ?>">
<script src="<?php echo Router::url('dists/admin/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js') ?>"></script>
<script src="<?php echo Router::webroot('dists/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>"></script>

<section class="content">

  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $inboxs ?></h3>
          <p>New Inbox</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="<?php echo Router::url('admin/inboxs') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?php echo $urls ?></sup></h3>
          <p>Urls</p>
        </div>
        <div class="icon">
          <i class="fa fa-database"></i>
        </div>
        <a href="<?php echo Router::url('admin/sqli/urls') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php echo $url_injectables ?></h3>
          <p>Injectables</p>
        </div>
        <div class="icon">
          <i class="fa fa-circle-o"></i>
        </div>
        <a href="<?php echo Router::url('admin/sqli/injectables') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo $proxy_lives ?></h3>
          <p>Proxy Live</p>
        </div>
        <div class="icon">
          <i class="fa fa-shield"></i>
        </div>
        <a href="<?php echo Router::url('admin/proxy?filter=status') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid bg-light-blue-gradient">
        <div class="box-header ui-sortable-handle" style="cursor: move;">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i></button>
          </div>
          <i class="fa fa-map-marker"></i>
          <h3 class="box-title">
            Word Site Vulnerables Detected
          </h3>
        </div>
        <div class="box-body">
          <div id="world-map-gdp" style="height: 750px; width: 100%;"></div>
        </div>
      </div>
    </div>
  </div>

</section>

<script>
  var gdpData = {
    <?php  echo $gdpData ?>
  };
  $('#world-map-gdp').vectorMap({
    series: {
      regions: [{
        values: gdpData,
        scale: ['#C8EEFF', '#0071A4'],
        normalizeFunction: 'polynomial'
      }]
    },
    onRegionTipShow: function(e, el, code){
      el.html(el.html()+' '+gdpData[code]+'');
    }
  });
</script>