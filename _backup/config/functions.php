<?php

// -----------------------------------------------------------------------
// Vérification champs input
// -----------------------------------------------------------------------
function checkInput($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_NOQUOTES);
	return $data;
}


// -----------------------------------------------------------------------
// Contrôle d'une quantité saisie
// -----------------------------------------------------------------------
function isValidQuantity($quantity)
{
	if ( !is_numeric($quantity) || empty($quantity) || $quantity <= 0 )
	{
		return false;
	}
	else
	{
		return true;
	}
}


// -----------------------------------------------------------------------
// Création fichier CSV avec infos de la recherche admin
// -----------------------------------------------------------------------
function array_to_csv(array $datas, $site)
{
    global $handle;

    $handle    = 'csv/inventory_' . $site . '.csv';
    $tmp 	   = fopen($handle, 'w+');
    $delimiter = ';';
    $enclosure = '*';
    
    foreach( $datas as $data )
    {
        fputcsv($tmp, $data, $delimiter, $enclosure);
    }
    
    rewind($tmp);
    
    $datas = $data = '';
    
    while( FALSE != ($data = fgets($tmp)) )
    {
        $datas .= $data;
    }
    
    fclose($tmp);

    $replace = str_replace("*", "", file_get_contents($handle) );
	
	file_put_contents($handle, $replace);
    
    return $datas;
}


// -----------------------------------------------------------------------
// Fonction qui efface tous les fichiers .csv d'un répertoire
// -----------------------------------------------------------------------
function deleteCsvFiles($folder , $extension_to_delete)
{
    // On ouvre le dossier.
    $target = opendir($folder);
    // On lance notre boucle qui lira les files un par un.
    while( false !== ($file = readdir($target)) )
    {
        // On met le chemin du dossier dans une variable simple
        $path = $folder . "/" . $file;
        
        // Les variables qui contiennent toutes les infos nécessaires
        $infos = pathinfo($path);
        $extension = $infos['extension'];
        
        if( $file != "." AND $file != ".." AND !is_dir($file) AND $extension == $extension_to_delete )
        {
            unlink($path);
        }
    }
    closedir($target);
}