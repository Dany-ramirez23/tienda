<?php

require('PHPMailer/PHPMailerAutoload.php');
require('PHPMailer/src/PHPMailer.php');
require('PHPMailer/src/SMTP.php');
require('PHPMailer/src/Exception.php');

class Model
{

    private $db;

    function __construct()
    {
        $server = 'db';
        $username = 'root';
        $password = '';
        $database = 'tienda_virtual';

        try {
            $this->db = new PDO("mysql:host=$server;dbname=$database;charset=utf8;", $username, $password);
        } catch (PDOException $e) {
            die('1Connection Failed: ' . $e->getMessage());
        }
    }

    function checkConnection()
    {
        if ($this->db) {
            return true;
        } else {
            return false;
        }
    }



    function getCategorias()
    {
        return $this->arreglo("SELECT * from categorias");
    }
    function borrarCategoria($id)
    {
        return $this->query("DELETE FROM categorias where id = $id");
    }

    function getUsuario($id)
    {
        return $this->registro("SELECT * from usuarios where id = $id");
    }

    function login($password, $email)
    {
        $usuario = $this->registro("SELECT id,tipo_usuario from usuarios where email = '$email'");
        if ($usuario['id']) {
            return $usuario;
        } else {
            return null;
        }
    }


    function getUsuarios($campo, $valor)
    {
        if ($campo && $valor) {
            return $this->arreglo("SELECT * from usuarios where $campo LIKE '%$valor%'");
        } else {
            return $this->arreglo("SELECT * from usuarios");
        }
    }

    function saveUsuario($usuario)
    {
        $email = $usuario['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $tipo_usuario = $usuario['tipo_usuario'];
        $nombre = $usuario['nombre'];

        $sql = "INSERT INTO usuarios(email,password,tipo_usuario,nombre)
        values ('$email','$password', '$tipo_usuario','$nombre')
        ";
        return $this->query($sql);
    }
    function borrarUsuario($id)
    {
        return $this->query("DELETE FROM usuarios where id = $id");
    }
    function getProducto($id)
    {
        return $this->registro("SELECT *,(SELECT categorias.nombre from categorias where categorias.id = productos.id_categoria) categoria from productos where id = $id");
    }

    function getProductos($campo, $valor)
    {
        if ($campo && $valor) {
            return $this->arreglo("SELECT * from productos where $campo LIKE '%$valor%'");
        } else {
            return $this->arreglo("SELECT * from productos");
        }
    }


    function getProductosByCategoria($id_categoria)
    {
        return $this->arreglo("SELECT * from productos where id_categoria = $id_categoria");
    }


    function getCantidadCarrito($id_usuario)
    {
        $cantidad =  $this->registro("SELECT sum(cantidad) total from carritos 
        where carritos.id_usuario = $id_usuario ")["total"];

        $cantidad = intval($cantidad);
        return $cantidad;
    }


    function agregarCarrito($id_usuario, $id_producto)
    {
        $total = $this->registro("SELECT count(*) total from carritos 
       where carritos.id_usuario = $id_usuario and carritos.id_producto = $id_producto  ")["total"];
        $total = intval($total);
        if ($total == 0) {
            $this->query("INSERT INTO carritos(id_usuario, id_producto, cantidad) 
            values($id_usuario,$id_producto,1)");
        } else {
            $sql = "UPDATE carritos set cantidad = cantidad+1 where id_producto = $id_producto 
            and id_usuario = $id_usuario";

            $this->query($sql);
        }
        return $this->getCantidadCarrito($id_usuario);
    }

    function getCarrito($id_usuario)
    {
        return $this->arreglo("SELECT * from productos inner join carritos 
        on productos.id =  carritos.id_producto where carritos.id_usuario = $id_usuario ");
    }

    function eliminarCarrito($producto_id)
    {
        return $this->query("DELETE from carritos where id = $producto_id");
    }


    function saveProducto($producto)
    {
        $nombre = $producto['nombre'];
        $especificaciones = $producto['especificaciones'];
        $precio = $producto['precio'];
        $id_categoria = $producto['id_categoria'];
        $existencias = $producto['existencias'];
        $ruta_imagen = $producto['ruta_imagen'];
        $sql = "INSERT INTO productos(nombre,especificaciones,precio,id_categoria,existencias,ruta_imagen)
        values ('$nombre','$especificaciones', $precio,$id_categoria,$existencias,'$ruta_imagen')
        ";
        return $this->query($sql);
    }

    function saveCategoria($categoria)
    {
        $nombre = $categoria['nombre'];
        $sql =  "INSERT INTO categorias(nombre) values('$nombre')";
        return $this->query($sql);
    }


    function borrarProducto($id)
    {
        return $this->query("DELETE FROM productos where id = $id");
    }
    function actualizarCategoria($id, $categoria)
    {

        $nombre = $categoria['nombre'];

        $sql = "UPDATE categorias
        SET 
        
        nombre = '$nombre'
        
        where id = $id
        ";
        return $this->query($sql);
    }

    function actualizarProducto($id, $producto)
    {

        $nombre = $producto['nombre'];
        $especificaciones = $producto['especificaciones'];
        $precio = $producto['precio'];
        $id_categoria = $producto['id_categoria'];
        $existencias = $producto['existencias'];
        $ruta_imagen = $producto['ruta_imagen'];


        $sql = "UPDATE productos 
        SET 
        
        nombre = '$nombre',
        especificaciones = '$especificaciones',
        precio = '$precio',
        id_categoria = $id_categoria,
        existencias = $existencias,
        ruta_imagen = '$ruta_imagen'
        where id = $id
        ";
        return $this->query($sql);
    }
    function actualizarUsuario($id, $usuario)
    {

        $email = $usuario['email'];

        $tipo_usuario = $usuario['tipo_usuario'];
        $nombre = $usuario['nombre'];

        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);


        $sql = "UPDATE usuarios 
        SET 
        
        email = '$email',
        
        tipo_usuario = '$tipo_usuario',
        nombre = '$nombre',
        password = '$password'
        
        where id = $id
        ";
        return $this->query($sql);
    }


    // Esta funcion es la que genera el tickets en la tabla tickets
    public function comprar($id_usuario, $total, $productos)
    {
        $id = $this->query("INSERT INTO tickets(id_usuario,total) values($id_usuario, $total)");
        $id_ticket = $this->db->lastInsertId();
        foreach ($productos as $producto) {
            $id_producto = $producto['id'];
            $precio = $producto['precio'];
            $cantidad = $producto['cantidad'];
            $sql = "INSERT INTO productos_ticket(id_ticket,id_producto,precio,cantidad) values($id_ticket,$id_producto, $precio, $cantidad)";
            $this->query($sql);
        }
        $this->query("DELETE from carritos where id_usuario = $id_usuario");
        $correo = $this->registro("SELECT email from usuarios where id = $id_usuario")['email'];
        //echo $correo;
        //$this->enviarEmail($correo,"Compra en Axanafer","Su compra ha sido realizado exitosamente :D");
        return $id_ticket;
    }


    function enviarEmail($email, $asunto, $mensaje)
    {

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587';
        //465

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Username = 'uaemex.ico.validar@gmail.com';
        $mail->Password = 'Universidad19';

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SetFrom('uaemex.ico.validar@gmail.com', 'no-reply@axanafer.mx');
        $mail->Subject = $asunto;
        $mail->AddAddress($email);



        $mail->Body = $mensaje;
        //   $mail->AddAttachment('D:/XAMPP/htdocs/ihm/test.pdf');

        if (!$mail->send()) {
            // echo "Mailer Error: " . $mail->ErrorInfo;

            // die("Sending failed.");
        } else {
            // echo 'Se ha enviado el codigo de verificacion a: ' . $email ;
            //$_SESSION['msg'] = array("tipo" => "verde-pastel", "texto" => "EMAIL enviado con EXITO");


        }
    }











    //Las funciones de abajo no se tienen que tocar



    function registro($sql)
    {
        $resultado = $this->db->prepare($sql);
        if ($resultado->execute()) {
            $arreglo =  $this->utf8_converter($resultado->fetchAll(PDO::FETCH_ASSOC));
            if (sizeof($arreglo) > 0) {
                return $arreglo[0];
            } else return null;
        } else return null;
    }

    function arreglo($sql)
    {
        $resultados = $this->db->prepare($sql);
        if ($resultados->execute()) {
            return $this->utf8_converter($resultados->fetchAll(PDO::FETCH_ASSOC));
        } else return null;
    }

    function query($sql)
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute();
    }


    function utf8_converter($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });

        return $array;
    }
}
