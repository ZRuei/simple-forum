<?php require_once 'check_login.php' ?>
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
        <li><a href="#">我的留言</a></li>
      </ul>
      <ul class="buttons">
      <?php require_once './partials/navbar.php' ?>
      </ul>
    </div>
  </header>
  <main>
    <div class="container">
      <form action="add_comment.php" method="POST">
     
        <?php if ($username) : ?>
          <div class="input-area">
            <textarea placeholder="嗨～<?= escape($user['nickname']) ?>，想聊些什麼呢？" name="content"></textarea>
            <button type="submit">發佈</button>
          </div>
        <?php else : ?>
          <div class="input-area">
          <textarea placeholder="想聊些什麼呢？" name="content"></textarea>
          <button type="submit" disabled="disabled">請註冊或登入</button>
          </div>
        <?php endif; ?>
        
      </form>
      <?php include_once './partials/comments.php' ?>
      <?php include_once './partials/pagination.php' ?>
    </div>
  </main>
<script src="index.js"></script>
</body>
</html>


