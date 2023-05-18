<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $id = $_GET["id"];
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');

    $delete = $conexion->prepare("DELETE FROM contiene where lista = ?");
    $delete->bind_param('i', $id);
    $delete->execute();
    $delete->close();

    $delete_lista = $conexion->prepare("DELETE FROM lista where id = ?");
    $delete_lista->bind_param('i', $id);
    $delete_lista->execute();
    $delete_lista->close();

    $conexion->close();
