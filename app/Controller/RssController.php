<?php

App::uses('AppController', 'Controller');

class RecipesController extends AppController {

	public $uses = array('Recipe', 'Image');
	public $components = array('CheckJson', 'Converter', 'RequestHandler');

	public function index($page = 1) {
		$mt = strtotime('Wed, 17 Sep 2014 19:01:33 GMT');
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
			strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $mt)
		{
			header('HTTP/1.1 304 Not Modified');
			die;
		}

		$this->Session->write('page', 1);

		/* Получение данных из поля Data БД*/

		$lenght = 10;
		$arrayRecipes = array();
		$recipes = $this->Recipe->find("all",array('limit'=>$lenght, 'page'=>$page));

		/* Приведение JSON в пригодное для развертывания состояние*/

		foreach ($recipes as $recipe) {
			$recd = str_replace("\n", '<br>', $recipe['Recipe']['Data']);
			$recd = str_replace("\r", '', $recd);
			$recd = $this->Converter->convert($recd);

			/* Извлечение данных из JSON*/

			if(!$this->CheckJson->isJson($recd)){
				continue;
			}

			$json = json_decode($recd);
			$toArray = array(
				'id' => $recipe['Recipe']['Id'],
				'json' => $json,
				'link' => "/recipes/recipe/{$recipe['Recipe']['Id']}"
			);

			if (isset($json->images) && !empty($json->images)){
				$toArray['imgLink'] = '/recipes/image/'.$toArray['id'].'/120';
			} else {
				$toArray['imgLink'] = FULL_BASE_URL.'/img/120/default.jpg';
			}
				$arrayRecipes[] = $toArray;
				unset($toArray);
		}

		/*Отправка данных в представление*/

		$this->set(array('arrayRecipes' => $arrayRecipes));
	}

	public function recipe($id) {
		$params = array('conditions' => array('Recipe.Id' => $id));
		$recipe = $this->Recipe->find('first', $params);
		$recd = str_replace("\n", '<br>', $recipe['Recipe']['Data']);
		$recd = str_replace("\r", '<br>', $recd);
		$recd = $this->Converter->convert($recd);

		/* Извлечение данных из JSON*/

		if(!$this->CheckJson->isJson($recd)){
			continue;
		}

		$json = json_decode($recd);
		if (isset($json->images) && !empty($json->images)){
			$imagedata = $json->images;
			$imglink = $this->Image->getImage($imagedata, 240);
		} else {
			$imglink = FULL_BASE_URL.'/img/240/default.jpg';
		}

		/*Отправка данных в представление*/

		$recipeData = array('title' => $json->title,
							'calories' => $json->calories,
							'cooktime' => $json->cooktime,
							'description' => $json->description,
							'ingredients' => $json->ingredients,
							'link' => $json->link,
							'imglink' => $imglink);
		$this->set($recipeData);
	}

	public function screw() {

		if ($this->request->is('ajax')) {
			$page = $this->Session->read('page') + 1;
			$this->layout = false;
			// Получение данных из поля Data БД
			$lenght = 10;
			$arrayRecipes = array();
			$recipes = $this->Recipe->find("all",array('limit'=>$lenght, 'page'=>$page));

			// Приведение JSON в пригодное для развертывания состояние

			foreach ($recipes as $recipe) {
				$recd = str_replace("\n", '<br>', $recipe['Recipe']['Data']);
				$recd = str_replace("\r", '', $recd);
				$recd = $this->Converter->convert($recd);

				// Извлечение данных из JSON
				if(!$this->CheckJson->isJson($recd))
					continue;

				$json = json_decode($recd);
				$toArray = array(
					'id' => $recipe['Recipe']['Id'],
					'json' => $json,
					'link' => "/recipes/recipe/{$recipe['Recipe']['Id']}"
				);

				if (isset($json->images) && !empty($json->images))
					$toArray['imgLink'] = '/recipes/image/'.$toArray['id'].'/120';
				else
					$toArray['imgLink'] = FULL_BASE_URL.'/img/120/default.jpg';
				$arrayRecipes[] = $toArray;
				unset($toArray);
			}

			/*Отправка данных в представление*/
			$this->set(array('arrayRecipes' => $arrayRecipes));
			$this->Session->write('page', $page);
		} else {
			throw new BadRequestException();
		}
	}

	public function image($id, $size){
		$mt = strtotime('Wed, 17 Sep 2014 19:11:33 GMT');
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
			strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $mt)
		{
			header('HTTP/1.1 304 Not Modified');
			die;
		}
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