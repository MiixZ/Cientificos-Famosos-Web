<?php
    require_once "./vendor/autoload.php";

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();        // Los datos se guardan en $_SESSION. Por ejemplo $_SESSION['count'];

    if(!isset($_SESSION['registrado'])) {
        $_SESSION['registrado'] = false;
    }

    if(!isset($_SESSION['username'])) {
        $_SESSION['username'] = "Anónimo";
    }

    echo $twig->render('index.html', []);
?>