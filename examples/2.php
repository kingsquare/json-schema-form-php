<?php
include('../vendor/autoload.php');
$retriever = new JsonSchema\Uri\UriRetriever;
$schema = $retriever->retrieve('file://' . realpath('schema2.json'));

$refResolver = new JsonSchema\RefResolver($retriever);
$refResolver->resolve($schema, 'file://' . __DIR__);

$generator = new JsonSchemaForm\Generator($schema);

?>
<html>
	<head>
		<!-- Foundation CSS framework (Bootstrap and jQueryUI also supported) -->
		<link rel="stylesheet" href="//cdn.jsdelivr.net/foundation/5.0.2/css/foundation.min.css">
		<!-- Font Awesome icons (Bootstrap, Foundation, and jQueryUI also supported) -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
	</head>
	<body>
		<?php echo ($generator->render(array('action' => '#'))); ?>
		<pre>
			<?php print_r($schema); ?>
		</pre>
	</body>
</html>

<form role="form">
	<div class="form-group">
		<label for="exampleInputEmail1">Email address</label>
		<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1">Password</label>
		<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
	</div>
	<div class="form-group">
		<label for="exampleInputFile">File input</label>
		<input type="file" id="exampleInputFile">
		<p class="help-block">Example block-level help text here.</p>
	</div>
	<div class="checkbox">
		<label>
			<input type="checkbox"> Check me out
		</label>
	</div>
	<button type="submit" class="btn btn-default">Submit</button>
</form>