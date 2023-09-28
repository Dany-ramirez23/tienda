<?php

require_once('Model.php');


function ejecutarTest($nombre, $funcion)
{
    global $testsExitosos;

    if (!$funcion()) {
        echo "Test '{$nombre}' fallido ❌ .\n";
        $testsExitosos = false;
    } else {
        echo "Test '{$nombre}' exitoso. ✅\n";
    }
    echo "<br />";
    echo "<br />";
}

$testsExitosos = true;
$model = new Model();




function testDBConnection()
{
    global $model;
    return $model->checkConnection();
}

function testLogin()
{
    global $model;
    return $model->login('hola', 'dany123rch@gmail.com') != null;
}

function testExistenciaCategorias()
{
    global $model;
    return sizeof($model->getCategorias()) > 0;
}

function testExistenciaUsuarios()
{
    global $model;
    return sizeof($model->getUsuarios(null, null)) > 0;
}


function checkNofFoundUserByInvalidId()
{
    global $model;
    return $model->getUsuario(-1) == null;
}
function checkFoundUserByValidId()
{
    global $model;
    $users = $model->getUsuarios(null, null);
    $lastUser = $users[sizeof($users) - 1];
    return $model->getUsuario($lastUser['id']) != null;
}




ejecutarTest('DB connection', 'testDBConnection');
ejecutarTest('Login', 'testLogin');
ejecutarTest('Existencia de categorias', 'testExistenciaCategorias');
ejecutarTest('Existencia de usuarios', 'testExistenciaUsuarios');
ejecutarTest('Usuario no encontrado usando id invalido', 'checkNofFoundUserByInvalidId');
ejecutarTest('Usuario encontrado usando id valido', 'checkFoundUserByValidId');

// Mensaje final
if ($testsExitosos) {
    echo "<br /><br /><b>Todas las pruebas completadas exitosamente. 🥳🎉</b>\n";
} else {
    echo "<br /><br /><b>Algunas pruebas no pasaron. 😭 💔</b>\n";
}
