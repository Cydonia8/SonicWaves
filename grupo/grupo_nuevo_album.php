<?php
    session_start();
    require_once "../php_functions/group_functions.php";
    require_once "../php_functions/general.php";

    $nuevo_id = getAutoID("album");
    $_SESSION["id"] = $nuevo_id;
    $id_grupo = getGroupID($_SESSION["user"]);

    if(isset($_POST["crear"])){
        $_SESSION["titulo_album"] = $_POST["nombre"];
        $_SESSION["lanzamiento"] = $_POST["fecha"];
        $foto_correcta = checkPhoto("foto");

        if($foto_correcta){
            $foto = newPhotoPathAlbum("foto", $_POST["nombre"]);
            // echo "<meta http-equiv='refresh' content='0;url=grupo_anadir_canciones.php'>";
        }else{
            echo "datos mal";
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Document</title>
</head>
<body id="grupo-nuevo-album">
    <form action="#" method="post" enctype="multipart/form-data">
        <input required type="text" placeholder="Nombre del album" name="nombre">
        <br>
        <label required for="foto">Carátula de álbum</label><input type="file" name="foto">
        <br>
        <label required for="fecha">Fecha de publicación</label><input type="date" name="fecha">
        <br>
        <input type="submit" value="Pasar a añadir canciones" name="crear">
    </form>
</body>
</html>