<?php
    require_once('../entities/User.php');
    require_once('../entities/Preguntas.php');
    require_once('../entities/Examen.php');

    class DB
    {
        private static $conexion;

        private static $usuario = "root";
        private static $contraseña = "";

        public static function conectarPDO()
        {
            self::$conexion = new PDO('mysql:host=localhost;dbname=autoescuela', self::$usuario, self::$contraseña);
        }

    }

?>