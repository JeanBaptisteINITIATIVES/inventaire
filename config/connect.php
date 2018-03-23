<?php
require_once('config.php');

// On vide les variables de session
$_SESSION = array();

// Initialisation des messages d'erreurs
$userAliasError = $passwordError = $siteError = "none";


if( $_SERVER["REQUEST_METHOD"] == "POST" )
{
	// Initialisation des variables
	$user_alias = $site = "";
	
	$user_password   = false;
	$user_level      = 1;
	$userIsLoggedIn  = true;
	$connect_control = false;
	$connect_admin   = false;
	$allowed_pwds    = [];
	
	if ( empty($_POST['user-alias']) || !checkIfAliasExist($_POST['user-alias']) )
	{
	    $userIsLoggedIn = false;
	    $userAliasError = 'block';
	}
	else
	{
	    $user_alias    = checkInput($_POST['user-alias']);
	    $user_level    = (int) getUserLevel($_POST['user-alias']);
	    $user_password = getUserPassword($_POST['user-alias']);
	    
	    switch ($user_level)
	    {
	    	case '2':
	    		$allowed_pwds = array($user_password, PASSWORD_CONTROL);
	    		break;
	    	case '3':
	    		$allowed_pwds = array($user_password, PASSWORD_CONTROL, PASSWORD_ADMIN);
	    		break;
	    	default:
	    		$allowed_pwds = array($user_password);
	    		break;
	    }
	}

	if ( empty($_POST['password']) || !in_array($_POST['password'], $allowed_pwds) )
	{
	    	$userIsLoggedIn = false;
	    	$passwordError = 'block';
	}

	if ( !isset($_POST['site']) )
	{
	    $siteError = 'block';
	    $userIsLoggedIn = false;
	}
	else
	{
	    $postData = explode('|', $_POST['site']);
	    $site_id  = intval($postData[0]);
	    $site     = $postData[1];
	}

	if ( $user_level >= 2 && $_POST['password'] === PASSWORD_CONTROL )
	{
		$connect_control = true;
	}

	if ( $user_level === 3 && $_POST['password'] === PASSWORD_ADMIN )
	{
		$connect_admin  = true;
	}

    if ( $userIsLoggedIn )
    {
    	if ( $connect_control )
	    {
	    	session_start();
	    	$_SESSION['user-alias'] = $user_alias;
	    	$_SESSION['site_id']    = $site_id;
	    	$_SESSION['user-level'] = $user_level;

	    	// Contrôle de l'existence de l'utilisateur en bdd
		    $check_user = checkIfUserExist($user_alias, $site_id) ? updateUser($user_alias, $site_id) : insertNewUser($user_alias, $site_id);

	    	header('Location: checkInputs.php');
	    	exit();
	    }
	    elseif ( $connect_admin )
	    {
	    	session_start();
	    	$_SESSION['user-alias'] = $user_alias;
	    	$_SESSION['site_id'] = $site_id;
	    	$_SESSION['user-level'] = $user_level;

		    $check_user = checkIfUserExist($user_alias, $site_id) ? updateUser($user_alias, $site_id) : insertNewUser($user_alias, $site_id);

	    	header('Location: admin/admin.php');
	    	exit();
	    }
	    else
	    {
	    	session_start();
		    $_SESSION['user-alias'] = $user_alias;
		    $_SESSION['site'] = $site;
		    $_SESSION['site_id'] = $site_id;
		    $_SESSION['user-level'] = $user_level;

		    $check_user = checkIfUserExist($user_alias, $site_id) ? updateUser($user_alias, $site_id) : insertNewUser($user_alias, $site_id);
		    
		    header('Location: stockInput.php');
			exit();
	    }
    }
}