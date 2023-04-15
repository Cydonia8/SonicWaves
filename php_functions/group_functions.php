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

        if($bio !== NULL and $foto!== NULL){
            $completo = true;
        }
        return $completo;
    }

    
?>
