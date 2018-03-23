<?php

$search_result = array();

if ( isset($_POST['search-product']) && $_POST['search-product'] != NULL )
{
	$search = checkInput($_POST['search-product']);

	$req = 'SELECT reference, designation, ';

	if ( $_POST['search-by'] == 'des' )
	{
		$req .= 'MATCH(designation) AGAINST (:search IN BOOLEAN MODE) AS score
	 			 FROM products
	 			 WHERE MATCH (designation)
	 		 	 AGAINST (:search IN BOOLEAN MODE)';
	}
	else
	{
		$req .= 'MATCH(reference) AGAINST (:search IN BOOLEAN MODE) AS score
	 			 FROM products
	 			 WHERE MATCH (reference)
	 		 	 AGAINST (:search IN BOOLEAN MODE)';
	}
		    
	if ( $_POST['tracking-stock'] == 'tracked' )
	{
		$req .= ' AND stock = -1
				  ORDER BY score DESC';
	}
	else
	{
		$req .= ' AND stock = 0
				  ORDER BY score DESC';
	}

	$results = $db->prepare($req);
	// print_r($req);
	$results->bindParam(':search', $search, PDO::PARAM_STR);

	$results->execute();
	// print_r($results);
	while ( $row = $results->fetch() )
	{
		$search_result[] = $row;
	}
}

// Affichage résultat recherche
if ( !empty($_POST['search-product']) )
{
	$title_search = "pour <span class='infos-search'>" . $_POST['search-product'];
}