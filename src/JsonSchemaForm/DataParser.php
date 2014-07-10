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

					case 'number':
						$parsedValue = (int) $value;
						break;

					case 'array':
						$parsedValue = array();
						foreach ($value as $item) {
							$parsedValue[] = DataParser::parse($item, $schemaNode->items);
						}
						break;

					default:
						echo 'Datatype not supported by DataParser: ' . $schemaNode->type . PHP_EOL;
						print_r($value);
						print_r($schemaNode);
						exit;
				}
				$result->{$key} = $parsedValue;
			}
		}
		return $result;
	}
}