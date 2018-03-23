<?php
session_start();
$user    = $_SESSION['user-alias'];
$site_id = $_SESSION['site_id'];

require_once('../config/load.php');

$array = array("locFreeError"  => "",
			   "desFreeError"  => "",
			   "qtyFreeError"  => "",
			   "isSuccess" 	   => false);

if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
	// Récupération des infos saisies
	$location  	  = checkInput($_POST['free-loc']);
	$reference    = checkInput($_POST['free-ref']);
	$designation  = checkInput($_POST['free-des']);
	$quantity     = checkInput($_POST['free-qty']);
	$status       = checkInput($_POST['free-sts']);
	$observations = checkInput($_POST['free-obs']);

	$array["isSuccess"] = true;

    // Contrôle de l'existence de l'emplacement
	if ( !checkIfLocationExist($location) || empty($location) )
	{
		$array["isSuccess"] = false;
		$array["locFreeError"] = "Emplacement non-valide";
	}

	// Contrôle si désignation
	if ( empty($designation) )
	{
		$array["isSuccess"] = false;
		$array["desFreeError"] = "Entrez une désignation";
	}
	
	// Contôle de la quantité saisie
	if ( !isValidQuantity($quantity) )
	{
		$array["isSuccess"] = false;
		$array["qtyFreeError"] = "Erreur sur la quantité";
	}

	// Si tout est bien renseigné, on insère les valeurs en bdd
	if ( $array["isSuccess"] )
	{
		$user_id = getUserId($user, $site_id);

		insertFreeInput($reference, $designation, $quantity, $status, $observations, $location, $user_id);
	}

	echo json_encode($array);
}