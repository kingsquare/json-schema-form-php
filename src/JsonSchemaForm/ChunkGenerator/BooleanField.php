<?php

namespace JsonSchemaForm\ChunkGenerator;

class BooleanField extends \JsonSchemaForm\ChunkGenerator {
	public function render($options = array()) {
		return $this->_render('chunk/boolean.twig', $options);
	}
}