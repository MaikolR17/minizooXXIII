<!-- admin.php -->
<?php 
session_start();
    if (!isset($_SESSION["access"])) {
        header("Location: adm-login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
</head>
<body>

<!-- Formulario para agregar, modificar o eliminar especie -->
    <form action="CRUD.php" method="POST" enctype="multipart/form-data" id="animal-form">
<!--contenedor de la caja de alertas, donde se informan errores y acciones completadas correctamente-->
        <div class="cont-alert">
        <?php
        if (isset($_SESSION['status'])) {
            if ($_SESSION['status'] === "error") {
                echo "<p class=\"error\">".$_SESSION['message'].'</p>';
            } else{
                echo "<p class=\"success\">".$_SESSION['message'].'</p>';
            }
            unset($_SESSION['status']);
            unset($_SESSION['message']);
        }
        ?>
        </div>
    <!--Seleccion de la lista de accion a realizar-->
        <label for="functionality">¿Qué acción quieres realizar?</label>
        <select name="functionality" id="func" required>
            <option value="add">Agregar</option>
            <option value="update">Modificar</option>
            <option value="delete">Eliminar</option>
        </select>

        <!-- Campos para ingresar o modificar los datos -->
        <label for="name">Nombre Común:</label>
        <input type="text" name="name" id="name">
        <label for="alt_name">Nombre Alternativo:</label> 
        <input type="text" name="alt_name" id="alt_name">
        <label for="scient_name">Nombre científico:</label>
        <input type="text" name="scient_name" id="scient_name">
        <label for="order">Orden:</label>
        <input type="text" name="order" id="order">
        <label for="family">Familia:</label>
        <input type="text" name="family" id="family">
        <label for="description">Descripción:</label>
        <textarea name="description" id="description" rows="4" cols="50"></textarea>
        <label for="ecology">Ecología:</label>
        <textarea name="ecology" id="ecology" rows="4" cols="50"></textarea>
        <label for="distribution">Distribución:</label>
        <textarea name="distribution" id="distribution" rows="4" cols="50"></textarea>
        <label for="img">Imagen de Referencia: </label>
        <input type="file" name="img" id="img">

        <!-- Selección de especie para modificar o eliminar -->
        <?php
        $file = 'species.json';
        $list_species = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        ?>

        <label for="list-species">Elija un animal registrado:</label>
        <select name="list-species" id="list-species">
            <option value=""> --Seleccione una especie-- </option>
            <?php foreach ($list_species as $specie): ?>
                <option value="<?= htmlspecialchars($specie['id']) ?>">
                    <?= htmlspecialchars($specie['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit" id="submit-btn">Confirmar Acción</button>
    </form>
    
    <script>
        //seleccion de los elementos del DOM
        const funcSelect = document.getElementById("func");
        const animalList = document.getElementById("list-species");
        const inputs = document.querySelectorAll("input[type=text], textarea, input[type=file]");
        const submitButton = document.getElementById("submit-btn");
        //funcion para obtener los datos de la especie seleccionada y mostrarlos en los inputs recibe como parametro el id de la especie
        function loadSpecie(id) {
            fetch('get_animal.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById("name").value = data.name || "";
                        document.getElementById("alt_name").value = data.alt_name || "";
                        document.getElementById("scient_name").value = data.scient_name || "";
                        document.getElementById("order").value = data.order || "";
                        document.getElementById("family").value = data.family || "";
                        document.getElementById("description").value = data.description || "";
                        document.getElementById("ecology").value = data.ecology || "";
                        document.getElementById("distribution").value = data.distribution || "";
                    }
                })
                .catch(error => console.error("Error cargando datos:", error));
        }
        //evento para modificar el DOM dependiendo de la funcionalidad seleccionada
        funcSelect.addEventListener("change", function () {
            const value = this.value;

            if (value === "delete") { //se desactivan todos los inputs, se activa el select de la lista de especies y el boton cambia de nombre a 'Confirmar eliminacion'
                inputs.forEach(del => del.disabled = true);
                animalList.disabled = false;
                submitButton.textContent = "Confirmar Eliminación";
            } else if (value === "update") { //se activan todos los inputs, se activa el select de la lista de especies y el boton cambia de nombre a 'Confirmar Modificacion'
                inputs.forEach(del => del.disabled = false);
                animalList.disabled = false;
                submitButton.textContent = "Confirmar Modificación";
                // Si ya hay un animal seleccionado, cargarlo
                if (animalList.value) {
                    loadSpecie(animalList.value);
                }
            } else { //se activan todos los inputs, se desactiva el select de la lista de especies y el boton cambia de nombre a 'Agregar Especie'
                inputs.forEach(del => del.disabled = false);
                animalList.disabled = true;
                submitButton.textContent = "Agregar Especie";
            }
        });
        //evento para modificar el DOM dependiendo de la especie seleccionada
        animalList.addEventListener("change", function () {
            const action = funcSelect.value;
            //comprobar que la funcionalidad seleccionada sea update para no interferir con delete
            if (action === "update") {
                loadSpecie(this.value);
            }
        });
    </script>
</body>
</html>
