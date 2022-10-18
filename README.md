Generate forms based on JSON Schema
===================================

A framework-agnostic PHP Implementation for generating simple forms based on [json-schema](http://json-schema.org/) . This package is compatible with version 4 and may be combined with

- Client-side validation (E.g. http://jqueryvalidation.org/)
- Server-side validation (E.g. https://packagist.org/packages/justinrainbow/json-schema)

## Installation

### Library

    $ wget http://getcomposer.org/composer.phar
    $ php composer.phar install --save kingsquare/json-schema-forms

### Usage

```php
<?php

// Get the schema and data as objects
$retriever = new JsonSchema\Uri\UriRetriever;
$schema = $retriever->retrieve('file://' . realpath('schema.json'));

// Generate
$formGenerator = new JsonSchemaForm\Generator($schema);
// Optional supply your twig environment
$formGenerator->setTwig($yourTwigEnvironment);
echo $formGenerator->render();
?>
```

See ```examples``` folder for a few more options.

Extra styling and JavaScript is required for proper presentation and validation.

### Process form data

To validate any data in the form against the schema, the form data should be casted to the proper datatypes.
Validation of form data may look like

```php
<?php
$validator = new JsonSchema\Validator();
$dataParser = new JsonSchemaForm\DataParser();

//cast any posted form-data (strings) to the proper data-types
$data = $dataParser->parse($_POST['root'], $schema);

$validator->check($data, $this->schema);

$message = "The supplied JSON validates against the schema.\n";
if (!$validator->isValid()) {
	$message = "JSON does not validate. Violations:\n";
	foreach ($validator->getErrors() as $error) {
		$message .= print_r($error, true);
	}
}
echo $message;

```

## Running the tests

    $ phpunit