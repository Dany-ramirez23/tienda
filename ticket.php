<?php

require 'config/database.php';
require 'Model.php';

$modelo = new Model();

$id = $_GET['id'];
$ticket = $modelo->registro("SELECT DATE_FORMAT(fecha, '%d/%m/%Y') fecha,total,id_usuario from tickets where id = $id");
$total = $ticket['total'];
$fecha = $ticket['fecha'];
$id_usuario = $ticket['id_usuario'];

$nombreUsuario = $modelo->registro("SELECT nombre from usuarios where id = $id_usuario")['nombre'];

$productos = $modelo->arreglo("SELECT productos.nombre,pt.precio precioR,pt.cantidad from productos inner join productos_ticket pt on pt.id_producto = productos.id where pt.id_ticket = $id");

// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';
// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf();
$html = "
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Ticket de compra </title>
    <style>
    table, th, td {
  border: 1px solid black;
}

th, td {
    padding: 10px;
  }
  td{
      width: 10%
  }
  .titulo-azul{
    background-color:rgb(39,85,119);
    color: white;
  }
  .titulo-oro{
    background-color:#9C8412;
    color: white;
    }

    </style>
    
</head>

<body>


<img src='img/logo.jpg' width='15px;' /></div>
<p style='text-align: right'>
    San Francisco Tepeoluco, Temascalcingo, México <br>
    Primer Barrio Centro <br>
    Calle Luis Donaldo Colosio<br>
    Teléfono: 7121735257<br>
    Correo: axanafer@gmail.com
</p>
<hr>
<div>
    <span style='text-align: left'> N.Ticket: $id</span> <br>
    <span style='text-align: right'> Fecha: $fecha</span> <br>
    <span style='text-align: right'> Nombre del cliente: $nombreUsuario</span>

</div>

<br>
";

$html .= "
    <table style='width:100%; text-align:center'>
    <tr  >
        <td class='titulo-azul'><b>N</b></td>
        <td class='titulo-azul'><b>Producto</b></td>
        <td class='titulo-azul'><b>Subtotal</b></td>
        <td class='titulo-azul'><b>Total</b></td>
    </tr>
 
";

foreach ($productos as $registro) {
    $subtotal = intval($registro['precioR']) / intval($registro['cantidad']);
    $html.= "<tr>";
            $html.= "<td>";
            $html.=  $registro['cantidad'];
            $html.= "</td>";
        
            $html.= "<td>";
                $html.=  $registro['nombre'];
            $html.= "</td>"; 

            $html.= "<td>$";
                $html.=  $subtotal;
            $html.= "</td>";

            $html.= "<td>$";
                $html.=  $registro['precioR'];
            $html.= "</td>";

           
       
        $html.= "</tr>";
    }


$html .= "</table> <br>

<p style='text-align: right'>
    <b>
    Total: $$total
    </b>
</p>


<p >
    <h5 style='text-align: center'>
        NOTA: Asiste a la tienda con este ticket de compra<br> para la entrega de tus productos
    </h5>
</p>
<hr>
</body>
</html>
";

//echo $html;
// Write some HTML code:
$mpdf->WriteHTML($html);
// echo $html;
// Output a PDF file directly to the browser
$mpdf->Output();
//echo json_encode($reporte);


?>