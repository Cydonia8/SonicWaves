<?php
    require_once "general.php";

    function checkInformationCompleted($mail){
        $completo = false;

        $con = createConnection();
        $consulta = $con->prepare("SELECT biografia, foto from grupo where correo = ?");
        $consulta->bind_param("s", $mail);
        $consulta->bind_result($bio, $foto);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();

        if(($bio !== NULL and $foto!== NULL) or ($bio == "" and $foto == "")){
            $completo = true;
        }
        return $completo;
    }

    function completeInformation($mail, $bio, $foto){
        $con = createConnection();
        $actualizacion = $con->prepare("UPDATE grupo set biografia = ?, foto = ? where correo = $mail");
        $actualizacion->bind_param("ss", $bio, $foto);
        $actualizacion->execute();
        $actualizacion->close();
        $con->close();
    }

    function checkPhoto($nombre){
        $correcto = false;
        $formato = $_FILES[$nombre]["type"];
        $size = $_FILES[$nombre]["size"];
        $size_mb = $size / pow(1024, 2);
        $ruta_original = $_FILES[$nombre]["tmp_name"];

        if($size_mb < 10 and ($formato == "image/jpeg" or $formato == "image/png" or $formato == "image/gif" or $formato == "image/webp")){
            $correcto = true;
        }
        return $correcto;
    }
?>
