<?php
    require_once "./vendor/autoload.php";
    include("bd.php"); // Controlador.

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    $error = "";

    if(isset($_POST["usernameRegistro"])) {
        $username = $_POST["usernameRegistro"];
        $password = $_POST["passwordRegistro"];
        $correo = $_POST["mailRegistro"];

        if(!registrarUsuario($username, $password, $correo)) {
            $error = "El usuario ya existe.";
        } else {
            header("Location: index.php");
        }
    }

    echo $twig->render('login.html', ['error' => $error]);
?>