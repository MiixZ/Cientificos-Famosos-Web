<?php
    require_once "./vendor/autoload.php";
    include("bd.php"); // Controlador.

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    /*if(isset($_GET['id'])) {
        $id_cientifico = $_GET['id'];
    }
    else {
        $id_cientifico = -1;
    }*/

    if(isset($_GET['id'])) {
        $id_cientifico = $_GET['id'];
        if (!is_numeric($id_cientifico)) {
            $id_cientifico = -1;
        } 
    } else {
        $id_cientifico = -1;
    }
    
    $cientifico = getCientifico($id_cientifico);

    $comentariosCientifico = getComentario($id_cientifico);

    $fotosCientifico = getFotos($id_cientifico);

    $palabras_censuradas = getPalabras();

    echo $twig->render('cientifico.html', ['cientifico' => $cientifico,
                       'comentariosCientifico' => $comentariosCientifico,
                       'fotosCientifico' => $fotosCientifico,
                       'palabras_censuradas' => $palabras_censuradas]);
?>