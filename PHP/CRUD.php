<?php
session_start();
require_once 'conex.php';

$db = new ConexionDB();

if (!$db->conectar()) {
    setError("No se pudo conectar a la base de datos: " . $db->getError());
}

$conn = $db->getConexion();

function setError(string $msg) {
    $_SESSION['status'] = "error";
    $_SESSION['message'] = $msg;
    header("Location: admin.php");
    exit;
}

function setSuccess(string $msg) {
    $_SESSION['status'] = "success";
    $_SESSION['message'] = $msg;
    header("Location: admin.php");
    exit;
}

function saveImage() {
    if (!isset($_FILES['img']) || $_FILES['img']['error'] !== 0) {
        setError("No se recibió ninguna imagen válida.");
    }

    $temp = $_FILES['img']['tmp_name'];
    $name = basename($_FILES['img']['name']);
    $uniqueName = $name;

    $relativePath = 'img/' . $uniqueName;
    $fullPath = '../' . $relativePath;

    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    $max = 5 * 1024 * 1024;

    if (!in_array($_FILES['img']['type'], $allowed)) {
        setError("Formato de imagen no permitido. Solo JPG, PNG y GIF.");
    }

    if ($_FILES['img']['size'] > $max) {
        setError("La imagen excede el tamaño máximo de 5MB.");
    }

    if (!is_dir('../img')) {
        mkdir('../img', 0777, true);
    }

    if (!move_uploaded_file($temp, $fullPath)) {
        setError("Error al guardar la imagen.");
    }

    return $relativePath;
}

function generateURL(string $id): string {
    return "https://juanxxiiizoo.infinityfreeapp.com/specie_info.php?id=" . $id;
}

function generateQRCodeURL(string $url): string {
    return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($url);
}


/**
 * Escribe en el historial de registros en un archivo .txt
 * 
 * @param string $admName Nombre del administrador que realizo la accion
 * @param string $action Accion realizada por el administrador
 * @param string $specieName Nombre de la especie
 * @param int $id ID de la especie
 * @return void No devuelve ningun valor
 */
function writeFile(string $admName,string $action,string $specieName,int $id):void{
    $regDir = '../reg/AdminHistory.json';
    $file = file_exists($regDir)? file_get_contents($regDir): [];   
    $decodedFile = json_decode($file,true)? : [];
    date_default_timezone_set('America/Asuncion');
    $text = date("d/m/Y H:i")."- ".$admName." ".$action." la especie de nombre: \"".$specieName."\" y id ".$id;
    $history = [
        'Accion del administrador' => $text
    ];
    $decodedFile[] = $history;
    if(file_exists($regDir)){
        file_put_contents($regDir, json_encode($decodedFile,JSON_PRETTY_PRINT));
    }else{
        setError("Error en la escritura del registro, ponte en contacto con los desarrolladores.");
    }
}

function generateQRCodeImage(string $url, string $id): string {
    $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($url);

    $qrDir = '../img/';
    if (!is_dir($qrDir)) {
        mkdir($qrDir, 0777, true);
    }

    $qrFilename = 'qr_' . $id .'.png';
    $qrPath = $qrDir . $qrFilename;
    $qrRelative = 'img/' . $qrFilename;

    $qrImage = file_get_contents($qrApiUrl);
    file_put_contents($qrPath, $qrImage);

    return $qrRelative; 
}


function addSpecie(mysqli $conn) {
    $img = saveImage();

    $requiredFields = ['name', 'specie_order', 'family', 'description', 'ecology', 'distribution'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            if (!empty($img)) { unlink('../' . $img); }
            setError("Todos los campos son obligatorios.");
        }
    }
    if (empty($img)) {
        setError("La imagen es obligatoria.");
    }

    $place = empty($_POST['place'])? NULL: $conn->real_escape_string($_POST['place']);
    $name = $conn->real_escape_string($_POST['name']);
    $alt_name = empty($_POST['alt_name'])? NULL : $conn->real_escape_string($_POST['alt_name']);
    $scient_name = empty($_POST['scient_name'])? NULL: $conn->real_escape_string($_POST['scient_name']);
    $specie_order = $conn->real_escape_string($_POST['specie_order']);
    $family = $conn->real_escape_string($_POST['family']);
    $description = $conn->real_escape_string($_POST['description']);
    $ecology = $conn->real_escape_string($_POST['ecology']);
    $distribution = $conn->real_escape_string($_POST['distribution']);
    $img = $conn->real_escape_string($img);

    $check = "SELECT id FROM especies WHERE name = '$name' OR COALESCE(alt_name) = '$alt_name' OR COALESCE(scient_name) = '$scient_name' LIMIT 1";
    $res = mysqli_query($conn, $check);
    if ($res && mysqli_num_rows($res) > 0) {
        if (!empty($img)) { unlink('../' . $img); }
        setError("Ya existe una especie con ese nombre.");
    }

    $sql = "INSERT INTO especies (place, name, alt_name, scient_name, img, specie_order, family, description, ecology, distribution)
            VALUES ('$place', '$name', '$alt_name', '$scient_name', '$img', '$specie_order', '$family', '$description', '$ecology', '$distribution')";

    if (!mysqli_query($conn, $sql)) {
        if (!empty($img)) unlink('../' . $img);
        setError("Error al agregar la especie: " . mysqli_error($conn));
    }
    
    $id = $conn->insert_id;
    $url = generateURL($id);
    $qrApiUrl = generateQRCodeURL($url);

    // Ruta donde se guardará localmente
    $qrFilename = 'qr_' . $id . '.png';
    $qrRelativePath = 'img/' . $qrFilename;
    $qrFullPath = '../' . $qrRelativePath;

    // Descargar la imagen QR y guardarla localmente
    $qrImage = file_get_contents($qrApiUrl);
    if ($qrImage === false) {
        if (!empty($img)) unlink('../' . $img);
        setError("Error al generar o guardar el código QR.");
    }
    file_put_contents($qrFullPath, $qrImage);

    $updateQR = "UPDATE especies SET qr_url = '$url', qr_img = '$qrRelativePath' WHERE id = $id";

    mysqli_query($conn, $updateQR);

    //writeFile($_SESSION['admin'],"agrego",$_POST['name'],intval($id));

    setSuccess("Especie agregada correctamente.");
}


function updateSpecie(mysqli $conn) {
    $id = $_POST['list-species'];
    $img = saveImage();
    
    $updates = [
        "place" => empty($_POST['place'])? NULL: $_POST['place'],
        "name" => $_POST['name'],
        "alt_name" => empty($_POST['alt_name'])? NULL : $_POST['alt_name'],
        "scient_name" => empty($_POST['scient_name'])? NULL : $_POST['scient_name'],
        "specie_order" => $_POST['specie_order'],
        "family" => $_POST['family'],
        "description" => $_POST['description'],
        "ecology" => $_POST['ecology'],
        "distribution" => $_POST['distribution']
    ];
    
    if (!empty($img)) {
        $updates["img"] = $img;
    }
    
    foreach (['name', 'specie_order', 'family', 'description', 'ecology', 'distribution'] as $field) {
        if (empty($updates[$field])) {
            if (!empty($img)) unlink('../' . $img);
            setError("Todos los campos son obligatorios.");
        }
    } 
    
    $sql_parts = [];
    foreach ($updates as $field => $value) {
        if(is_null($value)){
            $sql_parts[] = "`$field` = NULL";
        }else{
            $sql_parts[] = "`$field` = '" . $conn->real_escape_string($value) . "'";
        }
    }
    
    $sql = "UPDATE especies SET " . implode(", ", $sql_parts) . " WHERE id = '" . $conn->real_escape_string($id) . "'";
    
    if (!mysqli_query($conn, $sql)) {
        if (!empty($img)) unlink('../' . $img);
        setError("Error al actualizar la especie: " . mysqli_error($conn));
    }

    //writeFile($_SESSION['admin'],"modifico",$updates['name'],intval($id));

    setSuccess("Especie modificada correctamente.");
}

function deleteSpecie(mysqli $conn) {
    $id = $_POST['list-species'];

    // Obtener las rutas de imagen y QR de la especie
    $res = mysqli_query($conn, "SELECT img, qr_img FROM especies WHERE id = '" . $conn->real_escape_string($id) . "'");
    
    if ($res && mysqli_num_rows($res) > 0) {
        $data = mysqli_fetch_assoc($res);

        $img = $data['img'];
        $qr = $data['qr_img'];
        $name = $data['name'];

        // Eliminar imagen si existe
        if (!empty($img) && file_exists('../' . $img)) {
            unlink('../' . $img);
        }

        // Eliminar QR si existe
        if (!empty($qr) && file_exists('../' . $qr)) {
            unlink('../' . $qr);
        }
    }

    // Eliminar la especie de la base de datos
    $sql = "DELETE FROM especies WHERE id = '" . $conn->real_escape_string($id) . "'";
    if (!mysqli_query($conn, $sql)) {
        setError("Error al eliminar la especie: " . mysqli_error($conn));
    }

    if(isset($id)) {
        //writeFile($_SESSION['admin'],"agrego",$_POST['name'],intval($id));
        setSuccess("La especie fue eliminada correctamente.");
    } else {
        setError("¡No seleccionaste ninguna especie!");
    }
}

$action = $_POST['functionality'] ?? '';

switch ($action) {
    case 'add':
        addSpecie($conn);
        break;
    case 'update':
        updateSpecie($conn);
        break;
    case 'delete':
        deleteSpecie($conn);
        break;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Location: admin.php");
}

?>
