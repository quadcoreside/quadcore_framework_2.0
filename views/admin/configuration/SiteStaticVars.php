<?php $searchEnabled = true; ?>
<div class="container">

    <h1 class="header">
        <?php echo $total ?> Variables
    </h1>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Var</th>
                <th>Type</th>
                <th>Content</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vars as $k => $v): ?>
                <tr>
                    <td><?php echo (empty($v->var)) ? '<b>NULL</b>' : $v->var ?></td>
                    <td><?php echo (empty($v->type)) ? '<b>NULL</b>' : $v->type ?></td>
                    <td><?php echo (empty($v->content)) ? '<b>NULL</b>' : word_limiter(htmlspecialchars($v->content), 10) ?></td>
                    <td><?php echo (empty($v->date_created)) ? '<b>NULL</b>' : $v->date_created ?></td>
                    <td>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Action <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo Router::url('admin/configuration/editVar/static/'.$v->id) ?>">Editer</a></li>
                                <li><a onclick="return confirm('Voulez vous vraiment supprimer cette element')" href="<?php echo Router::url('admin/configuration/SIteStaticVars?delete='.$v->id) ?>">Supprimer</a></li>
                                <li role="separator" class="divider"></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6">
                    <div class="pull-right">
                      <?php echo $pagination ?>
                    </div>
                </th>
            </tr>
        </tfoot>
    </table>

</div>