<?php
require './database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email'], $_POST['nombre'], $_POST['password'])) {

        $email = $_POST['email'];
        $nombre_completo = $_POST['nombre'];
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

<body class="dark:text-slate-400 bg-white dark:bg-slate-900 min-h-screen flex items-center justify-center">


    <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
        <form class="space-y-6" method="POST" action="./signup.php">

            <div class="flex justify-center flex-col items-center">
                <h2 class="font-bold text-2xl text-center mb-2">
                    Artesanías de barro Sánchez
                </h2>
                <img src="./assets/logo.jpeg" class="h-36" alt="Flowbite Logo" />
            </div>
            <h5 class="text-xl font-medium text-gray-900 dark:text-white">Registro de usuario</h5>



            <div>
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre completo</label>
                <input type="text" name="nombre" id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Juan Pérez" required>
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="nombre@compania.com" required>
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
            </div>


            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Registrarme
            </button>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                ¿Ya tienes cuenta? <a href="./login.php" class="text-blue-700 hover:underline dark:text-blue-500">
                    Iniciar sesión
                </a>
            </div>
        </form>
    </div>


</body>

</html>