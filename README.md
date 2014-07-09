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
echo $formGenerator->render();
?>
```

See ```examples``` folder for a few more options.

Extra styling and JavaScript is required for proper presentation and validation.

```
## Running the tests

    $ phpunit