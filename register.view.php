<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;1,300;1,500&display=swap" rel="stylesheet">   <title>simple forum</title>
</head>
<body>
  <header>
    <div class="navbar">
      <div class="logo">
        <a href="./index.php">FORUM</a>
      </div>
      <ul class="nav">
        <li><a href="./index.php">所有留言</a></li>
        <li><a href="./my_comments.php">我的留言</a></li>
      </ul>
      <ul class="buttons">
        <!-- <li><a href="#" >飽飽</a></li> -->
        <li><a class="btn" href="./register.view.php">註冊</a></li>
        <li><a class="btn" href="./login.view.php">登入</a></li>
        <!-- <li><a class="btn" href="./logout.php">登出</a></li> -->
      </ul>
    </div>
  </header>
  <main>
    <div class="container">
      <form action="./register.php" method="POST">
        <h2>註冊</h2>
        <div class="nickname">暱稱： <input type="text" name="nickname"></div>
        <div class="nickname">帳號： <input type="text" name="username"></div>
        <div class="nickname">密碼： <input type="password" name="password"></div>
        <button type="submit">送出</button>  
      </form>
    </div>
  </main>

</body>