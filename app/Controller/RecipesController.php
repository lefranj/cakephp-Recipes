<?php

App::uses('AppController', 'Controller');

class RecipesController extends AppController {

	public $uses = array('Recipe', 'Image');
	public $components = array('CheckJson', 'Converter');

	public function index() {

		/* Получение данных из поля Data БД*/

		$page=1;
		$lenght = 10;
		$recipes = $this->Recipe->find("all",array('limit'=>$lenght, 'page'=>$page,'recursive' => -1));

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
			$arraytitles[] = $json->title;
			$arraycalories[] = $json->calories;
			$arraycooktime[] = $json->cooktime;
			$arraylinks[] = "/recipes/recipe/{$recipe['Recipe']['Id']}";

			if (isset($json->images) && !empty($json->images)){
				$imagedata = $json->images;
				$arrayimglinks[] = $this->Image->getImage($imagedata, 120);
			} else {
				$arrayimglinks[] = 'img/120/default.jpg';
			}
		}

		/*Отправка данных в представление*/

		$recipeData = array('titles' => $arraytitles,
							'calories' => $arraycalories,
							'cooktimes' => $arraycooktime,
							'links' => $arraylinks,
							'imglinks' => $arrayimglinks);
		$this->set($recipeData);
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
}