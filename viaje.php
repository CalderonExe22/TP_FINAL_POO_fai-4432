<?php

include_once("empresa.php");
include_once("responsable.php");

class viaje{

    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $vimporte;
    private $obj_idempresa;
    private $obj_rnumeroempleado;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idviaje = null;   
        $this->vdestino = ""; 
        $this->vcantmaxpasajeros = null; 
        $this->vimporte = null; 
        $this->obj_idempresa = null; 
        $this->obj_rnumeroempleado = null; 
        $this->mensajeOperacion = "";
    }

/******************************************************************************************************************** */

    public function get_idviaje(){
        return $this->idviaje;
    }

    public function get_vdestino(){
        return $this->vdestino;
    }

    public function get_vcantmaxpasajeros(){
        return $this->vcantmaxpasajeros;
    }
    
    public function get_vimporte(){
        return $this->vimporte;
    }

    public function get_obj_idempresa(){
        return $this->obj_idempresa;
    }

    public function get_obj_numeroempleado(){
        return $this->obj_rnumeroempleado;
    }

    public function get_mensajeOperacion(){
        return $this->mensajeOperacion;
    } 

/******************************************************************************************************************** */

    public function set_idviaje($idviaje){
        $this->idviaje = $idviaje;
    }

    public function set_vdestino($vdestino){
        $this->vdestino = $vdestino;
    }

    public function set_vcantmaxpasajeros($vcantmaxpasajeros){
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
    }

    public function set_vimporte($vimporte){
        $this->vimporte = $vimporte;
    }
    
    public function set_obj_idempresa($obj_idempresa){
        $this->obj_idempresa = $obj_idempresa;
    }

    public function set_obj_numeroempleado($obj_rnumeroempleado){
        $this->obj_rnumeroempleado = $obj_rnumeroempleado;
    }

    public function set_mensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    } 

/********************************************************************************************************************/

    public function __toString()
    {
        return
        "\n"."------------------- VIAJE -------------------"."\n".
        "id de viaje: ". $this->get_idviaje()."\n".
        "destino del viaje: ". $this->get_vdestino()."\n".
        "cantidad maxima de pasajeros del viaje: ". $this->get_vcantmaxpasajeros()."\n".
        "importe del viaje: ". $this->get_vimporte()."\n".
        "id empresa: ". $this->get_obj_idempresa()."\n".
        "numero empleado: ". $this->get_obj_numeroempleado()."\n";
    }

/********************************************************************************************************************/

    public function cargarDatos($idviaje,$vdestino,$vcantmaxpasajeros,$vimporte,$obj_idempresa,$obj_rnumeroempleado){
        $this->set_idviaje($idviaje);
        $this->set_vdestino($vdestino);
        $this->set_vcantmaxpasajeros($vcantmaxpasajeros);
        $this->set_vimporte($vimporte);
        $this->set_obj_idempresa($obj_idempresa);
        $this->set_obj_numeroempleado($obj_rnumeroempleado);
    }

/********************************************************************************************************************/

    public function buscarViaje($idviaje){

        $baseDeDatos = new BaseDatos();

        $consultaBuscar = "SELECT * FROM viaje WHERE idviaje = ".$idviaje;

        $resultado = false;

        if ($baseDeDatos->Iniciar()){
            if ( $baseDeDatos->Ejecutar($consultaBuscar)){
                if($filas = $baseDeDatos->Registro()){

                    $nroEmpleado = $filas["rnumeroempleado"];
                    $r = new responsable();
                    $r->buscarResponsable($nroEmpleado);

                    $idempresa = $filas["idempresa"];
                    $e = new empresa();
                    $e->buscar($idempresa);

                    $this->cargarDatos($filas["idviaje"],$filas["vdestino"],$filas["vcantmaxpasajeros"],$filas["vimporte"],$e,$r);
                    $resultado = true;

                }else{
                    $this->set_mensajeOperacion($baseDeDatos->getError());
                }
            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }
        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $resultado;

    }

    public function insertarViaje(){

        $baseDeDatos = new BaseDatos();

        $empresa = $this->get_obj_idempresa();

        $idempresa = $empresa->get_idempresa();

        $responsable = $this->get_obj_numeroempleado();

        $nroEmpleado = $responsable->get_nro_empleado();

        $consultaInsert = "INSERT INTO viaje (vdestino,vcantmaxpasajeros,idempresa,rnumeroempleado,vimporte)
        VALUES ('". $this->get_vdestino(). "',". $this->get_vcantmaxpasajeros().",". $idempresa.",". $nroEmpleado.",". $this->get_vimporte().")";

        $resultado = false; 

        if($baseDeDatos->Iniciar()){
            if($id = $baseDeDatos->devuelveIDInsercion($consultaInsert)){
                $this->set_idviaje($id);
                $resultado = true;
            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }
        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $resultado;

    }

    public function eliminarViaje(){

        $baseDeDatos = new BaseDatos();

        $consultaDelete = "DELETE FROM viaje WHERE idviaje= ". $this->get_idviaje();

        $resultado = false;

        if ($baseDeDatos->Iniciar()){
            if($baseDeDatos->Ejecutar($consultaDelete)){
                $resultado = true;
            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }
        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $resultado;

    }

    public function actualizarViaje(){

        $baseDeDatos = new BaseDatos();

        $empresa = $this->get_obj_idempresa();

        $idempresa = $empresa->get_idempresa();

        $responsable = $this->get_obj_numeroempleado();

        $nroEmpleado = $responsable->get_nro_empleado();

        $consultaUpdate = "UPDATE viaje SET  vdestino = '". $this->get_vdestino()."', vcantmaxpasajeros = ". $this->get_vcantmaxpasajeros().", idempresa = ". $idempresa.", rnumeroempleado = ". $nroEmpleado. ", vimporte = ". $this->get_vimporte()." WHERE idviaje = ". $this->get_idviaje();

        if ( $baseDeDatos->Iniciar()){
            if($baseDeDatos->Ejecutar($consultaUpdate)){
                $resultado = true;
            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }
        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $resultado;

    }


    public function listarViajes($condicion=""){

        $baseDeDatos = new BaseDatos();

        $consultaListar = "SELECT * FROM viaje";

        $arregloViajes = null;

        if ( $condicion != ""){
            $consultaListar = $consultaListar.' where '.$condicion;
        }

        $consultaListar = $consultaListar. ' order by idviaje ';

        if($baseDeDatos->Iniciar()){
            if($baseDeDatos->Ejecutar($consultaListar)){
                $arregloViajes = [];
                while( $filas=$baseDeDatos->Registro()){

                    $id = $filas['idviaje'];
                    $destino = $filas['vdestino'];
                    $cantmaxpasajeros = $filas['vcantmaxpasajeros'];
                    $idemp = $filas['idempresa'];
                    $nroEmpl = $filas['rnumeroempleado'];
                    $importe = $filas['vimporte'];

                    $viaje = new viaje();
                    $viaje->cargarDatos($id,$destino,$cantmaxpasajeros,$importe,$idemp,$nroEmpl);
                    $arregloViajes[] = $viaje;

                }

            }else{

                $this->set_mensajeOperacion($baseDeDatos->getError());
            }

        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $arregloViajes;

    }



}