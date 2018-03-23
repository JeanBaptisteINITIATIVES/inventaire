<?php
require_once('../config/load.php');

if (isset($_GET['id']))
{
	$sql = 'SELECT i.reference AS reference, i.designation AS designation, i.quantity AS quantity, i.status AS status, i.observations AS observations, l.num_location AS location
			FROM free_input AS i
			INNER JOIN location AS l
			ON i.location_id = l.id
			WHERE i.id = ?';

	$req = $db->prepare($sql);

	$req->execute(array($_GET['id']));
	
	$result = $req->fetch();

	$req->closeCursor();

	echo json_encode($result);

	/*print_r($donnees);*/
}