<?php
    session_start();
    // echo $_SESSION["user"]
    require_once "../php_functions/admin_functions.php";
    require_once "../php_functions/general.php";
    forbidAccess("admin");
    if(isset($_POST["activar"])){
        activateGroup($_POST["id"]);
        // echo "<meta http-equiv='refresh' content='0;url=admin_discografica.php'>";
    }elseif(isset($_POST["desactivar"])){
        deactivateGroup($_POST["id"]);
        // echo "<meta http-equiv='refresh' content='0;url=admin_discografica.php'>";
    }
    if(isset($_POST["aprobar"])){
        approveGroupCreation($_POST["id"]);
    }elseif(isset($_POST["denegar"])){
        denyGroupCreation($_POST["id"]);
    }
    closeSession($_POST);

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
    <!-- <div class="admin-grupos-selector d-flex justify-content-around mt-3 mb-4">
            <h2 class="tipo-activo" data-type="disco">Grupos de discográfica</h2>
            <h2 data-type="auto">Grupos autogestionados</h2>
       </div> -->
       <input type="text" class="busqueda-dinamica-admin">
    <section class="filter-abc-admin">
        <h3 class="text-center mt-4">Filtro alfabético</h3>
        <form action="#" method="post">
            <ul class="d-flex list-style-none justify-content-center gap-3 flex-wrap mb-3 pe-2 ps-2">
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="a"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="b"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="c"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="d"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="e"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="f"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="g"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="h"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="i"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="j"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="k"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="l"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="m"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="n"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="ñ"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="o"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="p"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="q"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="r"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="s"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="t"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="u"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="v"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="w"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="x"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="y"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="z"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value=""></li>
            </ul>
        </form>
    </section>
    <section class="grupos-container container-activo container-fluid mx-auto row gap-3">
       
       <?php
            if(!isset($_POST["filtro"])){
                getAllGroups();
            }else{
                getGroupsFiltered($_POST["filtro"]);
            }
            
       ?>
    </section>
    <!-- <section data-section="auto" class="grupos-container container-fluid mx-auto row gap-3">
       
       <?php
            // getAllGroupsNoDisc();
    //    ?>
    </section> -->

</body>
</html>