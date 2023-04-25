<?php
    require_once "general.php";

    function menuAdmin(){
        echo "<header class=\"menu-admin border-bottom\">
                <nav class=\"pt-3\">
                    <ul class=\"p-0\">
                        <li><a href=>Usuarios</a></li>
                        <li><a href=>Grupos</a></li>
                        <li><a href=>Discográficas</a></li>
                        <li class=\"li-foto\"><a href=\"../index.php\"><img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a></li>
                        <li><a href=>Álbumes</a></li>
                        <li><a href=>Reseñas</a></li>
                        <li><a href=\"admin_estilos.php\">Estilos</a></li>
                    </ul>
                </nav>
              </header>";
    }
    function menuAdminDropdown(){
        echo "<header class=\"d-flex justify-content-between align-items-center pt-3 pe-5 pb-2 ps-5 border-bottom\">
                <a href=\"../index.php\"><img class=\"w-25\" src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a>
                <div class=\"dropdown\">
                    <button class=\"btn btn-secondary btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                    Menú de administración
                    </button>
                    <ul class=\"dropdown-menu\">
                        <li><a class=\"dropdown-item\" href=\"admin_main.php\">Resumen general</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_usuarios.php\">Usuarios</a></li>
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
    
    function songsPerStyle($id){
        $total = 0;
        $con = createConnection();
        $consulta = $con->query("SELECT COUNT(*) numero_de_canciones
        FROM cancion, estilo where cancion.estilo = estilo.id and estilo.id = '$id'
        GROUP BY estilo.id");
        $fila = $consulta->fetch_array(MYSQLI_ASSOC);
        if($consulta->num_rows > 0){
            $total = $fila["numero_de_canciones"];
        }
        return $total;
    }

    function albumsPerGroup($id){
        $total = 0;
        $con = createConnection();
        $consulta = $con->query("SELECT COUNT(*) numero_albums
        FROM album a, grupo g where a.grupo = g.id and g.id = '$id'
        GROUP BY g.id");
        $fila = $consulta->fetch_array(MYSQLI_ASSOC);
        if($consulta->num_rows > 0){
            $total = $fila["numero_albums"];
        }
        return $total;
    }

    function getAllStyles(){
        $con = createConnection();
        $consulta = $con->query("SELECT * FROM estilo where id <> 0");
        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            $canciones_estilo = songsPerStyle($fila["id"]);
            echo "<div class=\"rounded border grupo-detalle d-flex justify-content-around p-3 gap-2 col-12 col-md-3\">
                    <div class=\"d-flex flex-column\">
                        <p>Nombre: $fila[nombre]</p>";
                        if($canciones_estilo != ""){
                            echo "<p>Canciones totales con este estilo: $canciones_estilo</p>";
                        }
                    echo "</div>
                    <div class=\"d-flex flex-column align-items-center\">
                        <p>Color característico</p>
                        <span style=\"background-color:$fila[color_caracteristico];\" class=\"style-dot-admin\"></span>
                    </div>";
                    
                echo "</div>";
        }
        $con->close();
    }

    function newStyle($nombre, $color){
        $exito = false;
        $con = createConnection();
        $insertar = $con->prepare("INSERT INTO estilo (nombre, color_caracteristico) VALUES (?,?)");
        $insertar->bind_param("ss", $nombre, $color);
        $insertar->execute();
        $insertar->close();
        $con->close();
    }

    function getAllGroups(){
        $con = createConnection();
        $consulta = $con->query("SELECT g.id id_grupo, g.nombre nom_grupo, g.activo grupo_activo, foto, g.foto_avatar avatar_grupo, d.nombre disco, g.pendiente_aprobacion aprob from grupo g, discografica d where g.discografica = d.id and g.id <> 0 order by g.nombre asc");
        $filas = $consulta->num_rows;

        if($filas > 0){
            while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
                $albums_grupo = albumsPerGroup($fila["id_grupo"]);
                echo "<div data-name=\"$fila[nom_grupo]\" class=\"rounded border grupo-detalle p-3 gap-2 col-12 col-md-3\">
                    <div class=\"w-50\">
                        <img class=\"rounded-circle img-fluid\" src=\"$fila[avatar_grupo]\">
                    </div>
                    <div class=\"d-flex flex-column justify-content-between\">
                        <p>Nombre: $fila[nom_grupo]</p>";
                        if($albums_grupo != ""){
                            echo "<p>Álbumes publicados: $albums_grupo</p>";
                        }
                        echo "<p>Gestión: $fila[disco]</p>";
                    if($fila["aprob"] == 1){
                        echo "<div class=\"d-flex gap-3\"><form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                                <input type=\"submit\" name=\"aprobar\" value=\"Aprobar\" class=\"btn btn-outline-success\">
                                </form>
                                <form method=\"post\" action=\"#\">
                                    <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                                    <input type=\"submit\" name=\"denegar\" value=\"Denegar\" class=\"btn btn-outline-danger\">
                                </form></div>";
                    }else{
                        if($fila["grupo_activo"] == 0){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                            <input type=\"submit\" name=\"activar\" value=\"Activar\" class=\"btn btn-outline-success\">
                            </form>";
                        }elseif($fila["grupo_activo"] == 1){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                            <input type=\"submit\" name=\"desactivar\" value=\"Desactivar\" class=\"btn btn-outline-danger\">
                            </form>";
                        }else{
                            echo "<div class=\"alert alert-danger\" role=\"alert\">
                            Petición denegada<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                            <input type=\"submit\" name=\"activar\" value=\"Pulsa para aprobar\" class=\"btn btn-success\">
                            </form>
                          </div>";
                        }
                    }
                    
                    echo "</div>
                </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        } 
        
    }

    function getGroupsFiltered($filter){
        $con = createConnection();
        $filtro = $filter.'%';
        $consulta = $con->prepare("SELECT g.id id_grupo, g.nombre nom_grupo, g.activo grupo_activo, foto, g.foto_avatar avatar_grupo, d.nombre disco, g.pendiente_aprobacion aprob from grupo g, discografica d where g.discografica = d.id and g.id <> 0 and g.nombre like ? order by g.nombre asc");
        $consulta->bind_param('s', $filtro);
        $consulta->bind_result($id_grupo, $nom_grupo, $grupo_activo, $foto, $avatar_grupo, $disco, $aprob);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows>0){
            while($consulta->fetch()){
                $albums_grupo = albumsPerGroup($id_grupo);
                echo "<div data-name=\"$nom_grupo\" class=\"rounded border grupo-detalle p-3 gap-2 col-12 col-md-3\">
                    <div class=\"w-50\">
                        <img class=\"rounded-circle img-fluid\" src=\"$avatar_grupo\">
                    </div>
                    <div class=\"d-flex flex-column justify-content-between\">
                        <p>Nombre: $nom_grupo</p>";
                        if($albums_grupo != ""){
                            echo "<p>Álbumes publicados: $albums_grupo</p>";
                        }
                        echo "<p>Gestión: $disco</p>";
                    if($aprob == 1){
                        echo "<div class=\"d-flex gap-3\"><form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id_grupo\">
                                <input type=\"submit\" name=\"aprobar\" value=\"Aprobar\" class=\"btn btn-outline-success\">
                                </form>
                                <form method=\"post\" action=\"#\">
                                    <input hidden name=\"id\" value=\"$id_grupo\">
                                    <input type=\"submit\" name=\"denegar\" value=\"Denegar\" class=\"btn btn-outline-danger\">
                                </form></div>";
                    }else{
                        if($grupo_activo == 0){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$id_grupo\">
                            <input type=\"submit\" name=\"activar\" value=\"Activar\" class=\"btn btn-outline-success\">
                            </form>";
                        }elseif($grupo_activo == 1){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$id_grupo\">
                            <input type=\"submit\" name=\"desactivar\" value=\"Desactivar\" class=\"btn btn-outline-danger\">
                            </form>";
                        }else{
                            echo "<div class=\"alert alert-danger\" role=\"alert\">
                            Petición denegada<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$id_grupo\">
                            <input type=\"submit\" name=\"activar\" value=\"Pulsa para aprobar\" class=\"btn btn-success\">
                            </form>
                          </div>";
                        }
                    }
                    
                    echo "</div>
                </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        }
        $consulta->close();
        $con->close();
        
    }

    function getAllGroupsNoDisc(){
        $con = createConnection();
        $consulta = $con->query("SELECT g.id id_grupo, g.nombre nom_grupo, g.correo correo_grupo, g.activo grupo_activo, foto, g.foto_avatar avatar_grupo, pendiente_aprobacion aprob from grupo g where g.discografica is null");

        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            echo "<div class=\"rounded border grupo-detalle d-flex justify-content-around p-3 gap-2 col-12 col-md-3\">
                <div class=\"w-50\">
                    <img class=\"img-fluid rounded-circle\" src=\"$fila[avatar_grupo]\">
                </div>
                <div class=\"d-flex flex-column justify-content-between\">
                    <p>ID: $fila[id_grupo]</p>
                    <p>Nombre: $fila[nom_grupo]</p>
                    <p>Correo: $fila[correo_grupo]</p>";
                if($fila["aprob"] == 1){
                    echo "<div class=\"d-flex gap-3\"><form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                            <input type=\"submit\" name=\"activar\" value=\"Aprobar\" class=\"btn btn-outline-success\">
                            </form>
                            <form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                                <input type=\"submit\" name=\"desactivar\" value=\"Denegar\" class=\"btn btn-outline-danger\">
                            </form></div>";
                }else{
                    if($fila["grupo_activo"] == 0){
                        echo "<form method=\"post\" action=\"#\">
                        <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                        <input type=\"submit\" name=\"activar\" value=\"Activar\" class=\"btn btn-outline-success\">
                        </form>";
                    }else{
                        echo "<form method=\"post\" action=\"#\">
                        <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                        <input type=\"submit\" name=\"desactivar\" value=\"Desactivar\" class=\"btn btn-outline-danger\">
                        </form>";
                    }
                }
                
                echo "</div>
            </div>";
        }
    }
    

    function groupsPerRecordLabel($id){
        $total = 0;
        $con = createConnection();
        $consulta = $con->query("SELECT COUNT(*) total_grupos
        FROM grupo, discografica where grupo.discografica = discografica.id and discografica.id = '$id'
        GROUP BY discografica.id");
        $fila = $consulta->fetch_array(MYSQLI_ASSOC);
        if($consulta->num_rows > 0){
            $total = $fila["total_grupos"];
        }
        return $total;
    }

    function activateDiscographic($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE discografica SET activo = 1 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function deactivateDiscographic($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE discografica SET activo = 0 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function deactivateAlbum($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE album SET activo = 0 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function activateAlbum($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE album SET activo = 1 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function activateGroup($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE grupo SET activo = 1 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function deactivateGroup($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE grupo SET activo = 0 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function getAllRecordLabels(){
        $con = createConnection();
        $consulta = $con->query("SELECT id, nombre, correo, foto_avatar, activo, pendiente_aprobacion aprob FROM discografica where id <> 0 order by nombre asc");
        
        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            $total_grupos = groupsPerRecordLabel($fila["id"]);
            echo "<div data-name=\"$fila[nombre]\" class=\"rounded border grupo-detalle p-3 gap-2 col-12 col-md-3\">
                        <div class=\"w-50\">
                            <img class=\"img-fluid\" src=\"$fila[foto_avatar]\">
                        </div>
                        <div class=\"d-flex flex-column justify-content-between\">
                            <p>Nombre: $fila[nombre]</p>
                            <p>Correo: $fila[correo]</p>
                            <p>Número de grupos gestionados: $total_grupos</p>";
                        if($fila["aprob"] == 1){
                            echo "<div class=\"d-flex gap-3\"><form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$fila[id]\">
                            <input type=\"submit\" name=\"aprobar\" value=\"Aprobar\" class=\"btn btn-outline-success\">
                            </form>
                            <form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$fila[id]\">
                                <input type=\"submit\" name=\"denegar\" value=\"Denegar\" class=\"btn btn-outline-danger\">
                            </form></div>";
                        }else{
                            if($fila["activo"] == 0){
                                echo "<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$fila[id]\">
                                <input type=\"submit\" name=\"activar\" value=\"Activar\" class=\"btn btn-outline-success\">
                                </form>";
                            }elseif($fila["activo"] == 1){
                                echo "<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$fila[id]\">
                                <input type=\"submit\" name=\"desactivar\" value=\"Desactivar\" class=\"btn btn-outline-danger\">
                                </form>";
                            }else{
                                echo "<div class=\"alert alert-danger\" role=\"alert\">
                                Petición denegada<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$fila[id]\">
                                <input type=\"submit\" name=\"activar\" value=\"Pulsa para aprobar\" class=\"btn btn-success\">
                                </form>
                              </div>";
                            }
                        }
                        
                        echo "</div>
                </div>";
        }
        $con->close();
    }

    function getRecordLabelsFiltered($filter){
        $con = createConnection();
        $filtro = $filter.'%';
        $consulta = $con->prepare("SELECT id, nombre, correo, foto_avatar, activo, pendiente_aprobacion aprob FROM discografica where id <> 0 and nombre like ? order by nombre asc");
        $consulta->bind_param('s', $filtro);
        $consulta->bind_result($id, $nombre, $correo, $foto_avatar, $activo, $aprob);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows() > 0){
            while($consulta->fetch()){
                $total_grupos = groupsPerRecordLabel($id);
                echo "<div data-name=\"$nombre\" class=\"rounded border grupo-detalle p-3 gap-2 col-12 col-md-3\">
                        <div class=\"w-50\">
                            <img class=\"img-fluid\" src=\"$foto_avatar\">
                        </div>
                        <div class=\"d-flex flex-column justify-content-between\">
                            <p>Nombre: $nombre</p>
                            <p>Correo: $correo</p>
                            <p>Número de grupos gestionados: $total_grupos</p>";
                        if($aprob == 1){
                            echo "<div class=\"d-flex gap-3\"><form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$id\">
                            <input type=\"submit\" name=\"aprobar\" value=\"Aprobar\" class=\"btn btn-outline-success\">
                            </form>
                            <form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <input type=\"submit\" name=\"denegar\" value=\"Denegar\" class=\"btn btn-outline-danger\">
                            </form></div>";
                        }else{
                            if($activo == 0){
                                echo "<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <input type=\"submit\" name=\"activar\" value=\"Activar\" class=\"btn btn-outline-success\">
                                </form>";
                            }elseif($activo == 1){
                                echo "<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <input type=\"submit\" name=\"desactivar\" value=\"Desactivar\" class=\"btn btn-outline-danger\">
                                </form>";
                            }else{
                                echo "<div class=\"alert alert-danger\" role=\"alert\">
                                Petición denegada<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <input type=\"submit\" name=\"activar\" value=\"Pulsa para aprobar\" class=\"btn btn-success\">
                                </form>
                              </div>";
                            }
                        }
                        
                        echo "</div>
                </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        }
        $consulta->close();
        $con->close();
    }

    function getAllAlbums(){
        $con = createConnection();
        $consulta = $con->query("SELECT a.id id_album, titulo, a.foto foto_album, a.activo album_activo, lanzamiento, g.nombre nom_grupo from album a, grupo g where g.id = a.grupo order by titulo asc");
        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            $fecha_format = formatDate($fila["lanzamiento"]);
            echo "<div data-name=\"$fila[titulo]\" class=\"rounded border grupo-detalle p-3 gap-3 col-12 col-xl-3 col-md-4\">
                <div class=\"w-50\">
                    <img class=\"img-fluid rounded\" src=\"$fila[foto_album]\">
                </div>
                <div class=\"d-flex flex-column justify-content-between gap-1\">
                    <p>Título: $fila[titulo]</p>
                    <p>Autor: $fila[nom_grupo]</p>
                    <p>Lanzado el: $fecha_format</p>";
                if($fila["album_activo"] == 0){
                    echo "<form method=\"post\" action=\"#\">
                    <input hidden name=\"id\" value=\"$fila[id_album]\">
                    <input type=\"submit\" name=\"activar\" value=\"Activar\" class=\"btn btn-outline-success\">
                    </form>";
                }else{
                    echo "<form method=\"post\" action=\"#\">
                    <input hidden name=\"id\" value=\"$fila[id_album]\">
                    <input type=\"submit\" name=\"desactivar\" value=\"Desactivar\" class=\"btn btn-outline-danger\">
                    </form>";
                }
                echo "<form method=\"post\" action=\"admin_listado_canciones.php\">
                        <input hidden name=\"id\" value=\"$fila[id_album]\">
                        <input class=\"btn btn-outline-primary\" type=\"submit\" name=\"ver\" value=\"Ver canciones\">
                      </form>
                </div>
                </div>";
        }
        $con->close();
    }

    function getAlbumsFiltered($filter){
        $con = createConnection();
        $filtro = $filter.'%';
        $consulta = $con->prepare("SELECT a.id id_album, titulo, a.foto foto_album, a.activo album_activo, lanzamiento, g.nombre nom_grupo from album a, grupo g where g.id = a.grupo and titulo like ? order by titulo asc");
        $consulta->bind_param('s', $filtro);
        $consulta->bind_result($id_album, $titulo, $foto_album, $album_activo, $lanzamiento, $nom_grupo);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows() > 0){
            while($consulta->fetch()){
                $fecha_format = formatDate($lanzamiento);
                echo "<div data-name=\"$titulo\" class=\"rounded border grupo-detalle d-flex justify-content-around p-3 gap-3 col-12 col-xl-3 col-md-4\">
                    <div class=\"w-50\">
                        <img class=\"img-fluid rounded\" src=\"$foto_album\">
                    </div>
                    <div class=\"d-flex flex-column justify-content-between gap-1\">
                        <p>Título: $titulo</p>
                        <p>Autor: $nom_grupo</p>
                        <p>Lanzado el: $fecha_format</p>";
                    if($album_activo == 0){
                        echo "<form method=\"post\" action=\"#\">
                        <input hidden name=\"id\" value=\"$id_album\">
                        <input type=\"submit\" name=\"activar\" value=\"Activar\" class=\"btn btn-outline-success\">
                        </form>";
                    }else{
                        echo "<form method=\"post\" action=\"#\">
                        <input hidden name=\"id\" value=\"$id_album\">
                        <input type=\"submit\" name=\"desactivar\" value=\"Desactivar\" class=\"btn btn-outline-danger\">
                        </form>";
                    }
                    echo "<form method=\"post\" action=\"admin_listado_canciones.php\">
                            <input hidden name=\"id\" value=\"$id_album\">
                            <input class=\"btn btn-outline-primary\" type=\"submit\" name=\"ver\" value=\"Ver canciones\">
                        </form>
                    </div>
                    </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        }
        $consulta->close();
        $con->close();
    }

    function getAlbumSongs($id){
        $con = createConnection();
        $consulta1 = $con->prepare("SELECT a.titulo album, a.foto foto, g.nombre grupo from album a, grupo g where g.id = a.grupo and a.id = ?");
        $consulta1->bind_param('i', $id);
        $consulta1->bind_result($album, $foto, $grupo);
        $consulta1->execute();
        $consulta1->fetch();
        echo "<div class=\"w-50\">
                <h2>$album</h2>
                <h3>$grupo</h3>
                <img class=\"img-fluid rounded\" src=\"$foto\">
                </div>";
        $consulta1->close();
        
        $consulta2 = $con->prepare("SELECT c.titulo cancion, duracion from album a, incluye i, cancion c where a.id = i.album and c.id = i.cancion and a.id = ?");
        $consulta2->bind_param('i', $id);
        $consulta2->bind_result($cancion, $duracion);
        $consulta2->execute();
        echo "<ul class=\"w-50\">";
        while($consulta2->fetch()) {
            echo "<li>$cancion $duracion</li>";
        }
        echo "</ul>";
        $consulta2->close();
        $con->close();
    }

    function getAlbumName($id){
        $con = createConnection();
        $consulta = $con->prepare("SELECT a.titulo from album a, grupo g where g.id = a.grupo and a.id = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($nombre);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $nombre;
    }


    function getAllUsers(){
        $con = createConnection();
        $consulta = $con->query("SELECT u.nombre nombre, apellidos, usuario, u.foto_avatar foto, u.correo correo, e.nombre estilo, g.nombre grupo FROM usuario u, grupo g, estilo e where u.estilo = e.id and u.grupo = g.id and u.id <> 0");

        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            echo "<div class=\"rounded border disco-detalle d-flex justify-content-around p-3 gap-2 col-12 col-md-3\">
                        <div class=\"w-50\">
                            <img class=\"img-fluid\" src=\"$fila[foto]\">
                            <span>$fila[nombre]</span>
                            <span>$fila[apellidos]</span>
                        </div>
                        <div class=\"d-flex flex-column justify-content-between\">
                            <p>Usuario: $fila[usuario]</p>
                            <p>Nombre: $fila[nombre]</p>
                            <p>Correo: $fila[correo]</p>";
                        if($fila["estilo"] != null){
                            echo "<p>Estilo favorito: $fila[estilo]</p>";
                        }else{
                            echo "<p>Sin estilo favorito</p>";
                        }
                        if($fila["grupo"] != null){
                            echo "<p>Miembro de $fila[grupo]</p>";
                        }else{
                            echo "<p>No es miembro de ningún grupo</p>";
                        }
                        
                        echo "</div>
                </div>";
        }
        $con->close();
    }

    function approveGroupCreation($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE grupo set activo = 1, pendiente_aprobacion = 0 where id = ?");
        $update->bind_param('i', $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function denyGroupCreation($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE grupo set activo = 2, pendiente_aprobacion = 0 where id = ?");
        $update->bind_param('i', $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function approveDiscCreation($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE discografica set activo = 1, pendiente_aprobacion = 0 where id = ?");
        $update->bind_param('i', $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function denyDiscCreation($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE discografica set activo = 2, pendiente_aprobacion = 0 where id = ?");
        $update->bind_param('i', $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function printFilterForm(){
        echo "<h3 class=\"text-center mt-4\">Filtro alfabético</h3>
        <form action=\"#\" method=\"post\">
            <ul class=\"d-flex list-style-none justify-content-center gap-3 flex-wrap mb-3 pe-2 ps-2\">
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"a\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"d\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"b\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"e\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"c\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"f\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"g\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"h\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"i\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"j\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"k\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"l\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"m\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"n\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"ñ\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"o\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"p\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"q\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"r\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"s\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"t\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"u\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"v\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"w\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"x\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"y\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"z\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"\"></li>
            </ul>
        </form>";
    }

    
    
?>