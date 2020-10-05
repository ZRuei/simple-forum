## `2020-09-15` 基礎 CRUD 與會員機制

此為 Lidemy 在後端基礎課程的主要專案，因為去年在[第三期課程](https://github.com/Lidemy/mentor-program-3rd-ZRuei/tree/master/homeworks/week12/hw1)時相當混亂與匆忙地完成留言板，不確定自己到底都寫了些什麼，今年再重新做一次，用來熟悉 PHP 基礎語法、MySQL 的 query 操作、Data Schema 與後端伺服器的基礎概念。

另外，去年是使用 XAMPP 大禮包內附的PHP、Apache 、phpMyAdmin 這樣的組合作為開發環境預覽網頁，每次都要打開 XAMPP、啟動伺服器、mount Volumes 再將檔案新增到 htdocs 資料夾，覺得有點懶惰。所以這次改為直接監聽本地伺服器的方式，在 command line 輸入 `php -S localhost:8080` ，圖形化資料庫工具則改用 Sequal Pro 處理速度有感提升，在測試階段用起來比較舒適。

### 資料庫

- 連線到資料庫 `conn.php`

  ```php
  <?php
  
  $server_name = 'your-servername';
  $username = 'your-username';
  $password = 'your-password';
  $db_name = 'your-dbname';
  
  $conn = new mysqli($server_name, $username, $password, $db_name);
  
  if ($conn->connect_error) {
    die('資料庫連線錯誤： ' . $conn->connect_error);
  }
  
  $conn->query('SET NAMES UTF8');
  $conn->query('SET time_zone = +8:00');
  ```

- 資料表規格 Table Schema

  **Table name: users**

  | Field      | Type     | Length | Key  | Default           | Extra          |
  | :--------- | -------- | ------ | ---- | ----------------- | -------------- |
  | id         | INT      |        | PRI  |                   | auto_increment |
  | nickname   | VARCHAR  | 128    |      |                   |                |
  | username   | VARCHAR  | 128    | UNI  |                   |                |
  | password   | VARCHAR  | 128    |      |                   |                |
  | created_at | DATETIME |        |      | CURRENT_TIMESTAMP |                |

  **Table name: comments**

  | Field      | Type     | Length | Key  | Default           | Extra          |
  | :--------- | -------- | ------ | ---- | ----------------- | -------------- |
  | id         | INT      |        | PRI  |                   | auto_increment |
  | user_id    | INT      |        |      |                   |                |
  | content    | TEXT     |        |      |                   |                |
  | is_deleted | TINYINT  |        |      | NULL              |                |
  | created_at | DATETIME |        |      | CURRENT_TIMESTAMP |                |

  - 由於留言內容可能有中文，將編碼設定為 `utf8mb4_unicode_ci` 以避免亂碼
  - PRI 即 Primary Key
  - UNI 即 Unique Key

### 功能

檔案還未做整理，僅簡單在呈現頁面的檔案上標記命名為  view `*.view.php` 。

- 主畫面 `index.php`

- 會員機制
	
  使用者可以註冊、登入留言版，登入後可以留言、管理自己的留言。
  
  - 註冊 `register.view.php` / `register.php`
  - 登入 `login.view.php` / `login.php`
  - 登出 `logout.php`
	
- 個人留言管理
	
  使用者登入後可以新增、編輯、刪除自己的留言，經由身份辨識避免更動不屬於自己的留言。
  
  - 新增留言 `add.php`
  - 編輯留言 `update_comment.view.php` / `update_comment.php`
  - 刪除留言 `delete_comment.php`
	
- 其他
  - 分頁導覽
  - 使用 `htmlspecialchars()` 防止 XSS
  - 使用 Prepared Statement 防止 SQL Injection
  - 使用 PHP 內建 SESSION 機制，作為網站的身份辨識
  - 使用 `password_hash('your_password', PASSWORD_DEFAULT)` 雜湊註冊密碼，不存明碼在資料庫中，並以 `password_verify($password , $hash_password)` 作為登入密碼驗證

#### 待辦項目

- 版面設計
  - 註冊頁面
  - 登入頁面
  - 編輯與刪除按鈕
  
- 權限管理 role
  - admin 可以新增留言、編輯與刪除任意留言
  - normal 可以新增留言、編輯與刪除自己的留言
  - suspend 不能新增留言，可以編輯與刪除自己的留言

- 管理使用者權限後台

  僅管理員可以進入後台、變更使用者權限

- 錯誤訊息



## `2020-10-05` 以 AJAX 改寫文章發佈



### 功能

- 拆分文章發佈的後端資料與前端頁面，發佈文章不換頁
- 錯誤訊息也儲存在後端所帶來的 JSON 資料中
- 初步拆分頁面上各功能區塊
  - 標頭 `navbar.php`
  - 留言區塊 `comments.php`
  - 留言編輯按鈕 `buttons.php`
  - 分頁 `pagination.php`

#### 待辦項目

- 刪除與編輯以 AJAX 改寫
- 版面設計
  - 錯誤訊息提示

