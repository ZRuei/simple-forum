<?php 
require_once './functions.php';

$current_page = 1;
if (!empty($_GET['page'])) {
  $current_page = $_GET['page'];
}
$limit = 8;
$offset = ($current_page - 1) * $limit;

$sql = "SELECT count(id) AS count FROM comments WHERE is_deleted = 0";
$stmt = $conn->prepare($sql);
$result = $stmt->execute();

if (!$result) {
  die('ERROR: '. $conn->error);
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $count = $row['count'];
  $total_page = ceil($count / $limit);
}
?>

<section>
  <ul class="pagination">
    <?php if ($current_page > 1) : ?>
      <li class="page-btn"><a href="./index.php?page=<?= escape($current_page - 1) ?>"><span>← </span>Prev</a></li>
    <?php endif; ?>  
    <?php for ($page = 1; $page <= $total_page; $page++) : ?>
      <li class="page-btn page"><a href="./index.php?page=<?= escape($page) ?>"><?= escape($page) ?></a></li>
    <?php endfor; ?> 
    <?php if ($current_page < $total_page) : ?>
      <li class="page-btn"><a href="./index.php?page=<?= escape($current_page + 1) ?>">Next<span> →</span></a></li>
    <?php endif; ?>
  </ul>
</section>