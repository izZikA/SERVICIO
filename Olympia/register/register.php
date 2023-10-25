<?php 
//Codigo de registro ralizado en codigo de tipo php

include("conection/con_db.php"); //Se realiza la conexion por medio de un archivo php se explica su funcionamiento en el mismo

if  ($conex){
    echo "En linea"; //Si la conexion se lleva a cabo se muestra un mensaje En linea
}



if (isset($_POST['register'])) {//Si el metodo POST denominado register es TRUE se realiza lo siguiente
	$curp = trim($_POST['curp']); //Se toma el dato en el metodo post con el name, id o name curp y se resguarda en una variablle , se utiliza trim para devolcer la cadena limpia sin espacion o saltos de linea
		//En el siguiente if se comprueban campos obligatorios por lo que la cadena deberia ser mayor a cero, como se observan son los campos nombre,email,curp y universidad
		//Se esperaria que todo el formulario se llene en su totalidad
		if (strlen($_POST['name']) >= 1 && strlen($_POST['email']) >= 1 && strlen($_POST['curp'])== 18 &&  strlen($_POST['university'])) { 
		//Ahora la variable curp servira para asignar en una variable found un query, el cual se consulta por medio de la variable curp
		$found="SELECT curp FROM servicio WHERE curp = '$curp'";

        $resultado = $conex->query($found);//Se asigna el resultado y hace la peticion a la conexion
		
        if ($resultado->num_rows > 0) { //Si el resultado es correcto habra una cadena de longitud mayor a cero, si se cumple se mandara
			//Un mensaje de que la curp ya se encuentra registrada por lo que no sera posble el registro
			?> 
	    	<h3 class="bad">¡La CURP ya se encuentra registrada!</h3> 
           <?php
		}else{
		//Si no es asi las respuestas de nuestro formulario pasaran a guardarse en las variables a continuacion

		$curp = trim($_POST['curp']);
		$name = trim($_POST['name']);
		$key_ss = trim($_POST['service']);
		$medical_condition = trim($_POST['medical_condition']);
		$email = trim($_POST['email']);
		$direction = trim($_POST['direction']);
		$phone_number = trim($_POST['phone_number']);
		$emergency = trim($_POST['emergency']);
		$key_university = trim($_POST['university']);
		$key_major = trim($_POST['major']);
		$credit = trim($_POST['credit']);
		$average = trim($_POST['average']);
		$status = trim($_POST['status']);
		$modality = trim($_POST['modality']);
		$start_date = trim($_POST['start_date']);
		$end_date = trim($_POST['end_date']);
		$schedule = trim($_POST['schedule']);
		$rfc = trim($_POST['rfc']);
		$birth=trim($_POST['birth']);
		$medicaments = trim($_POST['medicaments']);
		$action = trim($_POST['action']);
		$report = trim($_POST['report']);
		
		//Llenar los casos deacuerdo a las carreras en las de las universidades que estam dadas de alta es to es debido a la arquitectura de nuestra base y como 
		// llevamos el problema se debe a que estas tablas seran estaticas y solo se llenaran manualmente por el personal de sistemas ademas de que se les asigan una llave
		// arbitraria es por eso que se hace la conversion deacuerdo a la llave

		if ($key_major == 'TECNOLOGIAS DE LA INFORMACION')
		{
			$key_major='043';
		}
		if ($key_major == 'ING.ELECTRICA Y ELECTRONICA')
		{
			$key_major='109';
		}
		if ($key_major == 'ING.COMPUTACION')
		{
			$key_major='110';
		}
		if ($key_major == 'ING.INDUSTRIAL')
		{
			$key_major='114';
		}
		if ($key_major == 'ING.MECATRONICA')
		{
			$key_major='124';
		}
		if ($key_major == 'DISEÑO DE ANIMACION DIGITAL')
		{
			$key_major='200';
		}
		if ($key_major == 'PSICOLOGIA')
		{
			$key_major='210';
		}
		if ($key_major == 'ADMINISTRACION')
		{
			$key_major='301';
		}
		if ($key_major == 'CONTADURIA')
		{
			$key_major='304';
		}
		if ($key_major == 'DERECHO')
		{
			$key_major='305';
		}
		if ($key_major == 'ARTES VISUALES')
		{
			$key_major='401';
		}
		if ($key_major == 'PEDAGOGIA')
		{
			$key_major='421';
		}
		if ($key_major == 'DISEÑO Y COMUNICACION VISUAL')
		{
			$key_major='423';
		}
		if ($key_major == 'TECNOLOGIAS DE LA INFORMACION')
		{
			$key_major='890';
		}

		// Se hara la insercion de la informacion por medio de querys, solo seran 3 tablas debido a la arquitectura de nuestra base de datos
	    $ingreso2 = "INSERT INTO info_personal(curp,nombre,padecimientos,nacimiento,medicamento,accion) VALUES ('$curp','$name','$medical_condition','$birth','$medicaments','$action')";
		$ingreso1 = "INSERT INTO servicio(curp,clave_plan,clave_car,modalidad,fecha_inicio, fecha_fin,horario,estatus, promedio,creditos,rfc,clave_ss,reporte) VALUES ('$curp','$key_university','$key_major','$modality','$start_date','$end_date','$schedule','$status','$average','$credit','$rfc','$key_ss','$report')";
		$ingreso3 = "INSERT INTO info_contacto(correo,direccion,telefono,contacto_emerge,curp) VALUES ('$email','$direction','$phone_number','$emergency','$curp')";

		//se asignas las variables resultados a el ingreso de los datos con la funcion mysqli_query que recibe la conexion y los ingresos de la infromacion 
	    $resultado1 = mysqli_query($conex,$ingreso2);
		$resultado2 = mysqli_query($conex,$ingreso1);
		$resultado3 = mysqli_query($conex,$ingreso3);

		// se verifica la expresiojn voleana de true en las variables anteriores por lo que se mandan mensajes en caso de logrado con exto o bien fallo
	    if ($resultado1 && $resultado2 && $resultado3) {
	    	?> 
	    	<h3 class="ok">¡Se ha registrado correctamente!</h3>
           <?php
	    } else {
	    	?> 
	    	<h3 class="bad">¡Ups ha ocurrido un error!</h3>
           <?php
	    }
		}
    }   else {
	    	?> 
	    	<h3 class="bad">¡Por favor complete los campos!</h3>
           <?php
    }
}

?>