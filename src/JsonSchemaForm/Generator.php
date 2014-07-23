<?php

namespace JsonSchemaForm;

class Generator {
	public $schema;
	public $twig;
	public $data;
	public $errors;
	public $errorPaths;

	/**
	 * @param StdClass $schema
	 * @param StdClass|null $data - The data to enter in the form
	 * @param array|null - Any errors to highlight and apply in the form
	 */
	public function __construct($schema, $data = null, $errors = null) {
		$this->schema = $schema;
		$this->data = $data;

		$this->errors = (empty($errors) ? array() : $errors);
		//easy and fast lookup
		$this->errorPaths = array_column($errors, 'property');
	}

	/**
	 * @param \Twig_Environment $twig
	 */
	public function setTwig(\Twig_Environment $twig) {
		$this->twig = $twig;
	}

	public function getDefaultTwigEnvironment() {
		return new \Twig_Environment(new \Twig_Loader_Filesystem(realpath(dirname(__FILE__).'/../../templates')));
	}

	/**
	 * @param array - Any additional options per element for rendering
	 * e.g. array('my.path' => array('inputType' => 'textarea'))

	 * @return string	HTML form
	 */
	public function render($formRenderOptions = array()) {
		if (!($this->twig instanceof \Twig_Environment)) {
			$this->setTwig($this->getDefaultTwigEnvironment());
		}

		//update valid with schema $formRenderOptions config
		if (!empty($formRenderOptions)) {
			foreach ($formRenderOptions as $path => $config) {
				$schemaNode = JsonPath::getSchemaNode($path, $this->schema);
				if ($schemaNode) {
					foreach ($config as $key => $value) {
						$schemaNode->{$key} = $value;
					}
				}
			}
		};

		$fieldGeneratorClassName =  'JsonSchemaForm\\ChunkGenerator\\' . ucfirst($this->schema->type) . 'Field';
		$fieldGenerator = new $fieldGeneratorClassName($this, (empty($formRenderOptions['path']) ?
				array() :
				$formRenderOptions['path'])
		);
		return $this->twig->render('form.twig', array(
			'html' => $fieldGenerator->render()
		));
	}
}