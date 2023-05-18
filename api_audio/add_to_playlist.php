<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root','','sonicwaves');

    $lista = $_GET["lista"];
    $cancion = $_GET["cancion"];

    $ultima_cancion = $conexion->prepare("SELECT orden from contiene where lista = ? order by orden desc limit 1");
    $ultima_cancion->bind_param('i', $lista);
    $ultima_cancion->bind_result($ultima);
    $ultima_cancion->execute();
    $ultima_cancion->fetch();
    $ultima_cancion->close();

    $orden = $ultima != '' ? ++$ultima : 1;



    $insert = $conexion->prepare("INSERT INTO contiene (lista, cancion, orden) values (?,?,?)");
    $insert->bind_param('iii', $lista, $cancion, $orden);
    $insert->execute();
    $insert->close();
    $conexion->close();