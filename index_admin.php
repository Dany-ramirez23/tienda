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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administración del Sistema</title>
    <link href="css/bootstrap-4.3.1.css" rel="stylesheet">
    <script src="assets/js/vue.js"></script>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">PEÑALOZA</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>

                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" value="<?=$_SESSION['email'];?>" type="text" readonly
                            aria-label="Search">
                        <a href="logout.php" class="btn btn-outline-success my-2 my-sm-0" type="button">Cerrar
                            Sesión</a>
                    </form>
                </div>
            </div>
        </nav>
        <br><br>
        <div class="container">
            <div class="row text-center">

                <div class="col-md-4 pb-1 pb-md-0">
                    <div class="card">
                        <img class="card-img-top" src="img/productos.jpg " width="100px" alt="Imagen de productos">
                        <div class="card-body">
                            <h5 class="card-title">Administrar productos</h5>
                            <p class="card-text">

                            </p>
                            <a href="productos.php" class="btn btn-primary">Ir</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 pb-1 pb-md-0">
                    <div class="card">
                        <img class="card-img-top" src="img/clientes.png " width="100px" alt="Imagen de productos">
                        <div class="card-body">
                            <h5 class="card-title">Administrar usuarios</h5>
                            <p class="card-text">

                            </p>
                            <a href="usuarios.php" class="btn btn-primary">Ir</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 pb-1 pb-md-0">
                    <div class="card">
                        <img class="card-img-top" src="img/category.png " width="100px" alt="Imagen de productos">
                        <div class="card-body">
                            <h5 class="card-title">Administrar categorias</h5>
                            <p class="card-text">

                            </p>
                            <a href="categorias.php" class="btn btn-primary">Ir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.3.1.js"></script>
</body>

</html>