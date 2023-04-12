<?php
    require_once "general.php";

    function getStyles(){
        $con = createConnection();
        $consulta = $con->prepare("SELECT nombre, id FROM estilo");
        $consulta->bind_result($nombre, $id);
        $consulta->execute();
        while($consulta->fetch()) {
            echo "<option class=\"p-2\" value=\"$id\">$nombre</option>";
        }
        $consulta->close();
        $con->close();
    }

    function userNameRepeated($user){
        $exists = true;
        $con = createConnection();
        $consulta = $con->prepare("SELECT COUNT(*) from USUARIO where usuario = ?");
        $consulta->bind_param("s", $user);
        $consulta->bind_result($count);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();

        if($count == 0){
            $exists = false;
        }
        return $exists;
    }

    function mailRepeated($mail){
        $exists = true;
        $con = createConnection();
        $consulta = $con->prepare("SELECT COUNT(*) from USUARIO where correo =?");
        $consulta->bind_param("s", $mail);
        $consulta->bind_result($count);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();

        if($count == 0){
            $exists = false;
        }
        return $exists;
    }

    function insertNewUser($user, $nombre, $apellidos, $pass, $mail, $estilo){
        $con = createConnection();
        $consulta = $con->prepare("INSERT INTO USUARIO (usuario, nombre, apellidos, pass, correo, estilo) VALUES (?,?,?,?,?,?)");
        $consulta->bind_param("sssssi", $user, $nombre, $apellidos, $pass, $mail, $estilo);
        $consulta->execute();
        $consulta->close();
        $con->close();
    }