<?php
require './database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email'], $_POST['password'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $db = new Database();
        $user = $db->login($password, $email);


        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            if ($user['tipo_usuario'] == 1) {
                header('Location: index.php');
            } else {
                header('Location: admin.php');
            }
        } else {
            echo 'Usuario o contraseña incorrectos';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#A58F77] min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h1 class="text-2xl font-semibold mb-4">Iniciar sesión</h1>

        <form action="login.php" method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Email:</label>
                <input type="email" name="email" required class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Contraseña:</label>
                <input type="password" name="password" required class="mt-1 p-2 w-full border rounded-md">
            </div>

            <button type="submit" class="w-full p-2 text-white bg-[#6C513B] rounded-md hover:bg-[#5A402D]">Ingresar</button>
        </form>
    </div>

</body>

</html>