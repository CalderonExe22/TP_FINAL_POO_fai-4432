<?php



class validar{

    public function solo_letras($cadena){
        $exprecionRegular = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
        return preg_match($exprecionRegular,$cadena);
        
    }

    public function solo_numeros($cadena){
        
    }

}