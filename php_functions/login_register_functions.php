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

    function mailRepeated($mail, $tabla){
        $exists = true;
        $con = createConnection();
        $consulta = $con->prepare("SELECT COUNT(*) from $tabla where correo = ?");
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
        $consulta = $con->prepare("INSERT INTO USUARIO (usuario, nombre, apellidos, pass, correo) VALUES (?,?,?,?,?,?)");
        $consulta->bind_param("sssssi", $user, $nombre, $apellidos, $pass, $mail);
        $consulta->execute();
        $consulta->close();
        $con->close();
    }

    function insertNewGroup($nombre, $pass, $mail){
        $con = createConnection();
        $consulta = $con->prepare("INSERT INTO grupo (nombre, pass, correo) VALUES (?,?,?)");
        $consulta->bind_param("sss", $nombre, $pass, $mail);
        $consulta->execute();
        $consulta->close();
        $con->close();
    }

    function insertNewDiscographic($nombre, $pass, $mail){
        $con = createConnection();
        $consulta = $con->prepare("INSERT INTO discografica (nombre, pass, correo) VALUES (?,?,?)");
        $consulta->bind_param("sss", $nombre, $pass, $mail);
        $consulta->execute();
        $consulta->close();
        $con->close();
    }

    function loginUser($user, $pass){
        $accede = false;
        $con = createConnection();
        $consulta = $con->prepare("SELECT count(*) FROM USUARIO WHERE usuario = ? and pass = ?");
        $consulta->bind_param("ss", $user, $pass);
        $consulta->bind_result($count);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        if($count == 1){
            $accede = true;
        }

        return $accede;
    }

    function loginGroupDisc($mail, $pass, $tabla){
        $accede = false;
        $con = createConnection();
        $consulta = $con->prepare("SELECT count(*) FROM $tabla WHERE correo = ? and pass = ? and activo = 1");
        $consulta->bind_param("ss", $mail, $pass);
        $consulta->bind_result($count);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        if($count == 1){
            $accede = true;
        }

        return $accede;
    }