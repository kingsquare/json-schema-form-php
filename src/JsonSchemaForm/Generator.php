<?php

namespace JsonSchemaForm;

class Generator {
	private $schema;
	private $twig;

	public function __construct($schema) {
		$this->schema = $schema;
		$this->twig = new \Twig_Environment(new \Twig_Loader_Filesystem('../templates'));
	}

	private function getSchemaNode($key, $container) {
		if (!$key) {
			//use $container!
			return $container;
		}

		if ($container->type === 'array' && $container->items) {
			return $this->getSchemaNode($key, $container->items);
		}

		$keyNibbles = explode('.', $key);
		$keyNibble = array_shift($keyNibbles);
		if ($container && $container->properties && isset($container->properties->{$keyNibble})) {
			return $this->getSchemaNode(implode('.', $keyNibbles), $container->properties->{$keyNibble});
		}
		return null;
	}

	/**
	 * Possible options
	 * - action {string}
	 *
	 *
	 * @param array - The options for rendering
	 * @param object - The data to enter in the form
	 * @param object - Any errors to highlight and apply in the form
	 * @return string	HTML form
	 */
	public function render($options, $data = null, $errors = null) {
		//update valid with schema $options['form'] config
		if (!empty($options['form'])) {
			foreach ($options['form'] as $path => $config) {
				$schemaNode = $this->getSchemaNode($path, $this->schema);
				if ($schemaNode) {
					foreach($config as $key => $value) {
						$schemaNode->{$key} = $value;
					}
				}
			}
			$options['form'] = null; //to prevent later misunderstandings
		};

		$fieldGeneratorClassName =  'JsonSchemaForm\\ChunkGenerator\\' . ucfirst($this->schema->type) . 'Field';
		$fieldGenerator = new $fieldGeneratorClassName($this->schema, $this->twig);
		$options['html'] = $fieldGenerator->render(array('path' => array('root')));
		return $this->twig->render('form.html', $options);
	}
}