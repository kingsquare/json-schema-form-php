<?php
namespace JsonSchemaForm;

abstract class ChunkGenerator {
	protected $generator;
	protected $path;
	protected $schema;


	public function __construct($generator, $path) {
		$this->generator = $generator;
		$this->path = $path;

		//fix for array traversing
		$nibbles = array();
		$nibbleIsNumeric = false;
		foreach($path as $nibble) {
			$nibbleIsNumeric = is_numeric($nibble);
			if (!$nibbleIsNumeric) {
				$nibbles[] = $nibble;
			}
		}

		$this->schema = \JsonSchemaForm\JsonPath::getSchemaNode(implode('.', $nibbles), $generator->schema);

		//last nibble numeric? The items of the Array schema is targeted!
		if ($nibbleIsNumeric) {
			$this->schema = $this->schema->items;
		}
	}

	abstract public function render($options = array());

	/**
	 * @return string
	 */
	public function getDomClass() {
		$result = array();

		if (!empty($this->path)) {
			$result[] = $this->getDomCompatible(implode('-', $this->path));
		}

		//error?
		if (!empty($this->generator->errorPaths)) {
			if (in_array(implode('.', $this->path), $this->generator->errorPaths)) {
				$result[] = 'error';
			}
		}

		return implode(' ', $result);
	}

	/**
	 * @param string $template
	 * @param array $options
	 * @return string
	 */
	protected function _render($template, array $renderVars) {
		foreach (array('id', 'label', 'name', 'value') as $expectedPropertyName) {
			if (!isset($renderVars[$expectedPropertyName])) {
				$renderVars[$expectedPropertyName] = $this->{'get' . $expectedPropertyName}();
			}
		}

		return $this->generator->twig->render($template, $renderVars);
	}

	/**
	 * @return string
	 */
	private function getLabel() {
		if (isset($this->schema->title)) {
			return $this->schema->title;
		}
		if (isset($options['name'])) {
			return $options['name'];
		}
		return '';
	}

	protected function getValue() {
		//traverse path in $this->generator->data;
		return JsonPath::getValue(implode('.',  $this->path), $this->generator->data);
	}

	/**
	 * @return string
	 */
	private function getId() {
		if (!empty($this->path)) {
			return $this->getDomCompatible(implode('-', $this->path));
		}
		return '';
	}

	private function getName() {
		return 'root[' . implode('][', $this->path) . ']';
	}

	protected function getDomCompatible($string) {
		return preg_replace('![^_a-z0-9-]!i', '-', $string);
	}
}