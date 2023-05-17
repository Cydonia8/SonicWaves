<?php
    session_start();
    require_once "../php_functions/general.php";
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
    $id_user->close();
    $nuevo_id = getAutoID("lista");
    if(isset($_POST["nombre"])){
        $nombre = $_POST["nombre"];
        if(isset($_FILES["foto"]["type"])){
            $foto_type = $_FILES["foto"]["type"];
            $nuevo_nombre;
            switch($foto_type){
                case "image/jpeg":
                    $nuevo_nombre = $usuario.'lista'.$nuevo_id.'.jpeg';
                    break;
                case "image/webp":
                    $nuevo_nombre = $usuario.'lista'.$nuevo_id.'.webp';
                    break;
                case "image/png":
                    $nuevo_nombre = $usuario.'lista'.$nuevo_id.'.png';
                    break;
            }
            if(!file_exists('../media/img_users/'.$usuario)){
                mkdir('../media/img_users/'.$usuario);
            }
            $nueva_ruta = '../media/img_users/'.$usuario.'/'.$nuevo_nombre;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $nueva_ruta);
        }else{
            $nueva_ruta = '../media/assets/no_cover.jpg';
        }  
        

        $crear = $conexion->prepare("INSERT INTO lista (nombre, foto, fecha_creacion, usuario) values (?,?,?,?)");
        $crear->bind_param('sssi', $nombre, $nueva_ruta, $fecha, $id);
        $crear->execute();
    }