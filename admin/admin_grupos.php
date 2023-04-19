<?php
    session_start();
    // echo $_SESSION["user"]
    require_once "../php_functions/admin_functions.php";
    if(isset($_POST["activar"])){
        activateGroup($_POST["id"]);
        // echo "<meta http-equiv='refresh' content='0;url=admin_discografica.php'>";
    }elseif(isset($_POST["desactivar"])){
        deactivateGroup($_POST["id"]);
        // echo "<meta http-equiv='refresh' content='0;url=admin_discografica.php'>";
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
    <script src="../scripts/admin_grupos.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32"/>
    <title>Panel de administración</title>
</head>
<body id="admin-body">
    <?php
        menuAdminDropdown();
    ?>
    <h1 class="text-center mt-5">Grupos de Sonic Waves</h1>
    <div class="admin-grupos-selector d-flex justify-content-around mt-3 mb-4">
            <h2 class="tipo-activo" data-type="disco">Grupos de discográfica</h2>
            <h2 data-type="auto">Grupos autogestionados</h2>
       </div>
    <section data-section="disco" class="grupos-container container-activo container-fluid mx-auto row gap-3">
       
       <?php
            getAllGroupsDisc();
       ?>
    </section>
    <section data-section="auto" class="grupos-container container-fluid mx-auto row gap-3">
       
       <?php
            getAllGroupsNoDisc();
       ?>
    </section>

</body>
</html>