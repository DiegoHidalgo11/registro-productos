<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Producto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="contenedor">
        <h1>Formulario de Producto</h1>

        <form id="formProducto">
            <div class="fila">
                <div class="grupo">
                    <label for="codigo">Código</label>
                    <input type="text" id="codigo" name="codigo">
                </div>

                <div class="grupo">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre">
                </div>
            </div>

            <div class="fila">
                <div class="grupo">
                    <label for="bodega">Bodega</label>
                    <select id="bodega" name="bodega">
                        <option value="">Seleccione</option>
                    </select>
                </div>

                <div class="grupo">
                    <label for="sucursal">Sucursal</label>
                    <select id="sucursal" name="sucursal">
                        <option value="">Seleccione</option>
                    </select>
                </div>
            </div>

            <div class="fila">
                <div class="grupo">
                    <label for="moneda">Moneda</label>
                    <select id="moneda" name="moneda">
                        <option value="">Seleccione</option>
                    </select>
                </div>

                <div class="grupo">
                    <label for="precio">Precio</label>
                    <input type="text" id="precio" name="precio">
                </div>
            </div>

            <div class="grupo-materiales">
                <label>Material del Producto</label>
                <div id="materiales" class="materiales"></div>
            </div>

            <div class="grupo-descripcion">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion"></textarea>
            </div>

            <div class="contenedor-boton">
                <button type="button" onclick="guardarProducto()">Guardar Producto</button>
            </div>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>