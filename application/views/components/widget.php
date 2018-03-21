<?php
// var_dump($page);
	$vars = (array) $page;
	extract($vars);
?>


<div <?= isset($id) != '' && $id != '' ? "id='$id'" : '' ?> class='widget-container tile <?= isset($class) != '' && $class != '' ? "$class " : '' ?>'>
	<div class="widget-header w3-row" onclick="jQuery(this).parent().find('.widget-body').slideToggle()">
		<div>
			<h4 class="w3-col s11"><?= (isset($widget_title) && $widget_title != "") ? $widget_title : '' ?></h4>
		</div>
		<!-- <div>
			<button class="w3-small w3-ripple w3-button w3-col s1" onclick="jQuery(this).parent().parent().parent().find('.widget-body').slideToggle()">Hide</button>
		</div> -->
	</div>
	<div class="widget-body">
		<div class="main">
			<?php
				if (isset($content) && $content != "")
					echo $content;
			?>
		</div>
		<div class="widget-footer">
			<?php
				if (isset($widget_footer) && $widget_footer != "")
					echo $widget_footer;
			?>
		</div>
	</div>
</div>