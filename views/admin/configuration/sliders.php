<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Sliders</h1>
            </div>
            <div class="col-md-12">
       
                <div class="panel-group" id="accordion">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">Ajouter</a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse in" style="height: auto;">
                            <div class="panel-body">
                                <form method="post" action="<?php echo Router::url('admin/configuration/sliders/'.$id) ?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Image (slider): </label>
                                        <?php if (!empty($this->request->data->slider_path)): ?>
                                            <img src="<?php echo Router::url('img/slider/'.$this->request->data->slider_path) ?>" height="50" width="80">
                                        <?php endif ?>
                                        <?php echo $this->Form->input('slider_path', 'hidden'); ?>
                                        <?php echo $this->Form->input('slider', 'Image', array('type' => 'file')); ?>
                                    </div>
                                    <?php echo $this->Form->input('online', 'En ligne', array('type' => 'checkbox')); ?>
                                    <?php echo $this->Form->input('context', 'Contexte') ?>  
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
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Sliders</a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse in" style="height: auto;">
                            <div class="panel-body">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr role="row">
                                            <th>En ligne ?</th>
                                            <th>Slider</th>
                                            <th>Contexte</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($sliders as $k => $v): ?>
                                            <tr>
                                                <td><span class="label <?php echo ($v->online == 1) ? 'label-success' : 'label-danger'; ?>"><?php echo ($v->online ==1) ? 'En ligne' : 'Hors ligne'; ?></span></td>
                                                <td><img src="<?php echo Router::url('img/slider/'.$v->var); ?>" height="80"></td>
                                                <td><?php echo $v->content ?></td>
                                                <td><?php echo $v->date_created ?></td>
                                                <td class="">
                                                    <div class="btn-group">
                                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Action <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="<?php echo Router::url('admin/configuration/sliders/?setonline='.$v->id) ?>"><?php echo ($v->online ==1) ? 'Désactiver' : 'Activer'; ?></a></li>
                                                            <li><a onclick="return confirm('Voulez vous vraiment supprimer ce slider')" href="<?php echo Router::url('admin/configuration/sliders/?delete='.$v->id) ?>">Supprimer</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                   
            </div>
        </div>
</div>
