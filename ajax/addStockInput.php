<?php
session_start();
$user    = $_SESSION['user-alias'];
$site_id = $_SESSION['site_id'];

require_once('../config/load.php');

// Initialisation du tableau contenant les infos à renvoyer en json
$array = array("locError"   => "",
			   "refError"   => "",
			   "desError"   => "",
			   "qtyError"   => "",
			   "inputError" => "",
			   "isSuccess"  => false);

if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
	// Récupération des infos saisies
	$location  	  = checkInput($_POST['location']);
	$reference    = checkInput($_POST['reference']);
	$designation  = checkInput($_POST['designation']);
	$quantity     = checkInput($_POST['quantity']);
	$status       = checkInput($_POST['status']);
	$observations = checkInput($_POST['observations']);

	$array["isSuccess"] = true;

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

	// Contrôle si une saisie existe au même emplacement
	$location_id = getLocationId($location);
	$product_id  = getProductId($reference, $designation);
	$user_id     = getUserId($user, $site_id);

	if ( checkIfInputExist($location_id, $product_id, $status, $user_id) )
	{
		$array["isSuccess"] = false;
		$array["inputError"] = "Ce produit existe déjà à cet emplacement...";
	}

	// Si tout est bien renseigné, on insère les valeurs en bdd
	if ( $array["isSuccess"] )
	{
		insertStockInput($quantity, $status, $observations, $location, $product_id, $user_id);
	}

	echo json_encode($array);
}