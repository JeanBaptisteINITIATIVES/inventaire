<?php
session_start();
require_once('../config/load.php');

$user          = $_SESSION['user-alias'];
$site_id       = $_SESSION['site_id'];
$power_site_id = $_SESSION["power-site-id"];
$list_users = getAllowedUsers();

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

// if ( isset($_SESSION['timestamp']) )
// {
//     if( $_SESSION['timestamp'] + 1800 > time() )
//     {    
//         $_SESSION['timestamp'] = time();
//         updateLastActivity($_SESSION['timestamp']);
//     }
//     else
//     {
//     	header('Location: ../config/disconnect.php');
//     	exit();
//     }
// }
// else { $_SESSION['timestamp'] = getLastActivity($_SESSION['user-alias']); }

$list_input    = array();
$export        = array();

if ( $_SERVER["REQUEST_METHOD"] === "POST" )
{
    $_SESSION["error"] = "";
    $_SESSION["final-message"] = "";
    $user_import = $_POST["user"];
    
    // ---------- Gestion import données -------------- 
    
    if ( file_exists($_FILES["import-file"]["tmp_name"]) && !empty($_POST['user']))
    {
        $file      = $_FILES["import-file"]["name"];
        $path_file = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    
        if ( $path_file != "csv" )
        {
            $_SESSION["error"] .= "Extension de fichier non-autorisée.";
        }
        else
        // Test de l'intégrité du fichier
        {
            // $allowed_status = ["A", "Q", "R"];
            $counter = 0;
            
            $f1 = fopen($_FILES["import-file"]["tmp_name"], "r");
    
            while ( !feof($f1) )
            {
                $row = fgets($f1, 4096);
                // print_r($row);
                $list = explode("|", $row);
            
                if ( !empty($row) )
                {
                    $list[0] = isset($list[0]) ? $list[0] : ""; // référence
                    $list[1] = isset($list[1]) && is_numeric($list[1]) && $list[1] > 0 ? $list[1] : 0; // quantité
                    // $list[2] = !empty($list[2]) ? $list[2] : "A"; // statut
                    $list[3] = isset($list[3]) ? $list[3] : ""; // observations
                    // $list[5] = isset($list[5]) ? $list[5] : $import_site; // site

                    if ( $list[0] == "" )
                    {
                        $_SESSION["error"] .= "Référence vide sur la ligne " . ($counter + 1) . "<br/>";
                    }
                    else if ( !checkIfReferenceExist($list[0]) )
                    {
                        $_SESSION["error"] .= "Référence de suivi stock inexistante sur la ligne " . ($counter + 1) . "<br/>";
                    }
                    else if ( $list[1] == 0 )
                    {
                        $_SESSION["error"] .= "Erreur de quantité sur la ligne " . ($counter + 1) . "<br/>";
                    }
                    
                    $counter++;
                }
            }
            fclose($f1);
        
            // On enregistre en bdd si tout est OK
            if ( $_SESSION["error"] == "" )
            {    
                $user_alias = getAliasByName($user_import);
                $_SESSION["user-alias-import"] = $user_alias;
                $check_user = checkIfUserExist($user_alias, $site_id) ? updateUser($user_alias, $site_id) : insertNewUser($user_alias, $site_id);                
                
                // echo $user_import;
                // echo $user_alias;
                // echo $site_id;

                $f2 = fopen($_FILES["import-file"]["tmp_name"], "r");
                
                $counter = 0;
                
                while ( !feof($f2) )
                {
                    $row = fgets($f2, 4096);
                    // print_r($row);
                    $list = explode("|", $row);
                    // print_r($list);
                    
                    if ( !empty($row) )
                    {
                        // print_r($list[2]);
                        // $list[2] = $list[2] != "" ? $list[2] : "A"; // statut
                        $list[3] = isset($list[3]) ? $list[3] : ""; // observations
                        // echo $list[3];
                        
                        $reference = $list[0];
                        $designation = getDesignation($reference);
                        $observations = $list[3];
                        $quantity = $list[1];
                        $status = $list[2];
                        
                        $product_id = getProductId($reference, $designation);
                        $user_id = getUserId($user_alias, $site_id);
                        
                        insertStockInput($quantity, $status, $observations, "AUTRE", $product_id, $user_id);
                        
                        $counter++;
                    }
                }
                fclose($f2);
                
                $_SESSION["final-message"] = "Importation réussie de " . $counter . " lignes. Vous pouvez désormais les exporter.";
            }
        }
    }
    else if ( file_exists($_FILES["import-file"]["tmp_name"]) && empty($_POST['user']) )
    {
        $_SESSION["error"] = "Veuillez sélectionner un référent pour cet inventaire.";    
    }
    else
    {
        if ( empty($_POST['admin-input-site']) )
        {
            $_SESSION["error"] = "Veuillez choisir un fichier.";
        }
    }



    // ---------- Gestion affichage saisies ------------

    if ( isset($_POST['admin-input-site']) )
    {
        $_POST['admin-input-site'] = checkInput($_POST['admin-input-site']);
        $_SESSION['site-admin']    = $_POST['admin-input-site'];
        
        $site_id 	   			   = getSiteId($_POST['admin-input-site']);
        $list_users_id 			   = getUsersIdOnSite($site_id);
        
        $req = 'SELECT p.reference AS reference, p.designation AS designation, i.quantity AS quantity, i.status AS status, i.observations AS observations
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
                // $export[] = $row;
                array_push($export, [ $row["reference"], $row["designation"], $row["quantity"], $row["status"], $row["observations"], $_SESSION['site-admin'] ]);
                // echo "<pre>";
                // print_r($export);
                // echo "</pre>";
            }
    
            /*print_r($export);*/
    
            $result->closeCursor();
        }
    
        array_to_csv($export, $_POST['admin-input-site']);
    }
}

$result_search = isset($_SESSION['site-admin']) ? "sur le site <span class='infos-search'>" . $_SESSION['site-admin'] : "";
$style_csv     = isset($_SESSION['site-admin']) ? "block" : "none";
$list_sites    = getInventorySites();