<?php

namespace PhalconRest\Filter;

class MongoId {

	public function filter($value) {
		$value = strtolower($value);
		$value = preg_replace('/[^0-9a-f]/', '', $value);
		return substr($value, 0, 24);
	}
}
