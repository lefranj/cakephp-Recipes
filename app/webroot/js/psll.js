$('a.fullRecipe').pjax('#main');
$(function(){
	$('body').screw({
		loadingHTML: '<img src="img/loading.gif">'
	});
});