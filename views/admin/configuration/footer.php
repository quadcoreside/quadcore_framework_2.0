<div class="container">

        <div class="row">
            <form action="<?php echo Router::url('admin/configuration/footer') ?>" method="post">
            <div class="col-lg-12">
                <h1 style="height: 88px;">Footer du site</h1>
            </div>
            <div class="col-md-12">
                <?php echo $this->Form->input('website_footer', 'Footer du site', array('type' => 'textarea', 'rows' => 20, 'class' => 'input-xxlarge')); ?>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Valider">
                </div>
            </div>
            </form>
        </div>
        
</div>
