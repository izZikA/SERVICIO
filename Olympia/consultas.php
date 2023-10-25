<!DOCTYPE html>
<html>
<head>
	<title>Consultas</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>

    <h2>CONSULTAS</h2>
    <li><a href="index.php">Inicio</a></li>

	<table class="table" background="pictures/fondot.jpg">
		<tr>

		<th>Correo</th>
		<th>Direccion</th>
		<th>Telefono</th>
		<th>Contacto de emergencia</th>		
		</tr>

		<?php
		include("conection/con_db.php");
		$sql="SELECT * from info_contacto";
		$resul=mysqli_query($conex,$sql);

		while($mostrar=mysqli_fetch_array($resul)){
			?>
		<tr>

		<td>><?php echo $mostrar['Correo'] ?></td>
		<td>><?php echo $mostrar['Direccion'] ?></td>
		<td>><?php echo $mostrar['Telefono'] ?></td>
		<td>><?php echo $mostrar['Contacto_Emerge'] ?></td>
		</tr>
<?php
}
?>

	</table>

</body>
</html>