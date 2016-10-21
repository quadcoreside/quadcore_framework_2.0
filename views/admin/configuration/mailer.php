<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1>Mailer</h1>
        </div>
        <div class="col-md-12">
            
            <div class="panel-group" id="accordion">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">Smtp Edite</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse in" style="height: auto;">
                        <div class="panel-body">
                            <form method="post" action="<?php echo Router::url('admin/configuration/mailer') ?>">
                                    <div class="col-md-12">
                                        <?php echo $this->Form->input('smtp_host', 'Hote') ?>                
                                        <?php echo $this->Form->input('smtp_secure', 'Smtp Secure', array('placeholder' => 'Type de securite: tls ou ssl')) ?>                
                                        <?php echo $this->Form->input('smtp_user', 'User') ?>                
                                        <?php echo $this->Form->input('smtp_password', 'Password', array('type' => 'password', 'placeholder' => 'Laissez vide pour ne pas changé')) ?>
                                        <?php echo $this->Form->input('smtp_online', 'Utiliser SMTP', array('type' => 'checkbox')); ?>              
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

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Mail Test</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse in" style="height: auto;">
                        <div class="panel-body">
                             <form action="<?php echo Router::url('admin/configuration/smtp/') ?>" method="post">
                                <div class="col-md-12">
                                    <?php echo $this->Form->input('mail_to', 'Adresse Mail', array('placeholder' => 'Entré votre adresse Email')) ?>                
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-success" name="send_mail_test" type="submit">Envoyer</button>
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
