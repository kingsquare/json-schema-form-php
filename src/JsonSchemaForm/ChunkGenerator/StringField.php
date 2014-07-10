<?php

namespace JsonSchemaForm\ChunkGenerator;

class StringField extends \JsonSchemaForm\ChunkGenerator {
	public function render($options = array()) {
		if (empty($this->schema->enum)) {
			$inputType = (isset($this->schema->inputType) ? $this->schema->inputType : 'input');
			$options['type'] = (isset($this->schema->format) ? $this->schema->format : 'text');
			return $this->_render('chunk/' . $inputType . '.twig', $options);
		}

		$options['options'] = array();
		foreach($this->schema->enum as $enumValue) {
			$options['options'][] = array(
				'id' =>  $this->getDomCompatible(implode(array_merge($this->path, array($enumValue)),  '-')),
				'label' => ((isset($this->schema->enumTitles) && isset($this->schema->enumTitles[$enumValue])) ?
						$this->schema->enumTitles[$enumValue] :
						$enumValue),
				'value' => $enumValue
			);
		}

		$inputType = (isset($this->schema->inputType) ? $this->schema->inputType : 'select');
		return $this->_render('chunk/' . $inputType . '.twig', $options);
	}
}
