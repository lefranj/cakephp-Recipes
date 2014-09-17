<?php if(!isset($_SERVER["HTTP_X_PJAX"])):?>
	<?php $_SERVER["HTTP_X_PJAX"] = 'true'; ?>

<!--Вывод контента без pjax-->

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
			echo $this->Html->css('recipelist'); // подключаем стиль
			echo $this->Html->script('jquery'); // подключаем jQuery
			echo $this->Html->script('bootstrap');
			echo $this->Html->script('jquery.pjax'); // подключаем jQuery-pjax
			echo $this->Html->script('jquery.ba-viewportoffset');
			echo $this->Html->script('jquery.screw'); // подключаем jQuery-screw
			echo $this->Html->script('psll');
		?>
		<style type="text/css">
			body{ padding: 70px 0px; }
		</style>
	</head>
	<body>
		<?php echo $this->Element('navigation'); ?>
		<?php echo $this->fetch('content'); ?>
	</body>
</html>
<?php else: ?>
	<!--Вывод контента c использованием pjax-->
	<?php echo $this->fetch('content'); ?>
<?php endif;?>
