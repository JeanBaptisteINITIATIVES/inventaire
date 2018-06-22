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
$id 		  = $_POST['change-free-id'];
$location     = checkInput($_POST['change-free-loc']);
$reference    = checkInput($_POST['change-free-ref']);
$designation  = checkInput($_POST['change-free-des']);
$quantity     = checkInput($_POST['change-free-qty']);
$status       = checkInput($_POST['change-free-sts']);
$observations = checkInput($_POST['change-free-obs']);

$location_id = getLocationId($location);
$product_id  = getProductId($reference, $designation);
$user_id     = getUserId($user, $site_id);

// Contrôle de l'existence de l'emplacement
if ( !checkIfLocationExist($location) || empty($location) )
{
	$array["isSuccess"] = false;
	$array["locError"] = "Emplacement non-valide";
}

// Contrôle référence
// if ( empty($reference) )
// {
// 	$array["isSuccess"] = false;
// 	$array["refError"] = "Référence non-valide";
// }

// Contrôle désignation
if ( empty($designation) )
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
	$req = $db->prepare('UPDATE free_input
						 INNER JOIN location
						 ON free_input.location_id = location.id
						 SET location_id = (SELECT id
						 					FROM location
						 					WHERE num_location = :location), reference = :reference, designation = :designation, quantity = :quantity, status = :status, observations = :observations, date_create = NOW()
						 WHERE free_input.id = :id');

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