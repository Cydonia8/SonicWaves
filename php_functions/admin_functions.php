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
                        <li><a class=\"dropdown-item\" href=\"admin_resenas.php\">Reseñas</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_estilos.php\">Estilos</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_publicaciones.php\">Publicaciones</a></li>
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
                    </div>";
                    
                echo "</div>";
        }
        $con->close();
    }

    function newStyle($nombre){
        $exito = false;
        $con = createConnection();
        $insertar = $con->prepare("INSERT INTO estilo (nombre) VALUES (?)");
        $insertar->bind_param("s", $nombre);
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
                                <button style='--clr:#09eb3a' class='btn-danger-own' name='aprobar'><span>Aprobar</span><i></i></button>
                                </form>
                                <form method=\"post\" action=\"#\">
                                    <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                                    <button style='--clr:#e80c0c' class='btn-danger-own' name='denegar'><span>Denegar</span><i></i></button>
                                </form></div>";
                    }else{
                        if($fila["grupo_activo"] == 0){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                            <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Activar</span><i></i></button>
                            </form>";
                        }elseif($fila["grupo_activo"] == 1){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                            <button style='--clr:#e80c0c' class='btn-danger-own' name='desactivar'><span>Desactivar</span><i></i></button>
                            </form>";
                        }else{
                            echo "<div class=\"alert alert-danger\" role=\"alert\">
                            Petición denegada<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$fila[id_grupo]\">
                            <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Pulsa para aprobar</span><i></i></button>
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
                                <button style='--clr:#09eb3a' class='btn-danger-own' name='aprobar'><span>Aprobar</span><i></i></button>
                                </form>
                                <form method=\"post\" action=\"#\">
                                    <input hidden name=\"id\" value=\"$id_grupo\">
                                    
                                    <button style='--clr:#e80c0c' class='btn-danger-own' name='denegar'><span>Denegar</span><i></i></button>
                                </form></div>";
                    }else{
                        if($grupo_activo == 0){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$id_grupo\">
                            <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Activar</span><i></i></button>
                            </form>";
                        }elseif($grupo_activo == 1){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$id_grupo\">
                            <button style='--clr:#e80c0c' class='btn-danger-own' name='desactivar'><span>Desactivar</span><i></i></button>
                            </form>";
                        }else{
                            echo "<div class=\"alert alert-danger\" role=\"alert\">
                            Petición denegada<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$id_grupo\">
                            <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Pulsa para aprobar</span><i></i></button>
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

    // function getAllGroupsNoDisc(){
    //     $con = createConnection();
    //     $consulta = $con->query("SELECT g.id id_grupo, g.nombre nom_grupo, g.correo correo_grupo, g.activo grupo_activo, foto, g.foto_avatar avatar_grupo, pendiente_aprobacion aprob from grupo g where g.discografica is null");

    //     while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
    //         echo "<div class=\"rounded border grupo-detalle d-flex justify-content-around p-3 gap-2 col-12 col-md-3\">
    //             <div class=\"w-50\">
    //                 <img class=\"img-fluid rounded-circle\" src=\"$fila[avatar_grupo]\">
    //             </div>
    //             <div class=\"d-flex flex-column justify-content-between\">
    //                 <p>ID: $fila[id_grupo]</p>
    //                 <p>Nombre: $fila[nom_grupo]</p>
    //                 <p>Correo: $fila[correo_grupo]</p>";
    //             if($fila["aprob"] == 1){
    //                 echo "<div class=\"d-flex gap-3\"><form method=\"post\" action=\"#\">
    //                         <input hidden name=\"id\" value=\"$fila[id_grupo]\">
    //                         <input type=\"submit\" name=\"activar\" value=\"Aprobar\" class=\"btn btn-outline-success\">
    //                         </form>
    //                         <form method=\"post\" action=\"#\">
    //                             <input hidden name=\"id\" value=\"$fila[id_grupo]\">
    //                             <input type=\"submit\" name=\"desactivar\" value=\"Denegar\" class=\"btn btn-outline-danger\">
    //                         </form></div>";
    //             }else{
    //                 if($fila["grupo_activo"] == 0){
    //                     echo "<form method=\"post\" action=\"#\">
    //                     <input hidden name=\"id\" value=\"$fila[id_grupo]\">
    //                     <input type=\"submit\" name=\"activar\" value=\"Activar\" class=\"btn btn-outline-success\">
    //                     </form>";
    //                 }else{
    //                     echo "<form method=\"post\" action=\"#\">
    //                     <input hidden name=\"id\" value=\"$fila[id_grupo]\">
    //                     <input type=\"submit\" name=\"desactivar\" value=\"Desactivar\" class=\"btn btn-outline-danger\">
    //                     </form>";
    //                 }
    //             }
                
    //             echo "</div>
    //         </div>";
    //     }
    // }
    

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
                            <button style='--clr:#09eb3a' class='btn-danger-own' name='aprobar'><span>Aprobar</span><i></i></button>
                            </form>
                            <form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$fila[id]\">
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='denegar'><span>Denegar</span><i></i></button>
                            </form></div>";
                        }else{
                            if($fila["activo"] == 0){
                                echo "<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$fila[id]\">
                                <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Activar</span><i></i></button>
                                </form>";
                            }elseif($fila["activo"] == 1){
                                echo "<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$fila[id]\">
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='desactivar'><span>Desactivar</span><i></i></button>
                                </form>";
                            }else{
                                echo "<div class=\"alert alert-danger\" role=\"alert\">
                                Petición denegada<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$fila[id]\">
                                <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Pulsa para aprobar</span><i></i></button>
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
                            <button style='--clr:#09eb3a' class='btn-danger-own' name='aprobar'><span>Aprobar</span><i></i></button>
                            </form>
                            <form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='denegar'><span>Denegar</span><i></i></button>
                            </form></div>";
                        }else{
                            if($activo == 0){
                                echo "<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Activar</span><i></i></button>
                                </form>";
                            }elseif($activo == 1){
                                echo "<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='desactivar'><span>Desactivar</span><i></i></button>
                                </form>";
                            }else{
                                echo "<div class=\"alert alert-danger\" role=\"alert\">
                                Petición denegada<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Pulsa para aprobar</span><i></i></button>
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
                    <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Activar</span><i></i></button>
                    </form>";
                }else{
                    echo "<form method=\"post\" action=\"#\">
                    <input hidden name=\"id\" value=\"$fila[id_album]\">
                    <button style='--clr:#e80c0c' class='btn-danger-own' name='desactivar'><span>Desactivar</span><i></i></button>
                    </form>";
                }
                echo "<form method=\"post\" action=\"admin_listado_canciones.php\">
                        <input hidden name=\"id\" value=\"$fila[id_album]\">
                        <button style='--clr:#0ce8e8' class='btn-danger-own' name='ver'><span>Ver canciones</span><i></i></button>
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
                        <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Activar</span><i></i></button>
                        </form>";
                    }else{
                        echo "<form method=\"post\" action=\"#\">
                        <input hidden name=\"id\" value=\"$id_album\">
                        <button style='--clr:#e80c0c' class='btn-danger-own' name='desactivar'><span>Desactivar</span><i></i></button>
                        </form>";
                    }
                    echo "<form method=\"post\" action=\"admin_listado_canciones.php\">
                            <input hidden name=\"id\" value=\"$id_album\">
                            <button style='--clr:#0ce8e8' class='btn-danger-own' name='ver'><span>Ver canciones</span><i></i></button>
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
        echo "<h2 class='text-center'>$grupo</h2>
        <div class=\"d-flex gap-5 mt-4\">
                <div class='w-50'>
                <img class=\"img-fluid rounded\" src=\"$foto\">
                </div>";
        $consulta1->close();
        
        $consulta2 = $con->prepare("SELECT c.titulo cancion, duracion from album a, incluye i, cancion c where a.id = i.album and c.id = i.cancion and a.id = ?");
        $consulta2->bind_param('i', $id);
        $consulta2->bind_result($cancion, $duracion);
        $consulta2->execute();
        echo "<ul class=\"w-50 admin-album-song-list d-flex flex-column gap-4\">";
        while($consulta2->fetch()) {
            echo "<li>$cancion ($duracion)</li>";
        }
        echo "</ul></div>";
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
                            <img class=\"img-fluid rounded-circle\" src=\"$fila[foto]\">
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

    function getAllPosts(){
        $con = createConnection();
        $consulta = $con->query("SELECT p.id id, titulo, contenido, fecha, p.foto foto, g.nombre grupo from publicacion p, grupo g where p.grupo = g.id order by g.nombre asc");
        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            $fecha = formatDate($fila["fecha"]);
            echo "<div class='grupo-detalle border rounded p-2 post-container-admin d-flex align-items-center align-items-lg-start justify-content-around gap-3'>
                    <img src='$fila[foto]' class='w-50 rounded object-fit-cover'>
                    <div class='d-flex flex-column gap-2'>
                        <p>Título: $fila[titulo]</p>
                        <p>Fecha de publicación: $fecha</p>
                        <p>Autor: $fila[grupo]</p>
                        <div class='d-flex gap-2 flex-column flex-lg-row'>
                            <form action='admin_publicacion_completa.php' method='get'>
                                <input hidden value='$fila[id]' name='id'>
                                <button style='--clr:#0ce8e8' class='btn-danger-own' name='ver-mas'><span>Ver más</span><i></i></button>
                            </form>
                            <form action='#' method='post'>
                                <input hidden value='$fila[id]' name='id'>
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='borrar'><span>Eliminar</span><i></i></button>
                            </form>
                        </div>
                    </div>
                </div>";
        }
        $con->close();
    }

    function getAllPostsFiltered($filter){
        $con = createConnection();
        $filtro = $filter."%";
        $consulta = $con->prepare("SELECT p.id id, titulo, contenido, fecha, p.foto foto, g.nombre grupo from publicacion p, grupo g where p.grupo = g.id and g.nombre like ?");
        $consulta->bind_param('s', $filtro);
        $consulta->bind_result($id, $titulo, $contenido, $fecha, $foto, $grupo);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows>0){
            while($consulta->fetch()){
                $fecha = formatDate($fecha);
                echo "<div class='grupo-detalle border rounded p-2 post-container-admin d-flex align-items-center align-items-lg-start justify-content-around gap-3'>
                        <img src='$foto' class='w-50 rounded'>
                        <div class='d-flex flex-column'>
                            <p>Título: $titulo</p>
                            <p>Fecha de publicación: $fecha</p>
                            <p>Autor: $grupo</p>
                            <div class='d-flex gap-2 flex-column flex-lg-row'>
                            <form action='admin_publicacion_completa.php' method='get'>
                                <input hidden value='$id' name='id'>
                                <button style='--clr:#0ce8e8' class='btn-danger-own' name='ver-mas'><span>Ver más</span><i></i></button>
                            </form>
                            <form action='#' method='post'>
                                <input hidden value='$id' name='id'>
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='borrar'><span>Eliminar</span><i></i></button>
                            </form>
                        </div>
                        </div>
                    </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        }
        
        $consulta->close();
        $con->close();
    }
    function getPostMainPhotoLink($id, $con){
        $consulta = $con->prepare("SELECT foto from publicacion where id = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($foto);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        return $foto;
    }

    function deletePostExtraPhotosLinks($id, $con){
        $consulta = $con->prepare("SELECT enlace from foto_publicacion where publicacion = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($enlace);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows > 0){
            while($consulta->fetch()){
                unlink($enlace);
            }
        }
        $consulta->close();
    }

    function deletePost($id){
        $con = createConnection();
        deletePostExtraPhotosLinks($id, $con);
        $delete1 = $con->prepare("DELETE FROM foto_publicacion where publicacion = ?");
        $delete1->bind_param('i', $id);
        $delete1->execute();
        $delete1->close();
        $foto = getPostMainPhotoLink($id, $con);
        $delete2 = $con->prepare("DELETE FROM publicacion where id = ?");
        $delete2->bind_param('i', $id);
        $delete2->execute();
        $delete2->close();
        $con->close();
        unlink($foto);
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

    function printFilterForm($tipo_filtro = ""){
        echo "<h3 class=\"text-center mt-4\">Filtro alfabético $tipo_filtro</h3>
        <form action=\"#\" method=\"post\">
            <ul class=\"filter-alphabetic d-flex list-style-none justify-content-center gap-3 flex-wrap mb-3 pe-2 ps-2\">
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"a\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"b\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"c\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"d\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"e\"></li>
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
                <li class='position-relative'><input class=\"btn btn-outline-light\" name=\"filtro\" type=\"submit\" value=\"\"><ion-icon class=\"position-absolute top-50 start-50 translate-middle\" name=\"refresh-outline\"></ion-icon></li>
            </ul>
        </form>";
    }

    function getPostPhotos($id){
        $con = createConnection();
        $consulta = $con->prepare("SELECT f.id id, enlace from foto_publicacion f, publicacion p where f.publicacion = p.id and p.id = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($id_f, $foto);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows > 0){

            echo "<h3>Fotografías adicionales</h3><div class='row gap-2'><div class='row gap-2'>";
            while($consulta->fetch()){
                echo "<form class='col-5 col-xl-3 position-relative' action='#' method='post'>
                        <img src='$foto' class='img-fluid rounded object-fit-cover post-admin-extra-photos'>
                        <input hidden value='$id_f' name='id-foto'>
                        <button style='--clr:#e80c0c' name='eliminar' class='btn-eliminar-foto-publicacion position-absolute btn-danger-own'><span>Eliminar</span><i></i></button>
                    </form>";
            }
            echo "</div></div>";
        }
        $consulta->close();
        $con->close();
    }
    
    function getPostPhotoLink($id){
        $con = createConnection();
        $consulta = $con->prepare("SELECT enlace from foto_publicacion where id = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($enlace);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $enlace;
    }

    function deletePostPhoto($id){
        $enlace = getPostPhotoLink($id);
        $con = createConnection();
        $delete = $con->prepare("DELETE FROM foto_publicacion where id = ?");
        $delete->bind_param('i', $id);
        $delete->execute();
        $delete->close();
        $con->close();
        unlink($enlace);
    }

    function getPost($id){
        $con = createConnection();
        $consulta = $con->prepare("SELECT titulo, contenido, p.foto foto, fecha, g.nombre grupo from publicacion p, grupo g where p.grupo = g.id and p.id = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($titulo, $contenido, $foto, $fecha, $grupo);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows != 0){
            $consulta->fetch();
            $consulta->close();
            $fecha = formatDate($fecha);
                echo "<section class='container-fluid mt-4'>
                            <div class='d-flex flex-column flex-xl-row gap-3'>
                                
                                <img src='$foto' class='w-50 rounded object-fit-cover ratio ratio-1x1'>
                                <div class='d-flex flex-column gap-3'>
                                    <h1>$titulo</h1>
                                    <pre class='pre-admin-full-post'>$contenido</pre>
                                    <i>$fecha</i>
                                    <strong>Publicado por: $grupo</strong>"; 
                                getPostPhotos($id);  
                                echo "</div>
                            </div>
                    </section>";
            
        }else{
            echo "<div class=\"alert-post-missing-info text-center alert alert-warning position-absolute\" role=\"alert\">
            No se ha encontrado ningun publicación.
          </div>";
        }
        
        $con->close();
    }

    function getAllReviews($filter){
        $con = createConnection();
        $filtro = $filter."%";
        $consulta = $con->prepare("SELECT r.id id, u.usuario autor, r.titulo titulo, contenido, r.fecha fecha, a.titulo album from reseña r, usuario u, album a where r.usuario = u.id and r.album = a.id and u.usuario like ?");
        $consulta->bind_param('s', $filtro);
        $consulta->bind_result($id, $autor, $titulo, $contenido, $fecha, $album);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows>0){
            while($consulta->fetch()){
                $fecha = formatDate($fecha);
                echo "<div class='grupo-detalle border rounded p-2 post-container-admin d-flex align-items-center align-items-lg-start justify-content-around gap-3'>
                        <div class='d-flex flex-column'>
                            <p>Título: $titulo</p>
                            <p>Fecha de publicación: $fecha</p>
                            <p>Autor: $autor</p>
                            <p>Álbum: $album</p>
                            <div class='d-flex gap-2 flex-column flex-lg-row'>
                            <form action='admin_resena_completa.php' method='get'>
                                <input hidden value='$id' name='id'>
                                <button style='--clr:#0ce8e8' class='btn-danger-own' name='ver-mas'><span>Ver más</span><i></i></button>
                            </form>
                            <form action='#' method='post'>
                                <input hidden value='$id' name='id'>
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='borrar'><span>Eliminar</span><i></i></button>
                            </form>
                        </div>
                        </div>
                    </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        }
        
        $consulta->close();
        $con->close();
    }
    
    function getReview($id){
        $con = createConnection();
        $consulta = $con->prepare("SELECT r.titulo titulo, contenido, u.usuario autor, fecha, a.titulo album from reseña r, usuario u, album a where r.album = a.id and r.usuario = u.id and r.id = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($titulo, $contenido, $autor, $fecha, $album);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows != 0){
            $consulta->fetch();
            $consulta->close();
            $fecha = formatDate($fecha);
                echo "<section class='container-fluid mt-4'>
                            <div class='d-flex flex-column flex-xl-row gap-3'>
                                <div class='d-flex flex-column gap-3'>
                                    <h1>$titulo</h1>
                                    <p>$contenido</p>
                                    <i>$fecha</i>
                                    <strong>Reseña escrita por por: $autor</strong>
                                </div>
                            </div>
                    </section>";
            
        }else{
            echo "<div class=\"alert-post-missing-info text-center alert alert-warning position-absolute\" role=\"alert\">
            No se ha encontrado ningun publicación.
          </div>";
        }
        
        $con->close();
    }

    function deleteReview($id){
        $con = createConnection();
        $delete = $con->prepare("DELETE FROM reseña where id = ?");
        $delete->bind_param('i', $id);
        $delete->execute();
        $delete->close();
        $con->close();
    }
    
    
?>