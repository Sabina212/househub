<?php

session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Delete session cookie
if (ini_get("session.use_cookies")) {

    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Delete application cookies if you have created any
setcookie("user_id", "", time() - 3600, "/");
setcookie("email", "", time() - 3600, "/");
setcookie("remember_token", "", time() - 3600, "/");

// Redirect to homepage
header("Location: index.php");
exit();

?>