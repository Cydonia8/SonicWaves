<?php
    
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    sleep(1);
    $id = $_GET["id"];
    $sentencia = $conexion->query("select titulo, a.foto foto, nombre autor, lanzamiento, g.foto_avatar avatar, g.id id_grupo from album a, grupo g where a.grupo = g.id and a.id = $id");
    $datos_album = [];
    
    while($fila = $sentencia->fetch_array(MYSQLI_ASSOC)){
        $datos_album[] = $fila;
    }
    $datos['datos_album'] = $datos_album;

    $consulta_canciones = $conexion->query("select i.album album, titulo, duracion, archivo, e.nombre estilo from cancion c, incluye i, estilo e where c.id = i.cancion and e.id = c.estilo and i.album = $id");
    $datos_canciones = [];
    while($fila = $consulta_canciones->fetch_array(MYSQLI_ASSOC)){
        $datos_canciones[] = $fila;
    }
    $datos["lista_canciones"] = $datos_canciones;

    echo json_encode($datos);
    $conexion->close();