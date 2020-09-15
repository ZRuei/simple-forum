<?php
session_start();
require_once './conn.php';
require_once './functions.php';

if (empty($_POST['content'])) {
  die('仍有未填寫資料');
}

$content = $_POST['content'];
$user = getUserByUsername($_SESSION['username']);
$nickname = $user['nickname'];
$user_id = $user['id'];

// $sql = sprintf(
//   "INSERT INTO comments (nickname, content) VALUES ('%s', '%s')",
//   $nickname, $content
// );

$sql = "INSERT INTO comments (user_id, content) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $user_id, $content);
$result = $stmt->execute();

if (!result) {
  die($conn->error);
}

header('Location: index.php');