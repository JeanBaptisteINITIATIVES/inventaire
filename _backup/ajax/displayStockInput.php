<?php
require_once('../config/load.php');

if (isset($_GET['id']))
{
	$sql = 'SELECT i.quantity AS quantity, i.status AS status, i.observations AS observations, l.num_location AS location, p.reference AS reference, p.designation AS designation
			FROM stock_input AS i
			INNER JOIN location AS l
			ON i.location_id = l.id
			INNER JOIN products AS p
			ON i.product_id = p.id
			WHERE i.id = ?';

	$req = $db->prepare($sql);

	$req->execute(array($_GET['id']));
	
	$result = $req->fetch();

	$req->closeCursor();

	echo json_encode($result);

	/*print_r($donnees);*/
}