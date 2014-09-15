<!--Вывод списка рецептов-->

<?php for ($i=0; $i < count($titles); $i++) :?>

<div id='recipe_title'><a href = "<?=$links[$i]?>" id="fullRecipe"> <?=$titles[$i]?> </a></div>
	<div id='recipe_image'><img src = "<?=$imglinks[$i]?>"></div>
	<div id='recipe_calories'>Calories: <?=$calories[$i]?></div>
	<div id='recipe_cooktime'>Cooktime: <?=$cooktimes[$i]?> min</div>
	<table border = '1' width = '100%' height = '0'><tr><td></td></tr></table>

<?php endfor;?>
<p class="screw screw-before screw-repeat" rel="index.php"></p>
