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
  <title> Administrar Productos </title>
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
          <li class="nav-item active">
            <a class="nav-link" href="/productos.php">Productos</span></a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="/usuarios.php">Usuarios</span></a>
          </li>
          <li class="nav-item ">
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
              <h2>Administrar <b>Productos</b></h2>
            </div>
            <div class="col-sm-6" style="align-content: flex-end;">
              <br><br>
              <!-- Button trigger modal -->

              <div class="top-action-container">
                <button @click="isEditar = false" type="button" class="btn btn-success " data-toggle="modal" data-target="#nuevoProducto">
                  <i class="fa fa-plus"></i> <span>Agregar nuevo producto</span>
                </button>
              </div>

              <!-- Modal Crear producto-->
              <div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="khkj" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">

                      <h5 class="modal-title" v-if="!isEditar">Agregar nuevo producto</h5>
                      <h5 class="modal-title" v-if="isEditar">Editar producto</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="nombreP">Nombre producto</label>
                        <input v-model="producto.nombre" type="text" name="nombreP" id="nombreP" class="form-control" placeholder="Nombre del producto" aria-describedby="">
                      </div>

                      <div class="form-group">
                        <label for="precioP">Precio</label>
                        <input type="number" name="precioP" id="precioP" v-model="producto.precio" class="form-control" placeholder="Precio del producto" aria-describedby="">
                      </div>

                      <div class="form-group">
                        <label for="existenciasP">Existencias</label>
                        <input v-model="producto.existencias" type="number" name="existenciasP" id="existenciasP" class="form-control" placeholder="Existencias del producto" aria-describedby="">
                      </div>

                      <div class="form-group">
                        <label for="rutaP">Ruta Imagen</label>
                        <input v-model="producto.ruta_imagen" type="text" name="rutaP" id="rutaP" class="form-control" placeholder="Ingrese ruta de la imagen" aria-describedby="">
                      </div>


                      <div class="form-group">
                        <label for="categoriP">Categorias</label>
                        <select v-model="producto.id_categoria" class="form-control" name="categoriP" id="categoriP">
                          <option :value="c.id" v-for="c in categorias">
                            {{c.nombre}}
                          </option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="espec">Especificaciones</label>
                        <textarea v-model="producto.especificaciones" class="form-control" name="espec" id="espec" rows="3"></textarea>
                      </div>



                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button type="button" class="btn btn-primary" v-if="!isEditar" @click="crearProducto()">Crear</button>
                      <button type="button" class="btn btn-primary" v-if="isEditar" @click="guardarProducto()">Guardar
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
                <button class="btn btn-info" type="button" @click="getProductos">
                  <i class="fa fa-search"></i>
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

        <!-- Show zero state message -->
        <div class="alert alert-warning" role="alert" v-if="productos.length == 0">
          No hay productos
        </div>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">&nbsp;ID</th>
              <th scope="col">&nbsp;Nombre</th>
              <th scope="col">&nbsp;Especificaciones</th>
              <th scope="col">&nbsp;Precio</th>
              <th scope="col">&nbsp;Categoria</th>
              <th scope="col">&nbsp;Existencias</th>
              <th scope="col">&nbsp;Ruta_imagen</th>
              <th scope="col">&nbsp;Imagen</th>

              <th scope="col">&nbsp;
                Acciones
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="p in productos">
              <td>{{p.id}}</td>
              <td>{{p.nombre}}</td>
              <td>{{p.especificaciones}}</td>
              <td>{{p.precio}}</td>
              <td>{{p.categoria}}</td>
              <td>{{p.existencias}}</td>
              <td>
                {{p.ruta_imagen}}
              </td>
              <td>
                <img :src="p.ruta_imagen" width="80px">
              </td>
              <td>
                <button class="btn btn-danger" @click="eliminarProducto(p)">
                  <i class="fa fa-trash"></i>
                </button>
                <button @click="editarProducto(p)" class="btn btn-warning" data-toggle="modal" data-target="#nuevoProducto">
                  <i class="fa fa-pen"></i>
                </button>
              </td>
            </tr>

          </tbody>
        </table>
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
        productos: [],
        categorias: [],
        producto: {
          nombre: '',
          ruta_imagen: '',
          especificaciones: '',
          precio: 0,
          existencias: 0,
          ruta_imagen: '',
          id_categoria: ''
        },
        isEditar: false,
        campo: 'nombre',
        valor: '',
        campos: [
          'nombre',
          'especificaciones',
          'precio',
          'id_categoria',
          'existencias',
          'ruta_imagen'
        ]
      },
      created: function() {
        this.getProductos();
        this.getCategorias();
      },
      methods: {
        getProductos() {
          console.log("campo:", this.campo, " => valor", this.valor);
          $.ajax({
            type: "POST",
            url: 'controladores/api.php',
            data: {
              servicio: "getProductos",
              campo: this.campo,
              valor: this.valor
            },
            success: function(respuesta) {
              respuesta = JSON.parse(respuesta);
              app.productos = respuesta;
            }
          });
        },
        eliminarProducto(producto) {
          var respuesta = confirm("¿Estas seguro de eliminar el producto: '" + producto.nombre + "' ?");
          if (respuesta) {
            $.ajax({
              type: "POST",
              url: 'controladores/api.php',
              data: {
                servicio: "borrarProducto",
                id: producto.id
              },
              success: function(respuesta) {

                respuesta = JSON.parse(respuesta);
                app.getProductos = respuesta;
              }
            });
          }
        },
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
        crearProducto() {
          $.ajax({
            type: "POST",
            url: 'controladores/api.php',
            data: {
              servicio: "saveProducto",
              producto: this.producto
            },
            success: function(respuesta) {
              $('#nuevoProducto').modal('toggle');
              this.resetProducto();
              app.getProductos();

            }
          });
        },
        resetProducto() {
          this.producto = {
            nombre: '',
            ruta_imagen: '',
            especificaciones: '',
            precio: 0,
            existencias: 0,
            ruta_imagen: '',
            id_categoria: ''
          };
        },
        editarProducto(producto) {
          this.isEditar = true;
          this.producto = Object.assign({}, producto);
        },
        guardarProducto() {
          $.ajax({
            type: "POST",
            url: 'controladores/api.php',
            data: {
              servicio: "actualizarProducto",
              producto: this.producto,
              id: this.producto.id,
            },
            success: function(respuesta) {
              app.getProductos();
              $('#nuevoProducto').modal('toggle');
              this.resetProducto();
            }
          });
        }
      }
    });
  </script>

</body>

</html>

</html>