<?php

function menuDiscograficaDropdown(){
    echo "<header class=\"d-flex justify-content-between align-items-center pt-3 pe-5 pb-2 ps-5 border-bottom\">
            <a href=\"../index.php\"><img class=\"w-25\" src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a>
            <div class=\"dropdown\">
                <button class=\"btn btn-secondary btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                Menú de discográfica
                </button>
                <ul class=\"dropdown-menu\">
                    <li><a class=\"dropdown-item\" href=\"discografica_grupos.php\">Grupos gestionados</a></li>
                    <li><a class=\"dropdown-item\" href=\"admin_usuarios.php\">Añadir nuevo grupo</a></li>
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
function getDiscographicGroups($id){
    $con = createConnection();
    $consulta = $con->prepare("SELECT id, nombre, foto_avatar from grupo where discografica = ?");
    $consulta->bind_param('i', $id);
    $consulta->bind_result($id, $nombre, $foto_avatar);
    $consulta->execute();
    while($consulta->fetch()){
        echo "<div class=\"disc-grupo-detalle border rounded d-flex justify-content-around p-3 gap-3 col-12 col-lg-3\">
                <div>
                    <img class=\"img-fluid rounded-circle mb-2\" src=\"$foto_avatar\" alt=\"\">
                    <p class=\"text-center font-weight-bold\">$nombre</p>
                </div>
                <div class=\"d-flex flex-column justify-content-center gap-5\">
                    <form method=\"post\" action=\"\">
                        <input class=\"btn btn-outline-primary\" type=\"submit\" name=\"ver\" value=\"Editar datos de grupo\">
                    </form>
                    <form method=\"post\" action=\"\">
                        <input class=\"btn btn-outline-primary\" type=\"submit\" name=\"ver\" value=\"Añadir nuevo álbum\">
                    </form>
                </div>
              </div>";
    }
    $consulta->close();
    $con->close();
}
?>