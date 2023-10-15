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
