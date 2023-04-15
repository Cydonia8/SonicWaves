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
    $consulta = $con->prepare("SELECT foto from $table where $identificador = ?");
    $consulta->bind_param('s',$user);
    $consulta->bind_result($foto);
    $consulta->execute();
    $consulta->fetch();
    $consulta->close();
    $con->close();
    return $foto;
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
                        <ul>
                            <a href=\"\"><li>Nosotros</li></a>
                            <a href=\"\"><li>Reproductor</li></a>
                            <a class=\"link-image-user\" href=\"admin/admin_main.php\"><li><img class=\"rounded-circle\" src=\"$foto\"></li></a>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "standard"){
                $foto = imageUser($_SESSION["user"], "usuario", "usuario");
                $foto = imageIndex($foto);
                echo "<header class=\"header-index\">
                    <img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul>
                            <a href=\"\"><li>Nosotros</li></a>
                            <a href=\"\"><li>Reproductor</li></a>
                            <a class=\"link-image-user\" href=\"admin/admin_main.php\"><li><img class=\"rounded-circle\" src=\"$foto\"></li></a>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "group"){
                $foto = imageUser($_SESSION["user"], "grupo", "correo");
                $foto = imageIndex($foto);
                echo "<header class=\"header-index\">
                    <img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul>
                            <a href=\"\"><li>Nosotros</li></a>
                            <a href=\"\"><li>Reproductor</li></a>
                            <a class=\"link-image-user\" href=\"grupo/grupo_main.php\"><li><img class=\"rounded-circle\" src=\"$foto\"></li></a>
                        </ul>
                    </nav>
                </header>";
            }else{
                $foto = imageUser($_SESSION["user"], "discografica", "correo");
                $foto = imageIndex($foto);
                echo "<header class=\"header-index\">
                    <img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul>
                            <a href=\"\"><li>Nosotros</li></a>
                            <a href=\"\"><li>Reproductor</li></a>
                            <a class=\"link-image-user\" href=\"discografica/discografica_main.php\"><li><img class=\"rounded-circle\" src=\"$foto\"></li></a>
                        </ul>
                    </nav>
                </header>";
            }
            
        }else{
            echo "<header class=\"header-index\">
                    <img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul>
                            <a href=\"\"><li>Nosotros</li></a>
                            <a href=\"\"><li>Reproductor</li></a>
                            <a href=\"login/login.php\"><li>Iniciar sesión</li></a>
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
                        <ul>
                            <a href=\"\"><li>Nosotros</li></a>
                            <a href=\"\"><li>Reproductor</li></a>
                            <a class=\"link-image-user\" href=\"../admin/admin_main.php\"><li><img class=\"rounded-circle\" src=\"$foto\"></li></a>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "standard"){
                $foto = imageUser($_SESSION["user"], "usuario", "usuario");
                echo "<header class=\"header-index\">
                    <img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul>
                            <a href=\"\"><li>Nosotros</li></a>
                            <a href=\"\"><li>Reproductor</li></a>
                            <a class=\"link-image-user\" href=\"../admin/admin_main.php\"><li><img class=\"rounded-circle\" src=\"$foto\"></li></a>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "group"){
                $foto = imageUser($_SESSION["user"], "grupo", "correo");
                echo "<header class=\"header-index\">
                    <img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul>
                            <a href=\"\"><li>Nosotros</li></a>
                            <a href=\"\"><li>Reproductor</li></a>
                            <a class=\"link-image-user\" href=\"../grupo/grupo_main.php\"><li><img class=\"rounded-circle\" src=\"$foto\"></li></a>
                        </ul>
                    </nav>
                </header>";
            }else{
                $foto = imageUser($_SESSION["user"], "discografica", "correo");
                echo "<header class=\"header-index\">
                    <img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul>
                            <a href=\"\"><li>Nosotros</li></a>
                            <a href=\"\"><li>Reproductor</li></a>
                            <a class=\"link-image-user\" href=\"../discografica/discografica_main.php\"><li><img class=\"rounded-circle\" src=\"$foto\"></li></a>
                        </ul>
                    </nav>
                </header>";
            }
            
        }else{
            echo "<header class=\"header-index\">
                    <img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\">
                    <nav>
                        <ul>
                            <a href=\"\"><li>Nosotros</li></a>
                            <a href=\"\"><li>Reproductor</li></a>
                            <a href=\"../login/login.php\"><li>Iniciar sesión</li></a>
                        </ul>
                    </nav>
                </header>";
        }
    }
}