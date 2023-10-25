<?php 
//Incluimos el archivo php para generar el reporte por medio del metodo POST
include("reporte.php");
?>
<!--<Se procede a realizar la pagina se utilizaron los mismo estilos>--> 
<!DOCTYPE html>
<html>
<head>
    <!--Nombre y declaracion de estilos y entrada--> 
    <title>Resgistros CIDTES</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="\Olympia/styles/style.css">
</head>
<body>
<!--Boton para regresar a la pagina principal index--> 
<a class="btn-inicio" href="\Olympia\index.php">Inicio</a>

<form method="POST">
    <!--Se realiza la consulta por medio de los siguientes campos--> 
    <h1>Consulta</h1>
    <input type="text" name="curp" placeholder="CURP">
    <!--<input type="submit" name="register">-->    
    <input type="text" name="rfc"  placeholder="RFC">
    <p>Programa</p>
    <!--Una lista para la consulta por programa del servicio--> 
    <select id="service" name="service" class="LISTA">
        <option value="none">SIN SELECCION</option>
        <option value="2022-5/883-1088">2022-5/883-1088 Soporte en la plataforma digital para impartición de cursos de...</option>
        <option value="2022-5/883-1076">2022-5/883-1076 Desarrollo de Sistemas de Gestión y la metodología aplicada para...</option>
        <option value="2022-5/883-1077">2022-5/883-1077 Fortalecimiento en programas para el desarrollo de competencias...</option>
        <option value="2023-5/883-3235">2023-5/883-3235 Desarrollo de Sistemas de Gestión y la metodología aplicada para...</option>
        <option value="2023-5/883-3662">2023-5/883-3235 Fortalecimiento en programas para el desarrollo de...</option>
        <option value="2023-5/883-3543">2023-5/883-3543 Soporte en la plataforma digital para impartición de...</option>
    </select>
    <p></p>
    <button type="submit" name="consulta1" class="CONSULTA"> CONSULTAR </button>
</form>

<p></p>
<!--Segunda forma de consultas por las que se podra filtrar mas aun la informacion--> 
<form method="POST">
    <h1>Filtra tu Informacion</h1>
    <p>Universidad</p>
    <!--  Lista de seleccion de la universidad, se incluye una nueva seleccion debido a que puedo no ser seleccionada -->
    <!-- SIN SELECCION con valor none servira para no filtrar por este campo  -->  
    <select id="university" class="LISTA" name="university">
            <option value="none">SIN SELECCION</option>
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

    <p>Carrera</p>
    <select id="m" class="LISTA" name='major'>
        <!-- Las opciones se cargarán dinámicamente aquí -->
    </select>
    <!-- Script para seleccionar en caso de que se haga una seleccion en la anterior lista pues la carrera depende de la universidad --> 
    <script>
        // Obtén referencias a los Select
        const categoriaSelect = document.getElementById('university');
        const productoSelect = document.getElementById('m');

        // Define un objeto con opciones para cada categoría
        const opcionesPorCategoria = {
            "none": ['SIN SELECCION'],
            "0002": ['SIN SELECCION','ARTES VISUALES', 'DISEÑO Y COMUNICACION VISUAL'],
            "0006": ['SIN SELECCION','CONTADURIA', 'ADMINISTRACION'],
            "0007": ['SIN SELECCION','DERECHO'],
            "0011": ['SIN SELECCION','ING.COMPUTACION','ING.ELECTRICA Y ELECTRONICA','ING.INDUSTRIAL','ING.MECATRONICA'],
            "0019": ['SIN SELECCION','PSICOLOGIA'],
            "0407": ['SIN SELECCION','DERECHO'],
            "0410": ['SIN SELECCION','PEDAGOGIA'],
            "0411": ['SIN SELECCION','ING.COMPUTACION','ING.ELECTRICA Y ELECTRONICA','ING.INDUSTRIAL'],
            "091D":['SIN SELECCION','DERECHO','CONTADURIA','PEDAGOGIA','PSICOLOGIA','TECNOLOGIAS DE LA INFORMACION'],
            "09PB":['SIN SELECCION','DERECHO','PEDAGOGIA','PSICOLOGIA',],
            "09PS":['SIN SELECCION','DERECHO','CONTADURIA','PEDAGOGIA','ADMINISTRACION','PSICOLOGIA','CONTADURIA'],
            "09PU":['SIN SELECCION','DERECHO','CONTADURIA','PEDAGOGIA','ADMINISTRACION','PSICOLOGIA','CONTADURIA','DISEÑO DE ANIMACION DIGITAL'],
            "1183":['SIN SELECCION','ADMINISTRACION',],
            "15PS":['SIN SELECCION','PSICOLOGIA'],
            "4111":['SIN SELECCION','DERECHO','ING.INDUSTRIAL','PEDAGOGIA','ING.COMPUTACION'],
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

        <!-- Lista para seleccion y filtro por este campo tambien se agrega el none  --> 
    <p>Modalidad</p>

    <select class="LISTA" name="modality" >
        <option value="none">SIN SELECCION</option>
        <option value="EN LINEA">EN LINEA</option>
        <option value="PRESENCIAL">PRESENCIAL</option>
        <option value="HIBRIDO">HIBRIDO</option>
    </select>
        <!-- Lista para seleecion y filtro por este campo tambin se agrega el none --> 
    <p>Estado del servicio</p>
    <select class="LISTA" name="status" >
        <option value="none">SIN SELECCION</option>
        <option value="ACTIVO">ACTIVO</option>
        <option value="INACTIVO">INACTIVO</option>
        <option value="PENDIENTE">PENDIENTE</option>
    </select>
    <p></p>
    <button type="submit" name="consulta2" class="CONSULTA"> CONSULTAR </button>
</form>
</body>
</html>


