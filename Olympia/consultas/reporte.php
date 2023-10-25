<?php
require 'vendor/autoload.php';
require 'conexion.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
if (isset($_POST['consulta1'])){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificar si se ha enviado una solicitud POST
        if (isset($_POST['curp']) && strlen($_POST['curp']) != 0 && isset($_POST['rfc']) && strlen($_POST['rfc']) != 0 && $_POST['service']!="none" 
        || (($_POST['curp']) && strlen($_POST['curp']) != 0 && isset($_POST['rfc']) && strlen($_POST['rfc'])) 
        || (isset($_POST['rfc']) && strlen($_POST['rfc']) != 0 && $_POST['service']!="none") 
        || (isset($_POST['curp']) && strlen($_POST['curp']) != 0 && $_POST['service']!="none")  ){
            echo '<h3 class="bad">¡Selecciona o rellena solo uno de los campos!</h3>';
        }
        else if (isset($_POST['curp']) && strlen($_POST['curp']) != 0) {
            $curp = trim($_POST['curp']);
            $found="SELECT curp FROM servicio WHERE curp = '$curp'";
            $resultado = $mysqli->query($found);
            if ($resultado->num_rows > 0)
            {
                $curp = trim($_POST['curp']);
           
                $sql1 = "SELECT curp, nombre, padecimientos,nacimiento,medicamento,accion FROM info_personal WHERE curp = '$curp'";
                
                $sql2 = "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte FROM servicio
                INNER JOIN info_personal ON servicio.curp = info_personal.curp WHERE info_personal.curp = '$curp'" ;
        
                $sql3 = "SELECT info_escuela.universidad FROM info_escuela 
                INNER JOIN servicio ON info_escuela.clave_plan = servicio.clave_plan WHERE servicio.curp = '$curp'";
                
                $sql4 = "SELECT carreras.carrera FROM carreras 
                INNER JOIN servicio ON carreras.clave_car = servicio.clave_car WHERE servicio.curp = '$curp'";
               
                $sql5 = "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge FROM info_contacto 
                INNER JOIN info_personal ON info_contacto.curp = info_personal.curp WHERE info_personal.curp = '$curp'";

                $sql6= "SELECT programa_ss FROM programa 
                INNER JOIN servicio ON servicio.clave_ss = programa.clave_ss WHERE servicio.curp  = '$curp'";

                exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
            }
            else{
                echo '<h3 class="bad">¡La CURP no se ha encontrado!</h3>';
            }
        } else if(isset($_POST['rfc']) && strlen($_POST['rfc']) != 0) {
            $rfc = trim($_POST['rfc']);
            $found="SELECT rfc FROM servicio WHERE rfc = '$rfc'";
            $resultado = $mysqli->query($found);
            if ($resultado->num_rows > 0)
            {
            
            
                $sql1 = "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion FROM info_personal
                INNER JOIN servicio ON info_personal.curp = servicio.curp WHERE servicio.rfc = '$rfc'";
                
                $sql2 = "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,
                servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte FROM servicio
                WHERE servicio.rfc = '$rfc'" ;
        
                $sql3 = "SELECT info_escuela.universidad FROM info_escuela 
                INNER JOIN servicio ON info_escuela.clave_plan = servicio.clave_plan WHERE servicio.rfc = '$rfc'";
                
                $sql4 = "SELECT carreras.carrera FROM carreras 
                INNER JOIN servicio ON carreras.clave_car=servicio.clave_car WHERE servicio.rfc = '$rfc'";
               
                $sql5 = "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge 
                FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp WHERE servicio.rfc='$rfc'";

                $sql6 = "SELECT programa_ss FROM programa 
                INNER JOIN servicio ON servicio.clave_ss = programa.clave_ss WHERE servicio.rfc='$rfc'";
            
                exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                }else{
                    echo '<h3 class="bad">¡El RFC no se ha encontrado!</h3>';
                }
        } else if($_POST['service']!="none"){
                $service = trim($_POST['service']);
           
                $sql1 = "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion,servicio.reporte  FROM info_personal INNER JOIN servicio ON info_personal.curp = servicio.curp
                WHERE servicio.clave_ss = '$service'";
                
                $sql2 = "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss 
                FROM servicio WHERE servicio.clave_ss = '$service'" ;

                $sql3 = "SELECT info_escuela.universidad FROM info_escuela 
                INNER JOIN servicio ON info_escuela.clave_plan = servicio.clave_plan WHERE servicio.clave_ss = '$service'";
                
                $sql4 = "SELECT carreras.carrera FROM carreras 
                INNER JOIN servicio ON carreras.clave_car = servicio.clave_car WHERE servicio.clave_ss = '$service'";
               
                $sql5 = "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge FROM info_contacto 
                INNER JOIN servicio ON info_contacto.curp = servicio.curp INNER JOIN info_personal ON info_contacto.curp = info_personal.curp
                WHERE servicio.clave_ss = '$service'";

                $sql6= "SELECT programa.programa_ss FROM programa 
                WHERE programa.clave_ss = '$service'";

                exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
            }else  {
                // Manejar el caso en que 'curp' no se ha proporcionado
                echo '<h3 class="bad">¡Seleccione o llene uno de los  ampos CURP, RFC o Programa del Servicio!</h3>';
            }
            // Manejar el caso en que 'curp' no se ha proporcionado
            
        }

    } else if (isset($_POST['consulta2'])){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['university']=="none" && $_POST['status']=="none" && $_POST['modality']=="none") {
            $key_university =trim($_POST['university']);
            //FUNCION QUERY
            echo '<h3 class="bad">¡Selecciona al menos un campo!</h3>';
        }
        else{

            if($_POST['university']!="none" && $_POST['status']=="none" && $_POST['modality']=="none"){
               
                if ($_POST['major']=="none" || $_POST['major']=="SIN SELECCION" ){

                    $key_university =trim($_POST['university']);

                    $sql1= "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion
                    FROM info_personal INNER JOIN servicio ON info_personal.curp = servicio.curp WHERE servicio.clave_plan = '$key_university'";
                    $sql2= "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte 
                    FROM servicio WHERE clave_plan = '$key_university'";
                    $sql3= "SELECT info_escuela.universidad FROM info_escuela INNER JOIN servicio ON servicio.clave_plan = info_escuela.clave_plan  WHERE servicio.clave_plan = '$key_university'";
                    $sql4= " SELECT carreras.carrera FROM carreras INNER JOIN servicio ON carreras.clave_car=servicio.clave_car WHERE servicio.clave_plan = '$key_university'";
                    $sql5= "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge 
                    FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp WHERE servicio.clave_plan = '$key_university'";
                    $sql6=  "SELECT programa.programa_ss
                    FROM programa INNER JOIN servicio ON programa.clave_ss = servicio.clave_ss
                    WHERE servicio.clave_plan = '$key_university'";
                    exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                    //FUNCION QUERY
                }
                else{
                    $key_university =trim($_POST['university']);
                    $key_major=trim($_POST['major']);
                    $key_major=conversion($key_major);
                    
                    $sql1= "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos, info_personal.nacimiento, info_personal.medicamento, info_personal.accion
                    FROM info_personal
                    INNER JOIN servicio ON info_personal.curp = servicio.curp
                    WHERE servicio.clave_plan = '$key_university' AND servicio.clave_car = '$key_major'";
                    $sql2= "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte 
                    FROM servicio WHERE clave_plan = '$key_university' AND clave_car = '$key_major'";
                    $sql3= "SELECT info_escuela.universidad FROM info_escuela INNER JOIN servicio ON info_escuela.clave_plan = servicio.clave_plan WHERE servicio.clave_plan = '$key_university' AND servicio.clave_car = '$key_major'";
                    $sql4= " SELECT carreras.carrera FROM carreras INNER JOIN servicio ON carreras.clave_car=servicio.clave_car WHERE servicio.clave_plan = '$key_university' AND servicio.clave_car = '$key_major'";
                    $sql5= "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp 
                    WHERE servicio.clave_plan = '$key_university' AND servicio.clave_car = '$key_major'";
                    $sql6=  "SELECT programa.programa_ss FROM programa
                    INNER JOIN servicio ON programa.clave_ss = servicio.clave_ss
                    WHERE servicio.clave_plan = '$key_university'
                    AND servicio.clave_car = '$key_major'";
                    exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                    //FUNCION QUERY
                }
            }
            
            else if($_POST['status']!="none" && $_POST['university']=="none" && $_POST['modality']=="none"){

                $status = trim($_POST['status']);
                $sql1= "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion
                FROM info_personal
                INNER JOIN servicio ON info_personal.curp = servicio.curp
                WHERE servicio.estatus = '$status'";
                $sql2= "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte 
                FROM servicio WHERE estatus = '$status'";
                $sql3= "SELECT info_escuela.universidad FROM info_escuela INNER JOIN servicio ON servicio.clave_plan= info_escuela.clave_plan WHERE servicio.estatus = '$status'";
                $sql4= " SELECT carreras.carrera FROM carreras INNER JOIN servicio ON carreras.clave_car=servicio.clave_car WHERE servicio.estatus = '$status'";
                $sql5= "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge 
                FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp WHERE servicio.estatus='$status' ";
                
                $sql6= "SELECT programa.programa_ss
                FROM programa INNER JOIN servicio ON programa.clave_ss = servicio.clave_ss
                WHERE servicio.estatus = '$status'";
                exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                //FUNCION QUERY
            }
            
            else if($_POST['university']=="none" && $_POST['status']=="none" && $_POST['modality']!="none"){
                
                
                $modality = trim($_POST['modality']);
                $sql1= "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion
                FROM info_personal
                INNER JOIN servicio ON info_personal.curp = servicio.curp
                WHERE servicio.modalidad = '$modality'";
                $sql2= "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte 
                FROM servicio WHERE modalidad = '$modality'";
                $sql3= "SELECT info_escuela.universidad FROM info_escuela INNER JOIN servicio ON servicio.clave_plan= info_escuela.clave_plan  WHERE servicio.modalidad = '$modality'";
                $sql4= " SELECT carreras.carrera FROM carreras INNER JOIN servicio ON carreras.clave_car=servicio.clave_car WHERE servicio.modalidad = '$modality'";
                $sql5= "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge 
                FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp WHERE servicio.modalidad='$modality' ";
                $sql6= "SELECT programa.programa_ss
                FROM programa
                INNER JOIN servicio ON programa.clave_ss = servicio.clave_ss
                WHERE servicio.modalidad = '$modality'";

                exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                //FUNCION QUERY
            }

            else if($_POST['university']=="none" && $_POST['status']!="none" && $_POST['modality']!="none"){
                
                $status = trim($_POST['status']);
                $modality = trim($_POST['modality']);

                $sql1= "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion
                FROM info_personal
                INNER JOIN servicio ON info_personal.curp = servicio.curp
                WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status'";
                $sql2= "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte 
                FROM servicio  WHERE modalidad = '$modality' && estatus = '$status'";
                $sql3= "SELECT info_escuela.universidad FROM info_escuela INNER JOIN servicio ON servicio.clave_plan= info_escuela.clave_plan WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status'";
                $sql4= " SELECT carreras.carrera FROM carreras INNER JOIN servicio ON carreras.clave_car=servicio.clave_car WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status'";
                $sql5= "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge 
                FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status'";
                $sql6="SELECT programa.programa_ss
                FROM programa
                INNER JOIN servicio ON programa.clave_ss = servicio.clave_ss
                WHERE servicio.modalidad = '$modality'
                AND servicio.estatus = '$status'";
                exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                //FUNCION QUERY
            }

            else if($_POST['university']!="none" && $_POST['status']=="none" && $_POST['modality']!="none"){
                
                if ($_POST['major']=="none" || $_POST['major']=="SIN SELECCION" ){
                    $modality = trim($_POST['modality']);
                    $key_university =trim($_POST['university']);
                
                    $sql1= "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion
                    FROM info_personal INNER JOIN servicio ON info_personal.curp = servicio.curp 
                    WHERE servicio.modalidad = '$modality' && servicio.clave_plan = '$key_university'";
                    $sql2= "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte 
                    FROM servicio WHERE modalidad = '$modality' && clave_plan = '$key_university'";
                    $sql3= "SELECT info_escuela.universidad FROM info_escuela INNER JOIN servicio ON servicio.clave_plan= info_escuela.clave_plan WHERE servicio.modalidad = '$modality' && servicio.clave_plan = '$key_university'";
                    $sql4= " SELECT carreras.carrera FROM carreras INNER JOIN servicio ON carreras.clave_car=servicio.clave_car WHERE servicio.modalidad = '$modality' && servicio.clave_plan = '$key_university'";
                    $sql5= "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge 
                    FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp WHERE servicio.modalidad = '$modality' && servicio.clave_plan = '$key_university'";
                    $sql6="SELECT programa.programa_ss
                    FROM programa
                    INNER JOIN servicio ON programa.clave_ss = servicio.clave_ss
                    WHERE servicio.modalidad = '$modality'
                    AND servicio.clave_plan = '$key_university'";
            
                    exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                    //FUNCION QUERY
                }
                else{
                    $modality = trim($_POST['modality']);
                    $key_university =trim($_POST['university']);
                    $key_major=trim($_POST['major']);
                    $key_major=conversion($key_major);
                    
                    $sql1= "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion
                    FROM info_personal INNER JOIN servicio ON info_personal.curp = servicio.curp 
                    WHERE servicio.modalidad = '$modality' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql2= "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte 
                    FROM servicio WHERE modalidad = '$modality' && clave_plan = '$key_university' && clave_car = '$key_major'";
                    $sql3= "SELECT info_escuela.universidad FROM info_escuela INNER JOIN servicio ON info_escuela.clave_plan = servicio.clave_plan WHERE servicio.modalidad = '$modality' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql4= " SELECT carreras.carrera FROM carreras INNER JOIN servicio ON carreras.clave_car=servicio.clave_car WHERE servicio.modalidad = '$modality' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql5= "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp 
                    WHERE servicio.modalidad = '$modality' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql6= "SELECT programa.programa_ss
                    FROM programa
                    INNER JOIN servicio ON programa.clave_ss = servicio.clave_ss
                    WHERE servicio.modalidad = '$modality'
                    AND servicio.clave_plan = '$key_university'
                    AND servicio.clave_car = '$key_major'";

                    exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                    //FUNCION QUERY
                }
            }
            else if($_POST['university']!="none" && $_POST['status']!="none" && $_POST['modality']=="none"){
                
                if ($_POST['major']=="none" || $_POST['major']=="SIN SELECCION" ){
                    
                    $key_university =trim($_POST['university']);
                    $status = trim($_POST['status']);

                    $sql1= "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion
                    FROM info_personal INNER JOIN servicio ON info_personal.curp = servicio.curp 
                    WHERE servicio.estatus = '$status' && servicio.clave_plan = '$key_university'";
                    $sql2= "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte 
                    FROM servicio WHERE estatus = '$status' && clave_plan = '$key_university'";
                    $sql3= "SELECT info_escuela.universidad FROM info_escuela INNER JOIN servicio ON servicio.clave_plan= info_escuela.clave_plan WHERE servicio.modalidad = '$modality' && servicio.clave_plan = '$key_university'";
                    $sql4= " SELECT carreras.carrera FROM carreras INNER JOIN servicio ON carreras.clave_car=servicio.clave_car 
                    WHERE servicio.estatus = '$status' && servicio.clave_plan = '$key_university'";
                    $sql5= "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge 
                    FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp WHERE servicio.estatus = '$status' && servicio.clave_plan = '$key_university'";
                    $sql6="SELECT programa.programa_ss
                    FROM programa
                    INNER JOIN servicio ON programa.clave_ss = servicio.clave_ss
                    WHERE servicio.clave_plan = '$key_university'
                    AND servicio.estatus = '$status'";
                    exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                    //FUNCION QUERY
                }
                else{
                    
                    $key_university =trim($_POST['university']);
                    $status = trim($_POST['status']);
                    $key_major=trim($_POST['major']);
                    $key_major=conversion($key_major);

                
                    $sql1= "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion
                    FROM info_personal INNER JOIN servicio ON info_personal.curp = servicio.curp 
                    WHERE servicio.estatus = '$status' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql2= "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte 
                    FROM servicio WHERE estatus = '$status' && clave_plan = '$key_university' && clave_car = '$key_major'";
                    $sql3= "SELECT info_escuela.universidad FROM info_escuela INNER JOIN servicio ON info_escuela.clave_plan = servicio.clave_plan WHERE servicio.estatus = '$status' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql4= " SELECT carreras.carrera FROM carreras INNER JOIN servicio ON carreras.clave_car=servicio.clave_car WHERE servicio.estatus = '$status' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql5= "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp 
                    WHERE servicio.estatus = '$status' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql6= "SELECT programa.programa_ss
                    FROM programa
                    INNER JOIN servicio ON programa.clave_ss = servicio.clave_ss
                    WHERE servicio.clave_plan = '$key_university'
                    AND servicio.clave_car = '$key_major'
                    AND servicio.estatus = '$status'"; 
                    exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                    //FUNCION QUERY
                }
            }
            else if($_POST['university']!="none" && $_POST['status']!="none" && $_POST['modality']!="none"){
                if ($_POST['major']=="none" || $_POST['major']=="SIN SELECCION" ){
                   
                    $modality = trim($_POST['modality']);
                    $key_university =trim($_POST['university']);
                    $status = trim($_POST['status']);
                    
                    $sql1= "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion
                    FROM info_personal INNER JOIN servicio ON info_personal.curp = servicio.curp 
                    WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status' && servicio.clave_plan = '$key_university'";
                    $sql2= "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte 
                    FROM servicio WHERE servicio.modalidad = '$modality' && estatus = '$status' && clave_plan = '$key_university'";
                    $sql3= "SELECT info_escuela.universidad FROM info_escuela INNER JOIN servicio ON info_escuela.clave_plan = servicio.clave_plan WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status' && servicio.clave_plan = '$key_university'";
                    $sql4= " SELECT carreras.carrera FROM carreras INNER JOIN servicio ON carreras.clave_car=servicio.clave_car WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status' && servicio.clave_plan = '$key_university' ";
                    $sql5= "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp 
                    WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status' && servicio.clave_plan = '$key_university'";
                    $sql6="SELECT programa.programa_ss
                    FROM programa
                    INNER JOIN servicio ON programa.clave_ss = servicio.clave_ss
                    WHERE servicio.modalidad = '$modality'
                    AND servicio.estatus = '$status'
                    AND servicio.clave_plan = '$key_university'";
                    exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                    //FUNCION QUERY
                }
                else{
                    
                    $modality = trim($_POST['modality']);
                    $key_university =trim($_POST['university']);
                    $status = trim($_POST['status']);
                    $key_major=trim($_POST['major']);
                    $key_major=conversion($key_major); 

            
                    $sql1= "SELECT info_personal.curp, info_personal.nombre, info_personal.padecimientos,info_personal.nacimiento,info_personal.medicamento,info_personal.accion
                    FROM info_personal INNER JOIN servicio ON info_personal.curp = servicio.curp 
                    WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql2= "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte 
                    FROM servicio WHERE servicio.modalidad = '$modality' && estatus = '$status' && clave_plan = '$key_university' && clave_car = '$key_major'";
                    $sql3= "SELECT info_escuela.universidad FROM info_escuela INNER JOIN servicio ON info_escuela.clave_plan = servicio.clave_plan WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql4= " SELECT carreras.carrera FROM carreras INNER JOIN servicio ON carreras.clave_car=servicio.clave_car WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql5= "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge FROM info_contacto INNER JOIN servicio ON info_contacto.curp = servicio.curp 
                    WHERE servicio.modalidad = '$modality' && servicio.estatus = '$status' && servicio.clave_plan = '$key_university' && servicio.clave_car = '$key_major'";
                    $sql6="SELECT programa.programa_ss
                    FROM programa
                    INNER JOIN servicio ON programa.clave_ss = servicio.clave_ss
                    WHERE servicio.clave_plan = '$key_university'
                    AND servicio.clave_car = '$key_major'
                    AND servicio.estatus = '$status'
                    AND servicio.modalidad = '$modality'";
                    exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli);
                    //FUNCION QUERY
                }
            }
        }
    }
}


function conversion($key_major) {

    if ($key_major == 'TECNOLOGIAS DE LA INFORMACION')
		{
            return '043';
		}
		else if ($key_major == 'ING.ELECTRICA Y ELECTRONICA')
		{
			return '109';
		}
		else if ($key_major == 'ING.COMPUTACION')
		{
			return '110';
		}
		else if ($key_major == 'ING.INDUSTRIAL')
		{
			return '114';
		}
		else if ($key_major == 'ING.MECATRONICA')
		{
			return '124';
		}
        else if ($key_major == 'CIENCIAS DE DATOS')
		{
			return '138';
		}
		else if ($key_major == 'DISEÑO DE ANIMACION DIGITAL')
		{
			return '200';
		}
		else if ($key_major == 'PSICOLOGIA')
		{
			return '210';
		}
        else if ($key_major == 'NEUROCIENCIAS')
		{
			return '226';
		}
		else if ($key_major == 'ADMINISTRACION')
		{
			return '301';
		}
		else if ($key_major == 'CONTADURIA')
		{
			return '304';
		}
		else if ($key_major == 'DERECHO')
		{
			return '305';
		}
        else if ($key_major == 'COMUNICACION')
		{
			return '315';
		}
		else if ($key_major == 'ARTES VISUALES')
		{
			return '401';
		}
        else if ($key_major == 'DISEÑO GRAFICO')
		{
			return '406';
		}
		else if ($key_major == 'PEDAGOGIA')
		{
			return '421';
		}
		else if ($key_major == 'DISEÑO Y COMUNICACION VISUAL')
		{
			return '423';
		}
        else if ($key_major == 'ARTE Y DISEÑO')
		{
			return '434';
		}
		else if ($key_major == 'TECNOLOGIAS DE LA INFORMACION')
		{
			return '890';
		}
}   

function exportToExcel($sql1, $sql2, $sql3, $sql4, $sql5, $sql6,$mysqli ) {
    // Crear un nuevo objeto Spreadsheet
    $excel = new Spreadsheet();

    // Ejecutar las consultas SQL y obtener los resultados
    $resultado1 = $mysqli->query($sql1);
    $resultado2 = $mysqli->query($sql2);
    $resultado3 = $mysqli->query($sql3);
    $resultado4 = $mysqli->query($sql4);
    $resultado5 = $mysqli->query($sql5);
    $resultado6 = $mysqli->query($sql6);

    // Obtener la hoja activa
    $hojaActiva = $excel -> getActiveSheet();
    $hojaActiva -> setTitle("Datos");

    $hojaActiva -> getColumnDimension('A')-> setWidth(10);
    $hojaActiva -> setCellValue('A1','CURP');
    $hojaActiva -> getColumnDimension('B')-> setWidth(30);
    $hojaActiva -> setCellValue('B1','NOMBRE');
    $hojaActiva -> getColumnDimension('C')-> setWidth(10);
    $hojaActiva -> setCellValue('C1','RFC');




    $hojaActiva -> getColumnDimension('D')-> setWidth(10);
    $hojaActiva -> setCellValue('D1','CARRERA');
    $hojaActiva -> getColumnDimension('E')-> setWidth(10);
    $hojaActiva -> setCellValue('E1','UNIVERSIDAD');
    $hojaActiva -> getColumnDimension('F')-> setWidth(10);
    $hojaActiva -> setCellValue('F1','ESTADO');
    $hojaActiva -> getColumnDimension('G')-> setWidth(10);
    $hojaActiva -> setCellValue('G1','MODALIDAD');



    $hojaActiva -> getColumnDimension('H')-> setWidth(10);
    $hojaActiva -> setCellValue('H1','HORARIO');
    $hojaActiva -> getColumnDimension('I')-> setWidth(10);
    $hojaActiva -> setCellValue('I1','FECHA INICIO');
    $hojaActiva -> getColumnDimension('J')-> setWidth(10);
    $hojaActiva -> setCellValue('J1','FECHA FIN');
    


    $hojaActiva -> getColumnDimension('K')-> setWidth(10);
    $hojaActiva -> setCellValue('K1','PROGRAMA');
    $hojaActiva -> getColumnDimension('L')-> setWidth(10);
    $hojaActiva -> setCellValue('L1','NOMBRE DEL PROGRAMA SS');



    $hojaActiva -> getColumnDimension('M')-> setWidth(10);
    $hojaActiva -> setCellValue('M1','TIPO DE REPOERTE');
    $hojaActiva -> getColumnDimension('N')-> setWidth(10);
    $hojaActiva -> setCellValue('N1','PROMEDIO');
    $hojaActiva -> getColumnDimension('O')-> setWidth(10);
    $hojaActiva -> setCellValue('O1','CREDITOS');
    $hojaActiva -> getColumnDimension('P')-> setWidth(10);
    $hojaActiva -> setCellValue('P1','FECHA DE NACIMIENTO');


    $hojaActiva -> getColumnDimension('Q')-> setWidth(10);
    $hojaActiva -> setCellValue('Q1','DIRECCION');
    $hojaActiva -> getColumnDimension('R')-> setWidth(10);
    $hojaActiva -> setCellValue('R1','TELEFONO');
    $hojaActiva -> getColumnDimension('S')-> setWidth(10);
    $hojaActiva -> setCellValue('S1','CORREO');
    $hojaActiva -> getColumnDimension('T')-> setWidth(10);
    $hojaActiva -> setCellValue('T1','CONTACTO EMERGENCIA');
    


    $hojaActiva -> getColumnDimension('U')-> setWidth(10);
    $hojaActiva -> setCellValue('U1','PADECIMIENTOS');
    $hojaActiva -> getColumnDimension('V')-> setWidth(10);
    $hojaActiva -> setCellValue('V1','MEDICAMENTOS');
    $hojaActiva -> getColumnDimension('W')-> setWidth(10);
    $hojaActiva -> setCellValue('W1','ACCION');


    $fila =2;

    while($rows= $resultado1-> fetch_assoc())
    {
        $hojaActiva -> setCellValue('A'.$fila, $rows['curp']);
        $hojaActiva -> setCellValue('B'.$fila, $rows['nombre']);
        $hojaActiva -> setCellValue('U'.$fila, $rows['padecimientos']);
        $hojaActiva -> setCellValue('P'.$fila, $rows['nacimiento']);
        $hojaActiva -> setCellValue('V'.$fila, $rows['medicamento']);
        $hojaActiva -> setCellValue('W'.$fila, $rows['accion']);

        $fila++;
    }

    $fila =2;
    
    while($rows= $resultado2-> fetch_assoc())
    {
        $hojaActiva -> setCellValue('G'.$fila, $rows['modalidad']);
        $hojaActiva -> setCellValue('I'.$fila, $rows['fecha_inicio']);
        $hojaActiva -> setCellValue('J'.$fila, $rows['fecha_fin']);
        $hojaActiva -> setCellValue('H'.$fila, $rows['horario']);
        $hojaActiva -> setCellValue('F'.$fila, $rows['estatus']);
        $hojaActiva -> setCellValue('N'.$fila, $rows['promedio']);
        $hojaActiva -> setCellValue('O'.$fila, $rows['creditos']);
        $hojaActiva -> setCellValue('C'.$fila, $rows['rfc']);
        $hojaActiva -> setCellValue('K'.$fila, $rows['clave_ss']);
        $hojaActiva -> setCellValue('M'.$fila, $rows['reporte']);
        $fila++;
    }

    $fila =2;
    
    while($rows= $resultado6-> fetch_assoc())
    {
        $hojaActiva -> setCellValue('L'.$fila, $rows['programa_ss']);
        $fila++;
    }

    $fila =2;
    
    while($rows= $resultado3-> fetch_assoc())
    {
        $hojaActiva -> setCellValue('E'.$fila, $rows['universidad']);

        $fila++;
    }

    $fila =2;
    
    while($rows= $resultado4-> fetch_assoc())
    {
        $hojaActiva -> setCellValue('D'.$fila, $rows['carrera']);

        $fila++;
    }

    $fila =2;
    
    while($rows= $resultado5-> fetch_assoc())
    {
        $hojaActiva -> setCellValue('S'.$fila, $rows['correo']);
        $hojaActiva -> setCellValue('Q'.$fila, $rows['direccion']);
        $hojaActiva -> setCellValue('R'.$fila, $rows['telefono']);
        $hojaActiva -> setCellValue('T'.$fila, $rows['contacto_emerge']);
        $fila++;
    }


    
    ob_end_clean();

    // Configurar las cabeceras HTTP para la descarga del archivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="datos.xlsx"');
    header('Cache-Control: max-age=0');

    // Crear el escritor y guardar el archivo en la salida
    $writer = IOFactory::createWriter($excel, 'Xlsx');
    $writer->save('php://output');
    exit;
}


// Cerrar la conexión a la base de datos
$mysqli->close();   
?>
