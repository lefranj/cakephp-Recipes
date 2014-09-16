$('a.fullRecipe').pjax('#main');
$(function(){
	$('body').screw({
		loadingHTML: '<h3>Loading...</h3>'
	});
});
$("img.lazy").lazyload();




