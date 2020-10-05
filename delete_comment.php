<?php
require_once './functions.php';
require_once './check_login.php';

if (empty($_GET['id'])) {
  die();
}

$comment_id = $_GET['id'];
$user_id = $user['id'];

$sql = "UPDATE comments SET is_deleted = 1 WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $comment_id, $user_id);
$result = $stmt->execute();

if (!$result) {
  die('ERROR: ' . $conn->error);
}

$previous_dir = $_SERVER['HTTP_REFERER'];
header("Location: $previous_dir");