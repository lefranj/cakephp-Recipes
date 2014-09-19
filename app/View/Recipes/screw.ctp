<!--Вывод списка рецептов-->

<?php foreach($arrayRecipes as $recipe):?>
	<div id="recipeshort">
		<div class='title'><a href = "<?=$recipe['link']?>" id="fullRecipe"> <?=$recipe['json']->title?> </a></div>
		<div class='image'><span class="screw-image" rel="<?=$recipe['imgLink']?>">Loading ... </span></div>
		<div class='calories'>Calories: <?=$recipe['json']->calories?></div><br><br>
		<div class='cooktime'>Cooktime: <?=$recipe['json']->cooktime?> min</div>
		<div class='ingredients'><?=$recipe['json']->ingredients?></div>
	</div>
<?php endforeach;?>
