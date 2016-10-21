<?php $searchEnabled = true; ?>
<div class="container">

    <h1 class="header">
        <?php echo $total ?> Variables
    </h1>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Content</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vars as $k => $v): ?>
                <tr>
                    <td><?php echo $v->name ?></td>
                    <td><?php echo (empty($v->content)) ? '<b>NULL</b>' : word_limiter(htmlspecialchars($v->content), 10) ?></td>
                    <td>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Action <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo Router::url('admin/configuration/editVar/vive/'.$v->id) ?>">Editer</a></li>
                                <li><a onclick="return confirm('Voulez vous vraiment supprimer cette element')" href="<?php echo Router::url('admin/configuration/SiteViveVars?delete='.$v->id) ?>">Supprimer</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">
                    <div class="pull-right">
                      <?php echo $pagination ?>
                    </div>
                </th>
            </tr>
        </tfoot>
    </table>

</div>