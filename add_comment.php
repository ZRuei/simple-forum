<?php
require_once 'functions.php';
require_once 'check_login.php';

header('Content-Type: application/json; charset=utf-8');

if (empty($_POST['content'])) {
  $json = array(
    'ok' => false, 
    'message' => '請輸入內容'
  );
  $res = json_encode($json);
  echo $res;
  die();
}

$content = $_POST['content'];
$user_id = $user['id'];
$is_deleted = 0;

$sql = "INSERT INTO comments (user_id, content, is_deleted) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('isi', $user_id, $content, $is_deleted);
$result = $stmt->execute();

if (!$result) {
  $json = array(
    'ok' => false,
    'message' => '連線發生錯誤，請稍後再試'
  );

  $response = json_encode($json);
  echo $response;
  die();
}

$new_comment_id = $stmt->insert_id;
$new_comment_sql = "SELECT comments.id, comments.content, comments.created_at, users.nickname
                    FROM comments LEFT JOIN users ON users.id = comments.user_id WHERE comments.id = ?";
$new_comment_stmt = $conn->prepare($new_comment_sql);
$new_comment_stmt->bind_param('i', $new_comment_id);
$new_comment_result = $new_comment_stmt->execute();

if (!$new_comment_result) {
  $json = array(
    'ok' => false,
    'message' => '發生錯誤，請稍後再試'
  );

  $response = json_encode($json);
  echo $response;
  die();
}
$new_comment_result = $new_comment_stmt->get_result();
$row = $new_comment_result->fetch_assoc();

$json = array(
  'ok' => true,
  'message' => '留言已發佈',
  'id' => $row['id'],
  'nickname' => $row['nickname'],
  'content' => $row['content'],
  'createdAt' => $row['created_at']
);
$response = json_encode($json);
echo $response;



// header('Location: index.php');