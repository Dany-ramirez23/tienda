<?php
require './database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email'], $_POST['nombre_completo'], $_POST['password'])) {

        $email = $_POST['email'];
        $nombre_completo = $_POST['nombre_completo'];
        $password = $_POST['password'];

        $db = new Database();
        $db->saveUsuario([
            'email' => $email,
            'nombre' => $nombre_completo,
            'password' => $password,
            'tipo_usuario' => 1
        ]);

        header('Location: login.php');
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#A58F77] min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h1 class="text-2xl font-semibold mb-4">Registro de usuario</h1>

        <form action="signup.php" method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Email:</label>
                <input type="email" name="email" required class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Nombre completo:</label>
                <input type="text" name="nombre_completo" required class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Contraseña:</label>
                <input type="password" name="password" required class="mt-1 p-2 w-full border rounded-md">
            </div>

            <button type="submit" class="w-full p-2 text-white bg-[#6C513B] rounded-md hover:bg-[#5A402D]">Registrar</button>
        </form>
    </div>

</body>

</html>