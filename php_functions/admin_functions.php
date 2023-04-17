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
                        <li><a class=\"dropdown-item\" href=\"#\">Usuarios</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_grupos.php\">Grupos</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_discografica.php\">Discográficas</a></li>
                        <li><a class=\"dropdown-item\" href=\"#\">Álbumes</a></li>
                        <li><a class=\"dropdown-item\" href=\"#\">Reseñas</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_estilos.php\">Estilos</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_estilos.php\">Publicaciones</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_estilos.php\">Encuestas</a></li>
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

    function getAllStyles(){
        $con = createConnection();
        $consulta = $con->query("SELECT * FROM estilo");
        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            $canciones_estilo = songsPerStyle($fila["id"]);
            echo "<tr>
                    <td>$fila[id]</td>
                    <td>$fila[nombre]</td>
                    <td bgcolor=\"$fila[color_caracteristico]\"></td>";
                    if($canciones_estilo != ""){
                        echo "<td>$canciones_estilo</td>";
                    }else{

                    }
                    
                echo "</tr>";
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

    function getAllGroupsDisc(){
        $con = createConnection();
        $consulta = $con->query("SELECT g.id id_grupo, g.nombre nom_grupo, g.activo grupo_activo, foto, g.foto_avatar avatar_grupo, d.nombre disco from grupo g, discografica d where g.discografica = d.id");

        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            echo "<div class=\"rounded border grupo-detalle d-flex justify-content-around p-3 gap-2 col-12 col-md-3\">
                <div class=\"w-50\">
                    <img class=\"img-fluid\" src=\"$fila[avatar_grupo]\">
                </div>
                <div class=\"d-flex flex-column justify-content-between\">
                    <p>ID: $fila[id_grupo]</p>
                    <p>Nombre: $fila[nom_grupo]</p>
                    <p>Gestionado por: $fila[disco]</p>";
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
                echo "</div>
            </div>";
        }
    }

    function getAllGroupsNoDisc(){
        $con = createConnection();
        $consulta = $con->query("SELECT g.id id_grupo, g.nombre nom_grupo, g.correo correo_grupo, g.activo grupo_activo, foto, g.foto_avatar avatar_grupo from grupo g where g.discografica is null");

        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            echo "<div class=\"rounded border grupo-detalle d-flex justify-content-around p-3 gap-2 col-12 col-md-3\">
                <div class=\"w-50\">
                    <img class=\"img-fluid rounded-circle\" src=\"$fila[avatar_grupo]\">
                </div>
                <div class=\"d-flex flex-column justify-content-between\">
                    <p>ID: $fila[id_grupo]</p>
                    <p>Nombre: $fila[nom_grupo]</p>
                    <p>Correo: $fila[correo_grupo]</p>";
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

    function getAllRecordLabels(){
        $con = createConnection();
        $consulta = $con->query("SELECT id, nombre, correo, foto_avatar, activo FROM discografica");
        
        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            $total_grupos = groupsPerRecordLabel($fila["id"]);
            echo "<div class=\"rounded border disco-detalle d-flex justify-content-around p-3 gap-2\">
                        <div class=\"w-50\">
                            <img class=\"img-fluid\" src=\"$fila[foto_avatar]\">
                        </div>
                        <div class=\"d-flex flex-column justify-content-between\">
                            <p>ID: $fila[id]</p>
                            <p>Nombre: $fila[nombre]</p>
                            <p>Correo: $fila[correo]</p>
                            <p>Número de grupos gestionados: $total_grupos</p>";
                        if($fila["activo"] == 0){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$fila[id]\">
                            <input type=\"submit\" name=\"activar\" value=\"Activar\" class=\"btn btn-outline-success\">
                            </form>";
                        }else{
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$fila[id]\">
                            <input type=\"submit\" name=\"desactivar\" value=\"Desactivar\" class=\"btn btn-outline-danger\">
                            </form>";
                        }
                        echo "</div>
                </div>";
        }
    }

    
?>