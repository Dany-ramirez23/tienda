<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
   
  }else{
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap-4.3.1.css" rel="stylesheet">
  <script src="assets/js/vue.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
</head>

<body style="background-color:#CEE3F6;">
  <div id="app">


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">PEÑALOZA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
              <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item" v-for="categoria in categorias">
              <a class="nav-link" :href="'categoria.php?id='+categoria.id">{{categoria.nombre}}</a>
            </li>

            <li class="nav-item active">
              <a href="carrito.php">
                <i class="fa fa-shopping-cart fa-2x"></i> {{cantidadCarrito}}
              </a>
            </li>


          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" value="<?=$_SESSION['email'];?>" type="text" readonly
              aria-label="Search">
            <a href="logout.php" class="btn btn-outline-success my-2 my-sm-0" type="button">Cerrar Sesión</a>
          </form>
        </div>
      </div>
    </nav>
    <br><br>


    <div class="container">
      <div class="row">
        <div class="col-4"> </div>
        <div class="col-4"> </div>
        <div class="col-4"> </div>
      </div>
    </div>
    <hr>
    <h2 class="text-center">Tu carrito</h2>

    <hr>
    <div class="container">
      <div class="row text-center">
        <table class="table">
          <thead>
            <tr>
              <th></th>
              <th>Nombre</th>
              <th>Precio</th>
              <th>Cantidad</th>
              <th>Total</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for=" p in productos">
              <td>
                <img width="100px" :src="p.ruta_imagen" :alt="p.nombre">
              </td>
              <td>{{p.nombre}}</td>
              <td>${{p.precio}}</td>
              <td>{{p.cantidad}}</td>
              <td>
                <b>${{p.precio*p.cantidad}}</b>
              </td>
              <td>
                <button class="btn btn-dark" @click="eliminarProducto(p)">
                  &minus;
                </button>
              </td>
            </tr>

          </tbody>
        </table>

      </div>

    </div>
    <div class="text-right">
      <b style="padding-right:34%; font-size: 1.4rem;">Total productos: {{cantidadCarrito}}</b> <b
        style="padding-right:15%; font-size: 2rem;">Total a pagar: ${{total}}</b>
    </div>
    <br><br>
    <div class="container">
      <div class="text-right">
        <button class="btn btn-success" @click="hacerCompra()">
          Comprar
        </button>
      </div>
    </div>
    <hr>
    <hr>
    <div class="container"> </div>
    <hr>
    <?php require 'partials/footer.php' ?>

  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap-4.3.1.js"></script>
  <script src="assets/js/notify.js"></script>


  <script>

    let app = new Vue({
      el: '#app',
      data: {
        productos: [],
        categorias: [],
        cantidadCarrito: 0,
        id_usuario: "<?=$_SESSION['user_id']?>",
        total: 0
      },
      created: function () {
        this.getCategorias();
        this.getProductos();
        this.fcantidadCarrito();
      },
      methods: {

        eliminarProducto(producto) {
          if (confirm("¿Estas seguro de eliminar '" + producto.nombre + "'?")) {
            $.ajax({
              type: "POST",
              url: 'controladores/api.php',
              data: {
                servicio: "eliminarCarrito",
                producto_id: producto.id
              },
              success: function (respuesta) {
                app.getProductos();
                app.fcantidadCarrito();
              }
            });
          }
        },
        hacerCompra() {
          if (confirm("Confirmar compra")) {
            $.ajax({
              type: "POST",
              url: 'controladores/api.php',
              data: {
                servicio: "comprar",
                id_usuario: this.id_usuario,
                total: this.total,
                productos: this.productos
              },
              success: (respuesta) => {
                respuesta = JSON.parse(respuesta);

                window.location.href = 'ticket.php?id=' + respuesta.id;
              }
            });
          }
        },
        fcantidadCarrito() {
          $.ajax({
            type: "POST",
            url: 'controladores/api.php',
            data: {
              servicio: "getCantidadCarrito",
              id_usuario: this.id_usuario,

            },
            success: function (respuesta) {
              app.cantidadCarrito = parseInt(respuesta);
            }
          });

        },
        getProductos() {
          $.ajax({
            type: "POST",
            url: 'controladores/api.php',
            data: {
              servicio: "getCarrito",
              id_usuario: this.id_usuario
            },
            success: function (respuesta) {
              respuesta = JSON.parse(respuesta);
              app.productos = respuesta;
              var total = 0;
              for (const producto of app.productos) {
                total = total + (producto.cantidad * producto.precio);
              }
              app.total = total;
            }
          });
        },
        getCategorias() {
          $.ajax({
            type: "POST",
            url: 'controladores/api.php',
            data: {
              servicio: "getCategorias",
            },
            success: function (respuesta) {
              respuesta = JSON.parse(respuesta);
              app.categorias = respuesta;
            }
          });
        }
      }
    });


  </script>

</body>

</html>