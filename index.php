<?php
  session_start();
  require_once "php_functions/general.php";
  require_once "square_image_creator/create_square_image.php";
  closeSession($_POST, "index");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="scripts/index.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="estilos.css">
    <link rel="icon" type="image/png" href="media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Sonic Waves</title>
</head>
<body>
  <?php
    printMainMenu("index");
  ?>
    <!-- <header class="header-index">
        <img src="media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png" alt="">
        <nav>
            <ul>
                <a href=""><li>Nosotros</li></a>
                <a href=""><li>Reproductor</li></a>
                <a href="login/login.php"><li>Iniciar sesión</li></a>
            </ul>
        </nav>
    </header> -->
    <div class="banner-intro">
        <div id="carouselExample" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-pause="false">
            <div class="carousel-inner">
              <div class="carousel-item active first" data-bs-interval="3500" >
                <div class="w-50 mx-auto d-flex flex-column align-items-center">
                  <h2>Para grupos</h2>
                </div>
              </div>
              <div class="carousel-item second" data-bs-interval="3500" data-pause="false">
                <div class="w-50 mx-auto d-flex flex-column align-items-center">
                  <h2>Para ti</h2>
                </div>
              </div>
            </div>
            <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button> -->
          </div>
    </div>
    <main>
      <div class="container-xl mx-auto">
        <h2 class="text-center text-white">
          Algunas de las canciones que podrás encontrar
        </h2>
        <div class="d-flex container-samples-index gap-5 align-items-center">
        <?php
          $con = new mysqli('localhost', 'root', '', 'sonicwaves');
          $consulta = $con->query("select c.titulo titulo, g.nombre grup, archivo, a.foto portada from cancion c, album a, grupo g, incluye i where a.grupo = g.id and i.album = a.id and i.cancion = c.id order by rand() limit 3");
          while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            $titulo = $fila["titulo"];
            $audio = $fila["archivo"];
            $foto = $fila["portada"];
            $foto = imageIndex($foto);
            $artista = $fila["grup"];
            echo "<div class=\"cancion-prev d-flex align-items-center justify-content-center flex-column gap-5\">
                    <div class=\"d-flex flex-column align-items-center gap-3\">
                      <img class=\"rounded img-fluid\" src=\"$foto\">
                      <h2>$titulo</h2>
                      <h3>$artista</h3>
                    </div>
                    <div class=\"\">
                      <audio src=\"$audio\" controls></audio>
                    </div>
                </div>";
          }
          
        ?>
        </div>
      </div>
    </main>
</body>
</html>