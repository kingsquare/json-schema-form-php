<?php

namespace JsonSchemaForm\ChunkGenerator;

class BooleanField extends \JsonSchemaForm\ChunkGenerator {
	public function render(array $options) {
		return $this->_render('chunk/boolean.twig', $options);
	}
}