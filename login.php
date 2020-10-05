<?php
session_start();

require_once './conn.php';
require_once './functions.php';

if (empty($_POST['username']) || empty($_POST['password'])) {
  die('仍有未填寫資料');
}

$username = $_POST['username'];
$password = $_POST['password'];
// $sql = sprintf(
//   "SELECT * FROM users WHERE username='%s' and password='%s'",
//   $username, $password
// );
// $result = $conn->query($sql);
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param('s', $username);
$result = $stmt->execute();

if (!$result) {
  die($conn->error);
}

$result = $stmt->get_result();
if ($result->num_rows === 0) {
  header('Location: login.php');
  exit();
}

$row = $result->fetch_assoc();

if (password_verify($password, $row['password'])) {
  $_SESSION['username'] = $username;
  header('Location: index.php');
} else {
  header('Location: login.php');
}