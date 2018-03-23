<?php
session_start();
$user    = $_SESSION['user-alias'];
$site_id = $_SESSION['site_id'];

require_once('../config/load.php');

// Initialisation de l'erreur
$array = array("locError"   => "",
			   "refError"   => "",
			   "desError"   => "",
			   "qtyError"   => "",
			   "isSuccess"  => true);

// Récupération des données du formulaire du modal
$id 		  = $_POST['change-id'];
$location     = checkInput($_POST['change-loc']);
$reference    = checkInput($_POST['change-ref']);
$designation  = checkInput($_POST['change-des']);
$quantity     = checkInput($_POST['change-qty']);
$status       = checkInput($_POST['change-sts']);
$observations = checkInput($_POST['change-obs']);

$location_id = getLocationId($location);
$product_id  = getProductId($reference, $designation);
$user_id     = getUserId($user, $site_id);

// Contrôle de l'existence de l'emplacement
if ( !checkIfLocationExist($location) || empty($location) )
{
	$array["isSuccess"] = false;
	$array["locError"] = "Emplacement non-valide";
}

// Contrôle de l'existence de la référence
if ( !checkIfReferenceExist($reference) || empty($reference) )
{
	$array["isSuccess"] = false;
	$array["refError"] = "Référence non-valide";
}

// Contrôle de l'existence de la désignation
if ( !checkIfDesignationExist($designation) || empty($designation) )
{
	$array["isSuccess"] = false;
	$array["desError"] = "Désignation non-valide";
}

// Contrôle de la quantité saisie
if ( !isValidQuantity($quantity) )
{
	$array["isSuccess"] = false;
	$array["qtyError"] = "Erreur sur la quantité";
}

if ( $array["isSuccess"] )
{
	// Modification des infos dans la bdd
	$req = $db->prepare('UPDATE stock_input
						 INNER JOIN location
						 ON stock_input.location_id = location.id
						 INNER JOIN products
						 ON stock_input.product_id = products.id
						 SET location_id = (SELECT id
						 					FROM location
						 					WHERE num_location = :location), product_id = (SELECT id
						 																   FROM products
						 																   WHERE reference = :reference
						 																   AND designation = :designation), quantity = :quantity, status = :status, observations = :observations, date_create = NOW()
						 WHERE stock_input.id = :id');

	$req->bindParam(':location', $location, PDO::PARAM_STR);
	$req->bindParam(':reference', $reference, PDO::PARAM_STR);
	$req->bindParam(':designation', $designation, PDO::PARAM_STR);
	$req->bindParam(':quantity', $quantity, PDO::PARAM_INT);
	$req->bindParam(':status', $status, PDO::PARAM_STR);
	$req->bindParam(':observations', $observations, PDO::PARAM_STR);
	$req->bindParam(':id', $id, PDO::PARAM_INT);

	$req->execute();

	$req->closeCursor();
}

echo json_encode($array);