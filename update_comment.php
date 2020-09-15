<?php
session_start();
require_once './conn.php';
require_once './functions.php';

if (empty($_POST['content'])) {
  die('仍有未填寫資料');
}

$content = $_POST['content'];
$comment_id = $_POST['id'];
$user = getUserByUsername($_SESSION['username']);
$user_id = $user['id'];

$sql = "UPDATE comments SET content = ? WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sii', $content, $comment_id, $user_id);
$result = $stmt->execute();

if (!result) {
  die('ERROR: '. $conn->error);
}

header('Location: index.php');