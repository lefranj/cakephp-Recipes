<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>
			<?php echo $title_for_layout;?>
		</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php
			echo $this->Html->meta('icon');
			echo $this->Html->css('bootstrap'); // подключаем стиль
			echo $this->Html->css('rss'); // подключаем стиль
			echo $this->Html->script('jquery'); // подключаем jQuery
			echo $this->Html->script('bootstrap');
		?>
		<style type="text/css">
			body{ padding: 70px 0px; }
		</style>
	</head>
	<body>
		<?php echo $this->Element('navigation'); ?>
		<div class="container">
		<?php echo $this->fetch('content'); ?>
		</div>
	</body>
</html>
