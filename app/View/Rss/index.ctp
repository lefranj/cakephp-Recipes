<!--Вывод RSS-->
<form method="post" action="/rss">
	<div class="rss_serch_title"><b>RSS feed URL: </b></div>  <input class="textfield" type="text" name="url" value="<?php echo $feed_url;?>">
	<input type="submit" class="rss_submit_button" id="fullRecipe" value="View">
</form>
	<?php foreach($toView as $item):?>
		<div class="rss_item">
			<div class="rss_title"><a id="fullRecipe" href="<?php echo $item['link'];?>"><?php echo $item['title'];?></a></div>
			<div class="rss_description"><?php echo $item['description'];?></div>
			<div class="rss_date"><?php echo $item['date'];?></div>
			<div class="rss_link"><a href="<?php echo $item['link'];?>"><?php echo $item['link'];?></a></div>
		</div>
	<?php endforeach;?>