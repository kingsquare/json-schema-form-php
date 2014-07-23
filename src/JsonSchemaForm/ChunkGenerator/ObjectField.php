<?php

namespace JsonSchemaForm\ChunkGenerator;

class ObjectField extends \JsonSchemaForm\ChunkGenerator {
	public function render($options = array()) {
		foreach ($this->schema->properties as $propertyName => $propertySchema) {
			if (!isset($propertySchema->type)) {
				continue;
			}
			$fieldGeneratorClassName =  'JsonSchemaForm\\ChunkGenerator\\' . ucfirst($propertySchema->type) . 'Field';
			$newPath = array_merge($this->path, array($propertyName));
			$errors = array();
			$implodedNewPath = implode('.', $newPath);
			foreach($this->generator->errors as $error) {
				if (strpos($error['property'], $implodedNewPath) === 0) {
					$errors[] = $error;
				}
			}

			$fieldGenerator = new $fieldGeneratorClassName($this->generator, $newPath);
			$fieldHtmlChunks[$fieldGenerator->getDomClass()] = $fieldGenerator->render();
		}
		$options['fieldHtmlChunks'] = $fieldHtmlChunks;
		return $this->_render('chunk/object.twig', $options);
	}
}