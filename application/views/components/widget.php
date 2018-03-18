<?php
var_dump($page->id);
?>


<div <?= isset($id) != '' && $id != '' ? "id='$id'" : '' ?><?= isset($class) != '' && $class != '' ? "class='$class'" : '' ?>>
	<div class="widget-title">
		<h4><?= (isset($widget_title) && $widget_title != "") ? $widget_title : '' ?></h4>
	</div>
	<div class="inside">
		<div class="main">
			<?php
				if (isset($main_content) && $main_content != "")
					echo $main_content;
			?>
		</div>
	</div>
</div>