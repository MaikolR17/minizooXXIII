<?php
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
    $history = [
        'date' => date("d/m/Y H:i"),
        'admin' => $admName,
        'action' => $action,
        'specie' => $specieName,
        'id' => $id
    ];
    $decodedFile[] = $history;
    if(file_exists($regDir)){
        file_put_contents($regDir, json_encode($decodedFile,JSON_PRETTY_PRINT));
    }
}

?>
