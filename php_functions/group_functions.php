<?php
    require_once "general.php";

    function checkInformationCompleted($mail){
        $completo = false;

        $con = createConnection();
        $consulta = $con->prepare("SELECT biografia, foto, foto_avatar from grupo where correo = ?");
        $consulta->bind_param("s", $mail);
        $consulta->bind_result($bio, $foto, $foto_avatar);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        if(($bio !== NULL and $foto!== NULL and $foto_avatar !== NULL) and ($bio != "" and $foto != "" and $foto_avatar != "")){
            $completo = true;
        }
        return $completo;
    }

    function completeInformation($mail, $bio, $foto, $foto_avatar){
        $con = createConnection();
        $actualizacion = $con->prepare("UPDATE grupo SET biografia = ?, foto = ?, foto_avatar = ? WHERE correo = ?");
        $actualizacion->bind_param("ssss", $bio, $foto, $foto_avatar, $mail);
        $actualizacion->execute();
        $actualizacion->close();
        $con->close();
    }

    function checkPhoto($nombre){
        $correcto = false;
        $formato = $_FILES[$nombre]["type"];
        $size = $_FILES[$nombre]["size"];
        $size_mb = $size / pow(1024, 2);

        if($size_mb < 10 and ($formato == "image/jpeg" or $formato == "image/png" or $formato == "image/gif" or $formato == "image/webp")){
            $correcto = true;
        }
        return $correcto;
    }

    function newPhotoPath($nombre, $tipo){
        $nuevo_nombre;
        switch($_FILES[$nombre]["type"]){
            case "image/jpeg":
                $nuevo_nombre = $_SESSION["user"].$tipo.".jpg";
                break;
            case "image/png":
                $nuevo_nombre = $_SESSION["user"].$tipo.".png";
                break;
            case "image/gif":
                $nuevo_nombre = $_SESSION["user"].$tipo.".gif";
                break;
            case "image/webp":
                $nuevo_nombre = $_SESSION["user"].$tipo.".webp";
                break;
        }
        if(!file_exists("../media/img_grupos/".$_SESSION["user"])){
            mkdir("../media/img_grupos/".$_SESSION["user"], 0777, true);
        }
        $nueva_ruta = "../media/img_grupos/".$_SESSION["user"]."/".$nuevo_nombre;
        move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
        return $nueva_ruta;
    }
    
    function newPhotoPathAlbum($nombre, $album){
        $nuevo_nombre;
        $quitar = ["/", ".", "*","'"];
        $album = strtolower(str_replace($quitar, "", $album));

        switch($_FILES[$nombre]["type"]){
            case "image/jpeg":
                $nuevo_nombre = $album.".jpg";
                break;
            case "image/png":
                $nuevo_nombre = $album.".png";
                break;
            case "image/gif":
                $nuevo_nombre = $album.".gif";
                break;
            case "image/webp":
                $nuevo_nombre = $album.".webp";
                break;
        }
        if(!file_exists("../media/img_grupos/".$_SESSION["user"])){
            mkdir("../media/img_grupos/".$_SESSION["user"], 0777, true);
        }
        $nueva_ruta = "../media/img_grupos/".$_SESSION["user"]."/".$nuevo_nombre;
        move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
        return $nueva_ruta;
    }

    function addAlbum($grupo, $nombre, $foto, $lanzamiento, $activo){
        $con = createConnection();
        $insercion = $con->prepare("INSERT INTO album (titulo,foto,activo,grupo,lanzamiento) values (?, ?, ?, ?, ?)");
        $insercion->bind_param('ssiis', $nombre, $foto, $activo, $grupo, $lanzamiento);
        $insercion->execute();
        $insercion->close();
        $con->close();
    }

    function getGroupID($mail){
        $con = createConnection();
        $consulta = $con->prepare("SELECT id from grupo where correo = ?");
        $consulta->bind_param('s', $mail);
        $consulta->bind_result($id);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $id;
    }
?>
