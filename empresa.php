<?php
include_once("baseDeDatos.php");

class empresa{

    private $idempresa;
    private $enombre;
    private $edireccion;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idempresa = "";
        $this->enombre = "";
        $this->edireccion = "";
        $this->mensajeOperacion = "";
    }

/*************************************************************************** */

    public function get_idempresa(){
        return $this->idempresa;
    }

    public function get_enombre(){
        return $this->enombre;
    }

    public function get_edireccion(){
        return $this->edireccion;
    }

    public function get_mensajeOperacion(){
        return $this->mensajeOperacion;
    }

/*************************************************************************** */

    public function set_idempresa($idempresa){
        $this->idempresa = $idempresa;
    }

    public function set_enombre($enombre){
        $this->enombre = $enombre;
    }

    public function set_edireccion($edireccion){
        $this->edireccion = $edireccion;
    }

    public function set_mensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

/*************************************************************************** */

    public function __toString()
    {
        return
        "\n"."------------------- EMPRESA -------------------"."\n".
        "id empresa: ". $this->get_idempresa ()."\n".
        "nombre de la empresa: ". $this->get_enombre()."\n".
        "direccion de la empresa: ". $this->get_edireccion()."\n";
    }


/******************************************************************************************************************* */

    public function cargarDatos($idempresa,$enombre,$edireccion){
        $this->set_idempresa($idempresa);
        $this->set_enombre($enombre);
        $this->set_edireccion($edireccion);
    } 

/******************************************************************************************************************* */

    public function buscar($idempresa){

        $baseDeDatos = new BaseDatos();

        $consultaBuscar = "select * from empresa where idempresa = ". $idempresa;

        $resultado = false;

        if ( $baseDeDatos->Iniciar()){
            if ($baseDeDatos->Ejecutar($consultaBuscar)){
                if ( $filas = $baseDeDatos->Registro()){
                    $this->cargarDatos($filas["idempresa"],$filas["enombre"],$filas["edireccion"]);
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

    public function insertarEmpresa(){

        $baseDeDatos = new BaseDatos();

        $consultaSqlInsert = "INSERT INTO empresa (enombre,edireccion) values ('".$this->get_enombre()."','".$this->get_edireccion()."')";

        $resultado = false;

        if ($baseDeDatos->Iniciar()){
            if($idempresa = $baseDeDatos->devuelveIDInsercion($consultaSqlInsert)){
                $this->set_idempresa($idempresa);
                $resultado = true;
            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }
        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $resultado;

    }


    public function deleteEmpresa(){

        $consultaDelete = "DELETE FROM empresa WHERE idempresa = ". $this->get_idempresa();

        $baseDeDatos = new BaseDatos();

        $resultado = false;

        if ($baseDeDatos->Iniciar()){
            if ($baseDeDatos->Ejecutar($consultaDelete)){
                $resultado = true;
            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }
        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $resultado;

    }


    public function actualizarEmpresa(){

        $consultaUpdate = "UPDATE empresa SET enombre='".$this->get_enombre()."'
        ,edireccion='".$this->get_edireccion()."' WHERE idempresa=". $this->get_idempresa();

        $baseDeDatos = new BaseDatos();

        $resultado = false;

        if ( $baseDeDatos->Iniciar() ){
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

    public function listarEmpresas($condicion=""){

        $baseDeDatos = new BaseDatos();

        $arregloEmpresa = null;

        $consultaLista = "SELECT * FROM empresa";

        if ($condicion != ""){
            $consultaLista = $consultaLista.' where '.$condicion;
        }

        $consultaLista = $consultaLista." ORDER BY idempresa"; 

        if ($baseDeDatos->Iniciar()){
            if($baseDeDatos->Ejecutar($consultaLista)){
                $arregloEmpresa = [];
                while($lista = $baseDeDatos->Registro()){
                    $idEmp = $lista["idempresa"];
                    $nombreEmp = $lista["enombre"];
                    $diireccionEmp = $lista["edireccion"];

                    $empresa = new empresa();
                    $empresa->cargarDatos($idEmp,$nombreEmp,$diireccionEmp);
                    $arregloEmpresa[] = $empresa;
                }
            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }
        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $arregloEmpresa;

    }

    function viajesEmpresa(){

    }


}