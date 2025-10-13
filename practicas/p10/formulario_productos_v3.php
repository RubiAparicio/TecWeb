<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <script type="text/javascript">
        function validarProductos() {
            var nombre = document.getElementById('form-nombre').value;
            var marca = document.getElementById('form-marca').value;
            var modelo = document.getElementById('form-modelo').value;
            var precio = document.getElementById('form-precio').value;
            var detalles = document.getElementById('form-detalles').value;
            var unidades = document.getElementById('form-unidades').value;
            var imagen = document.getElementById('form-imagen').value;
            precio = parseFloat(precio);
            unidades = parseInt(unidades);
            if (nombre == "" || nombre.length>100) {
                alert('El nombre es requerido y debe tener máximo 100 caracteres!');
                return false;
            }
            if (marca == "") {
                alert('Debes seleccionar una marca!');
                return false;
            }
            const regexModelo = /^[a-zA-Z0-9]+$/;
            if (modelo == "" || !regexModelo.test(modelo) || modelo.length > 25) {
                alert('El modelo es requerido, alfanúmerico y máximo 25 caracteres!');
                return false;
            }
            if (precio == "" || precio <= 99.99) {
                alert('El precio es requerido y debe ser mayor a $99.99!');
                return false;
            }
            if (detalles.length > 250) {
                alert('Los detalles no pueden tener más de 250 caracteres!');
                return false;
            }
            if (unidades == "" || unidades < 0) {
                alert('Las unidades son requeridas y deben ser mayor o igual a 0!');
                return false;
            }
            if (imagen == "") {
                const inputOculto = document.createElement("input");
                inputOculto.type = "hidden";
                inputOculto.name = "imagen_defecto";
                inputOculto.value = "img/imagen.png";
                document.getElementById("formulario").appendChild(inputOculto);
            }
            return true;
        }
    </script>
    <h1>Registro de nuevos productos</h1>
    <form id="formulario" action="update_producto.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Detalles del Producto</legend>
            <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>">
            
            <label for="form-nombre">Nombre del Producto: </label>
            <input type="text" name="nombre_producto" id="form-nombre" value="<?= isset($_GET['nombre']) ? $_GET['nombre'] : '' ?>"><br>

            <label for="form-marca">Marca del Producto: </label>
            <select name="marca_producto" id="form-marca">
                <option value="">Seleccione</option>
                <option value="Samsung" <?= (isset($_GET['marca']) && $_GET['marca'] == 'Samsung') ? 'selected' : '' ?>>Samsung</option>
                <option value="Huawei" <?= (isset($_GET['marca']) && $_GET['marca'] == 'Huawei') ? 'selected' : '' ?>>Huawei</option>
                <option value="Apple" <?= (isset($_GET['marca']) && $_GET['marca'] == 'Apple') ? 'selected' : '' ?>>Apple</option>
                <option value="Motorola" <?= (isset($_GET['marca']) && $_GET['marca'] == 'Motorola') ? 'selected' : '' ?>>Motorola</option>
                <option value="Xiaomi" <?= (isset($_GET['marca']) && $_GET['marca'] == 'Xiaomi') ? 'selected' : '' ?>>Xiaomi</option>
            </select><br>

            <label for="form-modelo">Modelo del Producto: </label>
            <input type="text" name="modelo_producto" id="form-modelo" value="<?= isset($_GET['modelo']) ? $_GET['modelo'] : '' ?>"><br>

            <label for="form-precio">Precio del Producto: </label>
            <input type="number" name="precio_producto" id="form-precio" step="0.01" value="<?= isset($_GET['precio']) ? $_GET['precio'] : '' ?>"><br>

            <label for="form-unidades">Unidades del Producto: </label>
            <input type="number" name="unidades_producto" id="form-unidades" value="<?= isset($_GET['unidades']) ? $_GET['unidades'] : '' ?>"><br>

            <label for="form-detalles">Detalles del Producto: </label>
            <textarea name="detalles_producto" id="form-detalles" rows="4" cols="60"><?= isset($_GET['detalles']) ? $_GET['detalles'] : '' ?></textarea><br>

            <label for="form-imagen">Imagen del Producto: </label>
            <input type="text" name="imagen_producto" id="form-imagen" value="<?= isset($_GET['imagen']) ? $_GET['imagen'] : '' ?>"><br>
        </fieldset>
        <input type="submit" value="Actualizar">
    </form>
</body>
</html>