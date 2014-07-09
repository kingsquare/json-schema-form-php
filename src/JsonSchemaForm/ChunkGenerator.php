<?php
namespace JsonSchemaForm;

abstract class ChunkGenerator {
	protected $schema;
	protected $twig;

	public function __construct($schema, $twig) {
		$this->schema = $schema;
		$this->twig = $twig;
	}

	abstract public function render(array $options);

	/**
	 * @param string $template
	 * @param array $options
	 * @return string
	 */
	protected function _render($template, array $options) {
		$renderVars = array_merge((array) $this->schema, $options);

		if (!isset($renderVars['label'])) {
			$renderVars['label'] = $this->getLabel($options);
		}
		if (!isset($options['id'])) {
			$renderVars['id'] = $this->getId($options);
		}
		if (!isset($options['class'])) {
			$renderVars['class'] = $this->getClass($options);
		}
		return $this->twig->render($template, $renderVars);
	}

	/**
	 * @return string
	 */
	private function getLabel(array $options) {
		if (isset($this->schema->title)) {
			return $this->schema->title;
		}
		if (isset($options['name'])) {
			return $options['name'];
		}
		return '';
	}

	/**
	 * @return string
	 */
	private function getId(array $options) {
		if (isset($options['path'])) {
			return $this->getDomCompatible(implode('-', $options['path']));
		}
		return '';
	}

	/**
	 * @return string
	 */
	private function getClass(array $options) {
		$result = array();

		if (!empty($options['path'])) {
			return $this->getDomCompatible(implode('-', $options['path']));
		}
		return $result;
	}

	protected function getDomCompatible($string) {
		return preg_replace('![^_a-z0-9-]!i', '-', $string);
	}
}