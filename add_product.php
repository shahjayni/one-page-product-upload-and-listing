<?php
$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

// validate the variables ======================================================
if (empty($_POST['product_name']))
    $errors['product_name'] = 'Product Name is required.';

if (empty($_POST['quantity']))
    $errors['quantity'] = 'Quantity is required.';

if (empty($_POST['price']))
    $errors['price'] = 'Price is required.';

// return a response ===========================================================
if ( ! empty($errors)) {

    // if there are items in our errors array, return those errors
    $data['success'] = false;
    $data['errors']  = $errors;
} else {
	$xmldoc = new DOMDocument();
	$xmldoc->encoding = 'utf-8';
	$xmldoc->xmlVersion = '1.0';
	$xmldoc->formatOutput = true;
	$xml_file_name = 'products_list.xml';
    if($xml = @file_get_contents($xml_file_name)){
    	$xmldoc->loadXML($xml);
    	$root = $xmldoc->getElementsByTagName('Products')->item(0);
    } else {
		$root = $xmldoc->createElement('Products');
	}
	$movie_node = $xmldoc->createElement('product');
	$child_node_title = $xmldoc->createElement('Name', cleanData($_POST['product_name']));
	$movie_node->appendChild($child_node_title);
	$child_node_year = $xmldoc->createElement('QuantityInStock', cleanData($_POST['quantity']));
	$movie_node->appendChild($child_node_year);
	$child_node_genre = $xmldoc->createElement('PricePerItem', cleanData($_POST['price']));
	$movie_node->appendChild($child_node_genre);
	$child_node_genre = $xmldoc->createElement('CreatedAt', date('Y-m-d H:i:s'));
	$movie_node->appendChild($child_node_genre);
	$root->appendChild($movie_node);
	$xmldoc->appendChild($root);

	$xmldoc->save($xml_file_name);

    $data['success'] = true;
    $data['message'] = 'Product has been added!';
}

echo json_encode($data);

function cleanData($string) {
	return preg_replace('/[^A-Za-z0-9\-\.\s]/', '', $string);	
}