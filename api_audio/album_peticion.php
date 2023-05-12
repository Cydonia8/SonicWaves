<?php
    
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    sleep(1);
    $id = $_GET["id"];
    $sentencia = $conexion->query("select titulo, a.foto foto, nombre autor, lanzamiento, g.foto_avatar avatar from album a, grupo g where a.grupo = g.id and a.id = $id");
    $datos_album = [];
    
    while($fila = $sentencia->fetch_array(MYSQLI_ASSOC)){
        $datos_album[] = $fila;
    }
    $datos['datos_album'] = $datos_album;

    $consulta_canciones = $conexion->query("select titulo, duracion, archivo from cancion c, incluye i where c.id = i.cancion and i.album = $id");
    $datos_canciones = [];
    while($fila = $consulta_canciones->fetch_array(MYSQLI_ASSOC)){
        $datos_canciones[] = $fila;
    }
    $datos["lista_canciones"] = $datos_canciones;

    echo json_encode($datos);