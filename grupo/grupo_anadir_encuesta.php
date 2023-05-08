<?php
    session_start();
    require_once "../php_functions/general.php";
    require_once "../php_functions/group_functions.php";
    forbidAccess("group");
    closeSession($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <link rel="stylesheet" href="../estilos.css">
    <script src="../scripts/grupo_add_survey.js" defer></script>
    <script src="../scripts/jquery-3.2.1.min.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Document</title>
</head>
<body id="grupo-añadir-encuesta">
    <?php
        menuGrupoDropdown();
    ?>
    <form>
        <div class="input-field  mb-3 gap-2">
            <div class=" justify-content-between">
                <label class="file">Título de la encuesta</label>
                <ion-icon name="image-outline"></ion-icon>
            </div>
            <input type="text" name="titulo" required>
        </div>
        <div class="input-field  mb-3 gap-2">
            <div class="justify-content-between">
                <label class="file">Duración de la encuesta</label>
                <ion-icon name="image-outline"></ion-icon>
            </div>
            <textarea name="contenido" id="" cols="30" rows="10" required></textarea>
        </div>
    </form>

</body>
</html>