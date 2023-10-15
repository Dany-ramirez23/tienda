<?php

require './database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['id'])) {

        $id = $_POST['id'];

        $db = new Database();
        $db->deleteCategoria($id);

        header('Location: admin_categorias.php');
    }
}
