<?php
session_start();
require_once './conn.php';
require_once './functions.php';

$comment_id = $_GET['id'];
$username = NULL;
if(!empty($_SESSION['username'])) {
  $username = $_SESSION['username'];
}

$sql = "SELECT comments.content, users.username 
        FROM comments LEFT JOIN users 
        ON users.id = comments.user_id 
        WHERE comments.id = ? AND users.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $comment_id, $username);
$result = $stmt->execute();
if (!$result) {
  die('ERROR: '. $conn->error);
}
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;1,300;1,500&display=swap" rel="stylesheet">   
  <title>編輯留言</title>
</head>
<body>
  <div class="container">
  <h2>編輯留言</h2>
    <form action="./update_comment.php" method="POST">

        <div class="input-area">
          <textarea name="content"><?= escape($row['content']); ?></textarea>
          <input type="hidden" name="id" value="<?= $comment_id ?>">
          <button type="submit">發佈</button>
        </div>
  
      </form>
      <a href="./index.php">返回</a>
    </div>
</body>
</html>