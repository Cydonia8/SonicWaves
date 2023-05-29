<?php
  session_start();
  require_once "php_functions/general.php";
  require_once "square_image_creator/create_square_image.php";
  decodeCookie();
  closeSession($_POST, "index");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="estilos.css">
    <script src="scripts/index.js" defer></script>
    <link rel="icon" type="image/png" href="media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Sonic Waves</title>
</head>
<body>
  <img class="img-menu-responsive" src="media/assets/sonic-waves-logo-simple.png" alt="">
  <button class="button-menu-responsive">
    <div></div>
    <div></div>
    <div></div>
  </button>
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
      <div class="container-xxl mx-auto">
        <h2 class="text-center text-white">
          Algunas de las canciones que podrás encontrar
        </h2>
        <div class="d-flex container-samples-index gap-5 flex-column flex-md-row">
        <?php
          $con = new mysqli('localhost', 'root', '', 'sonicwaves');
          $consulta = $con->query("select c.titulo titulo, g.nombre grup, archivo, a.foto portada from cancion c, album a, grupo g, incluye i where a.grupo = g.id and i.album = a.id and i.cancion = c.id and a.activo = 1 order by rand() limit 3");
          $cont = 1;
          while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
            $titulo = $fila["titulo"];
            $audio = $fila["archivo"];
            $foto = $fila["portada"];
            $foto = imageIndex($foto);
            $audio = imageIndex($audio);
            $artista = $fila["grup"];
            
            echo "<div class=\"cancion-prev d-flex align-items-center flex-column gap-3 justify-content-between\">
                    <div class=\"text-center d-flex flex-column gap-3\">
                      <img class=\"rounded img-fluid\" src=\"$foto\">
                      <h2>$titulo</h2>
                      <h3>$artista</h3>
                      
                    </div>
                      
                      <ion-icon data-audio='play-audio$cont' name=\"play-circle-outline\" class='play-simbol mx-auto'></ion-icon>
                      <div class='position-relative w-75 timebar-container'>
                        
                        <div class='bar2 play-audio$cont'></div>                  
                      </div>
                      
                      <audio data-audio='play-audio$cont' src=\"$audio\" class='audio-index'></audio>
                    
                </div>";
            $cont++;
          }
          
        ?>
        </div>
      </div>
      
    </main>
    	<!-- footer section start -->
      <?php
        printFooter();
      ?>
		<!-- <footer id="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-3">
						<a href="index.html"><img src="media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png" alt="" class="img-fluid logo-footer"></a>
                      <div class="footer-about">
                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,  </p>
                      </div>

					</div>
					<div class="col-md-3">
						<div class="useful-link">
							<h2>Useful Links</h2>
							<img src="./assets/images/about/home_line.png" alt="" class="img-fluid">
							<div class="use-links">
								<li><a href="index.html"><i class="fa-solid fa-angles-right"></i> Home</a></li>
								<li><a href="about.html"><i class="fa-solid fa-angles-right"></i> About Us</a></li>
								<li><a href="gallery.html"><i class="fa-solid fa-angles-right"></i> Gallery</a></li>
								<li><a href="contact.html"><i class="fa-solid fa-angles-right"></i> Contact</a></li>
							</div>
						</div>

					</div>
                    <div class="col-md-3">
                        <div class="social-links">
							<h2>Follow Us</h2>
							<img src="./assets/images/about/home_line.png" alt="">
							<div class="social-icons">
								<li><a href=""><i class="fa-brands fa-facebook-f"></i> Facebook</a></li>
								<li><a href=""><i class="fa-brands fa-instagram"></i> Instagram</a></li>
								<li><a href=""><i class="fa-brands fa-linkedin-in"></i> Linkedin</a></li>
							</div>
						</div>
                    

                    </div>
					<div class="col-md-3">
						<div class="address">
							<h2>Address</h2>
							<img src="./assets/images/about/home_line.png" alt="" class="img-fluid">
							<div class="address-links">
								<li class="address1"><i class="fa-solid fa-location-dot"></i> Kolathur ramankulam-
									Malappuram Dt 
								   Kerala 679338</li>
								   <li><a href=""><i class="fa-solid fa-phone"></i> +91 90904500112</a></li>
								   <li><a href=""><i class="fa-solid fa-envelope"></i> mail@1234567.com</a></li>
							</div>
						</div>
					</div>
                  
				</div>
			</div>

		</footer> -->
		<!-- footer section end -->
		<!-- footer copy right section start -->
		<!-- footer copy right section end -->
</body>
</html>
