<?php
require './database.php';
session_start();

$db = new Database();

$totales = $db->getTotales();



?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="dark:text-slate-400 bg-white dark:bg-slate-900 min-h-screen">

    <nav class="sticky top-0 z-40 flex-none w-full mx-auto bg-white border-b border-gray-200 dark:border-gray-600 dark:bg-gray-800">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="./index.php" class="flex items-center">
                <img src="./assets/logo.jpeg" class="h-8 mr-3" alt="logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">
                    Artesanías de barro Sánchez
                </span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">

                    <li>
                        <a href="./index.php" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page">
                            Inicio
                        </a>
                    </li>

                    <li>
                        <a href="./carrito.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                            <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 902.86 902.86" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M671.504,577.829l110.485-432.609H902.86v-68H729.174L703.128,179.2L0,178.697l74.753,399.129h596.751V577.829z
			 M685.766,247.188l-67.077,262.64H131.199L81.928,246.756L685.766,247.188z" />
                                        <path d="M578.418,825.641c59.961,0,108.743-48.783,108.743-108.744s-48.782-108.742-108.743-108.742H168.717
			c-59.961,0-108.744,48.781-108.744,108.742s48.782,108.744,108.744,108.744c59.962,0,108.743-48.783,108.743-108.744
			c0-14.4-2.821-28.152-7.927-40.742h208.069c-5.107,12.59-7.928,26.342-7.928,40.742
			C469.675,776.858,518.457,825.641,578.418,825.641z M209.46,716.897c0,22.467-18.277,40.744-40.743,40.744
			c-22.466,0-40.744-18.277-40.744-40.744c0-22.465,18.277-40.742,40.744-40.742C191.183,676.155,209.46,694.432,209.46,716.897z
			 M619.162,716.897c0,22.467-18.277,40.744-40.743,40.744s-40.743-18.277-40.743-40.744c0-22.465,18.277-40.742,40.743-40.742
			S619.162,694.432,619.162,716.897z" />
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="./logout.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                            Cerrar sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container p-8  gap-8 w-full">
        <h2 class="relative group font-bold text-3xl mb-4">Mi Carrito</h2>
        <ul id="shopping-cart-list" class="divide-y max-w-md divide-gray-200 dark:divide-gray-700">

        </ul>
        <div id="total" class="flex max-w-md font-bold flex justify-end text-2xl">

        </div>

        <div class="flex justify-end max-w-md mt-6" id="button">
            <button onclick="finalizarCompra()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Finalizar compra
            </button>
        </div>
    </div>

</body>

<script>
    function quitar(index) {
        let carrito = JSON.parse(localStorage.getItem('carrito'));

        carrito.splice(index, 1);

        localStorage.setItem('carrito', JSON.stringify(carrito));

        window.location.reload();
    }

    function finalizarCompra() {
        let carrito = JSON.parse(localStorage.getItem('carrito'));

        fetch('./finalizar_compra.php', {
            method: 'POST',
            body: JSON.stringify({
                carrito
            }),
            headers: {
                "Content-Type": "application/json",
            },
        }).then(response => response.json().then(data => {
            const {
                ticket_id = {}
            } = data;
            const {
                id = null
            } = ticket_id;
            console.log("id", id);
            if (id) {
                localStorage.removeItem('carrito');
                const link = `./ticket.php?id=${id}`;
                window.location.href = link;
            }
        }))
    }

    window.onload = function() {

        let carrito = JSON.parse(localStorage.getItem('carrito')) ?? [];


        fetch('./cargar_carrito.php', {
            method: 'POST',
            body: JSON.stringify({
                carrito
            }),
            headers: {
                "Content-Type": "application/json",
            },
        }).then((response) => response.json().then((data) => {

            const productos = data.productos;
            let body = "";

            if (productos.length == 0) {
                body += `<div class="flex justify-center items-center" style="height: 400px">
                    <h1 class="text-2xl font-bold text-center">No hay productos en el carrito</h1>
                </div>`

                document.querySelector("#button").style.display = "none";
            } else {
                document.querySelector('#total').innerHTML = `Total: $${data.total}`;
            }

            for (let index in productos) {
                body += `
                <li class="pb-3 sm:pb-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="${productos[index].ruta_imagen}" alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            ${productos[index].nombre}
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                            ${productos[index].cantidad} ${productos[index].cantidad == 1? 'Unidad': 'Unidades'} 
                            </p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                ${productos[index].cantidad} x $${productos[index].precio} = $${productos[index].total}
                            </div>
                            <div onclick="quitar(${index})" class="text-sm flex justify-end font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">
                                Quitar
                            </div>
                        </div>
                    </div>
                </li>
                `;
            }

            document.querySelector('#shopping-cart-list').innerHTML = body;
        }))

    }
</script>

</html>