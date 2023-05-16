<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $fecha = date('Y-m-d');
    $usuario = $_SESSION["user"];
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    $id_user = $conexion->prepare("SELECT id from usuario where usuario = ?");
    $id_user->bind_param('s', $usuario);
    $id_user->bind_result($id);
    $id_user->execute();
    $id_user->fetch();
    $id_user->close;

    $crear = $conexion->prepare("INSERT INTO lista (nombre, foto, fecha_creacion, usuario) values (?,?,?,?)");
    $crear->bind_param('sssi', $nombre, $foto, $fecha, $id);
    $crear->execute();