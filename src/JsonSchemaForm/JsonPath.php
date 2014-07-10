<?php
namespace JsonSchemaForm;

class JsonPath {
	static public function getSchemaNode($key, $parentSchemaNode) {
		if (!$key) {
			//use $container!
			return $parentSchemaNode;
		}

		if ($parentSchemaNode->type === 'array' && $parentSchemaNode->items) {
			return JsonPath::getSchemaNode($key, $parentSchemaNode->items);
		}

		$keyNibbles = explode('.', $key);
		$keyNibble = array_shift($keyNibbles);

		if ($parentSchemaNode && $parentSchemaNode->properties && isset($parentSchemaNode->properties->{$keyNibble})) {
			return JsonPath::getSchemaNode(implode('.', $keyNibbles), $parentSchemaNode->properties->{$keyNibble});
		}
		return null;
	}

	static public function getValue($key, $container) {
		if ($key === '') {
			return $container;
		}

		$keyNibbles = explode('.', $key);
		$keyNibble = array_shift($keyNibbles);

		if ($container) {
			// Traverse arrays
			if (is_numeric($keyNibble) && isset($container[$keyNibble])) {
				return JsonPath::getValue(implode('.', $keyNibbles), $container[$keyNibble]);
			}

			if (isset($container->{$keyNibble})) {
				return JsonPath::getValue(implode('.', $keyNibbles), $container->{$keyNibble});
			}
		}
		return null;
	}
}