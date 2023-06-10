<?php
    require_once "./vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();        // Los datos se guardan en $_SESSION. Por ejemplo $_SESSION['count'];

    if (isset($_POST['busqueda'])) {
        $nombrecientifico = $_POST['busqueda'];

        if (esGestor($_SESSION['username'])) {
            $idc = getIdCientificoByNombre($nombrecientifico);
        } else {
            $idc = getIdCientificoByNombreSiPublicado($nombrecientifico);
        }

        if(is_numeric($idc) && $idc != -1) {
            header("Location: cientifico.php?id=".$idc);
        } else {
            header("Location: index.php");
        }
    }

    if (!isset($_SESSION['registrado']) || !isset($_SESSION['username'])) {
        $_SESSION['registrado'] = false;
        $_SESSION['username'] = "Anónimo";
        $_SESSION['correo'] = "";
    }

    if (esGestor($_SESSION['username'])) {
        $cientificos = getCientificos();
    } else {
        $cientificos = getCientificosPublicados();
    }

    echo $twig->render('index.html', ['registrado' => $_SESSION['registrado'], 'username' => $_SESSION['username'],
                                            'modder' => esModder($_SESSION['username']), 'cientificos' => $cientificos,
                                            'gestor' => esGestor($_SESSION['username']), 'correo' => $_SESSION['correo'],
                                            'superuser' => esSuperuser($_SESSION['username'])]);
?>