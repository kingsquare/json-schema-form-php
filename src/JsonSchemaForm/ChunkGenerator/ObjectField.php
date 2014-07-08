<?php

namespace JsonSchemaForm\ChunkGenerator;

class ObjectField extends \JsonSchemaForm\ChunkGenerator {
	public function render(array $options) {
		foreach ($this->schema->properties as $propertyName => $propertySchema) {
			$fieldGeneratorClassName =  'JsonSchemaForm\\ChunkGenerator\\' . ucfirst($propertySchema->type) . 'Field';
			$fieldGenerator = new $fieldGeneratorClassName($propertySchema, $this->twig);
			$newPath = array_merge($options['path'], array($propertyName));
			$pathAsClassName = preg_replace('![^_a-z0-9-]!i', '-', implode($newPath, '-'));

			$fieldHtmlChunks[$pathAsClassName] = $fieldGenerator->render(array(
				'path' => $newPath,
				'name' => $propertyName,
			));
		}
		$options['fieldHtmlChunks'] = $fieldHtmlChunks;
		return $this->_render('chunk/object.html', $options);
	}
}
