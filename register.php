<?php
session_start();
require_once './conn.php';

if (empty($_POST['nickname']) || 
    empty($_POST['username']) || 
    empty($_POST['password'])
) {
  die('仍有未填寫資料');
}

$nickname = $_POST['nickname'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
// $sql = sprintf(
//   "INSERT INTO users (nickname, username, password) VALUES ('%s', '%s', '%s')",
//   $nickname, $username, $password
// );
$sql = "INSERT INTO users (nickname, username, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $nickname, $username, $password);
$result = $stmt->execute();

if (!$result) {
  die($conn->error);
}
$_SESSION['username'] = $username;
header('Location: index.php');
