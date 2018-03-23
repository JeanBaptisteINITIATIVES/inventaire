<?php
require_once('../config/load.php');

$term      = $_GET['term'];
$isTracked = $_GET['entry'];

if ( isset($_GET['entry']) )
{
	if ( $_GET['entry'] == 'stock' )
	{
		$req = 'SELECT p.reference AS reference, p.designation AS designation
				FROM products AS p
				INNER JOIN stock_input AS s
				ON p.id = s.product_id
				WHERE reference LIKE :term';
	}
	
	if ( $_GET['entry'] == 'no-stock' )
	{
		$req = 'SELECT reference, designation
				FROM free_input
				WHERE reference LIKE :term';
	}
}

$result = $db->prepare($req);

$result->execute(array('term' => $term . '%'));

$array = array();

while( $results = $result->fetch() )
{
    
    $array_results = array("reference"   => $results['reference'],
    					   "designation" => $results['designation']);
    
    array_push($array, $array_results);
}

$result->closeCursor();

echo json_encode($array);