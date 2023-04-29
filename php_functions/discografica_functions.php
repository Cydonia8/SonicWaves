<?php

function menuDiscograficaDropdown(){
    echo "<header class=\"dropdown-header d-flex justify-content-between align-items-center pt-3 pe-5 pb-2 ps-5 border-bottom\">
            <a class=\"dropdown-link-responsive\" href=\"../index.php\"><img src=\"../media/assets/sonic-waves-logo-simple.png\"></a>
            <a href=\"../index.php\"><img class=\"w-25\" src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a>
            <div class=\"dropdown\">
                <button class=\"btn btn-secondary btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                Menú de discográfica
                </button>
                <ul class=\"dropdown-menu\">
                    <li><a class=\"dropdown-item\" href=\"discografica_grupos.php\">Grupos gestionados</a></li>
                    <li><a class=\"dropdown-item\" href=\"discografica_añadir_grupo.php\">Añadir nuevo grupo</a></li>
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

function getDiscographicName($correo){
    $con = createConnection();
    $consulta = $con->prepare("SELECT nombre FROM discografica where correo = ?");
    $consulta->bind_param('s',$correo);
    $consulta->bind_result($nombre);
    $consulta->execute();
    $consulta->fetch();
    $consulta->close();
    $con->close();
    return $nombre;
}

function getDiscographicID($mail){
    $con = createConnection();
    $consulta = $con->prepare("SELECT id FROM discografica where correo = ?");
    $consulta->bind_param('s', $mail);
    $consulta->bind_result($id);
    $consulta->execute();
    $consulta->fetch();
    $consulta->close();
    $con->close();
    return $id;
}
function getDiscographicGroups($id_disc){
    $con = createConnection();
    $consulta = $con->prepare("SELECT id, nombre, foto_avatar from grupo where discografica = ?");
    $consulta->bind_param('i', $id_disc);
    $consulta->bind_result($id, $nombre, $foto_avatar);
    $consulta->execute();
    while($consulta->fetch()){
        echo "<div class=\"disc-grupo-detalle border rounded d-flex justify-content-around p-3 gap-3 col-12 col-lg-3\">
                <div>
                    <img class=\"img-fluid rounded-circle mb-2\" src=\"$foto_avatar\" alt=\"\">
                    <p class=\"text-center font-weight-bold\">$nombre</p>
                </div>
                <div class=\"d-flex flex-column justify-content-center gap-5\">
                    <form method=\"post\" action=\"discografica_editar_grupo.php\">
                        <input hidden value=\"$id\" name=\"id\">
                        <input class=\"btn btn-outline-primary\" type=\"submit\" name=\"ver\" value=\"Editar datos de grupo\">
                    </form>
                    <form method=\"post\" action=\"../discografica/discografica_añadir_album.php\">
                        <input hidden value=\"$id\" name=\"id\">
                        <input class=\"btn btn-outline-info\" type=\"submit\" name=\"ver\" value=\"Añadir nuevo álbum\">
                    </form>
                </div>
              </div>";
    }
    $consulta->close();
    $con->close();
}

function addGroup($nombre, $biografia, $foto, $foto_avatar, $activo, $id_disco){
    $con = createConnection();
    $insercion = $con->prepare("INSERT INTO grupo (nombre,biografia, foto, foto_avatar, activo, discografica) VALUES (?,?,?,?,?,?)");
    $insercion->bind_param('ssssii', $nombre, $biografia, $foto, $foto_avatar, $activo, $id_disco);
    $insercion->execute();
    $insercion->close();
    $con->close();
}

function newPhotoPathDisc($nombre, $tipo, $grupo, $id){
    $nuevo_nombre;
    switch($_FILES[$nombre]["type"]){
        case "image/jpeg":
            $nuevo_nombre = $grupo."_".$id."_".$tipo.".jpg";
            break;
        case "image/png":
            $nuevo_nombre = $grupo."_".$id."_".$tipo.".png";
            break;
        case "image/gif":
            $nuevo_nombre = $grupo."_".$id."_".$tipo.".gif";
            break;
        case "image/webp":
            $nuevo_nombre = $grupo."_".$id."_".$tipo.".webp";
            break;
    }
    if(!file_exists("../media/img_grupos/".$grupo."_".$id)){
        mkdir("../media/img_grupos/".$grupo."_".$id, 0777, true);
    }
    $nueva_ruta = "../media/img_grupos/".$grupo."_".$id."/".$nuevo_nombre;
    move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
    return $nueva_ruta;
}

function newPhotoPathAlbumDisc($nombre, $album, $grupo, $id){
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
    if(!file_exists("../media/img_grupos/".$grupo."_".$id)){
        mkdir("../media/img_grupos/".$grupo."_".$id, 0777, true);
    }
    $nueva_ruta = "../media/img_grupos/".$grupo."_".$id."/".$nuevo_nombre;
    move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
    return $nueva_ruta;
}

function getGroupDataEdit($id){
    $con = createConnection();
    $consulta = $con->prepare("SELECT nombre, biografia, foto, foto_avatar from grupo where id = ?");
    $consulta->bind_param('i', $id);
    $consulta->bind_result($nombre, $bio, $foto, $foto_av);
    $consulta->execute();
    $consulta->fetch();
    $consulta->close();
    $con->close();
    $datos["nombre"] = $nombre;
    $datos["bio"] = $bio;
    $datos["foto"] = $foto;
    $datos["foto_avatar"] = $foto_av;
    return $datos;
}

function editGroup($id, $bio, $foto, $foto_avatar){
    $con = createConnection();
    $update = $con->prepare("UPDATE grupo set biografia = ?, foto = ?, foto_avatar = ? where id = ?");
    $update->bind_param('sssi', $bio, $foto, $foto_avatar, $id);
    $update->execute();
    $update->close();
    $con->close();
}

?>