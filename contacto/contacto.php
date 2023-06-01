<?php
    session_start();
    require_once "../php_functions/general.php";
    decodeCookie();
    closeSession($_POST);

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    
    if(isset($_POST["enviar"])){
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "holymustaine20@gmail.com";
        $mail->Password = "uprisingcydonia8C++";
        $mail->SMTPSecure= "tls";
        $mail->Port = 587;
        echo $_POST["nombre"];
        $mail->setFrom("holymustaine20@gmail.com", $_POST["nombre"]);
        $mail->addAddress("tomorrownknows@gmail.com");
        $mail->isHTML(true);
        $mail->Subject = "Solicitud de contacto";
        $body_content = "<h1>Duda de usuario</h1>";

        $mail->Body = $body_content;

        if($mail->send()){
            echo "Consulta enviada";
        }else{
            echo "No se ha podido enviar el correo debido a ".$mail->ErrorInfo;
        }
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../estilos.css">
    <script src="../scripts/index.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Sonic Waves | Contacto</title>
</head>
<body id="contacto">
<div class="bg-black contacto-responsive-container">
    <img class="img-menu-responsive" src="../media/assets/sonic-waves-logo-simple.png" alt="">
    <button class="button-menu-responsive">
        <div></div>
        <div></div>
        <div></div>
    </button>
</div>
  <?php
    printMainMenu();
  ?>
  <h1 class='text-center mt-4'>¿En qué podemos ayudarte?</h1>
  <section class="container-xl mt-4 mb-4">
    <form action="#" id="form-contacto" method="post">
        <div class="input-field d-flex flex-column mb-3">
            <div class="input-visuals d-flex justify-content-between">
                <label for="nombre">Nombre</label>
                <ion-icon name="person-outline"></ion-icon>
            </div>
            <input name="nombre" type="text" required>                        
        </div>
        <div class="input-field d-flex flex-column mb-3">
            <div class="input-visuals d-flex justify-content-between">
                <label for="correo">Correo</label>
                <ion-icon name="person-outline"></ion-icon>
            </div>
            <input name="correo" type="email" required>                        
        </div>
        <div class="input-field d-flex flex-column mb-3 gap-2">
            <div class="input-visuals d-flex justify-content-between">
                <label for="correo">Elige un motivo</label>
                <ion-icon name="person-outline"></ion-icon>
            </div>
            <select class="p-2" name="" id="select-motivo-contacto">
                <option value="">Petición de grupo denegada</option>
                <option value="">Petición de discográfica denegada</option>
                <option value="">Mi álbum ha sido desactivado</option>
                <option value="">Mi publicación ha sido eliminada</option>
                <option value="">Mi reseña ha sido eliminada</option>
                <option value="">Otro</option>
            </select>                       
        </div>
        <div class="input-field d-flex flex-column mb-3">
            <div class="input-visuals d-flex justify-content-between">
                <label for="correo">Cuéntanos más</label>
                <ion-icon name="person-outline"></ion-icon>
            </div>
            <textarea name="contenido" id="" cols="30" rows="10"></textarea>                  
        </div>
        <button type="submit" style='--clr:#0ce8e8' class='btn-danger-own w-100' name="enviar"><span>Enviar</span><i></i></button>
    </form>
  </section>
  <?php
    printFooter("..");
  ?>
</body>
</html>