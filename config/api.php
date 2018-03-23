<?php
require_once('load.php');

$req_api = 'http://sccoreapi/v1/product/?rows=99999';
// $req_api = 'http://sccoreapi/v1/product/?filter={"is_stock_managed":-1}&rows=99999';

$result = json_decode(file_get_contents($req_api));

$array = array();

foreach ( $result as $row )
{
	$array_results = array("reference"   => $row->id,
						   "designation" => $row->name,
						   "stock" 	     => $row->is_stock_managed);
    
    array_push($array, $array_results);
}

// echo '<pre>';
// print_r($array);
// echo '</pre>';

$req = $db->prepare('INSERT INTO products (reference, designation, stock)
					 VALUES (:reference, :designation, :stock)
					 ON DUPLICATE KEY UPDATE designation = :designation, stock = :stock');

foreach ($array as $data) {
	
	// echo '<pre>';
	// 	print_r($data['designation']);
	// echo '</pre>';
	
	$req->bindParam(':reference', $data['reference'], PDO::PARAM_STR);
	$req->bindParam(':designation', $data['designation'], PDO::PARAM_STR);
	$req->bindParam(':stock', $data['stock'], PDO::PARAM_INT);

	$req->execute();

	$req->closeCursor();
}