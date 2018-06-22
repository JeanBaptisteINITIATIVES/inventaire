<?php
require_once('../config/load.php');

// $req1 = $db->prepare('ALTER TABLE users NOCHECK CONSTRAINT ALL');
// $req1->execute();
// $req1->closeCursor();

$req2 = $db->prepare('DELETE FROM stock_input');
$req2->execute();
$req2->closeCursor();

$req3 = $db->prepare('DELETE FROM free_input');
$req3->execute();
$req3->closeCursor();

$req4 = $db->prepare('DELETE FROM users');
$req4->execute();
$req4->closeCursor();





