<?php
    session_start();
    require_once "../php_functions/group_functions.php";
    require_once "../php_functions/general.php";
    closeSession($_POST);
    
    if(isset($_POST["cargar"])){
        $id_grupo = getGroupID($_SESSION["user"]);
        addAlbum($id_grupo, $_SESSION["titulo_album"], $_SESSION["foto_album"], $_SESSION["lanzamiento"], 1);
        for($i = 1; $i <= $_SESSION["num_canciones"]; $i++){
            if($_SESSION["recopilatorio"] == "no"){
                $titulo = $_POST["titulo".$i];
                $minutos = getDuration($_FILES["archivo".$i]["tmp_name"]);
                $estilo = $_POST["estilo".$i];
                $ruta = moveUploadedSong("archivo".$i, $_SESSION["user"], $_SESSION["titulo_album"]);
                addSong($titulo, $ruta, $minutos, $estilo);
                $id_cancion = getLastSongID();
                linkSongToAlbum($_SESSION["id_album"], $id_cancion);
            }else{
                linkSongToAlbum($_SESSION["id_album"], $_POST["cancion".$i]);
            }
            // echo $_FILES["archivo".$i]["name"];
            // echo "<br>";
            // echo $_POST["titulo".$i];
            // $titulo = $_POST["titulo".$i];
            // echo "<br>";
            // echo $_SESSION["id_album"];
            // echo "<br>";
            // $minutos = getDuration($_FILES["archivo".$i]["tmp_name"]);
            // echo $minutos;
            // echo "<br>";
            // echo $_POST["estilo".$i];
            // $estilo = $_POST["estilo".$i];
            // echo "<br>";
            // $ruta = moveUploadedSong("archivo".$i, $_SESSION["user"], $_SESSION["titulo_album"]);
            // echo $ruta;
            // addSong($titulo, $ruta, $minutos, $estilo);
            // $id_cancion = getLastSongID();
            // echo $id_cancion;
            // linkSongToAlbum($_SESSION["id_album"], $id_cancion);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../scripts/anadir_cancion.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32"/>
    <title>Document</title>
</head>
<body id="grupo-nuevo-album">
    <?php
        menuGrupoDropdown();
    ?>
    <section class="container-añadir-canciones">
    <?php
        if(isset($_SESSION["foto_album"])){
            if($_SESSION["recopilatorio"] == "no"){
                echo "<form action=\"#\" method=\"post\" enctype=\"multipart/form-data\">";
                generateInputs($_SESSION["num_canciones"]);
            }else{
                echo "<form action=\"#\" method=\"post\">";
                generateSelects($_SESSION["num_canciones"]);
                echo "</form>";
            }
        }else{
            
        }
    ?>
    </section>
    
</body>
</html>