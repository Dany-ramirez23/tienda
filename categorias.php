<?php
session_start();

if (isset($_SESSION['user_id'])) {
} else {
    header("Location: login.php");
}
?>


<html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar categorias </title>
    <script src="assets/js/vue.js"></script>
    <link href="css/bootstrap-4.3.1.css" rel="stylesheet">
    <script src="assets/js/vue.js"></script>
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/index_admin.php">PEÑALOZA</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                        <a class="nav-link" href="/index_admin.php">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="/productos.php">Productos</span></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="/usuarios.php">Usuarios</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/categorias.php">Categorías</span></a>
                    </li>
                </ul>

                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" value="<?= $_SESSION['email']; ?>" type="text" readonly aria-label="Search">
                    <a href="logout.php" class="btn btn-outline-success my-2 my-sm-0" type="button">Cerrar
                        Sesión</a>
                </form>
            </div>
        </div>
    </nav>
    <br><br>
    <div id="app">

        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Administrar <b>categorias</b></h2>
                        </div>
                        <div class="col-sm-6" style="align-content: flex-end;">
                            <br><br>

                            <div style="display: flex; justify-content: flex-end;">
                                <button @click="isEditar = false" type="button" class="btn btn-success " data-toggle="modal" data-target="#nuevaCategoria">
                                    Agregar categoría <div class="fa fa-plus"></div>
                                </button>
                            </div>


                            <!-- Modal Crear producto-->
                            <div class="modal fade" id="nuevaCategoria" tabindex="-1" role="dialog" aria-labelledby="khkj" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" v-if="!isEditar">Agregar nueva categoria</h5>
                                            <h5 class="modal-title" v-if="isEditar">Editar categoria</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nombreP">Nombre Categoria</label>
                                                <input v-model="categoria.nombre" type="text" name="nombreP" id="nombreP" class="form-control" placeholder="Nombre de la categoria" aria-describedby="">
                                            </div>



                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <button type="button" class="btn btn-primary" v-if="!isEditar" @click="crearCategoria()">Crear</button>
                                                <button type="button" class="btn btn-primary" v-if="isEditar" @click="guardarCategoria()">Guardar
                                                    cambios</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <br><br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">&nbsp;ID</th>
                                <th scope="col">&nbsp;Nombre</th>



                                <th scope="col">&nbsp;
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="p in categorias">
                                <td>{{p.id}}</td>
                                <td>{{p.nombre}}</td>

                                <td>
                                    <button class="btn btn-danger" @click="eliminarCategoria(p)">
                                        <!-- Add trash icon  -->
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <button @click="editarCategoria(p)" class="btn btn-warning" data-toggle="modal" data-target="#nuevaCategoria">
                                        <i class="fa fa-pen"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.3.1.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {

                categorias: [],
                categoria: {
                    nombre: ''


                },
                isEditar: false
            },
            created: function() {
                this.getCategorias();

            },
            methods: {
                getCategorias() {
                    $.ajax({
                        type: "POST",
                        url: 'controladores/api.php',
                        data: {
                            servicio: "getCategorias",

                        },
                        success: function(respuesta) {
                            respuesta = JSON.parse(respuesta);
                            app.categorias = respuesta;
                        }
                    });
                },
                eliminarCategoria(categoria) {
                    var respuesta = confirm("¿Estas seguro de eliminar la categoria: '" + categoria.nombre + "' ?");
                    if (respuesta) {
                        $.ajax({
                            type: "POST",
                            url: 'controladores/api.php',
                            data: {
                                servicio: "borrarCategoria",
                                id: categoria.id
                            },
                            success: function(respuesta) {

                                respuesta = JSON.parse(respuesta);
                                app.getCategorias();
                            }
                        });
                    }
                },

                crearCategoria() {
                    $.ajax({
                        type: "POST",
                        url: 'controladores/api.php',
                        data: {
                            servicio: "saveCategoria",
                            categoria: this.categoria
                        },
                        success: function(respuesta) {
                            $('#nuevaCategoria').modal('toggle');
                            this.resetCategoria();
                            app.getCategorias();

                        }
                    });
                },
                resetCategoria() {
                    this.categoria = {
                        nombre: '',


                    };
                },
                editarCategoria(categoria) {
                    this.isEditar = true;
                    this.categoria = Object.assign({}, categoria);
                },
                guardarCategoria() {
                    $.ajax({
                        type: "POST",
                        url: 'controladores/api.php',
                        data: {
                            servicio: "actualizarCategoria",
                            categoria: this.categoria,
                            id: this.categoria.id,
                        },
                        success: function(respuesta) {
                            app.getCategorias();
                            $('#nuevaCategoria').modal('toggle');
                            this.resetCategoria();
                        }
                    });
                }
            }
        });
    </script>
</body>

</html>