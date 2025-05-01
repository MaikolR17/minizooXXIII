<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: admin.php");
    exit;
}

function guardarImagen() {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $nombreTemp = $_FILES['imagen']['tmp_name'];
        $nombreFinal = uniqid() . '_' . basename($_FILES['imagen']['name']);
        $destino = 'imgs/' . $nombreFinal;
        
        // Validación del archivo (tipo y tamaño)
        $tipoPermitido = ['image/jpeg', 'image/png', 'image/gif'];
        $tamañoMaximo = 5 * 1024 * 1024; // 5MB

        if (!in_array($_FILES['imagen']['type'], $tipoPermitido)) {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Formato de imagen no permitido.";
            header("Location: admin.php");
            exit;
        }

        if ($_FILES['imagen']['size'] > $tamañoMaximo) {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "La imagen es demasiado grande. El tamaño máximo es de 5MB.";
            header("Location: admin.php");
            exit;
        }

        move_uploaded_file($nombreTemp, $destino);
        return $destino;
    }
    return ""; // En caso de que no haya imagen
}

function agregarAnimal(&$animales, $archivo) {
    $nuevo = [
        "id" => uniqid(),
        "nombre" => $_POST['name'],
        "nombre_alt" => $_POST['name_alt'],
        "nombre_cientifico" => $_POST['name_sc'],
        "orden" => $_POST['orden'],
        "familia" => $_POST['family'],
        "descripcion" => $_POST['desc'],
        "ecologia" => $_POST['eco'],
        "distribucion" => $_POST['distr'],
        "imagen" => guardarImagen() // Si la imagen no se sube correctamente, será una cadena vacía
    ];

     // Validación de los campos
    if (
        empty($_POST['name']) || empty($_POST['name_alt']) || empty($_POST['name_sc']) ||
        empty($_POST['orden']) || empty($_POST['family']) || empty($_POST['desc']) ||
        empty($_POST['eco']) || empty($_POST['distr'])
    ) {
        $_SESSION['status'] = "error";
        $_SESSION['message'] = "Todos los campos son obligatorios. Por favor, complete todo el formulario.";
        header("Location: admin.php");
        exit;
    }
    // Verificamos si la imagen está vacía (no se subió)
    if (empty($nuevo['imagen'])) {
        $_SESSION['status'] = "error";
        $_SESSION['message'] = "La imagen es obligatoria. Por favor, sube una imagen.";
        header("Location: admin.php");
        exit;
    }

    $animales[] = $nuevo;
    file_put_contents($archivo, json_encode($animales, JSON_PRETTY_PRINT));
    $_SESSION['status'] = "success";
    $_SESSION['message'] = "Animal agregado correctamente.";
    header("Location: admin.php");
    exit;
}


function modificarAnimal(&$animales, $archivo) {
    $id = $_POST['list-animal'];

    foreach ($animales as &$animal) {
        if ($animal['id'] === $id) {
            $animal['nombre'] = $_POST['name'];
            $animal['nombre_alt'] = $_POST['name_alt'];
            $animal['nombre_cientifico'] = $_POST['name_sc'];
            $animal['orden'] = $_POST['orden'];
            $animal['familia'] = $_POST['family'];
            $animal['descripcion'] = $_POST['desc'];
            $animal['ecologia'] = $_POST['eco'];
            $animal['distribucion'] = $_POST['distr'];

            // Solo si se subió una nueva imagen
            if (!empty($_FILES['imagen']['name'])) {
                $animal['imagen'] = guardarImagen();
            }

            file_put_contents($archivo, json_encode($animales, JSON_PRETTY_PRINT));
            $_SESSION['status'] = "success";
            header("Location: admin.php");
            exit;
        }
    }

    $_SESSION['status'] = "error";
    header("Location: admin.php");
    exit;
}

function eliminarAnimal(&$animales, $archivo) {
    $id = $_POST['list-animal'];
    $nuevaLista = array_filter($animales, fn($a) => $a['id'] !== $id);

    file_put_contents($archivo, json_encode(array_values($nuevaLista), JSON_PRETTY_PRINT));
    $_SESSION['status'] = "success";
    header("Location: admin.php");
    exit;
}


$accion = $_POST['functionality']; // 'agregar', 'modificar' o 'eliminar'

// 1. Leer JSON actual
$archivo = 'especies.json';
$animales = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

switch ($accion) {
    case 'agregar':
        agregarAnimal($animales, $archivo);
        break;
    case 'modificar':
        modificarAnimal($animales, $archivo);
        break;
    case 'eliminar':
        eliminarAnimal($animales, $archivo);
        break;
    default:
        $_SESSION['status'] = "error";
        header("Location: admin.php");
        exit;
}