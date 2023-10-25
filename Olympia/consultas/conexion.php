<?php
//Se guarda la conexion en una variable con sus variables correspondientes
$mysqli = new mysqli("localhost","root","","servicio_social");
//En caso de que la conexion falle
if($mysqli -> connect_errno){
    echo 'Fallo en la conexion' . mysqli -> connect_error;
    die(); 
}

?>