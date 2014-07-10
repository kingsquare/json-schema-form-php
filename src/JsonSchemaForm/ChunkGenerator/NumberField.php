<?php

namespace JsonSchemaForm\ChunkGenerator;

class NumberField extends \JsonSchemaForm\ChunkGenerator {
	public function render($options = array()) {
		$inputType = (isset($this->schema->inputType) ? $this->schema->inputType : 'number');
		return $this->_render('chunk/' . $inputType . '.twig', $options);
	}
}