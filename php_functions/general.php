<?php


function createConnection(){
    $con = new mysqli('localhost','root','','sonicwaves');
    $con->set_charset("utf8");
    return $con;
}

function imageIndex($ruta){
    $imagen_rutanueva = preg_replace("`^.{1}`",'',$ruta);
    return $imagen_rutanueva;
}

function imageUser($user, $table, $identificador){
    $con = createConnection();
    $consulta = $con->prepare("SELECT foto_avatar from $table where $identificador = ?");
    $consulta->bind_param('s',$user);
    $consulta->bind_result($foto);
    $consulta->execute();
    $consulta->fetch();
    $consulta->close();
    $con->close();
    return $foto;
}

function formatDate($date){
    $marcatiempo = strtotime($date);
    $fecha_formateada = date('d-m-Y', $marcatiempo);
    return $fecha_formateada;
}

function getAutoID($tabla){
    $con = createConnection();
    $consulta_id = $con->prepare("select auto_increment cod from information_schema.tables where table_schema = 'sonicwaves' and table_name = ?");
    $consulta_id->bind_param('s', $tabla);
    $consulta_id->bind_result($id);
    $consulta_id->execute();
    $consulta_id->fetch();
    $consulta_id->close();

    return $id;
}

function printMainMenu($location = "noindex"){

    if($location == "index"){
        if(isset($_SESSION["user-type"])){
            if($_SESSION["user-type"] == "admin"){
                $foto = imageUser("admin", "usuario", "usuario");
                $foto = imageIndex($foto);
                echo "<header class=\"header-index\">
                    <img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul class=\"links-header\">
                            <li><a href=\"\">Nosotros</a></li>
                            <li><a href=\"\">Reproductor</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"admin/admin_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "standard"){
                $foto = imageUser($_SESSION["user"], "usuario", "usuario");
                $foto = imageIndex($foto);
                echo "<header class=\"header-index\">
                    <img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul class=\"links-header\">
                            <li><a href=\"\">Nosotros</a></li>
                            <li><a href=\"\">Reproductor</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"grupo/grupo_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "group"){
                $foto = imageUser($_SESSION["user"], "grupo", "correo");
                $foto = imageIndex($foto);
                echo "<header class=\"header-index\">
                    <img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul class=\"links-header\">
                            <li><a href=\"\">Nosotros</a></li>
                            <li><a href=\"\">Reproductor</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"grupo/grupo_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }else{
                $foto = imageUser($_SESSION["user"], "discografica", "correo");
                $foto = imageIndex($foto);
                echo "<header class=\"header-index\">
                    <img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul class=\"links-header\">
                            <li><a href=\"\">Nosotros</a></li>
                            <li><a href=\"\">Reproductor</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"discografica/discografica_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }
            
        }else{
            echo "<header class=\"header-index\">
                    <img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul class=\"links-header\">
                            <li><a href=\"\">Nosotros</a></li>
                            <li><a href=\"\">Reproductor</a></li>
                            <li><a href=\"login/login.php\">Iniciar sesión</a></li>
                        </ul>
                    </nav>
                </header>";
        }
        
    }else{
        if(isset($_SESSION["user-type"])){
            if($_SESSION["user-type"] == "admin"){
                $foto = imageUser("admin", "usuario", "usuario");
                echo "<header class=\"header-index\">
                    <img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul class=\"links-header\">
                            <li><a href=\"\">Nosotros</a></li>
                            <li><a href=\"\">Reproductor</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"../admin/admin_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "standard"){
                $foto = imageUser($_SESSION["user"], "usuario", "usuario");
                echo "<header class=\"header-index\">
                    <img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul class=\"links-header\">
                            <li><a href=\"\">Nosotros</a></li>
                            <li><a href=\"\">Reproductor</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "group"){
                $foto = imageUser($_SESSION["user"], "grupo", "correo");
                echo "<header class=\"header-index\">
                    <img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul class=\"links-header\">
                            <li><a href=\"\">Nosotros</a></li>
                            <li><a href=\"\">Reproductor</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"../grupo/grupo_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }else{
                $foto = imageUser($_SESSION["user"], "discografica", "correo");
                echo "<header class=\"header-index\">
                    <img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul class=\"links-header\">
                            <li><a href=\"\">Nosotros</a></li>
                            <li><a href=\"\">Reproductor</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"../discografica/discografica_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }
            
        }else{
            echo "<header class=\"header-index\">
                    <img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul class=\"links-header\">
                            <li><a href=\"\">Nosotros</a></li>
                            <li><a href=\"\">Reproductor</a></li>
                            <li><a href=\"../login/login.php\">Iniciar sesión</a></li>
                        </ul>
                    </nav>
                </header>";
        }
    }
}

function closeSession($POST, $seccion = "noindex"){
    if($seccion == "noindex"){
        if(isset($_POST["cerrar-sesion"])){
            if(isset($_COOKIE['sesion'])){
                setcookie("sesion","", time()-3600, '/');
                unset($_SESSION['user']);
                unset($_SESSION["user-type"]);
                header("location:../index.php");
            }else{
                unset($_SESSION['user']);
                unset($_SESSION["user-type"]);
                header("location:../index.php");
            }
            
        }
    }else{
        if(isset($_POST["cerrar-sesion"])){
            if(isset($_COOKIE['sesion'])){
                unset($_SESSION['user']);
                unset($_SESSION["user-type"]);
                setcookie("sesion","", time()-3600, '/');              
                echo "<meta http-equiv='refresh' content='0;url=index.php'>";
            }else{
                unset($_SESSION['user']);
                unset($_SESSION["user-type"]);
                header("location:index.php");
            }
        }
    }
    
}