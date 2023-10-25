<?php

    ob_start(); //Se habre el buffer
    require 'vendor/autoload.php'; //Se manda a llamar la libreria autoload.php, aqui utilizamos librerias de internet
    //por lo que descargamos composer ademas de los cripts para trabajar con la generacion de archivos excel de manera correcta
    require 'conexion.php'; //De igual manera verificamos la conexion con la base de datos

    use PhpOffice\PhpSpreadsheet\Spreadsheet; //Uso de librerias descargadas
    use PhpOffice\PhpSpreadsheet\IOFactory; //Uso de librerias descargadas
    // Realizamo los query correspondiente deacuerdo a la arquitectura de nuestra base de datos, un total de hasta 6 querys el total de las tablas
    $sql1 = "SELECT curp,nombre,padecimientos,nacimiento,medicamento,accion FROM info_personal";
    
    $sql2 = "SELECT servicio.modalidad,servicio.fecha_inicio,servicio.fecha_fin,servicio.horario,servicio.estatus,servicio.promedio,servicio.creditos,servicio.rfc,servicio.clave_ss,servicio.reporte FROM servicio
    INNER JOIN info_personal ON servicio.curp = info_personal.curp";

    $sql3 = "SELECT programa_ss FROM programa INNER JOIN servicio ON servicio.clave_ss=programa.clave_ss";
    
    $sql4 = "SELECT info_escuela.universidad FROM info_escuela 
    INNER JOIN servicio ON info_escuela.clave_plan = servicio.clave_plan ORDER BY servicio.curp";
    
    $sql5 = "SELECT carreras.carrera FROM carreras 
    INNER JOIN servicio ON carreras.clave_car = servicio.clave_car ORDER BY servicio.curp";

    $sql6 = "SELECT info_contacto.correo,info_contacto.direccion,info_contacto.telefono,info_contacto.contacto_emerge FROM info_contacto 
    INNER JOIN info_personal ON info_contacto.curp = info_personal.curp";
   
    //Como se observa los querys anteriores se asignana a variables


    $excel = new Spreadsheet();  //Funcion proveniente de la libreria que crea un nuevo archivo de excel


    //Se realiza la peticion de la informacion con los querys y se asigna a variables denominadas resultado
    $resultado1 = $mysqli-> query($sql1);
    $resultado2 = $mysqli-> query($sql2);
    $resultado3 = $mysqli-> query($sql3);
    $resultado4 = $mysqli-> query($sql4);
    $resultado5 = $mysqli-> query($sql5);
    $resultado6 = $mysqli-> query($sql6);


    //Se crea una nueva hoja de excel
    $hojaActiva = $excel -> getActiveSheet();
    //Se denomina a 
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
        $hojaActiva -> setCellValue('P'.$fila, $rows['nacimiento']);
        $hojaActiva -> setCellValue('U'.$fila, $rows['padecimientos']);
        $hojaActiva -> setCellValue('W'.$fila, $rows['accion']);
        $hojaActiva -> setCellValue('V'.$fila, $rows['medicamento']);
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
    
    while($rows= $resultado3-> fetch_assoc())
    {
        $hojaActiva -> setCellValue('L'.$fila, $rows['programa_ss']);
        $fila++;
    }

    $fila =2;
    
    while($rows= $resultado4-> fetch_assoc())
    {
        $hojaActiva -> setCellValue('E'.$fila, $rows['universidad']);
        $fila++;
    }

    $fila =2;
    
    while($rows= $resultado5-> fetch_assoc())
    {
        $hojaActiva -> setCellValue('D'.$fila, $rows['carrera']);

        $fila++;
    }

    $fila =2;
    
    while($rows= $resultado6-> fetch_assoc())
    {
        $hojaActiva -> setCellValue('S'.$fila, $rows['correo']);
        $hojaActiva -> setCellValue('Q'.$fila, $rows['direccion']);
        $hojaActiva -> setCellValue('R'.$fila, $rows['telefono']);
        $hojaActiva -> setCellValue('T'.$fila, $rows['contacto_emerge']);
        $fila++;
    }

    ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="datos.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($excel, 'Xlsx');
    $writer->save('php://output');
    exit;
 ?>