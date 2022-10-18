<?php

namespace JsonSchemaForm\ChunkGenerator;

class StringField extends \JsonSchemaForm\ChunkGenerator {
	public function render($options = array()): string
    {
		if (empty($this->schema->enum)) {
			$inputType = ($this->schema->inputType ?? 'input');
			$options['type'] = ($this->schema->format ?? 'text');
			return $this->_render('chunk/' . $inputType . '.twig', $options);
		}

		$options['options'] = array();
		$enumTitles = (isset($this->schema->enumTitles) ? (object) $this->schema->enumTitles : new \StdClass());
		foreach($this->schema->enum as $enumValue) {
			$options['options'][] = array(
				'id' =>  $this->getDomCompatible(implode(array_merge($this->path, array($enumValue)),  '-')),
				'label' => ($enumTitles->$enumValue ?? $enumValue),
				'value' => $enumValue
			);
		}

		$inputType = ($this->schema->inputType ?? 'select');
		return $this->_render('chunk/' . $inputType . '.twig', $options);
	}
}