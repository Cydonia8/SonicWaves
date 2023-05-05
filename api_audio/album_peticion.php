<?php
    
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    sleep(1);
    $id = $_GET["id"];
    $sentencia = $conexion->query("select titulo, a.foto foto, nombre autor from album a, grupo g where a.grupo = g.id and a.id = $id");
    $datos = [];
    
    while($fila = $sentencia->fetch_array(MYSQLI_ASSOC)){
        $datos[] = $fila;
    }
    $info['datos'] = $datos;

    echo json_encode($info);