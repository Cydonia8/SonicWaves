<?php
    session_start();
    require_once "../square_image_creator/create_square_image.php";
    require_once "../php_functions/general.php";
    require_once "../php_functions/group_functions.php";
    forbidAccess("group");
    if(isset($_POST["completar"])){
        $foto_correcta = checkPhoto("foto");
        $foto_avatar_correcta = checkPhoto("foto-avatar");
        
        if($foto_correcta and $foto_avatar_correcta){
            $foto_avatar = newPhotoPath("foto-avatar", "avatar");
            $foto = newPhotoPath("foto", "");
            completeInformation($_SESSION["user"], $_POST["bio"], $foto, $foto_avatar);
        }
        
    }
    if(isset($_POST["actualizar-avatar"])){
        $foto_avatar_correcta = checkPhoto("foto-avatar-nueva");
        if($foto_avatar_correcta){
            $foto_avatar = newPhotoPath("foto-avatar-nueva", "avatar");
            updateAvatarPhoto($_SESSION["user"], $foto_avatar);
        }else{
            echo "<div class=\"alert alert-danger\" role=\"alert\">
            Formato incorrecto
          </div>";
        }
    }elseif(isset($_POST["actualizar-foto"])){
        $foto_correcta = checkPhoto("foto-nueva");
        if($foto_correcta){
            $foto = newPhotoPath("foto-nueva", "");
            updateMainPhoto($_SESSION["user"], $foto);
        }
    }

    if(isset($_POST["actualizar-bio"])){
        $bio = $_POST["bio"] != '' ? $_POST["bio"] : NULL;

        if($bio != NULL){
            $bio = strip_tags($bio);
            updateBio($_SESSION["user"], $bio);
        }
    }elseif(isset($_POST["actualizar-datos"])){
        $mail = $_POST["mail"];
        $pass = $_POST["pass"] != '' ? $_POST["pass"] : $_POST["pass-original"];
        $mail_repetido = emailRepeatedAtUpdate($mail, $_SESSION["user"]);
        if($mail_repetido == 1){
            updateGroupData($_SESSION["user"], $mail, $pass);
            $_SESSION["user"] = $mail;
            echo $mail;
            echo $pass;
            echo $_SESSION["user"];
        }else{
            echo "ta repetio pirataaa";
        }
    }
    
    closeSession($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../scripts/grupo_main.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Document</title>
</head>
<body id="grupo-main">
    <?php
        menuGrupoDropdown();
        $completo = checkInformationCompleted($_SESSION["user"]);
        if(!$completo){
            echo "<section class=\"form-group-completition gap-5\">
                    <img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\">
                    <h2>Antes de continuar, por favor, completa tu perfil</h2>
                    <form class=\" gap-3 d-flex flex-column\" action=\"#\" method=\"post\" enctype=\"multipart/form-data\">
                        <legend>Biografía del grupo (2000 caracteres máximo)</legend>
                        <textarea name=\"bio\" required rows=\"10\" cols=\"50\"></textarea>
                        <div>
                            <label for=\"foto\">Fotografía principal (asegúrate de que tenga una buena calidad, al menos 1920x1080)</label>
                            <input required type=\"file\" name=\"foto\">
                        </div>
                        <div>
                            <label for=\"foto-avatar\">Fotografía de avatar (dimensiones cuadradas, por ejemplo 400x400)</label>
                            <input required type=\"file\" name=\"foto-avatar\">
                        </div>
                        <input class=\"btn-completar-info-inicial\" type=\"submit\" name=\"completar\" value=\"Continuar\">
                    </form>
                </section>";
        }
        getGroupInfo($_SESSION["user"]);
    ?>
    <!-- <section class="update-avatar-photo">
        <ion-icon name="close-outline"></ion-icon>
        <form action="#" method="post" enctype="multipart/form-data">
            <img src="" alt="">
            <input type="submit" value="Actualizar foto de avatar" name="actualizar-avatar">
        </form>
    </section> -->
</body>
</html>
