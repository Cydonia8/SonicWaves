<?php
    require_once "general.php";
    require "../PHP Duracion script/AudioMP3Class.php";

    function checkInformationCompleted($mail){
        $completo = false;

        $con = createConnection();
        $consulta = $con->prepare("SELECT biografia, foto, foto_avatar from grupo where correo = ?");
        $consulta->bind_param("s", $mail);
        $consulta->bind_result($bio, $foto, $foto_avatar);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        if(($bio !== NULL and $foto!== NULL and $foto_avatar !== NULL) and ($bio != "" and $foto != "" and $foto_avatar != "")){
            $completo = true;
        }
        return $completo;
    }

    function getGroupAlbums($mail){
        $con = createConnection();
        $consulta = $con->prepare("SELECT titulo, a.foto foto, lanzamiento from album a, grupo g where a.grupo = g.id and correo = ?");
        $consulta->bind_param('s', $mail);
        $consulta->bind_result($titulo, $foto, $lanzamiento);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows > 0){
            $counter = 0;
            while($consulta->fetch()){
                if($counter % 3 == 0){
                    echo "<div class='row gap-3'>";
                }
                $fecha = formatDate($lanzamiento);
                echo "<div class='col-12 col-lg-3 d-flex justify-content-center gap-3'>
                        <img class='w-50 rounded' src='$foto'>
                        <div class='w-50'>
                            <h4>$titulo</h4>
                            <h4>Lanzado el $fecha</h4>
                        </div>
                    </div>";
                if($counter+1 % 3 == 0){
                    echo "</div>";
                }
                $counter++;
            }
        }else{
            echo "<h2 class='text-center'>No hay discos publicados por el momento</h2>";
        }
        $consulta->close();
        $con->close();
    }

    function getGroupInfo($mail){
        $con = createConnection();
        $consulta = $con->prepare("SELECT nombre, foto, foto_avatar, biografia from grupo where correo = ?");
        $consulta->bind_param('s', $mail);
        $consulta->bind_result($nombre, $foto, $foto_avatar, $bio);
        $consulta->execute();
        $consulta->fetch();
        echo "<section class='banner-group-main mb-5 pb-3' data-bg='$foto'>
                <div class='position-relative'>
                    <a class='banner-group-main-avatar-link' href=''>
                        <img class='banner-group-main-avatar rounded-circle' src='$foto_avatar'>
                        <ion-icon class='icon-edit-avatar-group d-none' name=\"pencil-outline\"></ion-icon>
                    </a>
                    <button class='banner-group-main-photo-link'>Editar</button>
                </div>
            </section>
            <section class='d-flex flex-column align-items-center justify-content-center'>
                <h1 class='text-center'>$nombre</h1>
                <details>
                    <summary class='text-center'>Biografía</summary>
                    <p class='text-center'>$bio</p>
                </details>
            </section>
            <section class=\"update-avatar-photo d-none flex-column justify-content-center align-items-center\">
                <ion-icon class='close-modal-update-avatar position-absolute' name=\"close-outline\"></ion-icon>
                <img class='rounded-circle w-25' src=\"$foto_avatar\" alt=\"\">
                <form class='text-center' action=\"#\" method=\"post\" enctype=\"multipart/form-data\">
                    <div class=\"input-field  mb-3 gap-2\">
                        <div class=\" justify-content-between\">
                            <label class=\"file\">Foto de avatar del grupo</label>
                            <ion-icon name=\"image-outline\"></ion-icon>
                            <input type=\"file\" class=\"custom-file-input\" name=\"foto-avatar-nueva\">
                        </div>
                    </div>
                    <input type=\"submit\" value=\"Actualizar foto de avatar\" name=\"actualizar-avatar\">
                </form>
            </section>
            <section class=\"update-main-photo d-none flex-column justify-content-center align-items-center\">
                <ion-icon class='close-modal-update-main-photo position-absolute' name=\"close-outline\"></ion-icon>
                <img class='rounded w-50' src=\"$foto\" alt=\"\">
                <form class='text-center' action=\"#\" method=\"post\" enctype=\"multipart/form-data\">
                    <div class=\"input-field  mb-3 gap-2\">
                        <div class=\" justify-content-between\">
                            <label class=\"file\">Foto principal del grupo</label>
                            <ion-icon name=\"image-outline\"></ion-icon>
                            <input type=\"file\" class=\"custom-file-input\" name=\"foto-nueva\">
                        </div>
                    </div>
                    <input type=\"submit\" value=\"Actualizar foto principal\" name=\"actualizar-foto\">
                </form>
            </section>
            <section class='container-xl'>";
                getGroupAlbums($_SESSION["user"]);
            echo "</section>";
        $consulta->close();
        $con->close();
    }

    function updateAvatarPhoto($mail, $foto_avatar){
        $con = createConnection();
        $update = $con->prepare("UPDATE grupo set foto_avatar = ? where correo = ?");
        $update->bind_param('ss', $foto_avatar, $mail);
        $update->execute();
        $update->close();
        $con->close();
    }

    function updateMainPhoto($mail, $foto){
        $con = createConnection();
        $update = $con->prepare("UPDATE grupo set foto = ? where correo = ?");
        $update->bind_param('ss', $foto, $mail);
        $update->execute();
        $update->close();
        $con->close();
    }

    // function getGroupInfo2($mail){
    //     $con = createConnection();
    //     $consulta = $con->prepare("SELECT nombre, foto, foto_avatar, biografia from grupo where correo = ?");
    //     $consulta->bind_param('s', $mail);
    //     $consulta->bind_result($nombre, $foto, $foto_avatar, $bio);
    //     $consulta->execute();
    //     $consulta->fetch();
    //     echo "<section class='banner-group-main' data-bg='$foto'><img class='img-fluid' src='$foto'><img src='$foto_avatar'></section>";
    //     $consulta->close();
    //     $con->close();
    // }

    function getStyles(){
        $con = createConnection();
        $consulta = $con->prepare("SELECT nombre, id FROM estilo");
        $consulta->bind_result($nombre, $id);
        $consulta->execute();
        while($consulta->fetch()) {
            echo "<option class=\"p-2\" value=\"$id\">$nombre</option>";
        }
        $consulta->close();
        $con->close();
    }

    function menuGrupoDropdown(){
        echo "<header class=\"dropdown-header d-flex justify-content-between align-items-center pt-3 pe-5 pb-2 ps-5 position-absolute w-100\">
                <a class=\"dropdown-link-responsive\" href=\"../index.php\"><img src=\"../media/assets/sonic-waves-logo-simple.png\"></a>
                <a href=\"../index.php\"><img class=\"w-25\" src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a>
                <div class=\"dropdown\">
                    <button class=\"btn btn-secondary btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                    Menú de grupo
                    </button>
                    <ul class=\"dropdown-menu\">
                        <li><a class=\"dropdown-item\" href=\"grupo_main.php\">Portada</a></li>
                        <li><a class=\"dropdown-item\" href=\"grupo_nuevo_album.php\">Subir nuevo álbum</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_usuarios.php\">Editar perfil</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_grupos.php\">Añadir encuesta</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_discografica.php\">Añadir publicación</a></li>
                        <li><a class=\"dropdown-item\" href=\"#\">Reseñas de mis álbumes</a></li>
                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                    </ul>
                </div>
              </header>";
    }

    function completeInformation($mail, $bio, $foto, $foto_avatar){
        $con = createConnection();
        $actualizacion = $con->prepare("UPDATE grupo SET biografia = ?, foto = ?, foto_avatar = ? WHERE correo = ?");
        $actualizacion->bind_param("ssss", $bio, $foto, $foto_avatar, $mail);
        $actualizacion->execute();
        $actualizacion->close();
        $con->close();
    }

    function checkPhoto($nombre){
        $correcto = false;
        $formato = $_FILES[$nombre]["type"];
        $size = $_FILES[$nombre]["size"];
        $size_mb = $size / pow(1024, 2);

        if($size_mb < 10 and ($formato == "image/jpeg" or $formato == "image/png" or $formato == "image/gif" or $formato == "image/webp")){
            $correcto = true;
        }
        return $correcto;
    }

    function newPhotoPath($nombre, $tipo){
        $nuevo_nombre;
        switch($_FILES[$nombre]["type"]){
            case "image/jpeg":
                $nuevo_nombre = $_SESSION["user"].$tipo.".jpg";
                break;
            case "image/png":
                $nuevo_nombre = $_SESSION["user"].$tipo.".png";
                break;
            case "image/gif":
                $nuevo_nombre = $_SESSION["user"].$tipo.".gif";
                break;
            case "image/webp":
                $nuevo_nombre = $_SESSION["user"].$tipo.".webp";
                break;
        }
        if(!file_exists("../media/img_grupos/".$_SESSION["user"])){
            mkdir("../media/img_grupos/".$_SESSION["user"], 0777, true);
        }
        $nueva_ruta = "../media/img_grupos/".$_SESSION["user"]."/".$nuevo_nombre;
        move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
        return $nueva_ruta;
    }
    
    function removeSpecialCharacters($nombre){
        $quitar = ["/", "*","'"];
        $arreglado = strtolower(str_replace($quitar, "", $nombre));
        return $arreglado;
    }
    function newPhotoPathAlbum($nombre, $album){
        $nuevo_nombre;
        $quitar = ["/", ".", "*","'"];
        $album = strtolower(str_replace($quitar, "", $album));

        switch($_FILES[$nombre]["type"]){
            case "image/jpeg":
                $nuevo_nombre = $album.".jpg";
                break;
            case "image/png":
                $nuevo_nombre = $album.".png";
                break;
            case "image/gif":
                $nuevo_nombre = $album.".gif";
                break;
            case "image/webp":
                $nuevo_nombre = $album.".webp";
                break;
        }
        if(!file_exists("../media/img_grupos/".$_SESSION["user"])){
            mkdir("../media/img_grupos/".$_SESSION["user"], 0777, true);
        }
        $nueva_ruta = "../media/img_grupos/".$_SESSION["user"]."/".$nuevo_nombre;
        move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
        return $nueva_ruta;
    }

    function addAlbum($grupo, $nombre, $foto, $lanzamiento, $activo){
        $con = createConnection();
        $insercion = $con->prepare("INSERT INTO album (titulo,foto,activo,grupo,lanzamiento) values (?, ?, ?, ?, ?)");
        $insercion->bind_param('ssiis', $nombre, $foto, $activo, $grupo, $lanzamiento);
        $insercion->execute();
        $insercion->close();
        $con->close();
    }

    function getGroupID($mail){
        $con = createConnection();
        $consulta = $con->prepare("SELECT id from grupo where correo = ?");
        $consulta->bind_param('s', $mail);
        $consulta->bind_result($id);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $id;
    }
    
    function getAllGroupSongs($mail){
        $con = createConnection();
        $consulta = $con->prepare("SELECT c.id cancion_id, c.titulo titulo_cancion from grupo g, album a, cancion c, incluye i where a.grupo = g.id and i.cancion = c.id and i.album = a.id and g.correo = ?");
        $consulta->bind_param('s', $mail);
        $consulta->bind_result($id, $cancion);
        $consulta->execute();
        while($consulta->fetch()){
            echo "<option value=\"$id\">$cancion</option>";
        }
        $consulta->close();
        $con->close();
    }

    function generateInputs($num){
        $contador = 1;
        echo "<ul>";
        while($contador <= $num){
            $name = "titulo".$contador;
            $name2 = "archivo".$contador;
            $name3 = "estilo".$contador;
            echo "<li><div>
                    <label for=\"\">Título</label>
                    <input required type=\"text\" name=\"$name\">
                    <label for=\"\">Archivo</label>
                    <input required accept=\".mp3\" type=\"file\" name=\"$name2\">
                    <label for=\"estilo\">Estilo de la canción</label>
                    <select required name=\"$name3\">";
                    getStyles();
                    echo "</select>
                 </div></li>";
            $contador++;
        }
        echo "</ul>
                <input type=\"submit\" name=\"cargar\" value=\"Cargar álbum\">";
    }

    function generateSelects($num){
        $contador = 1;
        echo "<ul class='selects-container'>";
        while($contador <= $num){
            $name = "cancion".$contador;
            echo "<li><select required name=\"$name\"><option value='' hidden>Elige una canción</option>";
                getAllGroupSongs($_SESSION["user"]);
                 echo "</select></li>";
            $contador++;
        }
        echo "</ul><input type=\"submit\" name=\"cargar\" value=\"Cargar álbum\">";
    }

    function getDuration($cancion){
        $mp3file = new MP3File($cancion);
        $duration_seconds = $mp3file->getDuration();
        $minutos = MP3File::formatTime($duration_seconds);
        return $minutos;
    }

    function addSong($titulo, $archivo, $duracion, $estilo){
        $con = createConnection();
        $insertar = $con->prepare("INSERT INTO cancion (titulo,duracion,archivo,estilo) values (?,?,?,?)");
        $insertar->bind_param('sssi', $titulo, $duracion, $archivo, $estilo);
        $insertar->execute();
        $insertar->close();
        $con->close();
    }

    function linkSongToAlbum($album, $cancion){
        $con = createConnection();
        $insertar = $con->prepare("INSERT INTO incluye (album,cancion) values (?,?)");
        $insertar->bind_param('ii', $album, $cancion);
        $insertar->execute();
        $insertar->close();
        $con->close();
    }

    function moveUploadedSong($nombre, $grupo, $album){
        $album = removeSpecialCharacters($album);
        if(!file_exists("../media/audio/$grupo")){
            mkdir("../media/audio/$grupo");
        }
        if(!file_exists("../media/audio/$grupo/$album")){
            mkdir("../media/audio/$grupo/$album");
        }
        $cancion = $_FILES[$nombre]["name"];
        $cancion = removeSpecialCharacters($cancion);
        $nueva_ruta = "../media/audio/$grupo/$album/$cancion";
        move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
        return $nueva_ruta;
    }

    function getLastSongID(){
        $con = createConnection();
        $consulta = $con->query("SELECT id from cancion order by id desc limit 1");
        $fila = $consulta->fetch_array(MYSQLI_ASSOC);
        $id = $fila["id"];
        return $id;
    }

    function getGroupName($id){
        $con = createConnection();
        $consulta = $con->prepare("SELECT nombre from grupo where id = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($nombre);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $nombre;
    }
?>
