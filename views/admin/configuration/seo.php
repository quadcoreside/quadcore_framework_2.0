<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 style="height: 88px;">Réferencement</h1>
            </div>
            <div class="col-md-12">
                
                <div class="panel-group" id="accordion">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">SEO</a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse in" style="height: auto;">
                            <div class="panel-body">
                                <form method="post" action="<?php echo Router::url('admin/configuration/seo/') ?>" >
                                    <div class="col-md-12">
                                        <?php echo $this->Form->input('website_description', 'Description', array('type' => 'textarea')); ?>
                                        <?php echo $this->Form->input('website_keywords', 'Keywords', array('type' => 'textarea')); ?>
                                        <?php echo $this->Form->input('website_author', 'Author'); ?>        
                                    </div>
                                    <div class="col-md-12">
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
</div>
