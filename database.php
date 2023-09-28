<?php

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'tienda_virtual';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('2Connection Failed: ' . $e->getMessage());
}
