<!--Вывод списка рецептов-->

<?php for ($i=0; $i < count($titles); $i++) :?>

		<div id='recipe_title'><a href = "<?=$links[$i]?>" id="fullRecipe"> <?=$titles[$i]?> </a></div>
		<img src="<?=$imglinks[$i]?>">
		<!-- <img class="lazy" data-original="<?=$imglinks[$i]?>"> -->
		<div id='recipe_calories'>Calories: <?=$calories[$i]?></div>
		<div id='recipe_cooktime'>Cooktime: <?=$cooktimes[$i]?> min</div>

		<table border = '1' width = '100%' height = '0'><tr><td></td></tr></table>


<?php endfor;?>
