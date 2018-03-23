<?php

// -----------------------------------------------------------------------
// Vérification de l'existence de l'utilisateur à la connexion
// -----------------------------------------------------------------------
function checkIfUserExist($alias, $site_id)
{
	global $db;

	$req = $db->prepare('SELECT au.alias, u.site_id
    					 FROM allowed_users AS au
    					 INNER JOIN users AS u
    					 ON au.id = u.allowed_users_id
    					 WHERE au.alias = :username AND u.site_id = :site');
	
	$req->bindParam(':username', $alias, PDO::PARAM_STR);
	$req->bindParam(':site', $site_id, PDO::PARAM_INT);
	
	$req->execute();

	if ( $req->fetch() )
	{
		return true;
	}
	else
	{ 
		return false;
	}

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Vérification si l'alias existe en bdd
// -----------------------------------------------------------------------
function checkIfAliasExist($alias)
{
	global $db;

	$req = $db->prepare('SELECT *
						 FROM allowed_users
						 WHERE alias = :alias');

	$req->bindParam(':alias', $alias, PDO::PARAM_STR);

	$req->execute();

	if ( !$req->fetch() )
	{
		return false;
	}
	else
	{
		return true;
	}

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Vérification si l'emplacement existe en bdd
// -----------------------------------------------------------------------
function checkIfLocationExist($location)
{
	global $db;

	$req = $db->prepare('SELECT num_location
					     FROM location
					     WHERE num_location = :location');

	$req->bindParam(':location', $location, PDO::PARAM_STR);

	$req->execute();

	if ( !$req->fetch() )
	{
		return false;
	}
	else
	{
		return true;
	}

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Vérification si la référence existe en bdd
// -----------------------------------------------------------------------
function checkIfReferenceExist($reference)
{
	global $db;

	$req = $db->prepare('SELECT reference
					     FROM products
					     WHERE reference = :reference');

	$req->bindParam(':reference', $reference, PDO::PARAM_STR);

	$req->execute();

	if ( !$req->fetch() )
	{
		return false;
	}
	else
	{
		return true;
	}

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Vérification si la désignation existe en bdd
// -----------------------------------------------------------------------
function checkIfDesignationExist($designation)
{
	global $db;

	$req = $db->prepare('SELECT designation
					     FROM products
					     WHERE designation = :designation');

	$req->bindParam(':designation', $designation, PDO::PARAM_STR);

	$req->execute();

	if ( !$req->fetch() )
	{
		return false;
	}
	else
	{
		return true;
	}

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Vérification si la saisie existe au même emplacement, même statut
// -----------------------------------------------------------------------
function checkIfInputExist($location_id, $product_id, $status, $user_id)
{
	global $db;

	$req = $db->prepare('SELECT COUNT(*) AS count
						 FROM stock_input
						 WHERE location_id = :location_id
						 AND product_id = :product_id
						 AND status = :status
						 AND user_id = :user_id');

	$req->bindParam(':location_id', $location_id, PDO::PARAM_INT);
	$req->bindParam(':product_id', $product_id, PDO::PARAM_INT);
	$req->bindParam(':status', $status, PDO::PARAM_STR);
	$req->bindParam(':user_id', $user_id, PDO::PARAM_INT);

	$req->execute();

	$result = $req->fetch();

	if ( $result['count'] >= 1 ) // Le produit existe déjà à cet emplacement
	{
		return true;
	}
	else
	{
		return false;
	}

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Récupération du niveau d'authorisation de l'utilisateur
// -----------------------------------------------------------------------
function getUserLevel($alias)
{
	global $db;

	$req = $db->prepare('SELECT user_level
						 FROM allowed_users
						 WHERE alias = :alias');

	$req->bindParam(':alias', $alias, PDO::PARAM_STR);

	$req->execute();

	$result = $req->fetch();

	$req->closeCursor();

	return $result['user_level'];
}


// -----------------------------------------------------------------------
// Récupération du nom associé à l'alias
// -----------------------------------------------------------------------
function getUsernameByAlias($alias)
{
	global $db;

	$req = $db->prepare('SELECT name
						 FROM allowed_users
						 WHERE alias = :alias');

	$req->bindParam(':alias', $alias, PDO::PARAM_STR);

	$req->execute();

	$result = $req->fetch();

	$req->closeCursor();

	return $result['name'];
}


// -----------------------------------------------------------------------
// Récupération du nom associé à l'ID de l'utilisateur
// -----------------------------------------------------------------------
function getUsernameByUserId($user_id)
{
	global $db;

	$req = $db->prepare('SELECT au.name AS username
						 FROM allowed_users AS au
						 INNER JOIN users AS u
						 ON au.id = u.allowed_users_id
						 WHERE u.id = :user_id');

	$req->bindParam(':user_id', $user_id, PDO::PARAM_INT);

	$req->execute();

	$result = $req->fetch();

	$req->closeCursor();

	return $result['username'];
}


// -----------------------------------------------------------------------
// Récupération de la liste des sites
// -----------------------------------------------------------------------
function getSites()
{
	global $db;

	$list_sites = array();

	$req = $db->query('SELECT id, code_site FROM sites');

	while ( $row = $req->fetch() )
	{
		$list_sites[] = $row;
	}

	$req->closeCursor();

	return $list_sites;
}


// -----------------------------------------------------------------------
// Récupération de la liste des sites inventoriés
// -----------------------------------------------------------------------
function getInventorySites()
{
	global $db;

	$list_sites = array();

	$req = $db->query('SELECT DISTINCT s.code_site AS code_site
					   FROM sites AS s
					   INNER JOIN users AS u
					   ON s.id = u.site_id');

	while ( $row = $req->fetch() )
	{
		$list_sites[] = $row;
	}

	$req->closeCursor();

	return $list_sites;
}



// -----------------------------------------------------------------------
// Récupération du dernier emplacement saisi (stock)
// -----------------------------------------------------------------------
function getLastStockLocation($user_id)
{
	global $db;

	$req = $db->prepare('SELECT num_location
						 FROM location
						 WHERE id = (SELECT location_id
									 FROM stock_input
									 WHERE id = (SELECT MAX(id)
									 			 FROM stock_input
									 			 WHERE user_id = :user_id))');	

	$req->bindParam(':user_id', $user_id, PDO::PARAM_INT);

	$req->execute();

	$last_location = $req->fetch();

	if ( isset($last_location['num_location']) )
	{
		return $last_location['num_location'];
	}
	else
	{
		return "";
	}

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Récupération du dernier emplacement saisi (libre)
// -----------------------------------------------------------------------
function getLastFreeLocation($user_id)
{
	global $db;

	$req = $db->prepare('SELECT num_location
						 FROM location
						 WHERE id = (SELECT location_id
									 FROM free_input
									 WHERE id = (SELECT MAX(id)
									 			 FROM free_input
									 			 WHERE user_id = :user_id))');	

	$req->bindParam(':user_id', $user_id, PDO::PARAM_INT);

	$req->execute();

	$last_location = $req->fetch();

	if ( isset($last_location['num_location']) )
	{
		return $last_location['num_location'];
	}
	else
	{
		return "";
	}

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Récupération de l'emplacement
// -----------------------------------------------------------------------
function getLocation($location_id)
{
	global $db;

	$req = $db->prepare('SELECT num_location
						 FROM location
						 WHERE id = :location_id');

	$req->bindParam(':location_id', $location_id, PDO::PARAM_INT);

	$req->execute();

	$result = $req->fetch();

	return $result['num_location'];

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Récupération de l'ID de l'emplacement
// -----------------------------------------------------------------------
function getLocationId($num_location)
{
	global $db;

	$req = $db->prepare('SELECT id
						 FROM location
						 WHERE num_location = :num_location');

	$req->bindParam(':num_location', $num_location, PDO::PARAM_STR);

	$req->execute();

	$result = $req->fetch();

	return $result['id'];

	$req->closeCursor();;
}


// -----------------------------------------------------------------------
// Récupération de l'ID du produit
// -----------------------------------------------------------------------
function getProductId($reference, $designation)
{
	global $db;

	$req = $db->prepare('SELECT id
						 FROM products
						 WHERE reference = :reference
						 AND designation = :designation');

	$req->bindParam(':reference', $reference, PDO::PARAM_STR);
	$req->bindParam(':designation', $designation, PDO::PARAM_STR);

	$req->execute();

	$result = $req->fetch();

	return $result['id'];

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Récupération de l'id du site
// -----------------------------------------------------------------------
function getSiteId($site)
{
	global $db;

	$req = $db->prepare('SELECT id
						 FROM sites
						 WHERE code_site = :site');

	$req->bindParam(':site', $site, PDO::PARAM_STR);

	$req->execute();

	$result = $req->fetch();

	return $result['id'];

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Récupération du code site
// -----------------------------------------------------------------------
function getSite($site_id)
{
	global $db;

	$req = $db->prepare('SELECT code_site
						 FROM sites
						 WHERE id = :site_id');

	$req->bindParam(':site_id', $site_id, PDO::PARAM_INT);

	$req->execute();

	$result = $req->fetch();

	return $result['code_site'];

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Récupération de l'ID de l'utilisateur
// -----------------------------------------------------------------------
function getUserId($alias, $site_id)
{
	global $db;

	$req = $db->prepare('SELECT au.alias, u.id AS id, u.site_id
    					 FROM allowed_users AS au
    					 INNER JOIN users AS u
    					 ON au.id = u.allowed_users_id
    					 WHERE au.alias = :alias AND u.site_id = :site_id');

	$req->bindParam(':alias', $alias, PDO::PARAM_STR);
	$req->bindParam(':site_id', $site_id, PDO::PARAM_INT);

	$req->execute();

	$result = $req->fetch();

	return $result['id'];

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Récupération des utilisateurs pour un site
// -----------------------------------------------------------------------
function getUsersIdOnSite($site_id)
{
	global $db;

	$list_users_id = array();

	$req = $db->prepare('SELECT id
						 FROM users
						 WHERE site_id = :site_id');

	$req->bindParam(':site_id', $site_id, PDO::PARAM_INT);

	$req->execute();

	while ( $row = $req->fetch() )
	{
		$list_users_id[] = $row;
	}
	
	$req->closeCursor();

	return $list_users_id;
}

// -----------------------------------------------------------------------
// Récupération des utilisateurs sur tous les sites
// -----------------------------------------------------------------------
function getUsersIdOnAllSites()
{
	global $db;

	$list_users_id = array();

	$req = $db->prepare('SELECT id
						 FROM users');

	$req->execute();

	while ( $row = $req->fetch() )
	{
		$list_users_id[] = $row;
	}
	
	$req->closeCursor();

	return $list_users_id;
}


// -----------------------------------------------------------------------
// Récupération des saisies de produits en stock de l'utilisateur connecté
// -----------------------------------------------------------------------
function getUserStockInputs($user_id)
{
	global $db;

	$list_input = array();

	$req = $db->prepare('SELECT i.id AS id, i.quantity AS quantity, i.status AS status, i.observations AS observations, i.user_id AS user_id, i.date_create AS date_input, l.num_location AS location, p.reference AS reference, p.designation AS designation
						 FROM stock_input AS i
						 INNER JOIN location AS l
						 ON i.location_id = l.id
						 INNER JOIN products AS p
						 ON i.product_id = p.id
						 WHERE i.user_id = :user_id');
	
	$req->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	
	$req->execute();
	
	while ( $row = $req->fetch() )
	{
		$list_input[] = $row;
	}
	
	$req->closeCursor();

	return $list_input;
}


// -----------------------------------------------------------------------
// Récupération des saisies libres de l'utilisateur connecté
// -----------------------------------------------------------------------
function getUserFreeInputs($user_id)
{
	global $db;
	global $list_input;

	$list_input = array();

	$req = $db->prepare('SELECT i.id AS id, l.num_location AS location, i.reference AS reference, i.designation AS designation, i.quantity AS quantity, i.status AS status, i.observations AS observations, i.date_create AS date_input, i.user_id AS user_id
						 FROM free_input AS i
						 INNER JOIN location AS l
						 ON i.location_id = l.id
						 WHERE user_id = :user_id');
	
	$req->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	
	$req->execute();
	
	while ( $row = $req->fetch() )
	{
		$list_input[] = $row;
	}
	
	$req->closeCursor();

	return $list_input;
}


// -----------------------------------------------------------------------
// Récupération du mot de passe de l'utilisateur
// -----------------------------------------------------------------------
function getUserPassword($user_alias)
{
	global $db;

	$req = $db->prepare('SELECT password
						 FROM allowed_users
						 WHERE alias = :user_alias');
	
	$req->bindParam(':user_alias', $user_alias, PDO::PARAM_STR);
	
	$req->execute();
	
	$result = $req->fetch();
	
	$req->closeCursor();

	return $result['password'];
}


// -----------------------------------------------------------------------
// Insertion infos de connexion de l'utilisateur en bdd
// -----------------------------------------------------------------------
function insertNewUser($alias, $site_id)
{
	global $db;

	$req = $db->prepare('INSERT INTO users(allowed_users_id, site_id, date_connection, online, last_activity)
					     SELECT allowed_users.id, :site, NOW(), 1, NOW()
					     FROM allowed_users
					     WHERE allowed_users.id = (SELECT id FROM allowed_users WHERE alias = :username)');
    
    $req->bindParam(':username', $alias, PDO::PARAM_STR);
    $req->bindParam(':site', $site_id, PDO::PARAM_INT);
    
    $req->execute();

    $req->closeCursor();
}


// -----------------------------------------------------------------------
// Insertion saisie stock de l'utilisateur
// -----------------------------------------------------------------------
function insertStockInput($quantity, $status, $observations, $location, $product_id, $user_id)
{
	global $db;

	$req = $db->prepare('INSERT INTO stock_input(location_id, product_id, quantity, status, observations, user_id, date_create)
						 SELECT location.id, products.id, :quantity, :status, :observations, users.id, NOW()
						 FROM location, products, users
						 WHERE location.num_location = :location
						 AND products.id = :product_id
						 AND users.id = :user_id');
    
    $req->bindParam(':quantity', $quantity, PDO::PARAM_INT);
	$req->bindParam(':status', $status, PDO::PARAM_STR);
	$req->bindParam(':observations', $observations, PDO::PARAM_STR);
	$req->bindParam(':location', $location, PDO::PARAM_STR);
	$req->bindParam(':product_id', $product_id, PDO::PARAM_INT);
	$req->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    
    $req->execute();

    $req->closeCursor();
}


// -----------------------------------------------------------------------
// Insertion saisie libre de l'utilisateur
// -----------------------------------------------------------------------
function insertFreeInput($reference, $designation, $quantity, $status, $observations, $location, $user_id)
{
	global $db;

	$req = $db->prepare('INSERT INTO free_input(location_id, reference, designation, quantity, status, observations, user_id, date_create)
						 SELECT location.id, :reference, :designation, :quantity, :status, :observations, users.id, NOW()
						 FROM location, users
						 WHERE location.num_location = :location
						 AND users.id = :user_id');
    
    $req->bindParam('reference', $reference, PDO::PARAM_STR);
	$req->bindParam('designation', $designation, PDO::PARAM_STR);
    $req->bindParam(':quantity', $quantity, PDO::PARAM_INT);
	$req->bindParam(':status', $status, PDO::PARAM_STR);
	$req->bindParam(':observations', $observations, PDO::PARAM_STR);
	$req->bindParam(':location', $location, PDO::PARAM_STR);
	$req->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    
    $req->execute();

    $req->closeCursor();
}


// -----------------------------------------------------------------------
// Mise à jour infos de connexion utilisateur en bdd
// -----------------------------------------------------------------------
function updateUser($alias, $site_id)
{
	global $db;

	$req = $db->prepare('UPDATE users
						 INNER JOIN allowed_users
						 ON users.allowed_users_id = allowed_users.id
						 SET date_connection = NOW(), online = 1, last_activity = NOW()
						 WHERE allowed_users_id = (SELECT id FROM allowed_users WHERE alias = :alias)
						 AND site_id = :site_id');
			
	$req->bindParam(':alias', $alias, PDO::PARAM_STR);
	$req->bindParam(':site_id', $site_id, PDO::PARAM_INT);
	
	$req->execute();

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// déconnexion de l'utilisateur en bdd
// -----------------------------------------------------------------------
function disconnectUser($alias)
{
	global $db;

	$req = $db->prepare('UPDATE users
						 SET online = 0
						 WHERE allowed_users_id = (SELECT id
						 						   FROM allowed_users
						 						   WHERE alias = :alias)');
	
	$req->bindParam(':alias', $alias, PDO::PARAM_STR);
	
	$req->execute();

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Récupération de la dernière activité de l'utilisateur
// -----------------------------------------------------------------------
function getLastActivity($alias)
{
	global $db;

	$req = $db->prepare('SELECT UNIX_TIMESTAMP(last_activity)
						 FROM users
						 WHERE allowed_users_id = (SELECT id
						 						   FROM allowed_users
						 						   WHERE alias = :alias)');
	
	$req->bindParam(':alias', $alias, PDO::PARAM_STR);
	
	$req->execute();

	$result = $req->fetch();

	return $result['UNIX_TIMESTAMP(last_activity)'];

	$req->closeCursor();
}


// -----------------------------------------------------------------------
// Mise à jour dernière activité de l'utilisateur
// -----------------------------------------------------------------------
function updateLastActivity($alias)
{
	global $db;

	$req = $db->prepare('UPDATE users
						 SET last_activity = NOW()
						 WHERE allowed_users_id = (SELECT id
						 						   FROM allowed_users
						 						   WHERE alias = :alias)');
	
	$req->bindParam(':alias', $alias, PDO::PARAM_STR);
	
	$req->execute();

	$req->closeCursor();
}

?>