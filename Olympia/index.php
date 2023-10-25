
<!-- Este codigo es el cuerpo principal de la pagina, se trabaja sobre el lenguaje PHP, el cual concluimos que seria perfecto para 
abordar el problema presentado en CIDTES sobre el registro de sus becarios del servicio social-->
<!-- El codigo php iniciara con  < ?php  codigo y terminara con ?> se coloco un espacio ya que son metacacteres lo correcto se observa
a continuacion -->

<?php 
    //Se incluye la libreria registros se hablara de ella en el arhivo correspondiente pues sera de utilidad para realizar 
    //los registros
    include("register/register.php"); 
?>  

<!-- Codigo HTML-->
<!DOCTYPE html>
<html>
<head>
    <!--Titulo de la pagina -->
	<title>Resgistros CIDTES</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles/style.css">z
</head>

<!-- Empiez el cuerpo de la pagina -->
<body>


<!-- Barra principal -->
<nav id="navbar">
       
	   <div><img id="logo" src="pictures/logo cidtes.png" alt="imagen del logo"></div> <!--Imagen de la empresa guardada en carpeta correspondiente -->
	   
	   <h2 id="title"> Registros SS CIDTES </h2> <!--Titulo formato h2 -->
	   <div id="bread">         <!--Se coloca un id para manejar el estilo en el archivo correspondiente -->
		   <ul class="breadcrumb">  <!-- Lista desordenada -->
			   <li><a href="consultas/consultas.php">Consultas</a></li> <!-- Elemento en la lista se trata deun URL hacia otra pagina se encuentra en este mismo proyecto-->
			   <li><a href="modificaciones/modificaciones.php">Modificaciones</a></li><!--Elemento en la lista se trata deun URL hacia otra pagina se encuentra en este mismo proyecto -->
			 </ul>
	   </div>

	
<div>
<!-- Se inicia con otra parte de la pagina por eso el div -->
</div>  
   </nav>
<!--  Etiqueta form con metodo de captura tipo POST-->
    <form method="post" >
        <!-- Se inicia con el cuerpo -->
		<p>(*) Campos Obligatorios</p> <!-- Parrafo -->
    	<h1>¡Informacion Personal!</h1> <!-- Titulo con formato h1 -->
        <!-- Las etiquetas tipo input recibiran datos se incluye un script capaz de covertir todo a mayusculas placeholder sera texto relacionado a la captura que s emostrara en el recuadro-->
		<input type="text" name="curp"  oninput="convertirAMayusculas(this)" placeholder="(*)CURP">
    	<input type="text" name="name" oninput="convertirAMayusculas(this)" placeholder="(*)Nombre Completo">
		<input type="text" name="medical_condition" oninput="convertirAMayusculas(this)" placeholder="Padecimientos">
        <input type="text" name="medicaments" oninput="convertirAMayusculas(this)" placeholder="Medicamentos">
        <p>Especificaciones de estado de salud</p> <!-- Nuevamente una etiqueta p solo para agregar texto en la pagina -->
        <input type="text" name="action" oninput="convertirAMayusculas(this)" placeholder="Accion a Tomar">
        <input type="text" name="rfc" oninput="convertirAMayusculas(this)" placeholder="RFC">
        <p>Fecha de nacimiento</p>
        <input type="date" name="birth" placeholder="Fecha de Nacimiento">
		<h1>¡Informacion de Contacto!</h1>
		<input type="email" name="email"  placeholder="(*)Email">
    	<input type="text" name="direction" oninput="convertirAMayusculas(this)" placeholder="Dirección Domicilio">
		<input type="text" name="phone_number" oninput="convertirAMayusculas(this)" placeholder="Numero Telefónico">
        <p>Contacto de Emergencia</p>
    	<input type="text" name="emergency" oninput="convertirAMayusculas(this)" placeholder="Parentesco-Numero telefonico">
	

		<h1>¡Trayectoria Escolar!</h1>

		<p>Universidad</p>
        <!-- etiqueta select sera para poder seleccionar de una casilla desplegable las siguientes opciones  -->
		<select id="university" class="LISTA" name="university">
			<!-- La etiqueta option sera maneja para la opcion value con cierto numero elegido arbitrariamente este funcionara para 
            utilizar de forma decuada y poder realizar las consultas desde la base de datos -->
            <option value="0002" >FACULTAD DE ARTES Y DISEÑO UNAM</option>
            <option value="0006" >FACULTAD DE CONTADURIA Y ADMINISTRACION UNAM</option>
            <option value="0007" >FACULTAD DE DERECHO UNAM</option>
            <option value="0011" >FACULTAD DE INGENIERIA UNAM</option>
            <option value="0019" >FACULTAD DE PSICOLOGIA UNAM</option>
            <option value="0407" >FES ARAGON (DERECHO)</option>
            <option value="0410" >FES ARAGON (FILOSOFIA)</option>
            <option value="0411" >FES ARAGON (INGENIERIA)</option>
            <option value="091D" >UNIVERSIDAD DE LONDRES</option>
            <option value="09PB" >UNIVERSIDAD CUGS</option>
            <option value="09PS" >UNIVERSIDAD DE NEGOCIOS ISEC</option>
            <option value="09PU" >UNIVERSIDAD SALESIANA</option>
            <option value="1183" >UNIVERSIDAD LATINA</option>
            <option value="15PS" >UNIVERSIDAD INSURGENTES</option>
            <option value="4111" >FES ARAGON (PEDAGOGIA)</option>

        </select>
        <!-- Como la carrera depende de la universidad se realizo una lista ligada a la anterior -->
        <p>Carrera</p>
        <select id="m" class="LISTA" name='major'>
			
            <!-- Las opciones se cargarán dinámicamente aquí -->
        </select>
        <!-- Comienzo del script -->
		<script>
        // Obtén referencias a los Select
        const categoriaSelect = document.getElementById('university');
        const productoSelect = document.getElementById('m');

        // Define un objeto con opciones para cada categoría
        const opcionesPorCategoria = {
            "0002": ['ARTES VISUALES', 'DISEÑO Y COMUNICACION VISUAL'],
            "0006": ['CONTADURIA', 'ADMINISTRACION'],
            "0007": ['DERECHO'],
            "0011": ['ING.COMPUTACION','ING.ELECTRICA Y ELECTRONICA','ING.INDUSTRIAL','ING.MECATRONICA'],
            "0019": ['PSICOLOGIA'],
            "0407": ['DERECHO'],
            "0410": ['PEDAGOGIA'],
            "0411": ['ING.COMPUTACION','ING.ELECTRICA Y ELECTRONICA','ING.INDUSTRIAL'],
            "091D":['DERECHO','CONTADURIA','PEDAGOGIA','PSICOLOGIA','TECNOLOGIAS DE LA INFORMACION'],
            "09PB":['DERECHO','PEDAGOGIA','PSICOLOGIA',],
            "09PS":['DERECHO','CONTADURIA','PEDAGOGIA','ADMINISTRACION','PSICOLOGIA','CONTADURIA'],
            "09PU":['DERECHO','CONTADURIA','PEDAGOGIA','ADMINISTRACION','PSICOLOGIA','CONTADURIA','DISEÑO DE ANIMACION DIGITAL'],
            "1183":['ADMINISTRACION',],
            "15PS":['PSICOLOGIA'],
            "4111":['DERECHO','ING.INDUSTRIAL','PEDAGOGIA','ING.COMPUTACION']
        };

        // Agrega un evento de cambio al Select de categoría
        categoriaSelect.addEventListener('change', () => {
            // Borra las opciones actuales en el Select de productos
            while (productoSelect.options.length > 0) {
                productoSelect.options.remove(0);
            }

            // Obtén las opciones para la categoría seleccionada
            const categoriaSeleccionada = categoriaSelect.value;
            const opciones = opcionesPorCategoria[categoriaSeleccionada];

            // Agrega las nuevas opciones al Select de productos
            opciones.forEach((opcion) => {
                const option = new Option(opcion, opcion);
                productoSelect.appendChild(option);
            });
        });

        // Inicialmente, carga las opciones para la categoría seleccionada
        categoriaSelect.dispatchEvent(new Event('change'));
    </script>
		<!-- Termina el script -->

		<input type="text" name="credit" oninput="convertirAMayusculas(this)" placeholder="Porcentaje de Creditos">
		<input type="text" name="average" oninput="convertirAMayusculas(this)" placeholder="Promedio">
		<h1>¡Informacion del Servicio!</h1>
        <p>Tipo de Reporte</p>
		<select class="LISTA" name="report">
            <option value="BIMESTRAL">BIMESTRAL</option>
            <option value="FINAL">FINAL</option>
        </select>
        <p>Programa de serivicio</p>
        <!-- Otra lista de eleccion en value se asigno el valor equivalente que manejan en la empresa CIDTES -->
		<select class="LISTA" name="service">
            <option value="2022-5/883-1088">2022-5/883-1088 Soporte en la plataforma digital para impartición de cursos de...</option>
            <option value="2022-5/883-1076">2022-5/883-1076 Desarrollo de Sistemas de Gestión y la metodología aplicada para...</option>
            <option value="2022-5/883-1077">2022-5/883-1077 Fortalecimiento en programas para el desarrollo de competencias...</option>
            <option value="2023-5/883-3235">2023-5/883-3235 Desarrollo de Sistemas de Gestión y la metodología aplicada para...</option>
            <option value="2023-5/883-3662">2023-5/883-3235 Fortalecimiento en programas para el desarrollo de...</option>
            <option value="2023-5/883-3543">2023-5/883-3543 Soporte en la plataforma digital para impartición de...</option>
        </select>

        
        <!-- Mas opciones de tipo lista presentes en el formulario -->
		<p>Modalidad</p>

        <select class="LISTA" name="modality" >
			
            <option value="EN LINEA">EN LINEA</option>
            <option value="PRESENCIAL">PRESENCIAL</option>
            <option value="HIBRIDO">HIBRIDO</option>
        </select>
        
		<p>Estado del servivicio</p>
        <select class="LISTA" name="status" >
            <option value="ACTIVO">ACTIVO</option>
            <option value="INACTIVO">INACTIVO</option>
            <option value="PENDIENTE">PENDIENTE</option>
        </select>

		<p>Fecha de Inicio</p>
		<input type="date" name="start_date" placeholder="Fecha de Inicio">
		<p>Fecha de Fin</p>
		<input type="date" name="end_date" placeholder="Fecha de Fin">
		<input type="text" name="schedule" oninput="convertirAMayusculas(this)" placeholder="Horario">
		<input type="submit" name="register">

    </form>
        <!-- Se termina la etiqueta form con el metodo post -->
<p></p>	
        <!-- Una vez llenado los datos este form servira para un boton que se encontrara en la misma pagina -->
	<form action="GeneratorExcel/reporte.php"> <!-- la accion de este forma consultara a el codigo denominado reporte.php -->
	<div>	
			<p>Descarga la totalidad de la información en la base de datos,</p><!-- Mensaje de lo que raliza el codigo -->
			<p>si requeire informacion especifica ir al apartado consultas.</p><!-- Mensaje continuacion -->
			<button class="btn" type="submit"> Descarga Excel</button><!-- Boton  -->
	</div>

    <!-- Script de las mayusculas -->
    <script>
        function convertirAMayusculas(input) {
            input.value = input.value.toUpperCase();
        }
    </script>
    <!-- Termina el script -->
    </form>
    <!-- termina la etiqueta form del boton -->
</body>
<!-- Termina el cuerpo -->
</html>
<!-- Termina la estrcutura HTML -->