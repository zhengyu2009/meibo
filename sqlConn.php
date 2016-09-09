<?php
$user = "meibo";
$pw = "Aug.2016";
$dbName = "meibo";
$host = "192.168.1.201:3306";
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";

$pdo = new PDO($dsn,$user, $pw);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);