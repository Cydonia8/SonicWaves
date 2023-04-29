<?php
    session_start();
    require_once "../square_image_creator/create_square_image.php";
    require_once "../php_functions/general.php";
    require_once "../php_functions/discografica_functions.php";
    forbidAccess("disc");
    closeSession($_POST);
    $id = $_POST["id"];
    $datos = getGroupDataEdit($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilos.css">
    <script src="../scripts/editar_grupo.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <title>Document</title>
</head>
<style>
    .custom-file-input {
  color: transparent;
}
.custom-file-input::-webkit-file-upload-button {
  visibility: hidden;
}
.custom-file-input::before {
  content: 'Select some files';
  color: black;
  display: inline-block;
  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
  border: 1px solid #999;
  border-radius: 3px;
  padding: 5px 8px;
  outline: none;
  white-space: nowrap;
  -webkit-user-select: none;
  cursor: pointer;
  text-shadow: 1px 1px #fff;
  font-weight: 700;
  font-size: 10pt;
}
.custom-file-input:hover::before {
  border-color: black;
}
.custom-file-input:active {
  outline: 0;
}
.custom-file-input:active::before {
  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9); 
}
</style>
<body id="discografica-editar-grupo">
    <?php
        menuDiscograficaDropdown();
        $nombre = getDiscographicName($_SESSION["user"])
    ?>
    <h1 class="text-center mt-3"><?php echo $datos["nombre"]; ?></h1>
    <section class="row container-fluid mt-5">
        <div class="col-12 col-lg-6">
            <form action="" class="d-flex flex-column">
                <h2 class="text-center">Formulario de edición de grupo</h2>
                <div class="input-field d-flex flex-column mb-3">
                    <div class="input-visuals d-flex justify-content-between">
                        <label for="usuario">Nombre del grupo (este valor no puede ser modificado)</label>
                        <ion-icon name="person-outline"></ion-icon>
                    </div>
                    <input readonly <?php echo "value='$datos[nombre]'"; ?> name="usuario" type="text">                        
                </div>
                <div class="input-field d-flex flex-column mb-3">
                    <div class="input-visuals d-flex justify-content-between">
                        <label for="usuario">Biografía</label>
                        <ion-icon name="person-outline"></ion-icon>
                    </div>
                    <textarea name="bio" id="" cols="30" rows="10" <?php echo "value='$datos[bio]' placeholder='$datos[bio]'"; ?> ></textarea>                        
                </div>
                <div class="input-field d-flex flex-column mb-3">
                    <label class="file">Foto principal del grupo
                        <input type="file" class="custom-file-input">
                    </label>
                </div>
                <div class="input-field d-flex flex-column mb-3">
                    <label class="file">Foto de avatar del grupo
                        <input type="file" class="custom-file-input">
                    </label>
                </div>
            </form>
        </div>
        <div class="col-12 col-lg-6">
            <img class="img-fluid rounded" <?php echo "src='$datos[foto]'"; ?> alt="">
        </div>
    

    </section>
</body>
</html>
