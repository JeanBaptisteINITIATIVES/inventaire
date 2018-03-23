<?php

// On regarde si l'utilisateur existe déjà
if ( checkIfUserExist($_SESSION['user-alias'], $_SESSION['site_id']) )
{
	$user_id = getUserId($_SESSION['user-alias'], $_SESSION['site_id']);
	
	// L'utilisateur existe, on récupère ses précédentes saisies
	$list_input = getUserStockInputs($user_id);
}