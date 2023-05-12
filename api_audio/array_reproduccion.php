<?php
    
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    // sleep(1);
    $id = $_GET["id"];
    $sentencia_lista = $conexion->query("select archivo, g.nombre autor, a.foto caratula, c.titulo titulo from cancion c, incluye i, album a, grupo g where i.cancion = c.id and a.id = i.album and a.grupo = g.id and i.album = $id");
    $datos_lista = [];
    
    while($fila = $sentencia_lista->fetch_array(MYSQLI_ASSOC)){
        $datos_lista[] = $fila;
    }
    $datos['lista_canciones'] = $datos_lista;

    // $consulta_canciones = $conexion->query("select titulo, duracion, archivo from cancion c, incluye i where c.id = i.cancion and i.album = $id");
    // $datos_canciones = [];
    // while($fila = $consulta_canciones->fetch_array(MYSQLI_ASSOC)){
    //     $datos_canciones[] = $fila;
    // }
    // $datos["lista_canciones"] = $datos_canciones;

    echo json_encode($datos);