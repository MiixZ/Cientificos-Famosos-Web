<?php
    require_once "./vendor/autoload.php";
    include("bd.php"); // Controlador.

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    if(isset($_SESSION['registrado']) && esSuperUser($_SESSION['username'])) {
        $usuarios = getUsuarios();
        $actual = $_SESSION['username'];

        if(isset($_GET['nombre']) && isset($_POST['opcion'])) {
            $opcion = $_POST['opcion'];
            $username = $_GET['nombre'];
            switch ($opcion) {
                case "opcion1" :
                    quitarTodosPermisos($username);
                    break;
                case "opcion2" :
                    quitarTodosPermisos($username);
                    hacerModder($username);
                    break;
                case "opcion3" :
                    quitarTodosPermisos($username);
                    hacerGestor($username);
                    break;
                case "opcion4" :
                    quitarTodosPermisos($username);
                    hacerSuperUser($username);
                    break;
                default:

                    break;
            }
        }
    } else {
        header("Location: index.php");
    }

    echo $twig->render('editarUsuarios.html', ['usuarios' => getUsuarios(),
                                                    'nombre_actual' => $actual]);
