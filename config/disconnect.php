<?php
session_start();

require_once('load.php');

if ( $_SESSION['power-site-id'] )
{
    disconnectPowerUser($_SESSION['user-alias']);
    disconnectUser($_SESSION["user-alias-import"], $_SESSION['site_id']);
}
else
{
    disconnectUser($_SESSION['user-alias'], $_SESSION['site_id']);
}

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