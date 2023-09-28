<html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar categorias </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/custom.css">
    <script src="assets/js/vue.js"></script>
</head>

<body>
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
                            <!-- Button trigger modal -->
                            <button @click="isEditar = false" type="button" class="btn btn-success " data-toggle="modal"
                                data-target="#nuevaCategoria">
                                <i class="material-icons">&#xE147;</i> <span>Agregar nueva categoria</span>
                            </button>

                            <!-- Modal Crear producto-->
                            <div class="modal fade" id="nuevaCategoria" tabindex="-1" role="dialog" aria-labelledby="khkj"
                                aria-hidden="true">
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
                                                <input v-model="categoria.nombre" type="text" name="nombreP" id="nombreP"
                                                    class="form-control" placeholder="Nombre de la categoria"
                                                    aria-describedby="">
                                            </div>

                                            
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cerrar</button>
                                            <button type="button" class="btn btn-primary" v-if="!isEditar"
                                                @click="crearCategoria()">Crear</button>
                                            <button type="button" class="btn btn-primary" v-if="isEditar"
                                                @click="guardarCategoria()">Guardar
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
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                </button>
                                <button @click="editarCategoria(p)" class="btn btn-warning" data-toggle="modal"
                                    data-target="#nuevaCategoria">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <script>

            var app = new Vue(
                {
                    el: '#app',
                    data: {

                        categorias: [],
                        categoria: {
                            nombre: ''

                           
                        },
                        isEditar: false
                    },
                    created: function () {
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
                                success: function (respuesta) {
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
                                    success: function (respuesta) {

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
                                success: function (respuesta) {
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
                                success: function (respuesta) {
                                    app.getCategorias();
                                    $('#nuevaCategoria').modal('toggle');
                                    this.resetCategoria();
                                }
                            });
                        }
                    }
                }
            );


        </script>
</body>

</html>