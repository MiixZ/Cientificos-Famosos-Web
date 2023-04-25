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
                echo "<br />";
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
?>