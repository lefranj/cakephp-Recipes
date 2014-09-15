<?php

// Является-ли строка объектом или массивом 

class CheckJsonComponent extends Component {

	public function isJson($string) {
		return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
	}
}