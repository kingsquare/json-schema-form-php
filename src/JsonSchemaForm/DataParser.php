<?php

namespace JsonSchemaForm;

class DataParser {
	public function parse($formData, $schema) {
		$result = new \StdClass();
		foreach($formData as $key => $value) {
			$schemaNode = JsonPath::getSchemaNode($key, $schema);
			if ($schemaNode && !empty($schemaNode->type)) {
				switch ($schemaNode->type) {
					case 'object':
						$parsedValue = $this->parse($value, $schemaNode);
						break;

					case 'string':
						$parsedValue = (string) $value;
						break;

					case 'boolean':
						$parsedValue = (boolean) $value;
						break;
					default:
						print_r($schemaNode);
						exit;
				}
				$result->{$key} = $parsedValue;
			}
		}
		return $result;
	}
}