<?php 
require_once 'conn.php';
require_once 'check_login.php';
?>
<?php if ($username) : ?>
  <li><a class="btn" href="./logout.php">登出</a></li>
<?php else : ?>
  <li><a class="btn" href="./register.view.php">註冊</a></li>
  <li><a class="btn" href="./login.view.php">登入</a></li>
<?php endif; ?>