<?php

class Recipe extends AppModel {
public $codes = array('u0','u1','u2','u3','u4','u5','u6','u7','u8','u9');
public $chars = array('\u0','\u1','\u2','\u3','\u4','\u5','\u6','\u7','\u8','\u9');
	/**
	 *  Метод getItemsList обрабатывает данные полученные из базы данных
	 * @param array $recipes - многмерный массив записей
	 * @return array $arrayRecipes - многомерный массив с информацией о рецептах
	 */
	public function getItemsList($recipes){
		foreach ($recipes as $recipe) {
			// Приведение JSON в пригодное для развертывания состояние
			$recd = str_replace("\n", '<br>', $recipe['Recipe']['Data']);
			$recd = str_replace("\r", '', $recd);
			$recd = $this->convert($recd);

			// Извлечение данных из JSON
			if(!$this->isJson($recd)){
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
			if (!isset($toArray['json']->calories) || empty($toArray['json']->calories)){
			$toArray['json']->calories = '-';
			}

			if (!isset($toArray['json']->cooktime) || empty($toArray['json']->cooktime)){
				$toArray['json']->cooktime = '-';
			}
				$arrayRecipes[] = $toArray;
				unset($toArray);
		}
		return $arrayRecipes;
	}

	/**
	 *  Метод getItemsRecipe обрабатывает данные полученные из базы данных
	 * @param array $recipe - массив c информацией о рецепте в формате JSON
	 * @return array $toArray - многомерный массив с информацией о рецептах
	 */
	public function getItemsRecipe($recipe){
		// Приведение JSON в пригодное для развертывания состояние
		$recd = str_replace("\n", '<br>', $recipe['Recipe']['Data']);
		$recd = str_replace("\r", '', $recd);
		$recd = $this->convert($recd);

		// Извлечение данных из JSON

		$json = json_decode($recd);
		$toArray['json'] = $json;

		if (isset($json->images) && !empty($json->images)){
			$toArray['imgLink'] = '/recipes/image/'.$json->id.'/240';
		} else {
			$toArray['imgLink'] = FULL_BASE_URL.'/img/240/default.jpg';
		}

		if (!isset($toArray['json']->calories) || empty($toArray['json']->calories)){
			$toArray['json']->calories = '-';
		}

		if (!isset($toArray['json']->cooktime) || empty($toArray['json']->cooktime)){
			$toArray['json']->cooktime = '-';
		}

		return $toArray;
	}

	/**
	 *  Метод convert исправляет кодировку в JSON
	 * @param string $d - JSON с неверной кодировкой
	 * @return string $d - JSON с верной кодировкой
	 */
	public function convert($d) {
		$d = str_replace($this->codes,$this->chars,$d);
		$d = urldecode($d);
		return($d);
	}

	/**
	 *  Метод isJson проверяет строку на JSON
	 * @param string $string - JSON 
	 * @return boolean $string - true-JSON, false-не JSON
	 */
	public function isJson($string) {
		return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
	}
}