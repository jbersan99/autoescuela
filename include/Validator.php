<?php
class Validator
{
    //Array de errores
    public $errores;

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

}
