<?php

namespace JsonSchemaForm\ChunkGenerator;

class NumberField extends \JsonSchemaForm\ChunkGenerator {
	public function render($options = array()) {
		if (empty($this->schema->enum)) {
			$inputType = (isset($this->schema->inputType) ? $this->schema->inputType : 'number');
			return $this->_render('chunk/' . $inputType . '.twig', $options);
		}

		$options['options'] = array();
		foreach ($this->schema->enum as $enumValue) {
			$enumTitles = (isset($this->schema->enumTitles) ? (object) $this->schema->enumTitles : new StdClass());
			$enumTitleKey = (string) $enumValue;

			$options['options'][] = array(
				'id' =>  $this->getDomCompatible(implode(array_merge($this->path, array($enumValue)),  '-')),
				'label' => (isset($enumTitles->$enumTitleKey) ? $enumTitles->$enumTitleKey: $enumValue),
				'value' => $enumValue
			);
		}

		$inputType = (isset($this->schema->inputType) ? $this->schema->inputType : 'select');
		return $this->_render('chunk/' . $inputType . '.twig', $options);
	}
}