<?php

session_start();
require './database.php';

$db = new Database();



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = file_get_contents("php://input");
   
    $json_data = json_decode($data, true); 

    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Error al decodificar el JSON');
    }
    if (isset($json_data['carrito'])) {

        $carrito = $json_data['carrito'];

        $respuesta = $db->comprarCarrito($carrito, $_SESSION['user_id']);

        echo json_encode($respuesta);
    }
}
