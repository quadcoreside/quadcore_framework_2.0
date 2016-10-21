<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 style="height: 88px;">Configuration</h1>
            </div>
            <div class="col-md-12">
                <div class="col-md-6 col-sm-6">
                    <?php echo $this->Form->input('website_name', 'Nom du site', array('disabled' => '')) ?>                
                    <?php echo $this->Form->input('website_email', 'Email Contact', array('disabled' => '')) ?>
                    <?php echo $this->Form->input('website_author', 'Author', array('disabled' => '')); ?>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-inline">
                        <label>Icone: </label>
                        <?php if (!empty($this->Cfg->read('website_icon'))): ?>
                            <img class="pull-right" src="<?php echo Router::url('images/logos/'.$this->Cfg->read('website_icon')) ?>" height="100" widht="200">
                        <?php endif ?>
                    </div>
                    <hr>
                    <div class="form-inline">
                        <h2>
                            <?php if ($this->Cfg->read('website_statut') == 1): ?>
                                <h2><span class="label label-success">Site Online</span></h2>
                            <?php else: ?>
                                <span class="label label-danger">Site Offline</span>
                            <?php endif ?>
                        </h2>
                    </div>
                </div>
               
            </div>
        </div>
</div>

