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
        echo "<header class=\"d-flex justify-content-between align-items-center pt-3 pe-5 pb-2 ps-5 border-bottom\">
                <a href=\"../index.php\"><img class=\"w-25\" src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a>
                <div class=\"dropdown\">
                    <button class=\"btn btn-secondary btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                    Menú de grupo
                    </button>
                    <ul class=\"dropdown-menu\">
                        <li><a class=\"dropdown-item\" href=\"grupo_nuevo_album.php\">Subir nuevo álbum</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_usuarios.php\">Editar perfil</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_grupos.php\">Grupos</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_discografica.php\">Discográficas</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_albumes.php\">Álbumes</a></li>
                        <li><a class=\"dropdown-item\" href=\"#\">Reseñas</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_estilos.php\">Estilos</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_estilos.php\">Publicaciones</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_estilos.php\">Encuestas</a></li>
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
        $quitar = ["/", ".", "*","'"];
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
        echo "<ul>";
        while($contador <= $num){
            $name = "cancion".$contador;
            echo "<li><select name=\"$name\">";
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
?>
