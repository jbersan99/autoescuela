<?php
class Validator
{
    //Array de errores
    private $errores;

    //Constructor
    public function __construct()
    {
        $this->errores=array();
    }

    /**
     * Comprueba si esta vacio
     *
     * @param [type] $campo
     * @return boolean
     */ 
    public function Requerido($campo)
    {
        if(!isset($_POST[$campo]) || empty($_POST[$campo]))
        {
            $this->errores[$campo]="El campo $campo no puede estar vacio";
            return false;
        }
        return true;
    }

    public function EsIgual($campo_01, $campo_02)
    {
        if($campo_01 != $campo_02)
        {
            $this->errores[$campo_01]="El campo $campo_01 y el $campo_02 no pueden ser distintos";
            return false;
        }
        return true;
    }
}

?>
