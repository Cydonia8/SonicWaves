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

    
?>