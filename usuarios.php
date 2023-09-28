<html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar usuarios </title>
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
                            <h2>Administrar <b>Usuarios</b></h2>
                        </div>
                        <div class="col-sm-6 pull-right" style="align-content: flex-end;margin-bottom: 50px;">
                            <br><br>
                            <!-- Button trigger modal -->
                            <button @click="isEditar = false" type="button" class="btn btn-success pull-right"
                                data-toggle="modal" data-target="#nuevoUsuario">
                                <i class="material-icons">&#xE147;</i> <span>Agregar nuevo usuario</span>
                            </button>

                            <!-- Modal Crear producto-->
                            <div class="modal fade" id="nuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="khkj"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" v-if="!isEditar">Agregar nuevo usuario</h5>
                                            <h5 class="modal-title" v-if="isEditar">Editar usuario</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nombreP">Nombre usuario</label>
                                                <input v-model="usuario.nombre" type="text" name="nombreP" id="nombreP"
                                                    class="form-control" placeholder="Nombre del usuario"
                                                    aria-describedby="">
                                            </div>

                                            <div class="form-group">
                                                <label for="emailP">Email</label>
                                                <input v-model="usuario.email" type="text" name="emailP" id="emailP"
                                                    class="form-control" placeholder="E-mail del usuario"
                                                    aria-describedby="">
                                            </div>
                                            <div class="form-group">
                                                <label for="passwordP">Contraseña</label>
                                                <input v-model="usuario.password" type="password" name="passwordP" id="passwordP"
                                                    class="form-control" placeholder="Contraseña del usuario"
                                                    aria-describedby="">
                                            </div>

                                            

                                            <div class="form-group">
                                                <label for="rutaP">Tipo Usuario</label>
                                                <input v-model="usuario.tipo_usuario" type="number" name="tipoP"
                                                    id="tipoP" class="form-control"
                                                    placeholder="Ingrese el tipo de usuario" aria-describedby="">
                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cerrar</button>
                                            <button type="button" class="btn btn-primary" v-if="!isEditar"
                                                @click="crearUsuario()">Crear</button>
                                            <button type="button" class="btn btn-primary" v-if="isEditar"
                                                @click="guardarUsuario()">Guardar
                                                cambios</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class='col-sm-4 pull-right'>
                    <div id="custom-search-input">
                        <div class="input-group col-md-12">
                            <input type="text" class="form-control" v-model="valor" placeholder="Buscar" id="q" />
                            <span class="input-group-btn">
                                <button class="btn btn-info" type="button" @click="getUsuarios">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-sm-4 pull-right'>
                    <div class="form-group">
                        <select v-model="campo" class="form-control" name="campo" id="campo">
                            <option v-for="c in campos" :value="c">
                                {{c}}
                            </option>
                        </select>
                    </div>
                </div>
                <br><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">&nbsp;ID</th>
                            <th scope="col">&nbsp;Nombre</th>
                            <th scope="col">&nbsp;E-mail</th>
                            <th scope="col">&nbsp;Contraseña</th>
                           
                            <th scope="col">&nbsp;tipo_usuario</th>


                            <th scope="col">&nbsp;
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="p in usuarios">
                            <td>{{p.id}}</td>
                            <td>{{p.nombre}}</td>
                            <td>{{p.email}}</td>
                            <td>{{p.password}}</td>
                            <td>{{getUsuarioString(p.tipo_usuario)}}</td>
                            <td>
                                <button class="btn btn-danger" @click="eliminarUsuario(p)">
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                </button>
                                <button @click="editarUsuario(p)" class="btn btn-warning" data-toggle="modal"
                                    data-target="#nuevoUsuario">
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
                        usuarios: [],
                        usuario: {
                            nombre: '',  
                            tipo_usuario: 0,
                            email: '',
                            password:''
                        },
                        isEditar: false,
                        campo: 'nombre',
                        valor: '',
                        campos: [
                            'email',
                            
                            'tipo_usuario',
                            'nombre',
                            'password'
                        ]
                    },
                    created: function () {
                        this.getUsuarios();

                    },
                    methods: {
                        getUsuarios() {
                            console.log("campo:", this.campo, " => valor", this.valor);

                            $.ajax({
                                type: "POST",
                                url: 'controladores/api.php',
                                data: {
                                    servicio: "getUsuarios",
                                    campo: this.campo,
                                    valor: this.valor
                                },
                                success: function (respuesta) {
                                    respuesta = JSON.parse(respuesta);
                                    app.usuarios = respuesta;
                                }
                            });
                        },
                        eliminarUsuario(usuario) {
                            var respuesta = confirm("¿Estas seguro de eliminar el usuario: '" + usuario.nombre + "' ?");
                            if (respuesta) {
                                $.ajax({
                                    type: "POST",
                                    url: 'controladores/api.php',
                                    data: {
                                        servicio: "borrarUsuario",
                                        id: usuario.id
                                    },
                                    success: function (respuesta) {

                                        respuesta = JSON.parse(respuesta);
                                        app.getUsuarios();
                                    }
                                });
                            }
                        },

                        crearUsuario() {
                            $.ajax({
                                type: "POST",
                                url: 'controladores/api.php',
                                data: {
                                    servicio: "saveUsuario",
                                    usuario: this.usuario
                                },
                                success: function (respuesta) {
                                    $('#nuevoUsuario').modal('toggle');
                                    this.resetUsuario();
                                    app.getUsuarios();

                                }
                            });
                        },
                        resetUsuario() {
                            this.usuario = {
                                nombre: '',

                               
                                tipo_usuario: 0,
                                email: '',
                                password: ''
                            };
                        },
                        editarUsuario(usuario) {
                            this.isEditar = true;
                            this.usuario = Object.assign({}, usuario);
                        },
                        guardarUsuario() {
                            $.ajax({
                                type: "POST",
                                url: 'controladores/api.php',
                                data: {
                                    servicio: "actualizarUsuario",
                                    usuario: this.usuario,
                                    id: this.usuario.id,
                                },
                                success: function (respuesta) {
                                    app.getUsuarios();
                                    $('#nuevoUsuario').modal('toggle');
                                    this.resetUsuario();
                                }
                            });
                        },
                        getUsuarioString(tipo) {
                            if (parseInt(tipo) == 0) {
                                return "Administrador";
                            }
                            if (parseInt(tipo) == 1) {
                                return "Cliente";
                            }
                        }
                    }
                }
            );


        </script>
</body>

</html>