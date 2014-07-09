<?php

namespace JsonSchemaForm\ChunkGenerator;

class NumberField extends \JsonSchemaForm\ChunkGenerator {
	public function render(array $options) {
		return $this->_render('chunk/number.twig', $options);
	}
}