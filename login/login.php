<?php
    require_once "../php_functions/login_register_functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../scripts/jquery-3.2.1.min.js" defer></script>
    <script type="text/javascript" src="../scripts/login.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <title>Acceso a Sonic Waves</title>
</head>
<body id="login">
    <header class="w-100 position-absolute d-flex justify-content-center p-4">
        <a class="text-center" href="../index.php">
            <img src="../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png" alt="">
        </a>
    </header>
    <section class="h-100 w-100 d-flex justify-content-center align-items-center">
        <div class="form-box w-50">
            <div class="form-option-picker d-flex justify-content-between flex-wrap mb-3 align-content-center">
                <h3 class="active text-center flex-grow-1" data-form-title="user">Usuario</h3>
                <h3 class="text-center flex-grow-1" data-form-title="group">Grupo</h3>
                <h3 class="text-center flex-grow-1" data-form-title="disc">Discográfica</h3>
            </div>
            <div class="forms-container border border-secondary d-flex flex-column align-items-center p-2">
                <form action="#" method="post" class="active-form" data-form="user">
                    <h2 class="text-center mb-5 mt-3">Acceso para usuarios</h2>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Usuario</label>
                            <ion-icon name="person-outline"></ion-icon>
                        </div>
                        <input name="usuario" type="text" required>                        
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                        <label for="pass">Contraseña</label>
                        <ion-icon name="lock-closed-outline"></ion-icon>
                    </div>
                        <div class="pass-row d-flex position-relative">
                            <input class="w-100" name="pass" type="password" required>
                            <ion-icon class="position-absolute end-0 view-pass" name="eye-outline"></ion-icon>
                        </div>
                    </div>
                    <div class="mantener-sesion text-center x gap-1 justify-content-center align-items-center mb-3">
                        <label for="sesion"> <input name="sesion" type="checkbox">Mantener sesión abierta</label>
                    </div>
                    <input type="submit" name="acceder-user" value="Iniciar sesión" class="w-100 rounded-pill border-0 mb-3 p-2">
                    <div class="register">
                        <p class="text-center">¿No tienes cuenta? <a class="text-white" href="registro.php">Crea una aquí</a></p>
                    </div>
                </form>

                <form action="#" method="post" data-form="group">
                    <h2 class="text-center mb-5 mt-3">Acceso para grupos</h2>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="mail">Correo electrónico</label>
                            <ion-icon name="mail-outline"></ion-icon>
                        </div>
                        <input name="mail" type="email" required>                        
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                        <label for="pass">Contraseña</label>
                        <ion-icon name="lock-closed-outline"></ion-icon>
                    </div>
                        <div class="pass-row d-flex position-relative">
                            <input class="w-100" name="pass" type="password" required>
                            <ion-icon class="position-absolute end-0 view-pass" name="eye-outline"></ion-icon>
                        </div>
                    </div>
                    <div class="mantener-sesion text-center x gap-1 justify-content-center align-items-center mb-3">
                        <label for="sesion"> <input name="sesion" type="checkbox">Mantener sesión abierta</label>
                    </div>
                    <input type="submit" name="acceder-group" value="Iniciar sesión" class="w-100 rounded-pill border-0 mb-3 p-2">
                    <div class="register">
                        <p class="text-center">¿No tienes cuenta? <a class="text-white" href="registro.php">Crea una aquí</a></p>
                    </div>
                </form>

                <form action="#" method="post" data-form="disc">
                    <h2 class="text-center mb-5 mt-3">Acceso para discográficas</h2>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="mail">Correo electrónico</label>
                            <ion-icon name="mail-outline"></ion-icon>
                        </div>
                        <input name="mail" type="email" required>                        
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                        <label for="pass">Contraseña</label>
                        <ion-icon name="lock-closed-outline"></ion-icon>
                    </div>
                        <div class="pass-row d-flex position-relative">
                            <input class="w-100" name="pass" type="password" required>
                            <ion-icon class="position-absolute end-0 view-pass" name="eye-outline"></ion-icon>
                        </div>
                    </div>
                    <div class="mantener-sesion text-center x gap-1 justify-content-center align-items-center mb-3">
                        <label for="sesion"> <input name="sesion" type="checkbox">Mantener sesión abierta</label>
                    </div>
                    <input type="submit" name="acceder-disc" value="Iniciar sesión" class="w-100 rounded-pill border-0 mb-3 p-2">
                    <div class="register">
                        <p class="text-center">¿No tienes cuenta? <a class="text-white" href="registro.php">Crea una aquí</a></p>
                    </div>
                </form>
            </div>
            <?php
                if(isset($_POST["acceder-user"])){
                    $accede = loginUser($_POST["usuario"], $_POST["pass"]);

                    if(!$accede){
                        echo "<div data-mdb-delay=\"3000\" class=\"alert text-center mt-3 alert-danger alert-dismissible fade show\" role=\"alert\">Credenciales incorrectas</div>";
                    }
                }elseif(isset($_POST["acceder-group"])){
                    $accede = loginGroupDisc($_POST["mail"], $_POST["pass"], "grupo");

                    if(!$accede){
                        echo "<div data-mdb-delay=\"3000\" class=\"alert text-center mt-3 alert-danger alert-dismissible fade show\" role=\"alert\">Credenciales incorrectas</div>";
                    }

                }elseif(isset($_POST["acceder-disc"])){
                    $accede = loginGroupDisc($_POST["mail"], $_POST["pass"], "discografica");

                    if(!$accede){
                        echo "<div data-mdb-delay=\"3000\" class=\"alert text-center mt-3 alert-danger alert-dismissible fade show\" role=\"alert\">Credenciales incorrectas</div>";
                    }
                }
            ?>
        </div>
    </section>
    
</body>
</html>