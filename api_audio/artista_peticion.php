<?php
    
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    sleep(1);
    $id = $_GET["id"];
    $sentencia_grupo = $conexion->query("select nombre, foto, foto_avatar, biografia, discografica from grupo where id = $id");
    $datos_grupo = [];
    
    while($fila = $sentencia_grupo->fetch_array(MYSQLI_ASSOC)){
        $datos_grupo[] = $fila;
    }
    $datos['datos_grupo'] = $datos_grupo;

    // $consulta_canciones = $conexion->query("select titulo, duracion, archivo from cancion c, incluye i where c.id = i.cancion and i.album = $id");
    // $datos_canciones = [];
    // while($fila = $consulta_canciones->fetch_array(MYSQLI_ASSOC)){
    //     $datos_canciones[] = $fila;
    // }
    // $datos["lista_canciones"] = $datos_canciones;

    echo json_encode($datos);