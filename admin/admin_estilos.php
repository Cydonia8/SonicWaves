<?php
    session_start();
    // echo $_SESSION["user"]
    require_once "../php_functions/admin_functions.php";
    if(isset($_POST["nuevo-estilo"])){
        newStyle($_POST["nombre"], $_POST["color"]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32"/>
    <title>Panel de administración</title>
</head>
<body id="admin-main">
    <?php
        menuAdmin();
    ?>
    <h1 class="text-center mt-5">Estilos de Sonic Waves</h1>
    <section class="estilos-container container-xl row mx-auto">
        <div class="col-12 col-md-6">
            <table class="tabla-estilos mx-auto">
                <thead>
                    <th>ID</th>
                    <th>Nombre de estilo</th>
                    <th>Color característico</th>
                    <th>Canciones con este estilo</th>
                </thead>
                <tbody>
                    <?php
                        getAllStyles();
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-12 col-md-6">
            <form action="#" method="post">
                <div class="row">
                    <label for="">Nombre</label>
                    <input type="text" required name="nombre">
                </div>
                <div class="row">
                    <label for="">Color característico</label>
                    <input type="color" required name="color">
                </div>
                <input type="submit" name="nuevo-estilo" value="Añadir estilo">
            </form>
        </div>
    </section>
</body>
</html>