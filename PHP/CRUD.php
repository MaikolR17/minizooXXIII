<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: admin.php");
    exit;
}

//guardar imagen de la especie en el servidor
function saveImage() {
    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $tempName = $_FILES['img']['tmp_name'];
        $finalName = uniqid() . '_' . basename($_FILES['img']['name']);
        $location = '../img/' . $finalName;
        
        // Validación del archivo (tipo y tamaño)
        $allowedFormat = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($_FILES['img']['type'], $allowedFormat)) {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Formato de imagen no permitido.";
            header("Location: admin.php");
            exit;
        }

        if ($_FILES['img']['size'] > $maxSize) {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "La imagen es demasiado grande. El tamaño máximo es de 5MB.";
            header("Location: admin.php");
            exit;
        }

        move_uploaded_file($tempName, $location);
        return 'img/'.$finalName;
    }
    return ""; // En caso de que no haya imagen
}

// Generar una url para cada especie
function generateURL($id) {
    return "https://juanxiiizoo.infinityfreapp.com/specie_info.php?id=" . $id;
}

// Genera codigo qr basandose en la url
function generateQRCodeURL($url) {
    return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($url);
}

//agregar especie, recibe 2 parametros: array de especies y ruta del archivo json
function addSpecie(&$species, $file) {
    $new = [
        "id" => uniqid(),
        "name" => $_POST['name'],
        "alt_name" => $_POST['alt_name'],
        "scient_name" => $_POST['scient_name'],
        "order" => $_POST['order'],
        "family" => $_POST['family'],
        "description" => $_POST['description'],
        "ecology" => $_POST['ecology'],
        "distribution" => $_POST['distribution'],
        "img" => saveImage() // Si la imagen no se sube correctamente, será una cadena vacía
    ];
    //generar nuevo QR
    $new['url'] = generateURL($new['id']); // Si la URL no se genero correctamente, será una cadena vacía
    $new['qr'] = generateQRCodeURL($new['url']); // genera la imagen QR desde una API 

     // Validación de los campos
    if (
        empty($_POST['name']) || empty($_POST['order'])|| 
        empty($_POST['family']) || empty($_POST['description'])||
        empty($_POST['ecology']) || empty($_POST['distribution'])
    ) {
        $_SESSION['status'] = "error";
        $_SESSION['message'] = "Todos los campos son obligatorios. Por favor, complete todo el formulario.";
        //se elimina la imagen del servidor si se subio una imagen
        if(!empty($new['img'])){
            unlink($new['img']);
        }
        header("Location: admin.php");
        exit;
    }
    // Verificamos si la imagen está vacía (no se subió)
    if (empty($new['img'])) {
        $_SESSION['status'] = "error";
        $_SESSION['message'] = "La imagen es obligatoria. Por favor, sube una imagen.";
        header("Location: admin.php");
        exit;
    }

    // Validar si el nombre ya existe
    foreach ($species as $existing) {
        if (
            strcasecmp($existing['name'], $_POST['name']) === 0 ||
            strcasecmp($existing['alt_name'], $_POST['alt_name']) === 0 ||
            strcasecmp($existing['scient_name'], $_POST['scient_name']) === 0 
            ) {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Ya existe una especie con ese nombre.";
            // Si ya se subió imagen, se elimina para evitar basura en el servidor
            if (!empty($new['img'])) {
                unlink($new['img']);
            }
            header("Location: admin.php");
            exit;
        }
    }
    
    //añadir nueva especie al array y escribir en el json
    $species[] = $new;
    file_put_contents($file, json_encode($species, JSON_PRETTY_PRINT));
    $_SESSION['status'] = "success";
    $_SESSION['message'] = "Especie agregada correctamente.";
    header("Location: admin.php");
    exit;
}

//actualizar especie, recibe 2 parametros: array de especies y ubicacion del archivo json
function updateSpecie(&$species, $file) {
    $id = $_POST['list-species'];

    foreach ($species as &$specie) {
        if ($specie['id'] === $id) {
            $specie['name'] = $_POST['name'];
            $specie['alt_name'] = $_POST['alt_name'];
            $specie['scient_name'] = $_POST['scient_name'];
            $specie['order'] = $_POST['order'];
            $specie['family'] = $_POST['family'];
            $specie['description'] = $_POST['description'];
            $specie['ecology'] = $_POST['ecology'];
            $specie['distribution'] = $_POST['distribution'];

            // Solo si se subió una nueva imagen
            if (!empty($_FILES['img']['name'])) {
                //se elimina la imagen anterior antes de guardar una nueva
                unlink('../'.$specie['img']);
                //se guarda la nueva imagen
                $specie['img'] = saveImage();
            }

            file_put_contents($file, json_encode($species, JSON_PRETTY_PRINT));
            $_SESSION['status'] = "success";
            $_SESSION['message'] = "Especie actualizada correctamente.";
            header("Location: admin.php");
            exit;
        }
    }

    $_SESSION['status'] = "error";
    $_SESSION['message'] = "No se pudo modificar la especie.";
    header("Location: admin.php");
    exit;
}

//eliminar especie. recibe 2 parametros: el array de especies y la ruta del archivo json
function deleteSpecie(&$species, $file) {
    $id = $_POST['list-species'];
    //eliminar la imagen de la especie del servidor
    foreach($species as $specie){
        if($id == $specie['id']){
            unlink('../'.$specie['img']);
        }
    }
    $newList = array_filter($species, fn($specie) => $specie['id'] !== $id);
    //reescribir el archivo json con todas las especies, excepto la eliminada
    file_put_contents($file, json_encode(array_values($newList), JSON_PRETTY_PRINT));

    $_SESSION['status'] = "success";
    $_SESSION['message'] = "La especie seleccionada fue eliminada correctamente.";
    header("Location: admin.php");
    exit;
}


$action = $_POST['functionality']; // 'agregar', 'modificar' o 'eliminar'

// 1. Leer JSON actual
$file = '../species.json';
$species = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

//llamada a la funcion dependiendo de la accion del usuario
switch ($action) {
    case 'add':
        addSpecie($species, $file);
        break;
    case 'update':
        updateSpecie($species, $file);
        break;
    case 'delete':
        deleteSpecie($species, $file);
        break;
    default:
        $_SESSION['status'] = "error";
        $_SESSION['message'] = "No se ha seleccionado ninguna opcion";
        header("Location: admin.php");
        exit;
}
