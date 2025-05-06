<!-- admin.php -->
<?php session_start();?>

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
        <div class="cont-alert">
        <?php
        if (isset($_SESSION['status'])) {
            if ($_SESSION['status'] === "error") {
                echo '<p id="alerta" style="color:red;">Datos vacíos... ¡Rellénelos!</p>';
            } else if ($_SESSION['status'] === "success") {
                echo '<p id="alerta" style="color:green;">Animal agregado correctamente.</p>';
            }
            unset($_SESSION['status']);
        }
        ?>
        </div>

        <label for="functionality">¿Qué acción quieres tomar?</label>
        <select name="functionality" id="func" required>
            <option value="agregar">Agregar</option>
            <option value="modificar">Modificar</option>
            <option value="eliminar">Eliminar</option>
        </select> <br><br>

        <!-- Campos para ingresar o modificar los datos -->
        <label for="name">Nombre Común:</label>
        <input type="text" name="name" id="name"><br><br>
        <label for="name_alt">Nombre Alternativo:</label> 
        <input type="text" name="name_alt" id="name_alt"><br><br>
        <label for="name_sc">Nombre científico:</label>
        <input type="text" name="name_sc" id="name_sc"><br><br>
        <label for="orden">Orden:</label>
        <input type="text" name="orden" id="orden"><br><br>
        <label for="familia">Familia:</label>
        <input type="text" name="family" id="family"><br><br>
        <label for="desc">Descripción:</label>
        <textarea name="desc" id="desc" rows="4" cols="50"></textarea><br><br>
        <label for="ecologia">Ecología:</label>
        <textarea name="eco" id="eco" rows="4" cols="50"></textarea><br><br>
        <label for="distribution">Distribución:</label>
        <textarea name="distr" id="distr" rows="4" cols="50"></textarea><br><br>
        <label for="Imagen">Imagen de Referencia: </label>
        <input type="file" name="imagen" id="img"><br><br>

        <!-- Selección de especie para modificar o eliminar -->
        <?php
        $archivo = 'especies.json';
        $lista_animales = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];
        ?>

        <label for="list-animal">Elija un animal registrado:</label>
        <select name="list-animal" id="list-animal">
            <option value=""> --Seleccione un animal-- </option>
            <?php foreach ($lista_animales as $animal): ?>
                <option value="<?= htmlspecialchars($animal['id']) ?>">
                    <?= htmlspecialchars($animal['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit" id="submit-btn">Confirmar Acción</button>
    </form>

    <!-- Script para ocultar alerta despues de 5 segundos -->
    <script>
        setTimeout(function() {
            const alerta = document.getElementById('alerta');
            if (alerta) {
                alerta.style.display = 'none';
            }
        }, 5000);
    </script>

    <script>
        const funcSelect = document.getElementById("func");
        const animalList = document.getElementById("list-animal");
        const inputs = document.querySelectorAll("input[type=text], textarea, input[type=file]");
        const submitButton = document.getElementById("submit-btn");

        function cargarAnimal(id) {
            fetch('get_animal.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById("name").value = data.nombre || "";
                        document.getElementById("name_alt").value = data.nombre_alt || "";
                        document.getElementById("name_sc").value = data.nombre_cientifico || "";
                        document.getElementById("orden").value = data.orden || "";
                        document.getElementById("family").value = data.familia || "";
                        document.getElementById("desc").value = data.descripcion || "";
                        document.getElementById("eco").value = data.ecologia || "";
                        document.getElementById("distr").value = data.distribucion || "";
                    }
                })
                .catch(error => console.error("Error cargando datos:", error));
        }

        funcSelect.addEventListener("change", function () {
            const value = this.value;
            if (value === "eliminar") {
                inputs.forEach(el => el.disabled = true);
                animalList.disabled = false;
                submitButton.textContent = "Confirmar Eliminación";
            } else if (value === "modificar") {
                inputs.forEach(el => el.disabled = false);
                animalList.disabled = false;
                submitButton.textContent = "Confirmar Modificación";
                if (animalList.value) {
                    cargarAnimal(animalList.value);
                }
            } else {
                inputs.forEach(el => el.disabled = false);
                animalList.disabled = true;
                submitButton.textContent = "Agregar Animal";
            }
        });

        animalList.addEventListener("change", function () {
            const action = funcSelect.value;
            if (action === "modificar") {
                cargarAnimal(this.value);
            }
        });
    </script>
</body>
</html>
