<?php
require_once('../config/load.php');

// Récupération des données du formulaire du modal
$id = $_POST['delete-id'];

// Modification des infos dans la bdd
$req = $db->prepare('DELETE FROM stock_input WHERE id = :id');

$req->bindParam(':id', $id, PDO::PARAM_INT);

$req->execute();

$req->closeCursor();