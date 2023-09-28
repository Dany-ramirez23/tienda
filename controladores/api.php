<?php

require '../Model.php';
session_start();

$modelo = new Model();

$servicio = $_POST['servicio'];

function responder($respuesta){
  echo json_encode($respuesta);
}


switch ($servicio) {
  case 'getUsuario':
    $id = $_POST['id'];
    $respuesta = $modelo->getUsuario($id);
    responder($respuesta);
    break;

  case 'getUsuarios':
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];
    $usuarios = $modelo->getUsuarios($campo,$valor);
    responder($usuarios);
    break;
  case 'getCategorias':
    $categorias = $modelo->getCategorias();
    responder($categorias);
    break;

  case 'saveUsuario':
    $usuario = $_POST['usuario'];
    $respuesta = $modelo->saveUsuario($usuario);
    responder($respuesta);
    break;

  case 'saveCategoria':
    $categoria = $_POST['categoria'] ;
    
    $respuesta = $modelo->saveCategoria($categoria);
    responder($respuesta);
    break;
    case 'actualizarCategoria':
      $categoria = $_POST['categoria'];
      $id = $_POST['id'];
      $respuesta = $modelo->actualizarCategoria($id,$categoria);
      responder($respuesta);
    break;
    case 'borrarCategoria':
      $id = $_POST['id'];  
      $respuesta = $modelo->borrarCategoria($id);
      responder($respuesta);
      break;
 case 'borrarUsuario':
    $id = $_POST['id'];  
    $respuesta = $modelo->borrarUsuario($id);
    responder($respuesta);
    break; 
    case 'actualizarUsuario':
      $usuario = $_POST['usuario'];
      $id = $_POST['id'];
      $respuesta = $modelo->actualizarUsuario($id,$usuario);
      responder($respuesta);
    break;

  case 'getProductos':
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];
    $productos = $modelo->getProductos($campo,$valor);
    responder($productos);
    break;
  case 'getProducto':
  $id = $_POST['id'];
    $respuesta = $modelo->getProducto($id);
    responder($respuesta);
    break;
  case 'saveProducto':
      $producto = $_POST['producto'];
      $respuesta = $modelo->saveProducto($producto);
      responder($respuesta);
      break;

  case 'actualizarProducto':
      $producto = $_POST['producto'];
      $id = $_POST['id'];
      $respuesta = $modelo->actualizarProducto($id,$producto);
      responder($respuesta);
    break;

  case 'borrarProducto':
    $id = $_POST['id'];  
    $respuesta = $modelo->borrarProducto($id);
    responder($respuesta);
    break;

  case 'getProductos':
      $id = $_POST['id'];  
      $respuesta = $modelo->getProductos($id);
      responder($respuesta);
      break;

    case 'getXcategoria':
       $id_categoria = $_POST['id_categoria'];
       $productos = $modelo->getProductosByCategoria($id_categoria);
       responder($productos);
    break;

    case 'getCarrito':
      $id_usuario = $_POST['id_usuario'];
      $productos = $modelo->getCarrito($id_usuario);
      responder($productos);
    break;

    case 'agregarCarrito':
      $id_usuario = $_POST['id_usuario'];
      $id_producto = $_POST['id_producto'];
      $respuesta = $modelo->agregarCarrito($id_usuario, $id_producto);
      responder($respuesta);
    break;

    case 'getCantidadCarrito':
      $id_usuario = $_POST['id_usuario'];
      $cantidad = $modelo->getCantidadCarrito($id_usuario);
      responder($cantidad);
      break;
      case 'eliminarCarrito':
        $producto_id = $_POST['producto_id'];
        $respuesta = $modelo->eliminarCarrito($producto_id);
        responder($respuesta);
        break;

      case 'comprar':
        $id_usuario = $_POST['id_usuario'];
        $total = $_POST['total'];
        $productos = $_POST['productos'];
        $respuesta = $modelo->comprar($id_usuario,$total,$productos);
        responder(array(
          "id" => intval($respuesta)
        ));
        
        break;
  default:
    echo json_encode(array('success' => 0, 'error' => 'Servicio no encontrado:'.$servicio));  
    break;
}
