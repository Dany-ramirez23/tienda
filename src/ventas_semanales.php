<?php
require './database.php';
$db = new Database();


$salesData = $db->getVentasSemanal();

echo json_encode($salesData);
