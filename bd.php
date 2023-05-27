<?php
    $conexionRealizada = false;

    function conectarBD() {                 // Control para que no esté conectándose todo el rato.
        global $conexionRealizada;
        global $mysqli;

        if($conexionRealizada) {
            return;
        }
        
        $mysqli = new mysqli('database', 'isma', 'calvo', 'SIBW');
        
        $conexionRealizada = true;

        if($mysqli->connect_errno) {
            echo ("Fallo al conectar: " . $mysqli->connect_errno);
        }
    }

    function getCientifico($id) {
        conectarBD();
        global $mysqli;
    
        $stmt = $mysqli->prepare("SELECT id, nombre, fechas, ciudad, texto FROM cientifico WHERE id = ?");

        // Vincular el valor del parámetro
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        $stmt->execute();

        $res = $stmt->get_result();

        $cientifico = array('idc' => 'idc', 'nombre' => 'nombre', 'fechas' => 'fechas', 'ciudad' => 'ciudad', 'texto' => 'texto');
    
        if($res !== false) {
            if($res->num_rows > 0) {
                $row = $res->fetch_assoc();

                $cientifico = array('idc' => $row['id'], 'nombre' => $row['nombre'], 'fechas' => $row['fechas'], 'ciudad' => $row['ciudad'], 'texto' => $row['texto']);
                echo "<br />";
            }
        }

        return $cientifico;
    }

    function registrarComentario($autor, $idC, $fecha, $hora, $texto) {
        conectarBD();
        global $mysqli;

        $stmt = $mysqli->prepare("INSERT INTO comentario (id, autor, idCientifico, correo, hora, texto) VALUES (?, ?, ?, ?, ?, ?)");

        $id = rand(13, 1000000);
        // Vincular el valor del parámetro.
        $stmt->bind_param("isisss", $id, $autor, $idC, $fecha, $hora, $texto);

        $stmt->execute();

        return true;
    }

    function getComentarios() {
        conectarBD();
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM comentario");

        $stmt->execute();

        $res = $stmt->get_result();
        $comentarios = [];

        if($res !== false && $res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                $comentarios[] = $row;
            }
        }

        return $comentarios;
    }

    function getComentario($id) {
        conectarBD();
        global $mysqli;
    
        $stmt = $mysqli->prepare("SELECT autor, correo, hora, texto FROM comentario WHERE idCientifico=?");

        // Vincular el valor del parámetro
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        $stmt->execute();

        $res = $stmt->get_result();

        $comentario = array('autor' => 'autor', 'correo' => 'correo', 'hora' => 'hora', 'texto' => 'texto');
        $comentarios = array();

        if($res !== false) {
            if($res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    $comentario = array('autor' => $row['autor'], 'correo' => $row['correo'], 'hora' => $row['hora'], 'texto' => $row['texto']);
                    $comentarios[] = $comentario;
                }
            }
        }

        return $comentarios;
    }

    function getFotos($id) {
        conectarBD();
        global $mysqli;
    
        $stmt = $mysqli->prepare("SELECT ruta FROM fotos WHERE idCientifico=?");

        // Vincular el valor del parámetro
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        $stmt->execute();

        $res = $stmt->get_result();

        $foto = array('ruta' => './img/tesla.jepg');
        $fotos = array();

        if($res !== false) {
            if($res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    $foto = array('ruta' => $row['ruta']);
                    $fotos[] = $foto;
                }
                echo "<br />";
            }
        }

        return $fotos;
    }

    function getPalabras() {
        conectarBD();
        global $mysqli;
    
        $res = $mysqli->query("SELECT palabrota FROM palabras");

        $palabras = array();

        if ($res !== false) {
            if ($res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    $palabras [] = array($row['palabrota']);
                }
                echo "<br />";
            }
        }

        return $palabras;
    }

    function comprobarUsuario($username, $password) {
        conectarBD();
        global $mysqli;
        $es_correcto = false;

        $stmt = $mysqli->prepare("SELECT nombre_usuario, password FROM usuario WHERE nombre_usuario = ? AND password = ?");

        // Vincular el valor del parámetro.
        $stmt->bind_param("ss", $username, $password);

        // Ejecutar la consulta.
        $stmt->execute();

        $res = $stmt->get_result();

        if($res !== false) {
            if($res->num_rows !== false && $res->num_rows > 0) {
                $es_correcto = true;
            }
        }

        return $es_correcto;
    }

    function editarUsernameCorreoPassword($username, $correo, $password, $antiguo_username) {
        conectarBD();
        global $mysqli;
        $ha_editado = false;

        $stmt = $mysqli->prepare("UPDATE usuario SET nombre_usuario = ?, correo = ?, password =? WHERE nombre_usuario = ?");

        // Vincular el valor del parámetro.
        $stmt->bind_param("ssss", $username, $correo, $password, $antiguo_username);

        // Ejecutar la consulta.
        $stmt->execute();

        $ha_editado = true;

        return $ha_editado;
    }

    function getCorreo($username) {
        conectarBD();
        global $mysqli;
        $correo = "";

        $stmt = $mysqli->prepare("SELECT correo FROM usuario WHERE nombre_usuario = ?");

        // Vincular el valor del parámetro.
        $stmt->bind_param("s", $username);

        // Ejecutar la consulta.
        $stmt->execute();

        $res = $stmt->get_result();

        if($res !== false) {
            if($res->num_rows !== false && $res->num_rows > 0) {
                $row = $res->fetch_assoc();
                $correo = $row['correo'];
            }
        }

        return $correo;
    }

    function registrarUsuario($username, $password, $correo) {
        conectarBD();
        global $mysqli;
        $ha_registrado = false;

        if(comprobarUsuario($username, $password)) {
            return $ha_registrado;
        }

        $stmt = $mysqli->prepare("INSERT INTO usuario (nombre_usuario, password, correo, moderador, gestor, superuser) VALUES (?, ?, ?, 0, 0, 0)");

        // Vincular el valor del parámetro.
        $stmt->bind_param("sss", $username, $password, $correo);

        // Ejecutar la consulta.
        $stmt->execute();

        $ha_registrado = true;

        return $ha_registrado;
    }

    function esModder($username) {
        conectarBD();
        global $mysqli;
        $es_modder = false;

        $stmt = $mysqli->prepare("SELECT moderador FROM usuario WHERE nombre_usuario = ?");

        // Vincular el valor del parámetro.
        $stmt->bind_param("s", $username);

        // Ejecutar la consulta.
        $stmt->execute();

        $res = $stmt->get_result();

        if($res !== false) {
            if($res->num_rows !== false && $res->num_rows > 0) {
                $row = $res->fetch_assoc();
                $es_modder = $row['moderador'];
            }
        }

        return $es_modder;
    }
?>