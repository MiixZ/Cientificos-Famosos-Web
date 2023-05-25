<?php
    require_once "./vendor/autoload.php";
    include("bd.php"); // Controlador.

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    $username = "";
    $correo = "";

    session_start();

    if(isset($_POST['username']) && isset($_SESSION['registrado'])) {
        $nuevo_username = $_POST['username'];
        $nuevo_correo = $_POST['email'];
        $nueva_password = $_POST['password'];
        $antiguo_username = $_SESSION['username'];

        editarUsernameCorreoPassword($nuevo_username, $nuevo_correo, $nueva_password, $antiguo_username);
        $_SESSION['username'] = $nuevo_username;
        header("Location: index.php");
    }

    if(!isset($_SESSION['registrado'])) {
        $_SESSION['registrado'] = false;
        $_SESSION['username'] = "Anónimo";
    } else {
        // Hay que permitir que el usuario pueda cambiar su nombre de usuario y su correo.

        if($_SESSION['registrado']) {
            $username = $_SESSION['username'];
            $correo = getCorreo($username);
        }
    }

    echo $twig->render('editPerfil.html', ['correo' => $correo, 'username' => $username]);
?>