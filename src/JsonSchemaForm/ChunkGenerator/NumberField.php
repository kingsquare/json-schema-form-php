<?php

namespace JsonSchemaForm\ChunkGenerator;

class NumberField extends \JsonSchemaForm\ChunkGenerator {
	public function render($options = array()) {
		return $this->_render('chunk/number.twig', $options);
	}
}