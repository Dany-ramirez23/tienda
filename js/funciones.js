function agregarAlCarrito(carrito, articulo) {
  carrito.push(articulo);
  return carrito;
}

function calcularTotal(carrito) {
  return carrito.reduce((total, articulo) => total + articulo.precio, 0);
}
function aplicarDescuento(total, porcentajeDescuento) {
  return total - total * (porcentajeDescuento / 100);
}
