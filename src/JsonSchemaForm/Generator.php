<?php

namespace JsonSchemaForm;

class Generator {
	private $schema;
	private $twig;

	public function __construct($schema) {
		$this->schema = $schema;
		$this->twig = new \Twig_Environment(new \Twig_Loader_Filesystem(dirname(__FILE__).'/../../templates'));
	}

	/**
	 * @param array - Any additional options per element for rendering
	 * e.g. array('my.path' => array('inputType' => 'textarea'))
	 * @param object - The data to enter in the form
	 * @param object - Any errors to highlight and apply in the form
	 * @return string	HTML form
	 */
	public function render($formRenderOptions = array(), $data = null, $errors = null) {
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
		$fieldGenerator = new $fieldGeneratorClassName($this->schema, $this->twig);

		return $this->twig->render('form.twig', array(
			'html' => $fieldGenerator->render(
				array(
					'path' => (empty($formRenderOptions['path']) ?  array('root') : $formRenderOptions['path']),
					'value' => $data
				)
			)
		));
	}
}