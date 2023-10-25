<?php
$mysqli = new mysqli("localhost","root","","servicio_social");

if($mysqli -> connect_errno){
    echo 'Fallo en la conexion' . mysqli -> connect_error;
    die(); 
}

?>