<?php

App::uses('AppController', 'Controller');

class RecipesController extends AppController {

	public $uses = array('Recipe', 'Image');
	public $components = array('CheckJson', 'RequestHandler', 'Converter');

	/**
	 *  Метод index вызывается при загрузке страницы со списком рецептов
	 * @param integer $page - номер страницы. Используется для последовательного получения рецептов из БД
	 */
	public function index($page = 1) {
		$mt = strtotime('Wed, 17 Sep 2014 19:01:33 GMT');

		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
			strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $mt)
		{
			header('HTTP/1.1 304 Not Modified');
			die;
		}
		
		$this->Session->write('page', 1);
		// Получение данных из поля Data БД
		$lenght = 10;
		$arrayRecipes = array();
		$recipes = $this->Recipe->find("all",array('limit'=>$lenght, 'page'=>$page));
		$arrayRecipes = $this->Recipe->getItemsList($recipes);
		// Отправка данных в представление
		$this->set(array('arrayRecipes' => $arrayRecipes));
	}

	/**
	 *  Метод recipe передает в представление данные рецепта с полученым Id
	 * @param integer $id - номер рецепта.
	 */
	public function recipe($id) {
		$params = array('conditions' => array('Recipe.Id' => $id));
		$recipe = $this->Recipe->find('first', $params);
		$recipeData = $this->Recipe->getItemsRecipe($recipe);
		$this->set('recipe', $recipeData);
	}

	/**
	 *  Метод аналогичен index, но вызывается только AJAX запросом
	 */
	public function screw() {

		if ($this->request->is('ajax')) {
			$page = $this->Session->read('page') + 1;
			$this->layout = false;
			// Получение данных из поля Data БД
			$lenght = 10;
			$arrayRecipes = array();
			$recipes = $this->Recipe->find("all",array('limit'=>$lenght, 'page'=>$page));
			$arrayRecipes = $this->Recipe->getItemsList($recipes);
			//Отправка данных в представление
			$this->set(array('arrayRecipes' => $arrayRecipes));
			$this->Session->write('page', $page);
		} else {
			throw new BadRequestException();
		}
	}

	/**
	 *  Метод передает в представление изображение нужного размера
	 * @param integer $id - номер рецепта.
	 * @param integer $size - необходимый размер изображения.
	 */
	public function image($id, $size){
		$params = array('conditions' => array('Recipe.Id' => $id));
		$recipe = $this->Recipe->find('first', $params);
		if (empty($recipe))
			$this->redirect(FULL_BASE_URL.'/img/'.$size.'/default.jpg', 303);
		$recd = str_replace("\n", '<br>', $recipe['Recipe']['Data']);
		$recd = str_replace("\r", '', $recd);
		$recd = $this->Converter->convert($recd);
		if(!$this->CheckJson->isJson($recd))
			$this->redirect(FULL_BASE_URL.'/img/'.$size.'/default.jpg', 303);
		$json = json_decode($recd);
		$link = $this->Image->getImage($json->images, $size);
		$this->redirect($link, 303);
	}
}