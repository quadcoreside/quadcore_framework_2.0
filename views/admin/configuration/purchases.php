<div class="container">
	
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="height: 88px;">Mode de Paiements</h1>
	    </div>
	    <div class="col-md-12">
	        <div class="panel panel-default">
	            <div class="panel-heading panel-title"><b>Paiements Config</b> <div class="label label-danger pull-right">Dangereux</div></div>
	            <div class="panel-body">
                <div class="panel-body panel-collapse in">

                    <div class="row well">
                    	<h2 class="text-center"><a target="blank_" href="https://developer.paypal.com/">Paypal</a></h2>
                        <form action="<?php echo Router::url('admin/configuration/purchases') ?>" method="post" autocomplete="off">
                        	<div class="col-md-12">
                                <?php echo $this->Form->input('website_paypal_url', 'URL API Paypal') ?>             
                                <?php echo $this->Form->input('website_paypal_email', 'Email Paypal') ?>
                                <?php echo $this->Form->input('website_paypal_allow', 'Active', array('type' => 'checkbox')); ?>          
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="Valider">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row well">
                        <form action="<?php echo Router::url('admin/configuration/purchases') ?>" method="post" autocomplete="off">
                        	<h2 class="text-center"><a target="blank_" href="https://bitcoin.org/fr/">Bitcoin</a>
                            <small><a target="blank_" href="https://blockchain.info/fr/api/api_receive">Blockchain</a></small></h2>
                            <div class="col-md-12">
                                <?php echo $this->Form->input('website_btc_api_key', 'Api key') ?>             
                                <?php echo $this->Form->input('website_btc_secret', 'Random Secret') ?>             
                                <?php echo $this->Form->input('website_btc_xpub', 'Xpub key') ?>  
                                <?php echo $this->Form->input('website_btc_allow', 'Active', array('type' => 'checkbox')); ?>           
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
