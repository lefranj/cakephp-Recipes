<div id="recipefull">
	<div class='title'><?php echo $recipe['json']->title;?><br><br></div>
	<div class='image'><img src="<?php echo $recipe['imgLink'];?>"></div>
	<div class='calories'>Calories: <?php echo $recipe['json']->calories;?></div><br><br>
	<div class='cooktime'>Cooktime: <?php echo $recipe['json']->cooktime;?> min</div>
	<div class='ingredients'><?php echo $recipe['json']->ingredients;?>><br><br></div>
	<div class='description'><?php echo $recipe['json']->description;?><br><br></div>
</div>
