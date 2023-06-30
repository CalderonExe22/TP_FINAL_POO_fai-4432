<?php

class responsable{

    private $rnumeroempleado;
    private $rnumerolicencia;
    private $rnombre;
    private $rapellido;
    private $mensajeOperacion;

    public function __construct()
    {
        $this-> rnumeroempleado = "";
        $this-> rnumerolicencia = "";
        $this-> rnombre = "";
        $this-> rapellido = "";
        $this->mensajeOperacion = "";
    }

/********************************************************************************************** */

    public function get_nro_empleado(){
        return $this->rnumeroempleado;
    }

    public function get_nro_licencia(){
        return $this->rnumerolicencia;
    }

    public function get_nombre(){
        return $this->rnombre;
    }

    public function get_apellido(){
        return $this->rapellido;
    }

    public function get_mensajeOperacion(){
        return $this->mensajeOperacion;
    }

/********************************************************************************************** */

    public function set_nro_empleado($rnumeroempleado){
        $this->rnumeroempleado = $rnumeroempleado;
    }

    public function set_nro_licencia($rnumerolicencia){
        $this-> rnumerolicencia = $rnumerolicencia;
    }

    public function set_nombre($rnombre){
        $this->rnombre = $rnombre;
    }

    public function set_apellido($rapellido){
        $this->rapellido = $rapellido;
    }

    public function set_mensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

/********************************************************************************************** */

    public function __toString()
    {
        return
        "\n"."------------------- RESPONSABLE -------------------"."\n".
        "numero de empleado: ". $this->get_nro_empleado()."\n".
        "numero de licencia: ". $this->get_nro_licencia()."\n".
        "nombre del responsable: ". $this->get_nombre()."\n".
        "apellido del responsable: ". $this->get_apellido()."\n";
    }

/********************************************************************************************** */

    public function cargarDatos($rnombre,$rapellido,$rnumeroempleado,$rnumerolicencia){
        $this->set_nombre($rnombre);
        $this->set_apellido($rapellido);
        $this->set_nro_empleado($rnumeroempleado);
        $this->set_nro_licencia($rnumerolicencia);
    }

/********************************************************************************************** */

    public function buscarResponsable($rnumeroempleado){

        $baseDeDatos = new BaseDatos();

        $consultaBuscar = "SELECT * FROM responsable WHERE rnumeroempleado = ". $rnumeroempleado;

        $resultado = false;

        if ($baseDeDatos->Iniciar()){
            if($baseDeDatos->Ejecutar($consultaBuscar)){
                if ($lista = $baseDeDatos->Registro()){
                    $this->cargarDatos($lista["rnombre"],$lista["rapellido"],$lista["rnumeroempleado"],$lista["rnumerolicencia"]);
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

    public function insertarResponsable(){

        $baseDeDatos = new BaseDatos();

        $consultaInsert = " INSERT INTO responsable (rnumerolicencia,rnombre,rapellido) VALUES 
        (". $this->get_nro_licencia(). ",'". $this->get_nombre(). "','". $this->get_apellido()."')"; 

        $resultado = false;

        if($baseDeDatos->Iniciar()){
            if($id = $baseDeDatos->devuelveIDInsercion($consultaInsert)){
                $this->set_nro_empleado($id);
                $resultado = true;
            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }
        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $resultado;

    }

    public function eliminarResponsable(){

        $baseDeDatos = new BaseDatos();

        $consultaDelete = "DELETE FROM responsable WHERE rnumeroempleado = ". $this->get_nro_empleado();

        $resultado = true;

        if( $baseDeDatos->Iniciar()){
            if( $baseDeDatos->Ejecutar($consultaDelete)){
                $resultado = true;
            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }
        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $resultado;

    }

    public function actualizarResponsable(){

        $baseDeDatos = new BaseDatos();

        $consultaUpdate = "UPDATE responsable SET rnumerolicencia='".$this->get_nro_licencia()."'
        ,rnombre='".$this->get_nombre()."',rapellido = '". $this->get_apellido()."' WHERE rnumeroempleado =". $this->get_nro_empleado();

        $resultado = true;

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

    public function listarResponsables($condicion = ""){

        $baseDeDatos = new BaseDatos();

        $arregloResponsables = null;

        $consultaListar = "SELECT * FROM responsable ";

        if( $condicion != ""){
            $consultaListar = $consultaListar.' where '.$condicion;
        }

        $consultaListar = $consultaListar. ' ORDER BY rapellido';

        if($baseDeDatos->Iniciar()){
            if($baseDeDatos->Ejecutar($consultaListar)){
                $arregloResponsables = [];
                while ( $lista = $baseDeDatos->Registro()){

                    $nombre = $lista["rnombre"];
                    $apellido = $lista["rapellido"];
                    $nroEmpleado = $lista["rnumeroempleado"];
                    $nroLicencia = $lista["rnumerolicencia"];

                    $responsable = new responsable ();
                    $responsable->cargarDatos($nombre,$apellido,$nroEmpleado,$nroLicencia);
                    $arregloResponsables[] = $responsable; 

                }

            }else{
                $this->set_mensajeOperacion($baseDeDatos->getError());
            }

        }else{
            $this->set_mensajeOperacion($baseDeDatos->getError());
        }

        return $arregloResponsables;

    }


}