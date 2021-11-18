<?php
require_once "./entities/User.php";
require_once "./entities/Preguntas.php";
require_once "./entities/Examen.php";

class DB
{
    private static $conexion;

    private static $usuario = "root";
    private static $contraseña = "";

    public static function conectarPDO()
    {
        self::$conexion = new PDO('mysql:host=localhost;dbname=autoescuela', self::$usuario, self::$contraseña);
    }

    public static function thereisUser($email, $password)
    {
        $query = self::$conexion->query("SELECT * FROM autoescuela " . "WHERE email='$email' " . "AND password='" . $password . "'");
        if ($resultado = $query->fetch()) {
            $fila = $resultado->fetch();
            return ($fila != null);
        }
    }

    public static function getUser($email, $password):User
    {
        $consulta = self::$conexion->query("select * from autoescuela where correo ='$email' and password='$password'");

        while ($user_info = $consulta->fetch()) {
            $user = new User(array(
                'ID' => $user_info['id'], 'Email' => $user_info['email'],
                'Nombre' => $user_info['nombre'], 'Apellidos' => $user_info['apellidos']
                , 'Password' => $user_info['password'], 'Rol' => $user_info['rol']
                , 'Foto' => $user_info['foto'], 'Activo' => $user_info['activo']
            ));
        }

        return $user;
    }
}
