<?php
session_start();
require_once './conn.php';
require_once './functions.php';

// 取得登入者的使用者資訊
$username = NULL;
$user = NULL;
// if (!empty($_COOKIE['token'])) {
//   $user = getUsernameByToken($_COOKIE['token']);
//   $username = $user['username'];
// }
if(!empty($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $user = getUserByUsername($username);
}

// 分頁
$current_page = 1;
if (!empty($_GET['page'])) {
  $current_page = intval($_GET['page']);
}
$limit = 3;
$offset = ($current_page - 1) * $limit;

// 取得所有留言 
// 限制單頁顯示筆數
$sql = "SELECT comments.id, comments.user_id, comments.content, comments.created_at, users.nickname, users.username 
        FROM comments LEFT JOIN users 
        ON users.id = comments.user_id
        WHERE is_deleted IS NULL
        ORDER BY comments.created_at DESC
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $limit, $offset);
$result = $stmt->execute();
if (!$result) {
  die('ERROR: '. $conn->error);
}
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;1,300;1,500&display=swap" rel="stylesheet">   
  <title>simple forum</title>
</head>
<body>
  <header>
    <div class="navbar">
      <div class="logo">
        <a href="./index.php">FORUM</a>
      </div>
      <ul class="nav">
        <li><a href="#">所有留言</a></li>
        <li><a href="./my_comments.php">我的留言</a></li>
      </ul>
      <ul class="buttons">
        <!-- <li><a href="#" >飽飽</a></li> -->
        <?php if ($username) : ?>
          <li><a class="btn" href="./logout.php">登出</a></li>
        <?php else : ?>
          <li><a class="btn" href="./register.view.php">註冊</a></li>
          <li><a class="btn" href="./login.view.php">登入</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </header>
  <main>
    <div class="container">
      <form action="./add.php" method="POST">
      <?php if ($username): ?>
        <!-- <div class="nickname">暱稱： <input type="text" name="nickname"></div> -->
        <div class="input-area">
          <textarea placeholder="嗨～<?= escape($user['nickname']); ?>，想聊些什麼呢？" name="content"></textarea>
          <button type="submit">發佈</button>
        </div>
      <?php else : ?>
        <div class="input-area">
        <textarea placeholder="想聊些什麼呢？" name="content"></textarea>
        <button type="submit" disabled="disabled">請註冊或登入</button>
        </div>
      <?php endif; ?>
      </form>
      <div class="message-cards">
        <?php if ($result->num_rows > 0) : ?>
          <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="card">
              <div class="avatar"><img src="#" alt=""></div>
              <div class="message">
                <div class="message__info">
                  <div class="message__info--author">By <span><?= escape($row['nickname']) ?></span> <span><?= escape($row['created_at']) ?></span>
                  <?php if($row['username'] === $username) : ?>
                    <span><a href="./update_comment.view.php?id=<?= escape($row['id']) ?>">編輯</a></span>
                    <span><a href="./delete_comment.php?id=<?= escape($row['id']) ?>">刪除</a></span>
                  <?php endif; ?>
                  </div>
                </div>
                <div class="message__content">
                  <?= escape($row['content']) ?>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
      <section>
        <ul class="pagination">
          <?php if($current_page > 1) : ?>
            <li class="page-btn"><a href="./index.php?page=<?= escape($current_page - 1) ?>"><span>← </span>Prev</a></li>
          <?php endif; ?>
          <?php 
            $sql = " SELECT count(id) AS count FROM comments WHERE is_deleted IS NULL";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute();
            if (!$result) {
              die('ERROR: '. $conn->error);
            }
            $result = $stmt->get_result();
            if ($result->num_rows > 0) : 
              $row = $result->fetch_assoc();
              $count = $row['count'];
              $total_page = ceil($count / $limit);
          ?>
            <?php for($page = 1; $page <= $total_page; $page++) : ?>
              <li class="page-btn page"><a href="./index.php?page=<?= escape($page) ?>"><?= escape($page) ?></a></li>
            <?php endfor; ?> 
          <?php endif; ?>
          <?php if ($current_page < $total_page) : ?>
            <li class="page-btn"><a href="./index.php?page=<?= escape($current_page + 1) ?>">Next<span> →</span></a></li>
          <?php endif; ?>
        </ul>
      </section>
    </div>
  </main>
<script src="./index.js"></script>
</body>
</html>


