<?php

include_once("viaje.php");

class pasajero {

    private $pdocumento;
    private $pnombre;
    private $papellido;
    private $ptelefono;
    private $obj_idviaje;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->pdocumento = null;
        $this->pnombre = "";
        $this->papellido = "";
        $this->ptelefono = null;
        $this->obj_idviaje = null;
        $this->mensajeOperacion = "";
    }

/********************************************************************************************* */

    public function get_doc(){
        return $this->pdocumento;
    }

    public function get_nombre(){
        return $this->pnombre;
    }

    public function get_apellido(){
        return $this->papellido;
    }

    public function get_telefono(){
        return $this->ptelefono;
    }

    public function get_obj_idviaje(){
        return $this->obj_idviaje;
    }

    public function get_mensajeOperacion(){
        return $this->mensajeOperacion;
    }

/********************************************************************************************* */

    public function set_doc($pdocumento){
        $this->pdocumento = $pdocumento;
    }

    public function set_nombre($pnombre){
        $this->pnombre = $pnombre;
    }

    public function set_apellido($papellido){
        $this->papellido = $papellido;
    }

    public function set_telefono($ptelefono){
        $this->ptelefono = $ptelefono;
    }

    public function set_obj_idviaje($obj_idviaje){
        $this->obj_idviaje = $obj_idviaje;
    }

    public function set_mensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

/********************************************************************************************* */

    public function __toString()
    {
        return
        "\n"."------------------- PASAJERO -------------------"."\n".
        "documente del pasajero: ". $this->get_doc()."\n".
        "nombre del pasajero: ". $this->get_nombre()."\n".
        "apellido del pasajero: ". $this->get_apellido()."\n".
        "telefono del pasajero: ". $this->get_telefono()."\n".
        "id viaje: ". $this->get_obj_idviaje()."\n";
    }

/********************************************************************************************* */

    public function cargarDatos($pdocumento,$pnombre,$papellido,$ptelefono,$obj_idviaje){

        $this->set_doc($pdocumento);
        $this->set_nombre($pnombre);
        $this->set_apellido($papellido);
        $this->set_telefono($ptelefono);
        $this->set_obj_idviaje($obj_idviaje);

    }

/********************************************************************************************* */
 
    public function buscarPasajero($pdocumento){

        $baseDeDatos = new BaseDatos();

        $consultaBuscar = "SELECT * FROM pasajero WHERE pdocumento = ". $pdocumento;

        $resultado = false;

        if($baseDeDatos->Iniciar()){
            if($baseDeDatos->Ejecutar($consultaBuscar)){
                if($lista = $baseDeDatos->Registro()){

                    $viaje = new viaje();
                    $viaje->buscarViaje($lista["idviaje"]);
                    $this->cargarDatos($lista["pdocumento"],$lista["pnombre"],$lista["papellido"],$lista["ptelefono"],$viaje);
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


    public function insertarPasajero(){

        $baseDeDatos = new BaseDatos();

        $viaje = $this->get_obj_idviaje();

        $idviaje = $viaje->get_idviaje();

        $resultado = false;

        $consultaInsert = "INSERT INTO pasajero (pdocumento,pnombre,papellido,ptelefono,idviaje) VALUES
         (".$this->get_doc().",'". $this->get_nombre()."','". $this->get_apellido()."',". $this->get_telefono().",".$idviaje.")";

        if($baseDeDatos->Iniciar()){
            if($baseDeDatos->Ejecutar($consultaInsert)){
                $resultado = true;
            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }
        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $resultado;


    }

    public function eliminarPasajero(){

        $baseDeDatos = new BaseDatos();

        $consultaDelete = "DELETE FROM pasajero WHERE pdocumento = ". $this->get_doc();

        $resultado = false;

        if($baseDeDatos->Iniciar()){
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


    public function actualizarPasajero(){
        
        $baseDeDatos = new BaseDatos();

        $viaje = $this->get_obj_idviaje();

        $idviaje = $viaje->get_idviaje();

        $resultado = false;

        $consultaUpdate = "UPDATE pasajero SET pnombre = '". $this->get_nombre()."', papellido = '". $this->get_apellido()."', ptelefono = ". $this->get_telefono().", idviaje = ". $idviaje. " WHERE pdocumento = ". $this->get_doc();

        if($baseDeDatos->Iniciar()){
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


    public function listarPasajeros($condicion=""){

        $baseDeDatos = new BaseDatos();

        $consultaListar = "SELECT * FROM pasajero ";

        $arregloPasajeros = null;

        if( $condicion != ""){
            $consultaListar = $consultaListar.' where '.$condicion;
        }

        $consultaListar = $consultaListar.' ORDER BY papellido';

        if($baseDeDatos->Iniciar()){
            if($baseDeDatos->Ejecutar($consultaListar)){
                $arregloPasajeros = [];
                while($lista = $baseDeDatos->Registro()){
                    
                    $doc = $lista["pdocumento"];
                    $nombre = $lista["pnombre"];
                    $apellido = $lista["papellido"];
                    $telefono = $lista["ptelefono"];
                    $idviaje = $lista["idviaje"];

                    $pasajero = new pasajero();
                    $pasajero->cargarDatos($doc,$nombre,$apellido,$telefono,$idviaje);
                    $arregloPasajeros[] = $pasajero;

                }
            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }
        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $arregloPasajeros;

    }


}