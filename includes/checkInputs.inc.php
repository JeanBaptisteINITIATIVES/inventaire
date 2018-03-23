<?php
// Session
if ( $_SESSION['user-level'] < 2 )
{
	header('Location: config/disconnect.php');
	exit();
}

// Pour le navbar
$page = $_SERVER['REQUEST_URI'];

// Initialisation variables
$list_input    = array();
$list_sites    = getInventorySites();
$isRefValid    = false;

if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
	$_POST['input-site'] 	  = checkInput($_POST['input-site']);
	$_SESSION['site-control'] = $_POST['input-site'];
	$_POST['search-ref'] 	  = checkInput($_POST['search-ref']);
	$site_id 	   			  = getSiteId($_POST['input-site']);

	$_POST['input-site'] === 'tous les sites' ? $list_users_id = getUsersIdOnAllSites() : $list_users_id = getUsersIdOnSite($site_id);
	
	if ( $_POST['tracking'] === 'stock' )
	{
		$req = 'SELECT i.quantity AS quantity, i.status AS status, i.observations AS observations, i.user_id AS user_id, i.date_create AS date_input, l.num_location AS location, p.reference AS reference, p.designation AS designation, u.site_id AS site_id
			    FROM stock_input AS i
			    INNER JOIN location AS l
			    ON i.location_id = l.id
			    INNER JOIN products AS p
			    ON i.product_id = p.id
			    INNER JOIN users AS u
			    ON i.user_id = u.id
			    WHERE i.user_id = :users_id';

		if ( isset($_POST['search-ref']) && checkIfReferenceExist($_POST['search-ref']) )
		{
			$isRefValid = true;

			$req .= ' AND p.reference = :reference';

			$result = $db->prepare($req);

			foreach ( $list_users_id as $users )
			{
				$result->bindParam(':users_id', $users['id'], PDO::PARAM_INT);
				$result->bindParam(':reference', $_POST['search-ref'], PDO::PARAM_INT);
				$result->execute();

				while ( $row = $result->fetch() )
				{
					$list_input[] = $row;
				}

				$result->closeCursor();
			}
		}
		else
		{
			$result = $db->prepare($req);

			foreach ( $list_users_id as $users )
			{
				$result->bindParam(':users_id', $users['id'], PDO::PARAM_INT);
				$result->execute();

				while ( $row = $result->fetch() )
				{
					$list_input[] = $row;
				}

				$result->closeCursor();
			}
		}
	}
	else
	{
		$req = 'SELECT i.reference AS reference, i.designation AS designation, i.quantity AS quantity, i.status AS status, i.observations AS observations, i.user_id AS user_id, i.date_create AS date_input, l.num_location AS location, u.site_id AS site_id
				FROM free_input AS i
				INNER JOIN location AS l
			    ON i.location_id = l.id
			    INNER JOIN users AS u
			    ON i.user_id = u.id
				WHERE user_id = :users_id';

		$result = $db->prepare($req);

		foreach ( $list_users_id as $users )
		{
			$result->bindParam(':users_id', $users['id'], PDO::PARAM_INT);
			$result->execute();

			while ( $row = $result->fetch() )
			{
				$list_input[] = $row;
			}

			$result->closeCursor();
		}
	}	
}

// Affichage de la recherche
$search_site = isset($_SESSION['site-control']) ? "sur <span class='infos-search'>" . $_SESSION['site-control'] : "";
$search_ref  = !empty($_POST['search-ref']) && $isRefValid ? " pour la référence <span class='infos-search'>" . $_POST['search-ref'] : "";


