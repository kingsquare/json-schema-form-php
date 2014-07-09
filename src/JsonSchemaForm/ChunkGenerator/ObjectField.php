<?php

namespace JsonSchemaForm\ChunkGenerator;

class ObjectField extends \JsonSchemaForm\ChunkGenerator {
	public function render(array $options) {
		foreach ($this->schema->properties as $propertyName => $propertySchema) {
			$fieldGeneratorClassName =  'JsonSchemaForm\\ChunkGenerator\\' . ucfirst($propertySchema->type) . 'Field';
			$fieldGenerator = new $fieldGeneratorClassName($propertySchema, $this->twig);
			$newPath = array_merge($options['path'], array($propertyName));
			$pathAsClassName = preg_replace('![^_a-z0-9-]!i', '-', implode($newPath, '-'));

			$inputName = '';
			foreach ($newPath as $key => $newPathNibble) {
				if ($key > 0) {
					$inputName .= '[';
				}
				$inputName .= $newPathNibble;
				if ($key > 0) {
					$inputName .= ']';
				}
			}

			$fieldRenderOptions = array(
				'path' => $newPath,
				'name' => $inputName
			);

			if (isset($options['value']) && isset($options['value']->{$propertyName})) {
				$fieldRenderOptions['value'] = $options['value']->{$propertyName};
			}

			$fieldHtmlChunks[$pathAsClassName] = $fieldGenerator->render($fieldRenderOptions);
		}
		$options['fieldHtmlChunks'] = $fieldHtmlChunks;
		return $this->_render('chunk/object.twig', $options);
	}
}
