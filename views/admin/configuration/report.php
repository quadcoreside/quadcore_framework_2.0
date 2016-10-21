<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Signaler un bug</h1>
            </div>
            <div class="col-md-12">
                
                <div class="panel-group" id="accordion">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">Rapport</a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse in" style="height: auto;">
                            <div class="panel-body">
                                <form action="<?php echo Router::url('admin/configuration/report/') ?>" method="post">
                                    <div class="col-md-12">
                                        <?php echo $this->Form->input('sujet', 'Sujet', array('placeholder' => 'Exemple: bug de lien')); ?>
                                        <?php echo $this->Form->input('content', 'Description', array('type' => 'textarea', 'rows' => 20, 'class' => 'wysiwyg')); ?>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit" >Envoyer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                   
            </div>
        </div>
</div>