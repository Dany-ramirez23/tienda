<?php

require '/Database.php';
session_start();

$db = new Database();

$servicio = $_POST['servicio'];

function responder($respuesta)
{
    echo json_encode($respuesta);
}


switch ($servicio) {
    case 'getUsuario':
        $id = $_POST['id'];
        $respuesta = $db->getUsuario($id);
        responder($respuesta);
        break;

    case 'getUsuarios':
        $campo = $_POST['campo'];
        $valor = $_POST['valor'];
        $usuarios = $db->getUsuarios($campo, $valor);
        responder($usuarios);
        break;
    case 'getCategorias':
        $categorias = $db->getCategorias();
        responder($categorias);
        break;

    case 'saveUsuario':
        $usuario = $_POST['usuario'];
        $respuesta = $db->saveUsuario($usuario);
        responder($respuesta);
        break;

        break;
    case 'borrarCategoria':
        $id = $_POST['id'];
        $respuesta = $db->borrarCategoria($id);
        responder($respuesta);
        break;
    case 'borrarUsuario':
        $id = $_POST['id'];
        $respuesta = $db->borrarUsuario($id);
        responder($respuesta);
        break;

    case 'getProductos':
        $campo = $_POST['campo'];
        $valor = $_POST['valor'];
        $productos = $db->getProductos($campo, $valor);
        responder($productos);
        break;
    case 'getProducto':
        $id = $_POST['id'];
        $respuesta = $db->getProducto($id);
        responder($respuesta);
        break;

    case 'getXcategoria':
        $id_categoria = $_POST['id_categoria'];
        $productos = $db->getProductosByCategoria($id_categoria);
        responder($productos);
        break;


        break;
    default:
        echo json_encode(array('success' => 0, 'error' => 'Servicio no encontrado:' . $servicio));
        break;
}
