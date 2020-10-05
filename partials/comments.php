<?php
require_once './functions.php';

$current_page = 1;
if (!empty($_GET['page'])) {
  $current_page = intval($_GET['page']);
}
$limit = 8;
$offset = ($current_page - 1) * $limit;
// 取得所有留言 
// 限制單頁顯示筆數
$sql = "SELECT comments.id, comments.user_id, comments.content, comments.created_at, users.nickname, users.username 
        FROM comments LEFT JOIN users 
        ON users.id = comments.user_id
        WHERE is_deleted = 0
        ORDER BY comments.created_at DESC
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $limit, $offset);
$result = $stmt->execute();

if (!$result) {
  die('發生錯誤，請稍後再試');
}

$result = $stmt->get_result();

?>

<div class="message-cards">
<?php while ($row = $result->fetch_assoc()) : ?>
  <div class="card">
    <div class="avatar"><img src="#" alt=""></div>
    <div class="message">
      <div class="message__info">
        <div class="message__info--author">
          By <span><?= escape($row['nickname']) ?></span> <span><?= escape($row['created_at']) ?></span>
          <?php include 'buttons.php' ?>
        </div>
      </div>
      <div class="message__content">
        <?= escape($row['content']) ?>
      </div>
    </div>
  </div>
<?php endwhile ?>
</div>