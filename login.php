<?php
    require_once "./vendor/autoload.php";
    include("bd.php"); // Controlador.

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    $error = "";
    session_start();

    if(isset($_POST["usernameRegistro"])) {
        $username = $_POST["usernameRegistro"];
        $password = $_POST["passwordRegistro"];
        $correo = $_POST["mailRegistro"];

        if(!registrarUsuario($username, $password, $correo)) {
            $error = "El usuario ya existe.";
        } else {
            $error = "Usuario registrado correctamente, puedes iniciar sesión.";
        }
    } else if(isset($_POST["username"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if(!comprobarUsuario($username, $password)) {
            $error = "El usuario no existe o la contraseña es incorrecta.";
        } else {
            $_SESSION['username'] = $username;
            $_SESSION['registrado'] = true;
            header("Location: index.php");
        }
    }

    echo $twig->render('login.html', ['error' => $error]);
?>