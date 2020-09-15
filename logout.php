<?php
// require_once './conn.php';

// $token = $_COOKIE['token'];
// $sql = sprintf(
//   "DELETE FROM tokens WHERE token = '%s'",
//   $token
// );

// setcookie('token', '', time()-3600);
session_start();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(
    session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
  );
}
session_destroy();
header('Location: index.php');