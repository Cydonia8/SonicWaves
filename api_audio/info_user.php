<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin:*");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    $usuario = $_GET["usuario"];
    $sentencia = $conexion->prepare("select u.foto_avatar foto_avatar, u.nombre nombre, apellidos, usuario, u.pass pass, u.correo correo, e.nombre estilo, g.nombre grupo from usuario u, estilo e, grupo g where u.estilo = e.id and u.grupo = g.id and u.usuario = ?");
    $datos = [];
    $sentencia->bind_param('s', $usuario);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    
    while($fila = $resultado->fetch_assoc()){
        $datos[] = $fila;
    }
    $info['datos'] = $datos;
    

    echo json_encode($info);