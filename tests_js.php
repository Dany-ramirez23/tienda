<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pruebas JS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jasmine-core@3.7.1/lib/jasmine-core/jasmine.css">
    <script src="https://cdn.jsdelivr.net/npm/jasmine-core@3.7.1/lib/jasmine-core/jasmine.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jasmine-core@3.7.1/lib/jasmine-core/jasmine-html.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jasmine-core@3.7.1/lib/jasmine-core/boot.js"></script>
    <script src="./js/funciones.js"></script>

</head>

<body>


    <script>
        describe("Función agregarAlCarrito", function() {
            it("debe agregar un artículo al carrito", function() {
                var carrito = [];
                var articulo = {
                    id: 1,
                    nombre: "camiseta",
                    precio: 10.0
                };

                var resultado = agregarAlCarrito(carrito, articulo);

                expect(resultado.length).toBe(1);
                expect(resultado[0]).toEqual(articulo);
            });
        });

        describe("Función calcularTotal", function() {
            it("debe calcular el total correcto", function() {
                var carrito = [{
                        id: 1,
                        nombre: "camiseta",
                        precio: 10.0
                    },
                    {
                        id: 2,
                        nombre: "pantalón",
                        precio: 20.0
                    }
                ];

                var total = calcularTotal(carrito);

                expect(total).toBe(30.0);
            });
        });
        describe("Función aplicarDescuento", function() {
            it("debe aplicar un descuento correcto", function() {
                var totalOriginal = 100.0;
                var descuento = 10; // 10%

                var totalConDescuento = aplicarDescuento(totalOriginal, descuento);

                expect(totalConDescuento).toBe(90.0);
            });
        });
    </script>
</body>

</html>