<?php
    require_once "./vendor/autoload.php";
    include("bd.php"); // Controlador.

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    $username = "";
    $correo = "";

    session_start();

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