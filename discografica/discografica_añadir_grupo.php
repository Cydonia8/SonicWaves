<?php
    session_start();
    require_once "../php_functions/discografica_functions.php";
    require_once "../php_functions/group_functions.php";
    require_once "../php_functions/general.php";
    forbidAccess("disc");
    closeSession($_POST);
    $id_discografica = getDiscographicID($_SESSION["user"]);
    $nombre = getDiscographicName($_SESSION["user"]);
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
    <title><?php echo $nombre; ?> | Añadir grupo</title>
</head>
<body id="discografica-nuevo-album">
    <?php
        menuDiscograficaDropdown();
    ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Nombre del grupo" name="nombre" required>
        <br>
        <label for="foto">Foto de grupo</label><input required type="file" name="foto">
        <br>
        <label for="foto">Foto de avatar</label><input required type="file" name="foto-avatar">
        <br>
        <textarea name="biografia" placeholder="Escribe una biografia" id="" cols="30" rows="10" maxlength="2000" required></textarea>
        <br>
        <input type="submit" value="Añadir grupo" name="anadir" >
    </form>
    <?php
        if(isset($_POST['anadir'])){
            $nombre = $_POST['nombre'];
            $bio = $_POST['biografia'];
            $foto_correcta = checkPhoto("foto");
            $foto_avatar_correcta = checkPhoto("foto-avatar");
            $id_grupo = getAutoID("grupo");
            if($foto_correcta and $foto_avatar_correcta){
                $foto_avatar = newPhotoPathDisc("foto-avatar", "avatar",  $nombre, $id_grupo);
                $foto = newPhotoPathDisc("foto", "", $nombre, $id_grupo);
                addGroup($nombre, $bio, $foto, $foto_avatar, 0, $id_discografica);
            }
        }
    ?>
</body>
</html>
