<?php

require './database.php';

$db = new Database();



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = file_get_contents("php://input");
   
    $json_data = json_decode($data, true); 

    // Verificar si la decodificación fue exitosa
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Error al decodificar el JSON');
    }
    if (isset($json_data['carrito'])) {

        $carrito = $json_data['carrito'];

        $carrito = $db->obtenerCarrito($carrito);

        echo json_encode($carrito);
    }
}
