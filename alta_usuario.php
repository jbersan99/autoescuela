<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Usuario</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/alta_usuario.css">
</head>

<body>
    <header>
        <h1> Alta Usuario</h1>
    </header>
    <main class="alta">
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="email"> Email <br>
                <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"><br>
            </label>
            <label for="nombre"> Nombre y Apellidos <br>
                <input type="text" name="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>"> <br>
            </label>
            <label for="password"> Contraseña <br>
                <input type="password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>"><br>
            </label>
            <label for="password_confirm"> Confirmar Contraseña <br>
                <input type="password" name="password_confirm" value="<?php echo isset($_POST['password_confirm']) ? htmlspecialchars($_POST['password_confirm']) : ''; ?>"><br>
            </label>
            <label for="nacimiento"> Fecha de Nacimiento <br>
                <input type="date" name="nacimiento" value="<?php echo isset($_POST['nacimiento']) ? htmlspecialchars($_POST['nacimiento']) : ''; ?>">
            </label>

            <section>Selecciona el rol:

                <input type="radio" id="rol_01" name="rol" value="Usuario" checked>
                <label for="rol_User">Usuario</label>

                <input type="radio" id="rol_01" name="rol" value="Profesor">
                <label for="rol_Prof">Profesor</label>
            </section>

            <label for="foto"> Selecciona la imagen de perfil: <br>
                <input type="file" class="form-control" id="image" name="image">
                <img id="imagenPrevisualizacion" width="175px"> <br>
                <script src="scripts/script.js"></script>
            </label>

            <input type="submit" value="Entrar" name="enviar">
        </form>
    </main>

    <footer>
        <hr>
        <p>Todos los derechos reservados</p>
        <p>Autoescuela Pepito</p>
        <a href="twitter.com">Twitter</a> <a href="facebook.com">Facebook</a> <a href="instagram.com">Instagram</a>
    </footer>
</body>

</html>

<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "entities/User.php";
require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enviar'])) {
        $v = new Validator();
        $v->Requerido('email');
        $v->Requerido('nombre');
        $v->Requerido('password');
        $v->Requerido('password_confirm');
        $v->Requerido('nacimiento');
        if (count($v->errores) > 0) {
            echo '<br><span class="error">' . $v->errores['email'] . '</span> ';
            echo '<span class="error">' . $v->errores['nombre'] . '</span> <br>';
            echo '<span class="error">' . $v->errores['password'] . '</span> ';
            echo '<span class="error">' . $v->errores['password_confirm'] . '</span> <br>';
            echo '<span class="error">' . $v->errores['nacimiento'] . '</span> ';
            if ($_FILES["image"]["size"] == 0) {
                echo '<span class="error">Introduce una imagen para continuar</span> <br>';
            }
        } else if ($_POST["password"] != $_POST["password_confirm"]) {
            echo '<span class="error">El campo de la contraseña y confirmar contraseña deben ser iguales</span> <br>';
        } else if ($_FILES["image"]["size"] == 0) {
            echo '<span class="error">Introduce una fotografía para continuar</span> <br>';
        } else if (!$v->EmailValido($_POST['email'])) {
            echo '<span class="error">Introduce un email que sea valido</span> <br>';
        } else if (!$v->FraseValida($_POST['nombre'])) {
            echo '<span class="error">Introduce un nombre que sea valido</span> <br>';
        } else {
            $email = $_POST['email'];
            $nombre = $_POST['nombre'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            $nacimiento = $_POST['nacimiento'];
            $rol = $_POST['rol'];
            $image = $_FILES['image']['tmp_name'];
            $imgContenido = file_get_contents($image);
            $imgContenido = base64_encode($imgContenido);
            $existe_email = DB::existsUser($email);
            if ($existe_email == "No existe") {
                $verifica = DB::insertUser($email, $nombre, $password, $nacimiento, $rol, $imgContenido, "no");
                $last_user = DB::getLastUser();
                if ($verifica) {
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    // cambiar a 0 para no ver mensajes de error
                    $mail->SMTPDebug  = 0;
                    $mail->SMTPAuth   = true;
                    $mail->SMTPSecure = "tls";
                    $mail->Host       = "smtp.gmail.com";
                    $mail->Port       = 587;
                    // introducir usuario de google
                    $mail->Username   = "jose.prueba.ftz@gmail.com";
                    // introducir clave
                    $mail->Password   = "jlftz99_";
                    $mail->SetFrom('jose.prueba.ftz@gmail.com', 'Test');
                    // asunto
                    $mail->Subject    = "Email Verificacion del Perfil";
                    // cuerpo
                    /* $path = 'pngegg.jpeg';
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    */

                    $mail->MsgHTML("<h1> Esto es una prueba </h1>
                    <a href='http://localhost/autoescuela/crear_password.php?id=$last_user'> Restablece tu contraseña </a>");
                    // adjuntos
                    /* $mail->AddEmbeddedImage('pngegg.jpeg', 'pngegg');
                    $mail->IsHTML(true);
                    $mail->Body = "<p><img src=\"cid:pngegg\" /></p><p>" . utf8_decode('' . "hola") . "</p>"; */
                    // destinatario
                    $address = "pepelubjxd@gmail.com";
                    $mail->AddAddress($address, "Email Verificación Perfil");
                    // enviar
                    $resul = $mail->Send();
                    if ($resul) {
                        echo "Enviado";
                    } else {
                        echo "No se pudo mandar el correo";
                    }
                } else {
                    echo '<span class="error">Hubo un fallo y no se pudó dar de alta</span> <br>';
                }
            } else {
                echo '<span class="error">El email introducido ya está registrado en la base de datos</span> <br>';
            }
        }
    }
}
?>