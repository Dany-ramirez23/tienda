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
  <style type="text/css">

  </style>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>INICIO</title>
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
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item" v-for="categoria in categorias">
              <a class="nav-link" :href="'categoria.php?id='+categoria.id">{{categoria.nombre}}</a>
            </li>

            <li>
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
    <br> <br>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100" height="300px" src="img/Banner.png" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" height="300px" src="img/Banner2.png" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" height="300px" src="img/Banner3.png" alt="Third slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" height="300px" src="img/Banner4.png" alt="Third slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" height="300px" src="img/Banner5.png" alt="Third slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" height="300px" src="img/Banner6.png" alt="Third slide">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <div class="container" style="background-color:#CEE3F6;">
      <div class="row">
        <div class="col-4"> </div>
        <div class="col-4"> </div>
        <div class="col-4"> </div>
      </div>
    </div>
    <hr>
    <h2 class="text-center">PRODUCTOS DESTACADOS</h2>
    <hr>
    <div class="container" style="background-color:#CEE3F6;">

      <div class="row text-center">

        <div class="col-md-4 pb-30 pb-md-4" v-for="producto in productos">
          <div class="card">
            <center> <img width="300px" height="200px" :src="producto.ruta_imagen" alt="Card image cap"></center>
            <div class="card-body">
              <h5 class="card-title">
                <font color="crimson">${{producto.precio}}</font>
              </h5>
              <p class="card-text"><b>{{producto.nombre}}</b> <br> {{producto.especificaciones}} </br> </p>
              <button @click="addCarrito(producto.id)" href="#" class="btn btn-primary">Añadir al carrito</button>
            </div>
          </div>
        </div>





        <hr>
        <hr>


      </div>
      <?php require 'partials/footer.php' ?>
    </div>
  </div>
  </footer>

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

        id_usuario: "<?=$_SESSION['user_id']?>"
      },
      created: function () {
        this.getCategorias();
        this.getProductos();
        this.fcantidadCarrito();
      },
      methods: {

        addCarrito(id_producto) {
          $.ajax({
            type: "POST",
            url: 'controladores/api.php',
            data: {
              servicio: "agregarCarrito",
              id_usuario: this.id_usuario,
              id_producto: id_producto
            },
            success: function (respuesta) {
              app.cantidadCarrito = parseInt(respuesta);
              $.notify(
                "Se ha agregado el producto a tu carrito", {
                position: "right top",
                className: "success"
              }
              );
            }
          });
        },

        fcantidadCarrito() {
          $.ajax({
            type: "POST",
            url: 'controladores/api.php',
            data: {
              servicio: "getCantidadCarrito",
              id_usuario: this.id_usuario
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
              servicio: "getProductos",
              campo: '',
              valor: ''
            },
            success: function (respuesta) {
              respuesta = JSON.parse(respuesta);
              app.productos = respuesta;


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