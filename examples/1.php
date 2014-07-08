<?php
include('../vendor/autoload.php');
$retriever = new JsonSchema\Uri\UriRetriever;
$schema = $retriever->retrieve('file://' . realpath('schema1.json'));
$generator = new JsonSchemaForm\Generator($schema);

$refResolver = new JsonSchema\RefResolver($retriever);
$refResolver->resolve($schema, 'file://' . __DIR__);

?>
<html>
<head>
	<link rel="stylesheet" id="theme_stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<link rel="stylesheet" id="icon_stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
</head>
<body>
<?php echo($generator->render(array(
	'action' => '#',
	'form' => array(
		"card.type" => array(
			"inputType" => "radio"
		),
		"card.text" => array(
			"inputType" => "textarea",
			"height" => "120px"
		),
		"card.anonymous" => array(
			"title" => "Ik wil anoniem blijven"
		),
		"address.recipient.countryCode" => array(
			"enumTitles" => array(
				"NL" => "Nederland",
				"BE" => "België",
				"LU" => "Luxemburg"
			)
		),
		"address.recipient.addressType" => array(
			"enumTitles" => array(
				"residence" => "Woning",
				"company" => "Bedrijf",
				"hospital" => "Ziekenhuis",
				"funeral center" => "Uitvaartcentrum of crematorium",
				"church" => "Kerk",
				"other" => "Anders"
			)
		),
		"address.recipient.salutation" => array(
			"enumTitles" => array(
				"mr" => "De heer",
				"mrs" => "Mevrouw"
			)
		),
		"address.customer.equalToDeliveryAddress" => array(
			"title" => "Gelijk aan bezorgadres"
		),
		"address.customer.type" => array(
			"inputType" => "radio",
			"enumTitles" => array(
				"individual" => "Particulier",
				"company" => "Bedrijf"
			)
		),
		"address.customer.countryCode" => array(
			"enumTitles" => array(
				"NL" => "Nederland",
				"BE" => "België",
				"LU" => "Luxemburg"
			)
		),
		"address.customer.salutation" => array(
			"enumTitles" => array(
				"mr" => "De heer",
				"mrs" => "Mevrouw"
			)
		),
		"delivery.partOfDay" => array(
			"inputType" => "radio",
			"enumTitles" => array(
				"allDay" => "Overdag",
				"morning" => "Ochtend\n08:00 - 12:00 extra € 4,95",
				"afternoon" => "Middag\n12:00 - 17:00 extra € 3,95",
				"evening" => "Ochtend\n17:00 - 21:00 extra € 5,95"
			)
		),
		"delivery.comment" => array(
			"inputType" => "textarea",
			"height" => "120px"
		),
		"payment.type" => array(),
		"items" => array(
			"format" => "table",
			"options" => array(
				"disable_array_add" => false,
				"disable_array_reorder" => true
			)
		),
		"items.webProductCollectionMemberId" => array(
			"inputType" => "hidden"
		),
		"final.termsAndConditions" => array(
			"title" => "Ik ga akkoord met de <a href=\"/algmene-voorwaarden\">algemene voorwaarden</a>"
		),
		"final.keepMeUpdated" => array(
			"title" => "Ik wil graag op de hoogte gehouden worden van acties"
		),
		"final.postalInvoice" => array(
			"title" => "Ik wil graag de factuur per post ontvangen (€ 1,95)"
		)
	)
))); ?>
<pre><?php print_r($schema); ?></pre>
</body>
</html>