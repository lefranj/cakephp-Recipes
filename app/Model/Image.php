<?php
/**
* Модель Image
*
* Служит для получения из базы данных информации о изображениях,
* их кеширования и ресайза
*
* @param object $imageResize; Объект класса ImageResize
* @param odject $HttpSocket; Объект класса HttpSocket
*/
class Image extends AppModel {

	public $imageResize;
	public $HttpSocket;

/**
* Метод getImage 
* 
*
* @param array $imgdata; Массив из одного элемента, содержащий данные о изображении
* @param integer $size; Размер изображения на выходе
* @return string Ссылка на кешированое изображение нужного размера
*/

	public function getImage($imgdata, $size) {
		if (isset($imgdata[0]) && !empty($imgdata[0])){

			$imgurl = $imgdata[0]->url;
			$imgcrc = $imgdata[0]->crc;

			//Если есть копия изображения необходимого размера, то возвращаем путь к ней

			if (file_exists(WWW_ROOT."img/$size/$imgcrc.jpg")) {
				return FULL_BASE_URL."/img/$size/$imgcrc.jpg";
			}

			//Если копии изображения нужного размера нет, то пробуемполучить оригинал по ссылке

			if (!file_exists(WWW_ROOT."img/full/$imgcrc.jpg")) {
				$response = $this->HttpSocket->get($imgurl);

				//При статусе ответа 200 сохраняем оригинал

				if ($response->code !== '200') {
					$this->imageResize->load(WWW_ROOT."img/$size/default.jpg");
					$this->imageResize->save(WWW_ROOT."img/$size/$imgcrc.jpg");
				}

				file_put_contents(WWW_ROOT."img/full/$imgcrc.jpg", $response);
			}

			//Ресайзим его и делаем копию нужного размера
			$this->imageResize->load(WWW_ROOT."img/full/$imgcrc.jpg");
			$this->imageResize->resize($size,$size);
			$this->imageResize->save(WWW_ROOT."img/$size/$imgcrc.jpg");

			//Возвращаем путь к копии изображения нужного размера
			return FULL_BASE_URL."/img/$size/$imgcrc.jpg";
		}
	}

	public function __construct() {

		//Подключаем HttpSocket и класс ImageResize, создаем их объекты

		App::uses('ImageResize', 'Vendor');
		App::uses('HttpSocket', 'Network/Http');
		$this->imageResize = new ImageResize();
		$this->HttpSocket = new HttpSocket();
	}
}

?>