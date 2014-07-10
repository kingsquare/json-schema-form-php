<?php

namespace JsonSchemaForm\ChunkGenerator;

class ArrayField extends \JsonSchemaForm\ChunkGenerator {
	public function render($options = array()) {
		$chunkGeneratorClass =  'JsonSchemaForm\\ChunkGenerator\\' . ucfirst($this->schema->items->type) . 'Field';
		$value = $this->getValue();
		if (empty($value)) {
			// add a blank object, as a template?
			$value = array(new \StdClass());
		}

		$options['content'] = '';
		foreach ($value as $key => $item) {
			$path = $this->path;
			$path[] = $key;
			$chunkGenerator = new $chunkGeneratorClass($this->generator, $path);
			$options['content'] .= $chunkGenerator->render();
		}

		return $this->_render('chunk/array.twig', $options);
	}
}