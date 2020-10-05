<?php
session_start();
require_once 'functions.php';
$username = NULL;
$user = NULL;

if(!empty($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $user = getUserByUsername($username);
}