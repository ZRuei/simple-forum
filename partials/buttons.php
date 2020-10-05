<?php
require_once 'check_login.php';

?>
<?php if ($row['username'] === $username) : ?>
  <span><a class="edit-btn" href="./update_comment.view.php?id=<?= escape($row['id']) ?>">編輯</a></span>
  <span><a class="del-btn" href="./delete_comment.php?id=<?= escape($row['id']) ?>">刪除</a></span>
<?php endif ?>