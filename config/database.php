<?php

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'tienda_virtual';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('1Connection Failed: ' . $e->getMessage());
}
