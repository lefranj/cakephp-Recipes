<?php

class ConverterComponent extends Component{

	// Исправляем закодированные символы в JSON объекте
	public $codes = array('u0','u1','u2','u3','u4','u5','u6','u7','u8','u9');
	public $chars = array('\u0','\u1','\u2','\u3','\u4','\u5','\u6','\u7','\u8','\u9');

	public function convert($d) {
		$d = str_replace($this->codes,$this->chars,$d);
		$d = urldecode($d);
		return($d);
	}
}