<?php

namespace JsonSchemaForm\ChunkGenerator;

class ArrayField extends \JsonSchemaForm\ChunkGenerator {
	public function render(array $options) {
		$subFormGenerator = new \JsonSchemaForm\Generator($this->schema->items);
		$subFormGeneratorOptions = $options;
		$subFormGeneratorOptions['name'] = 'item 0';
		$subFormGeneratorOptions['isSubForm'] = true;
		$options['content'] = $subFormGenerator->render($subFormGeneratorOptions);
		return $this->_render('chunk/array.html', $options);
	}

}
