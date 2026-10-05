<?php
require_once 'config.php';

// Session variables ko clear karein
$_SESSION = array();

// Session ko destroy karein
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// Home page par redirect karein
header("Location: index.php");
exit();
?>