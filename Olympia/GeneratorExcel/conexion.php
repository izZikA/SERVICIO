<?php
//Guardamos en una variable nuestra conexion, 
$mysqli = new mysqli("localhost","root","","servicio_social");
//En caso de que falle la conexion
if($mysqli -> connect_errno){
    echo 'Fallo en la conexion' . mysqli -> connect_error;
    die(); 
}

?>