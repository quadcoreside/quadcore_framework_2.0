<script src="<?php echo Router::webroot('dists/js/angular.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo Router::webroot('dists/js/tinymce/tinymceA.min.js') ?>"></script>

<div class="container">
	<div class="page-header">
		<h2>Editer une Page</h2>
	</div>

	<div class="row" ng-app="PageApp" ng-controller="PageController">

		<div ng-init="page.name='<?php echo isset($this->request->data->name) ? addslashes($this->request->data->name) : ''; ?>'"></div>
        <div ng-init="page.slug='<?php echo isset($this->request->data->slug) ? addslashes($this->request->data->slug) : ''; ?>'"></div>
        	
		<form action="<?php echo Router::url('admin/pages/edit/'.$id); ?>" method="post" autocomplete="off">
			<div class="col-md-6 col-sm-12 col-xs-12">
                <?php echo $this->Form->input('id', 'hidden'); ?>
                <?php echo $this->Form->input('date_created', 'hidden'); ?>
				<?php echo $this->Form->input('name', 'Titre', array('placeholder' => 'Exemple: Conditions et termes', 'require' => '', 'ng-model' => 'page.name', 'ng-change' => 'changeName()')); ?>
				<?php echo $this->Form->input('online', 'En ligne', array('type' => 'checkbox')); ?>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<?php echo $this->Form->input('slug', 'Url', array('placeholder' => 'mon-url', 'require' => '', 'ng-model' => 'page.slug')); ?>
				<?php echo $this->Form->input('in_menu', 'Affiché dans le meunu', array('type' => 'checkbox')); ?>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php echo $this->Form->input('content', 'Conteunu', array('type' => 'textarea', 'rows' => 25, 'class' => 'wysiwyg')); ?>
				
				<div class="form-group">
					<button type="submit" value="Modifier" class="btn btn-primary">Valider</button>
				</div>

			</div>
		</form>
	</div>

</div>

<script type="text/javascript">
var root_folder = "<?php echo Router::url('admin') ?>";
tinymce.init({
    mode : "specific_textareas",
    editor_selector : "wysiwyg",
    editor_deselector : "mceNoEditor",
    relative_urls : false,
    convert_urls: false,
    plugins: [
        "advlist autolink lists link image charmap preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime table paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    file_browser_callback: function(field_name, url, type, win) {
        if(type == 'file')
        {
            var explorer = root_folder + '/medias/pages/tinymce';
        } else {
            var explorer = root_folder + '/medias/index/<?php echo $id ?>/pages';
        }
        tinymce.activeEditor.windowManager.open({
            title: 'Gallerie',
            width: 520,
            height: 400,
            resizable : 'yes',
            inline : 'yes',
            close_previous : 'no',
            url : explorer
        },{
            window : win,
            input : field_name,
            oninsert: function(path) {
                document.getElementById(field_name).value = path;   
            }
        });
    }
});

var app = angular.module('PageApp', []);

app.controller('PageController', function($scope) {
	$scope.changeName = function(){
		if ($scope.page.name) {
    		$scope.page.slug = $scope.page.name.toLowerCase().replaceAll(' ', '-').replaceAll('é', 'e').replaceAll('è', 'e').replaceAll('\'', '-').replaceAll('à', 'a').replaceAll('ç', 'c').replaceAll('/', '').replaceAll('(', '').replaceAll(')', '');
		};
    }
    String.prototype.replaceAll = function(str1, str2, ignore) 
	{
	    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
	}
});

</script>