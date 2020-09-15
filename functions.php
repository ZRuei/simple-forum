<?php

require_once './conn.php'; 

function generateToken() {
  $length = 16;
  return bin2hex(random_bytes($length));
}

function getUsernameByToken($token) {
  global $conn;
  $sql = "SELECT tokens.username, users.nickname FROM tokens 
    LEFT JOIN users ON users.username = tokens.username WHERE tokens.token = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $token);
  $result = $stmt->get_result();
  return $result->fetch_assoc();
}

function getUserByUsername($username) {
  global $conn;
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $username);
  $result = $stmt->execute();
  $result = $stmt->get_result();
  return $result->fetch_assoc();
}


function escape($str) {
  return htmlspecialchars($str, ENT_QUOTES); 
}