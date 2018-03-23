<?php
session_start();

require_once('load.php');

disconnectUser($_SESSION['user-alias']);

unset($_SESSION);
session_destroy();
// $_SESSION = array();
// if (ini_get("session.use_cookies"))
// {
//     $params = session_get_cookie_params();
//     setcookie(session_name(), '', time() - 42000,
//         $params["path"], $params["domain"],
//         $params["secure"], $params["httponly"]
//     );
// }
// session_destroy();

if ( basename($_SERVER['HTTP_REFERER']) === 'admin.php' )
{
	deleteCsvFiles('../admin/csv', 'csv');
}

Database::disconnect();

header('Location: ../index.php');
exit();