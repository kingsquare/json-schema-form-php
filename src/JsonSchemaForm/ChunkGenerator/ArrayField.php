<?php

namespace JsonSchemaForm\ChunkGenerator;

class ArrayField extends \JsonSchemaForm\ChunkGenerator {
	public function render(array $options) {
		$subFormGenerator = new \JsonSchemaForm\Generator($this->schema->items);

		if (!empty($options['value'])) {
			$options['content'] = '';
			foreach ($options['value'] as $key => $item) {
				$options['content'] .= $subFormGenerator->render(
					$this->getSubFormGeneratorOptions($options, $key),
					$item
				);
			}
		} else {
			// At least show a single items (maybe as a template for other items?)
			$options['content'] = $subFormGenerator->render($this->getSubFormGeneratorOptions($options, 0));
		}
		return $this->_render('chunk/array.twig', $options);
	}

	private function getSubFormGeneratorOptions($options, $key) {
		$subFormGeneratorOptions = $options;
		$subFormGeneratorOptions['name'] = 'item ' . $key;
		$subFormGeneratorOptions['isSubForm'] = true;
		$subFormGeneratorOptions['path'][] = $key;
		return $subFormGeneratorOptions;
	}
}