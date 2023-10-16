<?php

class Database
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
            die('Connection Failed: ' . $e->getMessage());
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
        $usuario = $this->registro("SELECT * from usuarios where email = '$email'");
        if ($usuario) {
            if (password_verify($password, $usuario['password'])) {
                return $usuario;
            } else {
                return null;
            }
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

    function getProductos($campo = null, $valor = null)
    {
        if ($campo && $valor) {
            return $this->arreglo("SELECT * from productos where $campo LIKE '%$valor%'");
        } else {
            return $this->arreglo("SELECT productos.*, categorias.nombre as categoria from productos inner join categorias on categorias.id = productos.id_categoria");
        }
    }




    function getProductosByCategoria($id_categoria)
    {
        return $this->arreglo("SELECT * from productos where id_categoria = $id_categoria");
    }

    function getVentasSemanal()
    {
        return $this->arreglo("SELECT DATE_FORMAT(fecha,'%d/%m/%Y') fecha_2, sum(total) total from tickets where fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) group by fecha_2");
    }

    function getCategoriaById($id)
    {
        return $this->registro("SELECT * from categorias where id = $id");
    }

    function actualizarCategoria($id, $nombre)
    {
        return $this->query("UPDATE categorias set nombre = '$nombre' where id = $id");
    }

    function eliminarCategoria($id)
    {
        return $this->query("DELETE from categorias where id = $id");
    }

    function crearCategoria($nombre)
    {
        return $this->query("INSERT INTO categorias(nombre) values ('$nombre')");
    }

    function crearProducto($nombre, $precio, $existencias, $id_categoria, $ruta_imagen, $especificaciones)
    {
        return $this->query("INSERT INTO productos(nombre, precio, existencias, id_categoria, ruta_imagen, especificaciones) values ('$nombre', $precio, $existencias, $id_categoria, '$ruta_imagen', '$especificaciones')");
    }

    function deleteCategoria($id)
    {
        return $this->query("DELETE from categorias where id = $id");
    }

    function deleteProducto($id)
    {
        return $this->query("DELETE from productos where id = $id");
    }

    function editarProducto($id, $nombre, $precio, $existencias, $id_categoria, $imagen, $especificaciones)
    {
        return $this->query("UPDATE productos set nombre = '$nombre', precio = $precio, existencias = $existencias, id_categoria = $id_categoria, ruta_imagen = '$imagen', especificaciones = '$especificaciones' where id = $id");
    }

    function obtenerCarrito($carrito)
    {

        $resultado = [];
        $total = 0;

        foreach ($carrito as $item) {

            $producto = $this->getProducto($item['id']);

            $producto['cantidad'] = intval($item['cantidad']);
            $producto['total'] = $producto['cantidad'] * $producto['precio'];
            $total += $producto['total'];

            array_push($resultado, $producto);
        }


        return [
            "productos" => $resultado,
            "total" => $total
        ];
    }

    function comprarCarrito($carrito, $user_id)
    {
        $data = $this->obtenerCarrito($carrito);
        $total = $data['total'];

        $this->query("INSERT INTO tickets(id_usuario, total) values ($user_id, $total)");
        $ticketId = $this->lastId();

        foreach ($data['productos'] as $producto) {
            $this->query("INSERT INTO productos_ticket(id_ticket, id_producto, cantidad, precio) values ($ticketId[id], $producto[id], $producto[cantidad], $producto[precio])");
        }
        return [
            "ticket_id" => $ticketId,
        ];
    }

    function getTicket($id)
    {
        return $this->registro("SELECT tickets.*, usuarios.nombre as nombre_usuario from tickets inner join usuarios on usuarios.id = tickets.id_usuario where tickets.id = $id");
    }

    function getProductosPorCategoria($id_categoria)
    {
        return $this->arreglo("SELECT productos.*, categorias.nombre as categoria from productos inner join categorias on categorias.id = productos.id_categoria where id_categoria = $id_categoria");
    }

    function categoriasConProductos()
    {
        $categorias = $this->arreglo("SELECT * from categorias");
        $categoriasConProductos = [];

        foreach ($categorias as $categoria) {
            $productos = $this->getProductosByCategoria($categoria['id']);
            if (sizeof($productos) > 0) {
                array_push($categoriasConProductos, $categoria);
            }
        }
        return $categoriasConProductos;
    }

    //Reportes

    function getTotales()
    {
        return $this->registro("SELECT (SELECT COUNT(*) from usuarios) usuarios, (SELECT COUNT(*) from productos) productos, (SELECT COUNT(*) from categorias) categorias, (SELECT COUNT(*) from tickets) tickets, (SELECT sum(total) from tickets) ventas_totales");
    }


    function lastId()
    {
        return $this->registro("SELECT LAST_INSERT_ID() id");
    }



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
