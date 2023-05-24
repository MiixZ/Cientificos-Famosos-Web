<?php
    require_once "./vendor/autoload.php";

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();        // Los datos se guardan en $_SESSION. Por ejemplo $_SESSION['count'];
    
    echo $twig->render('index.html', []);
?>