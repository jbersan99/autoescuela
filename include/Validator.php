<?php
class Validator
{
    public $errores;

    public function __construct()
    {
        $this->errores=array();
    }

    public function Requerido($campo)
    {
        if(!isset($_POST[$campo]) || empty($_POST[$campo]))
        {
            $this->errores[$campo]="El campo $campo no puede estar vacio";
            return false;
        }
        return true;
    }

    public function EmailValido($email)
    {
        $patron_email = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
        if(preg_match($patron_email, $email)){
            return true;
        }else{
            return false;
        }
    }

    public function NombreValido($nombre)
    {
        $patron_nombre = "/^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/";
        if(preg_match($patron_nombre, $nombre)){
            return true;
        }else{
            return false;
        }
    }

}
