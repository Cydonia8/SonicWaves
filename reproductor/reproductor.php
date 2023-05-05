<?php
    session_start();
    require_once "../php_functions/general.php";
    // echo $_SESSION["user"];
    if(!isset($_SESSION["user-type"])){
        header("location:../login/login.php");
    }else{
        forbidAccess("standard");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <script src="../scripts/reproductor.js" defer></script>
    <link rel="stylesheet" href="../estilos.css">
    <title>Sonic Waves | Reproductor Web</title>
</head>
<body id="reproductor">
    <header class="p-3 d-flex flex-column align-items-start">
        <a class="w-75" href="../index.php">
            <img class="img-fluid" src="../media/assets/sonic-waves-logo-simple.png" alt="">
        </a>
        <ul>
            <li>
                <a id="home-link" href="">
                    <ion-icon name="home-outline"></ion-icon>
                    <span>Inicio</span>
                </a>
            </li>
        </ul>
    </header>
    <main id="main-content">
        <header>
            
        </header>
        <span class="loader d-none"></span>
        <button>Ver albumes</button>
    </main>
    <footer class="d-flex justify-content-center align-items-center" id="player">
        <audio src="../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - firth of fifth (official audio) (320 kbps).mp3" controls></audio>
    </footer>
</body>
</html>