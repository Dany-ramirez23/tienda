<html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Administrar Productos </title>
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
              <h2>Administrar <b>Productos</b></h2>
            </div>
            <div class="col-sm-6" style="align-content: flex-end;">
              <br><br>
              <!-- Button trigger modal -->
              <button @click="isEditar = false" type="button" class="btn btn-success " data-toggle="modal"
                data-target="#nuevoProducto">
                <i class="material-icons">&#xE147;</i> <span>Agregar nuevo producto</span>
              </button>

              <!-- Modal Crear producto-->
              <div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="khkj"
                aria-hidden="true">
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
                        <input v-model="producto.nombre" type="text" name="nombreP" id="nombreP" class="form-control"
                          placeholder="Nombre del producto" aria-describedby="">
                      </div>

                      <div class="form-group">
                        <label for="precioP">Precio</label>
                        <input type="number" name="precioP" id="precioP" v-model="producto.precio" class="form-control"
                          placeholder="Precio del producto" aria-describedby="">
                      </div>

                      <div class="form-group">
                        <label for="existenciasP">Existencias</label>
                        <input v-model="producto.existencias" type="number" name="existenciasP" id="existenciasP"
                          class="form-control" placeholder="Existencias del producto" aria-describedby="">
                      </div>

                      <div class="form-group">
                        <label for="rutaP">Ruta Imagen</label>
                        <input v-model="producto.ruta_imagen" type="text" name="rutaP" id="rutaP" class="form-control"
                          placeholder="Ingrese ruta de la imagen" aria-describedby="">
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
                        <textarea v-model="producto.especificaciones" class="form-control" name="espec" id="espec"
                          rows="3"></textarea>
                      </div>



                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button type="button" class="btn btn-primary" v-if="!isEditar"
                        @click="crearProducto()">Crear</button>
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
                  <span class="glyphicon glyphicon-remove-sign"></span>
                </button>
                <button @click="editarProducto(p)" class="btn btn-warning" data-toggle="modal"
                  data-target="#nuevoProducto">
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
          created: function () {
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
                success: function (respuesta) {
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
                  success: function (respuesta) {

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
                success: function (respuesta) {
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
                success: function (respuesta) {
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
                success: function (respuesta) {
                  app.getProductos();
                  $('#nuevoProducto').modal('toggle');
                  this.resetProducto();
                }
              });
            }
          }
        }
      );


    </script>
</body>

</html>

</html>