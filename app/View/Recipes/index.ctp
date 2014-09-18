<!--Вывод списка рецептов-->
<div id="main" class="container">
<?php foreach($arrayRecipes as $recipe):?>
	<div id="recipeshort">
		<div class='title'><a href = "<?=$recipe['link']?>" id="fullRecipe"> <?=$recipe['json']->title?> </a></div>
		<div class='image'><img src="<?=$recipe['imgLink']?>"></div>
		<div class='calories'>Calories: <?=$recipe['json']->calories?></div><br><br>
		<div class='cooktime'>Cooktime: <?=$recipe['json']->cooktime?> min</div>
		<div class='ingredients'>Ingredients:<br> <?=$recipe['json']->ingredients?></div>
	</div>
<?php endforeach;?>
<p class="screw screw-before screw-repeat" rel="/recipes/screw"></p>
</div>