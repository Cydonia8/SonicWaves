<?php
    session_start();
    require_once "../php_functions/general.php";
    require_once "../php_functions/group_functions.php";
    forbidAccess("group");
    closeSession($_POST);
    if(isset($_POST["subir"])){
      $titulo = strip_tags($_POST["titulo"]);  
      $contenido = strip_tags($_POST["contenido"]);
      $foto_correcta = checkPhoto("foto");
      $fecha = $_POST["fecha"];

      if($foto_correcta){
        $ruta_princ = newMainPhotoPathPost(2);
      }

      if(is_array($_FILES["fotos"])){
        $total = count($_FILES["fotos"]);
        
        $cont = 1;
        foreach($_FILES["fotos"]["tmp_name"] as $key => $tmp_name){
            // var_dump($foto_op);
            $file_name = $_FILES['fotos']['name'][$key];
            $file_size =$_FILES['fotos']['size'][$key];
            $file_tmp =$_FILES['fotos']['tmp_name'][$key];
            $file_type=$_FILES['fotos']['type'][$key];
            if($file_name != ''){
                $correct = checkPhotosArray("fotos", $key);
                var_dump($correct);
                if($correct){
                    $ruta = newPhotoPathPost($file_type, $cont, 2, $file_tmp);
                    $cont++;
                }
                // echo "$file_name";
                // echo "<br>$file_size<br>$file_tmp<br>$file_type<br>";
            }
            
            // echo $_FILES["fotos"][$key][0];
            // echo $_FILES["fotos"][]
            // print_r($foto_op);
            // echo $total;
            // ++$cont;
            // echo "he";
        }
      }
    }
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
    <script src="../scripts/grupo_add_post.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Document</title>
</head>
<body id="grupo-añadir-publi">
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="input-field  mb-3 gap-2">
            <div class=" justify-content-between">
                <label class="file">Título de la publicación</label>
                <ion-icon name="image-outline"></ion-icon>
            </div>
            <input type="text" name="titulo" required>
            
        </div>
        <div class="input-field  mb-3 gap-2">
            <div class="justify-content-between">
                <label class="file">Contenido de la publicación</label>
                <ion-icon name="image-outline"></ion-icon>
            </div>
            <textarea name="contenido" id="" cols="30" rows="10" required></textarea>
        </div>
        <div class="input-field d-flex flex-column mb-3 gap-2">
            <div class="d-flex justify-content-between"><label class="file">Foto principal de la publicación</label><ion-icon name="image-outline"></ion-icon></div>
                <input type="file" class="custom-file-input" name="foto" required accept=".jpeg,.webp,.png,.gif">             
        </div>
        <button type="button" id="btn-add-photos">Añadir fotos extra (máximo ocho)</button>
        <div class="modal-añadir-fotos-publi d-none">
            <ion-icon class='close-modal-photos-post position-absolute' name="close-outline"></ion-icon>
            <div class="modal-añadir-fotos-container">
                <input type="file" name="fotos[]" accept=".jpeg,.webp,.png,.gif">
                <input type="file" name="fotos[]" accept=".jpeg,.webp,.png,.gif">
                <input type="file" name="fotos[]" accept=".jpeg,.webp,.png,.gif">
                <input type="file" name="fotos[]" accept=".jpeg,.webp,.png,.gif">
                <input type="file" name="fotos[]" accept=".jpeg,.webp,.png,.gif">
                <input type="file" name="fotos[]" accept=".jpeg,.webp,.png,.gif">
                <input type="file" name="fotos[]" accept=".jpeg,.webp,.png,.gif">
                <input type="file" name="fotos[]" accept=".jpeg,.webp,.png,.gif">
            </div>
        </div>
        <div class="input-field  mb-3 gap-2">
            <div class="justify-content-between">
                <label class="file">Fecha de la publicación</label>
                <ion-icon name="image-outline"></ion-icon>
            </div>
            <input type="date" name="fecha" required>
        </div>
        <input type="submit" name="subir" value="Crear publicación">
    </form>
</body>
</html>