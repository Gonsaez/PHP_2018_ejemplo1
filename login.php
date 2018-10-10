<?php

session_start();

include ('misFunciones.php');

function limpiaPalabra($palabra) {
    $palabra = trim($palabra, "'");
    $palabra = trim($palabra, " ");
    $palabra = trim($palabra, "-");
    $palabra = trim($palabra, "`");
    $palabra = trim($palabra, '"');
    return $palabra;
}

$mysqli = conectaBBDD();
$cajaNombre = $_POST['cajaNombre'];

$cajaPassword = $_POST['cajaPassword'];

//Filtro muy básico para evitar la inyección de SQL
$cajaNombre = limpiaPalabra($_POST['cajaNombre']);
$cajaPassword = limpiaPalabra($_POST['cajaPassword']);

//echo 'Has escrito el usuario: '.$cajaNombre.' y la contraseña: '.$cajaPassword; 

$resultadoQuery = $mysqli->query("SELECT * FROM usuarios WHERE nombreUsuario = '$cajaNombre'AND userPass = '$cajaPassword'");

$numUsuarios = $resultadoQuery->num_rows;

if ($numUsuarios > 0) {
    $r = $resultadoQuery -> fetch_array();
    //en la variable de sesion "nombreUsuario" guardo el nombre de usuario
    $_SESSION['nombreUsuario'] = $cajaNombre;
    //en la variable de sesion idUsuario guardo el id de usuario leido de la BBDD
    $_SESSION['idUsuario'] = $r['idUsuario'];
    //muestro la pantalla de la aplicación
    require 'aplicacion.php';
} else {
    //muestro una pantalla de error
    require 'error.php';
}

