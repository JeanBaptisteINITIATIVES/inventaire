<?php
session_start();
require_once('../config/load.php');

// Session admin
if ( !isset($_SESSION['user-alias']) )
{
	header('Location: ../index.php');
	exit();
}

if ( $_SESSION['user-level'] !== 3 )
{
	header('Location: ../config/disconnect.php');
	exit();
}

if ( isset($_SESSION['timestamp']) )
{
    if( $_SESSION['timestamp'] + 1800 > time() )
    {    
        $_SESSION['timestamp'] = time();
        updateLastActivity($_SESSION['timestamp']);
    }
    else
    {
    	header('Location: ../config/disconnect.php');
    	exit();
    }
}
else { $_SESSION['timestamp'] = getLastActivity($_SESSION['user-alias']); }

$list_input    = array();
$export        = array();

$list_sites    = getInventorySites();

if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
	$_POST['admin-input-site'] = checkInput($_POST['admin-input-site']);
	$_SESSION['site-admin']    = $_POST['admin-input-site'];
	
	$site_id 	   			   = getSiteId($_POST['admin-input-site']);
	$list_users_id 			   = getUsersIdOnSite($site_id);
	
	$req = 'SELECT p.reference AS reference, p.designation AS designation, i.status AS status, i.quantity AS quantity
			FROM stock_input AS i
			INNER JOIN products AS p
			ON i.product_id = p.id
			WHERE i.user_id = :users_id';
	
	$result = $db->prepare($req);

	foreach ( $list_users_id as $users )
	{
		$result->bindParam(':users_id', $users['id'], PDO::PARAM_INT);
		$result->execute();

		while ( $row = $result->fetch(PDO::FETCH_ASSOC) )
		{
			$list_input[] = $row;
			$export[]     = $row;
		}

		/*print_r($export);*/

		$result->closeCursor();
	}

	array_to_csv($export, $_SESSION['site-admin']);
}

$result_search = isset($_SESSION['site-admin']) ? "sur le site <span class='infos-search'>" . $_SESSION['site-admin'] : "";
$style_csv     = isset($_SESSION['site-admin']) ? "block" : "none";