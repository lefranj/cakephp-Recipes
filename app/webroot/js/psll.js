$('#fullRecipe').pjax('#main'); // Данные полученые по ссылкам с классом "fullRecipe", будут загружаться в контейнер с классом "main"
$(function(){
	$('body').screw({
		loadingHTML: '<img src="img/loading.gif">'
	});
});