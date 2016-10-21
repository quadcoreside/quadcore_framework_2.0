<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Serveur</h1>
            </div>
            <div class="col-md-12">
                

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">Serveur site</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse in" style="height: auto;">
                        <div class="panel-body">
                            <form method="post" action="<?php echo Router::url('admin/configuration/server') ?>" enctype="multipart/form-data">
                                <div class="col-lg-12">
                                    <?php echo $this->Form->input('website_name', 'Nom du site') ?>
                                    <?php echo $this->Form->input('website_email', 'Email Contact') ?>  
                                    <?php echo $this->Form->input('website_report', 'Email Report') ?>  
                                    <div class="form-group inline">
                                        <h2>
                                            <label>Site Statut:</label>
                                            <?php if ($this->Cfg->read('website_status') == 1): ?>
                                                <span class="label label-success">Online</span>
                                            <?php else: ?>
                                                <span class="label label-danger">Offline</span>
                                            <?php endif ?>
                                        </h2>
                                    </div>
                                        <div class="form-group">
                                            <label>Icone: </label>
                                            <?php if ($this->Cfg->read('website_icon')): ?>
                                                <img class="pull-right" style="width:180px;padding:10px 10px;" src="<?php echo Router::url('images/logos/'.$this->Cfg->read('website_icon')) ?>">
                                            <?php endif ?>
                                            <?php echo $this->Form->input('website_icon', 'hidden'); ?>
                                            <?php echo $this->Form->input('icone', 'Icone du site', array('type' => 'file')); ?>
                                        </div>
                                        <?php echo $this->Form->input('website_status', 'Site en ligne', array('type' => 'checkbox')); ?>

                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success" value="Valider">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</div>
