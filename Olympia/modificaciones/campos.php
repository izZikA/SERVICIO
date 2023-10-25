<?php

require 'conexion.php';
if (isset($_POST['eliminacion'])){

        if(isset($_POST['curp']) && strlen($_POST['curp']) != 0) {
            $curp = trim($_POST['curp']);
            $found="SELECT curp FROM servicio WHERE curp = '$curp'";
            $resultado = $mysqli->query($found);
        if ($resultado->num_rows > 0)
            {
                echo '<h3 class="ok">¡La CURP no se ha encontrado!</h3>';
            }
            else{
                echo '<h3 class="bad">¡La CURP no se ha encontrado!</h3>';
            }
    }
}
// Cerrar la conexión a la base de datos
$mysqli->close();   
?>
