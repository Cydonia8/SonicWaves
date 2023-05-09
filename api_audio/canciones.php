<?php
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    sleep(1);
    $sentencia = $conexion->query("select titulo, archivo, estilo from cancion order by rand() limit 1");
    $datos = [];
    
    while($fila = $sentencia->fetch_array(MYSQLI_ASSOC)){
        $datos[] = $fila;
    }
    $info['datos'] = $datos;

    echo json_encode($info);