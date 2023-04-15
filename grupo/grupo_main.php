<?php
    session_start();
    require_once "../square_image_creator/create_square_image.php";
    require_once "../php_functions/general.php";
    require_once "../php_functions/group_functions.php";
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
    <link rel="stylesheet" href="../estilos.css">
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Document</title>
</head>
<body id="grupo-main">
    <?php
        $completo = checkInformationCompleted($_SESSION["user"]);
        if(!$completo){
            echo "<section class=\"form-group-completition gap-5\">
                    <h2>Antes de continuar, por favor, completa tu perfil</h2>
                    <form class=\" gap-3 d-flex flex-column\" action=\"#\" method=\"post\">
                        <legend>Biografía del grupo (2000 caracteres máximo)</legend>
                        <textarea required rows=\"10\" cols=\"50\"></textarea>
                        <div>
                            <label for=\"foto\">Fotografía principal</label>
                            <input required type=\"file\" name=\"foto\">
                        </div>
                        <input class=\"btn-completar-info-inicial\" type=\"submit\" name=\"Completar\" value=\"Continuar\">
                    </form>
                </section>";
        }
        echo $_SESSION["user"];
        $con = createConnection();
        $consulta = $con->prepare("SELECT foto FROM grupo where correo = ?");
        $consulta->bind_param("s", $_SESSION["user"]);
        $consulta->bind_result($foto);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        echo "<img src=\"$foto\"/>";
    ?>
</body>
</html>
