<?php

App::uses('AppController', 'Controller');
require_once(APP.'Vendor/simplepie/autoloader.php');
include_once(APP.'Vendor/simplepie/idn/idna_convert.class.php');

class RssController extends AppController {
	private $feed;

	//Вывод RSS фида
	public function index() {
		$toVeiw = array();
		$this->layout = 'rss';
		$this->feed = new SimplePie();
		// Провряем получен-ли url фида
		if (isset($this->request['data']['url']) && $this->request['data']['url'] !== '') {
			// Устанавливаем url из которого будем получать фид
			$this->feed->set_feed_url($this->request['data']['url']); 
			$this->feed->init(); // Инициализация SimplePie
			$this->feed->handle_content_type();
			// Получаем последние 50 записей
			foreach($this->feed->get_items(0, 50) as $item) {
				// Готовим данные для передачи в представление
				$toView[] = array(
					'title' => $item->get_title(),
					'date' => $item->get_date('j F Y | g:i a'),
					'description' => $item->get_description(),
					'link' => $item->get_permalink(),
					'feed_url' => $this->request['data']['url']
					);
				// Передаем данные в представление  
				$this->set('feed_url', $this->request['data']['url']);
			}
		} else {
			$toView[] = array(
				'title' => '',
				'date' => '',
				'description' => '',
				'link' => '',
			);
			$this->set('feed_url', '');
		}
		// Передаем данные в представление
		$this->set('toView', $toView);
		$this->set('title_for_layout', 'RSS');
	}
}