<?php

include_once("empresa.php");
include_once("viaje.php");
include_once("pasajero.php");
include_once("responsable.php");
include_once("validar.php");


$validar = new validar();
//valores anteriores
$empresa = new empresa();
$viaje = new viaje();
$responsable = new responsable();
$pasajero = new pasajero();

do{
    echo "\n"."-------EMPRESA DE VIAJES-------"."\n";
    echo "1- Empresas"."\n";
    echo "2- Viajes."."\n";
    echo "3- Pasajero."."\n";
    echo "4- Responsable."."\n";
    echo "5- Salir."."\n";
    echo "Ingrese el numero de su eleccion: ";
    $opcion = trim(fgets(STDIN));

    while ( !is_numeric($opcion) || !($opcion >= 1 && $opcion <= 5)){
        echo "Ingrese solamente una de las opciones disponibles:";
        $opcion = trim(fgets(STDIN));
    }

    switch($opcion){

        case 1:
            do{
                echo "\n"."------MODIFICAR DATOS DE EMPRESA------"."\n";
                echo "1- Ingresar una empresa a la base de datos."."\n";
                echo "2- Eliminar una empresa de la base de datos."."\n";
                echo "3- Actualizar datos de una empresa."."\n";
                echo "4- buscar una empresa."."\n";
                echo "5- Listar empresas."."\n";
                echo "6- Listar viajes asociados a una empresa."."\n";
                echo "7- Salir."."\n";
                echo "Ingrese el numero de su eleccion: ";

                $opcionEmpresa = trim(fgets(STDIN));
                
                while ( !is_numeric($opcionEmpresa) || !($opcionEmpresa >= 1 && $opcionEmpresa <= 7)){
                    echo "Ingrese solamente una de las opciones disponibles: ";
                    $opcionEmpresa = trim(fgets(STDIN));
                }

                switch($opcionEmpresa){

                    case 1:

                        echo "\n"."----INGRESAR UNA EMPRESA A LA BASE DE DATOS----"."\n";
                        echo "Ingrese una el nombre de la empresa a ingresar: ";
                        $nombreEmpresa = trim(fgets(STDIN))."\n";

                        while($validar->solo_letras($nombreEmpresa) == false){
                            echo "No ingrese ningun numero."."\n";
                            echo "Ingrese una el nombre de la empresa a ingresar: ";
                            $nombreEmpresa = trim(fgets(STDIN))."\n";
                        }

                        echo "Ingrese la direccion del la empresa: ";
                        $direccionEmpresa = trim(fgets(STDIN))."\n";

                        $empresa->set_enombre($nombreEmpresa);
                        $empresa->set_edireccion($direccionEmpresa);

                        $resultado = $empresa->insertarEmpresa();

                        if ($resultado){
                            echo "La empresa se ingreso correctamente a la base de datos con id = ".$empresa->get_idempresa()."\n";
                        }else{
                            echo "A sucedido el siguiente error:"."\n";
                            echo $empresa->get_mensajeOperacion();
                        }

                        break;
                    
                    case 2:

                        echo "\n"."----ELIMINAR UNA EMPRESA A LA BASE DE DATOS----"."\n";
                        for($i = 0; $i < count($empresa->listarEmpresas()); $i++){
                            echo $empresa->listarEmpresas()[$i];
                        }
                        echo "------EMPRESAS DISPONIBLES EN LA BASE DE DATOS------"."\n";
                        
                        echo "Ingrese el id de la empresa que quiere eliminar: ";
                        $idEmpresaDelete = trim(fgets(STDIN));

                        while(!is_numeric($idEmpresaDelete)){
                            echo "Ingrese solo numeros: ";
                            $idEmpresaDelete = trim(fgets(STDIN));
                        }

                        if (@$empresa->buscar($idEmpresaDelete)){
                            
                            $consultaDelete = "idempresa = ".$idEmpresaDelete;
                            $colViajes = $viaje->listarViajes($consultaDelete);
                            
                            if(count($colViajes) == 0){
                                $resultado = $empresa->deleteEmpresa();
                                if ($resultado){
                                    echo "La empresa se elimino correctamente a la base de datos"."\n";
                                }else{
                                    echo "A sucedido el siguiente error:"."\n";
                                    echo $empresa->get_mensajeOperacion();
                                }
                            }else{
                                echo "No se puede eliminar la empresa, hay un viaje asociado a el."."\n";
                            }
                        }else{
                            echo "No se encontro la empresa."."\n";
                        }

                        break;

                    case 3:

                        echo "\n"."----ACTUALIZAR DATOS DE UNA EMPRESA EN LA BASE DE DATOS----"."\n";
                        for($i = 0; $i < count($empresa->listarEmpresas()); $i++){
                            echo $empresa->listarEmpresas()[$i];
                        }
                        echo "------EMPRESAS DISPONIBLES EN LA BASE DE DATOS------"."\n";
                        echo "ingrese el id de la empresa a modificar: ";
                        $idEmpresaUpdate = trim(fgets(STDIN));

                        while(!is_numeric($idEmpresaUpdate)){
                            echo "Ingrese solo numeros: ";
                            $idEmpresaUpdate = trim(fgets(STDIN));
                        }

                        if (@$empresa->buscar($idEmpresaUpdate)){

                            echo "Ingrese el nombre de la empresa: ";
                            $updateNombre = trim(fgets(STDIN));

                            while($validar->solo_letras($updateNombre) == false){
                                echo "No ingrese ningun numero."."\n";
                                echo "Ingrese una el nombre de la empresa a ingresar: ";
                                $updateNombre = trim(fgets(STDIN))."\n";
                            }

                            echo "Ingrese la direccion de la empresa: ";
                            $updateDireccion = trim(fgets(STDIN));

                            
                                $empresa->set_enombre($updateNombre);
                                $empresa->set_edireccion($updateDireccion);
                                $resultado = @$empresa->actualizarEmpresa();

                                if (@$resultado){
                                    echo "La empresa se actualizo correctamente a la base de datos"."\n";
                                }else{
                                    echo "A sucedido el siguiente error:"."\n";
                                    echo $empresa->get_mensajeOperacion();
                                }

                        }else{
                            echo "No se encontro la empresa."."\n";
                        }
                        break;                        
                        

                    case 4:

                        echo "\n"."-----BUSCAR UNA EMPRESA EN LA BASE DE DATOS-----"."\n";
                        echo "Ingrese el id de la empresa: "."\n";
                        $idEmpresaBuscar = trim(fgets(STDIN));
                        
                        while(!is_numeric($idEmpresaBuscar)){
                            echo "Ingrese solo numeros: ";
                            $idEmpresaBuscar = trim(fgets(STDIN));
                        }

                        if(@$empresa->buscar($idEmpresaBuscar)){
                            echo "EMPRESA SELECCIONADA: "."\n";
                            echo $empresa;
                        }else{
                            echo "No se encontro la empresa."."\n";
                        }

                        break;

                    case 5:

                        echo "\n"."-----LISTAR EMPRESAS DE LA BASE DE DATOS-----"."\n";
                        
                        if(count($empresa->listarEmpresas()) > 0){

                            for($i = 0; $i < count($empresa->listarEmpresas()); $i++){
                                echo $empresa->listarEmpresas()[$i];
                            }

                        }else{
                            echo "No hay ninguana empresa cargada en la base de datos"."\n";
                        }
                        
                        break;

                    case 6:
                        echo "\n"."------LISTAR VIAJES ASOCIADOS A UNA EMPRESA EN LA BASE DE DATOS------"."\n";
                        for($i = 0;$i < count($empresa->listarEmpresas());$i++){
                            echo $empresa->listarEmpresas()[$i];
                        }
                        echo "------EMPRESAS DISPONIBLES EN LA BASE DE DATOS------"."\n";
                        echo "Ingrese el id de la empresa que quiere consultar: ";
                        $idEmpresaViajes = trim(fgets(STDIN));
                        $consulta = "idempresa = ".$idEmpresaViajes;
    
                        $viaje = new viaje(); 
                        $colecViajes = $viaje->listarViajes($consulta);
    
                        if (count($colecViajes) > 0){
    
                            for($i = 0; $i < count($colecViajes); $i++){
                                echo $colecViajes[$i]; 
                            }
    
                        }else{
                            echo "No se encontro ningun viaje asociado a la empresa"."\n";
                        }
                           
                        break;

                }//switch

            }while($opcionEmpresa <= 6 && $opcionEmpresa >= 1);
        break;
        case 2:

            do{

                echo "\n"."------MODIFICAR DATOS DE VIAJES------"."\n";
                echo "1- Ingresar un viaje a la base de datos."."\n";
                echo "2- Eliminar un viaje de la base de datos."."\n";
                echo "3- Actualizar datos de un viaje."."\n";
                echo "4- buscar un viaje."."\n";
                echo "5- Listar viajes."."\n";
                echo "6- Listar pasajeros asiciados a un viaje."."\n";
                echo "7- Salir."."\n";
                echo "Ingrese el numero de su eleccion: ";
                $opcionViaje = trim(fgets(STDIN));

                while ( !is_numeric($opcionViaje) || !($opcionViaje >= 1 && $opcionViaje <= 7)){
                    echo "Ingrese solamente una de las opciones disponibles:";
                    $opcionViaje = trim(fgets(STDIN));
                }

                switch($opcionViaje){
                    case 1:

                        echo "\n"."------INGRESAR UNA VIAJE A LA BASE DE DATOS------"."\n";
                        echo "Ingrese destino del viaje: ";
                        $destino = trim(fgets(STDIN));

                        while($validar->solo_letras($destino) == false){
                            echo "No ingrese ningun numero."."\n";
                            echo "Ingrese destino del viaje: ";
                            $destino = trim(fgets(STDIN))."\n";
                        }

                        echo "Ingrese la cantidad maxima de pasajeros: ";
                        $cantMaxPasajeros = trim(fgets(STDIN));

                        while(!(is_numeric($cantMaxPasajeros) && $cantMaxPasajeros > 1)){
                            echo "Ingrese solo numeros: ";
                            $cantMaxPasajeros = trim(fgets(STDIN));
                        }

                        echo "Ingrese el importe del viaje: ";
                        $importe = trim(fgets(STDIN));

                        while(!(is_numeric($importe) && $importe > 0)){
                            echo "Ingrese solo numeros: ";
                            $importe = trim(fgets(STDIN));
                        }

                        for($i = 0;$i < count($empresa->listarEmpresas());$i++){
                            echo $empresa->listarEmpresas()[$i];
                        }
                        echo "------EMPRESAS DISPONIBLES EN LA BASE DE DATOS------"."\n";

                        echo "Ingrese id de la empresa encargada del viaje: ";
                        $idEmpresaBuscar = trim(fgets(STDIN)); 
                        
                        while(!is_numeric($idEmpresaBuscar)){
                            echo "Ingrese solo numeros: ";
                            $idEmpresaBuscar = trim(fgets(STDIN));
                        }

                        while(!@$empresa->buscar($idEmpresaBuscar)){
                            echo "La empresa no esta registrada en la base de datos"."\n";
                            echo "Ingrese id de la empresa encargada del viaje: ";
                            $idEmpresaBuscar = trim(fgets(STDIN));
                            while(!is_numeric($idEmpresaBuscar)){
                                echo "Ingrese solo numeros: ";
                                $idEmpresaBuscar = trim(fgets(STDIN));
                            }
                        }

                        for($e = 0; $e < count($responsable->listarResponsables()); $e++){
                            echo $responsable->listarResponsables()[$e];
                        }
                        echo "------ENCARGADOS DISPONIBLES EN LA BASE DE DATOS------"."\n";
                        
                        echo "Ingrese numero de empleado del responsable del viaje: ";
                        $nroEmpleadoResponsable = trim(fgets(STDIN));

                        while(!is_numeric($nroEmpleadoResponsable)){
                            echo "Ingrese solo numeros: ";
                            $nroEmpleadoResponsable = trim(fgets(STDIN));
                        }

                        while(!@$responsable->buscarResponsable($nroEmpleadoResponsable)){
                            echo "El responsable no esta registrada en la base de datos"."\n";
                            echo "Ingrese numero de empleado del responsable del viaje: ";
                            $nroEmpleadoResponsable = trim(fgets(STDIN));
                            while(!is_numeric($nroEmpleadoResponsable)){
                                echo "Ingrese solo numeros: ";
                                $nroEmpleadoResponsable = trim(fgets(STDIN));
                            }
                        }

                        $viaje->set_vdestino($destino);
                        $viaje->set_vcantmaxpasajeros($cantMaxPasajeros);
                        $viaje->set_vimporte($importe);
                        $viaje->set_obj_idempresa($empresa);
                        $viaje->set_obj_numeroempleado($responsable);

                        $resultado = $viaje->insertarViaje();

                        if ($resultado){
                            echo "El viaje se ingreso correctamente a la base de datos = ".$viaje->get_idviaje()."\n";
                        }else{
                            echo $viaje->get_mensajeOperacion();
                        }

                        break;

                    case 2:

                        echo "\n"."----ELIMINAR UN VIAJE DE LA BASE DE DATOS----"."\n";
                        for($i = 0; $i < count($viaje->listarViajes()); $i++){
                            echo $viaje->listarViajes()[$i];
                        }
                        echo "------VIAJES DISPONIBLES EN LA BASE DE DATOS------"."\n";
                        echo "Ingrese id del viaje a eliminar: ";
                        $idViajeDelete = trim(fgets(STDIN));
                        
                        while(!is_numeric($idViajeDelete)){
                            echo "Ingrese solo numeros: ";
                            $idViajeDelete = trim(fgets(STDIN));
                        }

                        if(@$viaje->buscarViaje($idViajeDelete)){

                            $condicionDelete = "idviaje = ".$idViajeDelete;
                            $colecPasajeros = $pasajero->listarPasajeros($condicionDelete);
                            
                            if (count($colecPasajeros) == 0){
                                $viaje->eliminarViaje();
                                echo "el viaje se elimino correctamente de la base de datos"."\n";
                            }else{
                                echo "no se puede eliminar el viaje ya que hay pasajeros asociados a ese viaje."."\n";
                            }       

                        }else{
                            echo "No se encontro el id viaje."."\n";
                        }


                        break;

                    case 3:

                        echo "\n"."----ACTUALIZAR DATOS DE VIAJES EN LA BASE DE DATOS----"."\n";
                        for($i = 0; $i < count($viaje->listarViajes()); $i++){
                            echo $viaje->listarViajes()[$i];
                        }
                        echo "Ingrese id del viaje a actualizar: ";
                        $idViajeUpadate = trim(fgets(STDIN));
                
                        while(!is_numeric($idViajeUpadate)){
                            echo "Ingrese solo numeros: ";
                            $idViajeUpadate = trim(fgets(STDIN));
                        }

                        if($viaje->buscarViaje($idViajeUpadate)){

                            echo "Ingrese destino del viaje: ";
                            $destino = trim(fgets(STDIN));
                            while($validar->solo_letras($destino) == false){
                                echo "No ingrese ningun numero."."\n";
                                echo "Ingrese destino del viaje: ";
                                $destino = trim(fgets(STDIN))."\n";
                            }
    
                            echo "Ingrese maxima cantidad de pasajeros del viaje: ";
                            $cantMaxPasajeros = trim(fgets(STDIN));
                            while(!(is_numeric($cantMaxPasajeros) && $cantMaxPasajeros > 1)){
                                echo "Ingrese solo numeros: ";
                                echo "Ingrese maxima cantidad de pasajeros del viaje: ";
                                $cantMaxPasajeros = trim(fgets(STDIN));
                            }
    
                            echo "Ingrese el importe: ";
                            $importe = trim(fgets(STDIN));
                            while(!(is_numeric($importe) && $importe > 0)){
                                echo "Ingrese solo numeros: ";
                                echo "Ingrese importe del viaje: ";
                                $importe = trim(fgets(STDIN));
                            }
                            
                            for($e = 0; $e < count($responsable->listarResponsables()); $e++){
                                echo $responsable->listarResponsables()[$e];
                            }
                            echo "------ENCARGADOS DISPONIBLES EN LA BASE DE DATOS------"."\n";

                            echo "Ingrese el numero de empleado del responsable: ";
                            $nroEmpleadoResponsable = trim(fgets(STDIN));
    
                            while(!is_numeric($nroEmpleadoResponsable)){
                                echo "Ingrese solo numeros: ";
                                $nroEmpleadoResponsable = trim(fgets(STDIN));
                            }
    
                            while(!@$responsable->buscarResponsable($nroEmpleadoResponsable)){
                                echo "El numero del responsable no se encuentra registrado en la base de datos. "."\n";
                                echo "Ingrese el numero de empleadop del responsable: ";
                                $nroEmpleadoResponsable = trim(fgets(STDIN));
                                 while(!is_numeric($nroEmpleadoResponsable)){
                                    echo "Ingrese solo numeros: ";
                                    $nroEmpleadoResponsable = trim(fgets(STDIN));
                                }
                            }
                            
                            for($i = 0;$i < count($empresa->listarEmpresas());$i++){
                                echo $empresa->listarEmpresas()[$i];
                            }
                            echo "------EMPRESAS DISPONIBLES EN LA BASE DE DATOS------"."\n";

                            echo "Ingrese id de la empresa: ";
                            $idEmpresaUpdate = trim(fgets(STDIN));
    
                            while(!is_numeric($idEmpresaUpdate)){
                                echo "Ingrese solo numeros: ";
                                $idEmpresaUpdate = trim(fgets(STDIN));
                            }

                            while(!@$empresa->buscar($idEmpresaUpdate)){
                                echo "El id empresa no se encuentra registrado en la base de datos. "."\n";
                                echo "Ingrese id de la empresa: ";
                                $idEmpresaUpdate = trim(fgets(STDIN));
                                 while(!is_numeric($idEmpresaUpdate)){
                                    echo "Ingrese solo numeros: ";
                                    $idEmpresaUpdate = trim(fgets(STDIN));
                                }
                            }
    
                            $viaje->set_vdestino($destino);
                            $viaje->set_vcantmaxpasajeros($cantMaxPasajeros);
                            $viaje->set_vimporte($importe);
                            $viaje->set_obj_numeroempleado($responsable);
                            $viaje->set_obj_idempresa($empresa);
                            $resultado = $viaje->actualizarViaje();
    
                            if($resultado){
                                echo "La actualizacion se realizo correctamente."."\n";
                            }else{
                                echo $viaje->get_mensajeOperacion();
                            }
    
                        }else{
                            echo "No se encontro el id viaje."."\n";
                        }

                        break; 

                    case 4:

                        echo "\n"."------BUSCAR UN VIAJE ------"."\n";
                        echo "Ingrese id del viaje a buscar:";
                        $idViajeBuscar = trim(fgets(STDIN));

                        while(!is_numeric($idViajeBuscar)){
                            echo "Ingrese solo numeros: ";
                            $idViajeBuscar = trim(fgets(STDIN));
                        }

                        if(@$viaje->buscarViaje($idViajeBuscar)){

                            $resultado = $viaje->buscarViaje($idViajeBuscar);

                            if($resultado){
                                echo $viaje;
                            }else{
                                echo $viaje->get_mensajeOperacion();
                            }

                        }else{
                            echo "No se encontro el id viaje."."\n";
                        }
                        
                        break;
                    
                    case 5:

                        echo "\n"."------LISTAR VIAJES EN LA BASE DE DATOS------"."\n";

                        $arrayViajes=$viaje->listarViajes();

                       if(count($arrayViajes) > 0){
                            for($i = 0; $i < count($arrayViajes); $i++){
                                echo $arrayViajes[$i];
                            }
                       }else{
                         echo "No se encontraron pasajeros."."\n";
                       }
                       

                        break;

                    case 6:

                        echo "\n"."------LISTAR PASAJEROS ASOCIADOS AL VIAJES EN LA BASE DE DATOS------"."\n";
                        for($i = 0; $i < count($arrayViajes); $i++){
                            echo $arrayViajes[$i];
                        }
                        echo "------VIAJES DISPONIBLES EN LA BASE DE DATOS------"."\n";
                        echo "Ingrese el id viaje que quiere consultar: ";
                        $idViajeListar = trim(fgets(STDIN));
                        $consulta = "idviaje = ". $idViajeListar;
                        $colecPasajeros = $pasajero->listarPasajeros($consulta);
                        if(count($colecPasajeros) > 0){
                            for($i = 0; $i < count($colecPasajeros); $i++){
                                echo $colecPasajeros[$i];
                            }
                        }else{
                            echo "No hay pasajeros registrados en este viaje."."\n";
                        }
                        
                        break;

                }//switch

            }while($opcionViaje <= 6 && $opcionViaje >= 1);
        break;
        case 3:
            
            do{
                echo "\n"."------MODIFICAR DATOS DE PASAJEROS EN LA BASE DE DATOS------"."\n";
                echo "1- Ingresar un pasajero a la base de datos."."\n";
                echo "2- Eliminar un pasajero de la base de datos."."\n";
                echo "3- Actualizar datos de un pasajero."."\n";
                echo "4- buscar un pasajero."."\n";
                echo "5- Listar pasajeros."."\n";
                echo "6- Salir."."\n";
                echo "Ingrese el numero de su eleccion: ";
                $opcionPasajero = trim(fgets(STDIN));

                while ( !is_numeric($opcionPasajero) || !($opcionPasajero >= 1 && $opcionPasajero <= 6)){
                    echo "Ingrese solamente una de las opciones disponibles:";
                    $opcionPasajero = trim(fgets(STDIN));
                }

                switch($opcionPasajero){
                    case 1:

                        echo "\n"."------INGRESAR UN PASAJERO A LA BASE DE DATOS------"."\n";
                        echo "Ingrese el documento del pasajero: ";
                        $dni = trim(fgets(STDIN));

                        while(!is_numeric($dni)){
                            echo "Ingrese solo numeros: ";
                            $dni = trim(fgets(STDIN));
                        }

                        while(@$pasajero->buscarPasajero($dni)){
                            echo "El dni ya se encuentra registrado en la base de datos. "."\n";
                            echo "Ingrese el documento del pasajero: ";
                            $dni = trim(fgets(STDIN));
                            while(!is_numeric($dni)){
                                echo "Ingrese solo numeros: ";
                                $dni = trim(fgets(STDIN));
                            }
                        }

                        echo "Ingrese el nombre del pasajero: ";
                        $nombre = trim(fgets(STDIN));
                        
                        while($validar->solo_letras($nombre) == false){
                            echo "No ingrese ningun numero."."\n";
                            echo "Ingrese destino del viaje: ";
                            $nombre = trim(fgets(STDIN))."\n";
                        }

                        echo "Ingrese el apellido del pasajero: ";
                        $apellido = trim(fgets(STDIN));
                        
                        while($validar->solo_letras($apellido) == false){
                            echo "No ingrese ningun numero."."\n";
                            echo "Ingrese destino del viaje: ";
                            $apellido = trim(fgets(STDIN))."\n";
                        }

                        echo "Ingrese el numero de telefono del pasajero: ";
                        $telefono = trim(fgets(STDIN));
                        while(!is_numeric($telefono)){
                            echo "Ingrese solo numeros: ";
                            $telefono = trim(fgets(STDIN));
                        }

                        
                        for ( $f = 0; $f < count($viaje->listarViajes()); $f++){
                            echo $viaje->listarViajes()[$f];
                        }
                        echo "------VIAJES DISPONIBLES EN LA BASE DE DATOS------"."\n";
                        
                        echo "Ingrese id del viaje al cual se asignara al pasajero: ";
                        $idViajePasajero = trim(fgets(STDIN));

                        while(!is_numeric($idViajePasajero)){
                            echo "Ingrese solo numeros: ";
                            $idViajePasajero = trim(fgets(STDIN));
                        }

                        while(!@$viaje->buscarViaje($idViajePasajero)){
                            echo "El id viaje no se encuentra registrado en la base de datos. "."\n";
                            echo "Ingrese id del viaje al cual se asignara al pasajero: ";
                            $idViajePasajero = trim(fgets(STDIN));
                            while(!is_numeric($idViajePasajero)){
                                echo "Ingrese solo numeros: ";
                                $idViajePasajero = trim(fgets(STDIN));
                            }
                        }

                        $pasajero->set_doc($dni);
                        $pasajero->set_nombre($nombre);
                        $pasajero->set_apellido($apellido);
                        $pasajero->set_telefono($telefono);
                        $pasajero->set_obj_idviaje($viaje);
                        $resultado = $pasajero->insertarPasajero();

                        if($resultado){
                            echo "El pasajero se ingreso correctamente: "."\n";
                        }else{
                            echo $pasajero->get_mensajeOperacion();
                        }

                        break;

                    case 2: 

                        echo "\n"."------ELIMINAR PASAJEROS DE LA BASE DE DATOS------"."\n";
                        for($i = 0; $i < count($pasajero->listarPasajeros()); $i++){
                            echo $pasajero->listarPasajeros()[$i];
                        }
                        echo "------PASAJEROS DISPONIBLES EN LA BASE DE DATOS------"."\n";
                        echo "Ingrese el numero de documento del pasajero a eliminar: ";
                        $docEliminar = trim(fgets(STDIN));

                        while(!is_numeric($docEliminar)){
                            echo "Ingrese solo numeros: ";
                            $docEliminar = trim(fgets(STDIN));
                        }

                        if(@$pasajero->buscarPasajero($docEliminar)){

                            $resultado = $pasajero->eliminarPasajero();

                            if($resultado){
                                echo "Se elimino el pasajero de la base de datos correctamente"."\n";
                            }else{
                                echo $pasajero->get_mensajeOperacion();
                            }                            
                        }else{
                            echo "No se encontro al pasajero."."\n";
                        }

                        
                        
                        break;

                    case 3:

                        echo "\n"."----ACTUALIZAR DATOS DE PASAJEROS EN LA BASE DE DATOS----"."\n";     
                        for($i = 0; $i < count($pasajero->listarPasajeros()); $i++){
                            echo $pasajero->listarPasajeros()[$i];
                        }
                        echo "------PASAJEROS DISPONIBLES EN LA BASE DE DATOS------"."\n";
     
                        echo "ingrese numero de documento del pasajero a modificar: ";
                        $docUpdateP = trim(fgets(STDIN));

                        while(!is_numeric($docUpdateP)){
                            echo "Ingrese solo numeros: ";
                            $docUpdateP = trim(fgets(STDIN));
                        }

                        if(@$pasajero->buscarPasajero($docUpdateP)){
    
                            echo "Ingrese nombre del pasajero: ";
                            $nombreUpdate = trim(fgets(STDIN));
                            while($validar->solo_letras($nombreUpdate) == false){
                                echo "No ingrese ningun numero."."\n";
                                echo "Ingrese destino del viaje: ";
                                $nombreUpdate = trim(fgets(STDIN))."\n";
                            }
    
                            echo "Ingrese apellido del pasajero: ";
                            $apellidoUpdate = trim(fgets(STDIN));
                            while($validar->solo_letras($apellidoUpdate) == false){
                                echo "No ingrese ningun numero."."\n";
                                echo "Ingrese destino del viaje: ";
                                $apellidoUpdate = trim(fgets(STDIN))."\n";
                            }
    
                            echo "Ingrese el telefono del pasajero: ";
                            $telefonoUpadate = trim(fgets(STDIN));
    
                            while(!is_numeric($telefonoUpadate)){
                                echo "Ingrese solo numeros: ";
                                $telefonoUpadate = trim(fgets(STDIN));
                            }   
    
                            for ( $f = 0; $f < count($viaje->listarViajes()); $f++){
                                echo $viaje->listarViajes()[$f];
                            }
                            echo "------VIAJES DISPONIBLES EN LA BASE DE DATOS------"."\n";

                            echo "Ingrese id de viaje: ";
                            $idViaje = trim(fgets(STDIN));
                            
                            $viajeUpdete = new viaje();
                            while(!@$viajeUpdete->buscarViaje($idViaje)){
                                echo "El id viaje no se encuentra registrado en la base de datos. "."\n";
                                echo "Ingrese id de viaje: ";
                                $idViaje = trim(fgets(STDIN));
                                while(!is_numeric($idViaje)){
                                    echo "Ingrese solo numeros: ";
                                    $idViaje = trim(fgets(STDIN));
                                }
                            }
                            
                            $pasajero->set_nombre($nombreUpdate);
                            $pasajero->set_apellido($apellidoUpdate);
                            $pasajero->set_telefono($telefonoUpadate);
                            $pasajero->set_obj_idviaje($viajeUpdete);
                            $resultado = $pasajero->actualizarPasajero();
    
                            if(@$resultado){
                                echo "La actualizacion fue exitosa"."\n";
                            }else{
                                echo $pasajero->get_mensajeOperacion();
                            }                           

                        }else{
                            echo "No se encontro al pasajero."."\n";
                        }


                        
                       break;

                        

                    case 4:

                        echo "\n"."------BUSCAR UN PASAJERO ------"."\n";
                        echo "Ingrese numero de documento del pasajero a buscar:";
                        $nroDocBuscar = trim(fgets(STDIN));

                        while(!is_numeric($nroDocBuscar)){
                            echo "Ingrese solo numeros: ";
                            $nroDocBuscar = trim(fgets(STDIN));
                        }


                        if(@$pasajero->buscarPasajero($nroDocBuscar)){

                            $resultado = $pasajero->buscarPasajero($nroDocBuscar);

                            if($resultado){
                                echo $pasajero;
                            }else{
                                echo $pasajero->get_mensajeOperacion();
                            }             

                        }else{
                            echo "No se encontro al pasajero."."\n";
                        }

                        
                        break;

                    case 5: 

                        echo "\n"."------LISTAR PASAJEROS EN LA BASE DE DATOS------"."\n";

                        $arregloPasajeros = $pasajero->listarPasajeros();

                        if (count($arregloPasajeros) > 0){

                            for($i = 0; $i < count($arregloPasajeros); $i++){
                                echo $arregloPasajeros[$i];
                            }
                        }else{
                            echo "No se encontraron pasajeros."."\n";
                        }

                        break;


                }

            }while($opcionPasajero >= 1 && $opcionPasajero <= 5);
        break;
        case 4:

            do{
                echo "\n"."------MODIFICAR DATOS DE RESPONSABLE------"."\n";
                echo "1- Ingresar un responsable a la base de datos."."\n";
                echo "2- Eliminar un responsable de la base de datos."."\n";
                echo "3- Actualizar un responsable."."\n";
                echo "4- buscar un responsable."."\n";
                echo "5- Listar responsable."."\n";
                echo "6- Listar viajes asociados a un responsable"."\n";
                echo "7- Salir."."\n";
                echo "Ingrese el numero de su eleccion: ";

                $opcionResponsable = trim(fgets(STDIN));
                
                while ( !is_numeric($opcionResponsable) || !($opcionResponsable >= 1 && $opcionResponsable <= 7)){
                    echo "Ingrese solamente una de las opciones disponibles:";
                    $opcionResponsable = trim(fgets(STDIN));
                }

                switch($opcionResponsable){
                    case 1:

                        echo "\n"."------INGRESAR UN RESPONSABLE A LA BASE DE DATOS------"."\n";

                        echo "Ingrese numero de licencia del responsable: ";
                        $nroLicencia = trim(fgets(STDIN));
                        while(!is_numeric($nroLicencia)){
                            echo "Ingrese solo numeros: ";
                            $nroLicencia = trim(fgets(STDIN));
                        }

                        echo "Ingrese el nombre del responsable: ";
                        $nombreResponsable = trim(fgets(STDIN));
                        while($validar->solo_letras($nombreResponsable) == false){
                            echo "No ingrese ningun numero."."\n";
                            echo "Ingrese el nombre del responsable: ";
                            $nombreResponsable = trim(fgets(STDIN));
                        }

                        echo "Ingrese el apellido del responsable: ";
                        $apellidoResponsable = trim(fgets(STDIN));
                        while($validar->solo_letras($apellidoResponsable) == false){
                            echo "No ingrese ningun numero."."\n";
                            echo "Ingrese el apellido del responsable: ";
                            $apellidoResponsable = trim(fgets(STDIN));
                        }

                        $responsable->set_nro_licencia($nroLicencia);
                        $responsable->set_nombre($nombreResponsable);
                        $responsable->set_apellido($apellidoResponsable);
                        $resultado = $responsable->insertarResponsable();

                        if($resultado){
                            echo "Se ingreso el responsable correctamente con id = ".$responsable->get_nro_empleado()."\n";
                        }else{
                            echo $responsable->get_mensajeOperacion();
                        }

                        break;

                    case 2:

                        echo "\n"."------ELIMINAR UN RESPONSABLE A LA BASE DE DATOS------"."\n";
                        for($i = 0; $i < count($responsable->listarResponsables()); $i++){
                            echo $responsable->listarResponsables()[$i];
                        }
                        echo "------RESPONSABLES DISPONIBLES EN LA BASE DE DATOS------"."\n";

                        echo "Ingrese el numero empleado del responsable a eliminar: ";
                        $nroResponsable = trim(fgets(STDIN));

                        while(!is_numeric($nroResponsable)){
                            echo "Ingrese solo numeros: ";
                            $nroResponsable = trim(fgets(STDIN));
                        }

                        if(@$responsable->buscarResponsable($nroResponsable)){

                            $consultaDeleteResponsable = "rnumeroempleado = ".$nroResponsable;
                            $colViajes = $viaje->listarViajes($consultaDeleteResponsable);

                            if(count($colViajes) == 0){
                                $resultado = $responsable->eliminarResponsable();
                                if($resultado){
                                    echo "Se elimino al responsable correctamente"."\n";
                                }else{
                                    echo $responsable->get_mensajeOperacion();
                                }
                            }else{
                                echo "No se pudo eliminar al responsable, hay un viaje asignado a el."."\n";
                            }

                        }else{
                            echo "No se encontro al responsable"."\n";
                        }

   
                        break;

                    case 3:

                        echo "\n"."------ACTUALIZAR DATOS DE RESPONSABLE------"."\n";
                        for($i = 0; $i < count($responsable->listarResponsables()); $i++){
                            echo $responsable->listarResponsables()[$i];
                        }
                        echo "------RESPONSABLES DISPONIBLES EN LA BASE DE DATOS------"."\n";

                        echo "Ingrese el numero empleado del responsable a actualizar: ";
                        $nroResponsable = trim(fgets(STDIN));

                        while(!is_numeric($nroResponsable)){
                            echo "Ingrese solo numeros: ";
                            $nroResponsable = trim(fgets(STDIN));
                        }

                        if(@$responsable->buscarResponsable($nroResponsable)){
    
                            echo "Ingrese numero de licencia del responsable: ";
                            $nroLicencia = trim(fgets(STDIN));
                            while(!is_numeric($nroLicencia)){
                                echo "Ingrese solo numeros: ";
                                $nroLicencia = trim(fgets(STDIN));
                            }
    
                            echo "Ingrese el nombre del responsable: ";
                            $nombreResponsable = trim(fgets(STDIN));
                            while($validar->solo_letras($nombreResponsable) == false){
                                echo "No ingrese ningun numero."."\n";
                                echo "Ingrese el nombre del responsable: ";
                                $nombreResponsable = trim(fgets(STDIN));
                            }
    
                            echo "Ingrese el apellido del responsable: ";
                            $apellidoResponsable = trim(fgets(STDIN));
                            while($validar->solo_letras($apellidoResponsable) == false){
                                echo "No ingrese ningun numero."."\n";
                                echo "Ingrese el apellido del responsable: ";
                                $apellidoResponsable = trim(fgets(STDIN));
                            }
    
                            $responsable->set_nro_empleado($nroResponsable);
                            $responsable->set_nro_licencia($nroLicencia);
                            $responsable->set_nombre($nombreResponsable);
                            $responsable->set_apellido($apellidoResponsable);
    
                            $resultado= $responsable->actualizarResponsable();
    
                            if($resultado){
                                echo "Se actualizo correctamente"."\n";
                            }else{
                                $responsable->get_mensajeOperacion();
                            }

                        }else{
                            echo "No se encontro al responsable"."\n";
                        }

                        
                        break;

                    case 4:

                        echo "\n"."------BUSCAR UN RESPONSABLE EN LA BASE DE DATOS------"."\n";
                        echo "Ingrese el numero empleado del responsable a buscar: ";
                        $nroResponsable = trim(fgets(STDIN));

                        while(!is_numeric($nroResponsable)){
                            echo "Ingrese solo numeros: ";
                            $nroResponsable = trim(fgets(STDIN));
                        }

                        if(@$responsable->buscarResponsable($nroResponsable)){
                            
                            echo $responsable;

                        }else{
                            echo "El numero empleado del responsable no se encuentra registrado en la base de datos. "."\n";
                        }

                        break;

                    case 5:

                        echo "\n"."------LISTAR RESPONSABLES EN LA BASE DE DATOS------"."\n";

                        $arregloResponsable = $responsable->listarResponsables();

                        if(count($arregloResponsable)){
                            for($i = 0; $i < count($arregloResponsable); $i++){
                                echo $arregloResponsable[$i];
                            }
                        }else{
                            echo "No se encontraron responsables en la base de datos."."\n";
                        }   
                        
                        break;

                    case 6: 
                        echo "\n"."------LISTAR VIAJES ASOCIADOS AL RESPONSABLE------"."\n";
                        for($i = 0; $i < count($responsable->listarResponsables()); $i++){
                            echo $responsable->listarResponsables()[$i];
                        }
                        echo "------RESPONSABLES DISPONIBLES EN LA BASE DE DATOS------"."\n";
                        echo "Ingrese el numero de empleado del responsable para consultar: ";
                        $numeroEmpleado = trim(fgets(STDIN));
                        $consulta = "rnumeroempleado = ".$numeroEmpleado;
                        $colecViajes = $viaje->listarViajes($consulta);
    
                        if( count($colecViajes) > 0){
                            for($i = 0; $i < count($colecViajes); $i++){
                                 echo $colecViajes[$i];
                            }
                        }else{
                            echo "no se encontro ningun viaje asociado al responsable"."\n";
                        }
    
                        break;

                }
            }while($opcionResponsable >= 1 && $opcionResponsable <= 6);
        
    }


}while($opcion >=1 && $opcion <= 4);

