<?php
require_once "./entities/User.php";
require_once "./entities/Preguntas.php";
require_once "./entities/Examen.php";
require_once "./entities/Tematica.php";

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

    public static function getUser($email, $password): User
    {
        $consulta = self::$conexion->query("select * from autoescuela where correo ='$email' and password='$password'");

        while ($user_info = $consulta->fetch()) {
            $user = new User(array(
                'ID' => $user_info['id'], 'Email' => $user_info['email'],
                'Nombre' => $user_info['nombre'], 'Apellidos' => $user_info['apellidos'], 'Password' => $user_info['password'], 'Rol' => $user_info['rol'], 'Foto' => $user_info['foto']
            ));
        }

        return $user;
    }

    public static function insertUser($email, $nombre, $apellidos, $password, $nacimiento, $rol, $foto)
    {
        self::conectarPDO();
        self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$consulta = "INSERT INTO `usuario` (NULL,'$email','$nombre', '$apellidos', '$password', '$nacimiento','$rol','$foto', 0)";
        $consulta = "INSERT INTO `usuario` (`id`, `email`, `nombre`, `apellidos`, `password`, `nacimiento`, `rol`, `foto`) VALUES (NULL, '$email', '$nombre', '$apellidos', '$password', '$nacimiento','$rol','$foto')";
        if (self::$conexion->exec($consulta)) {
            return true;
        } else {
            return false;
        }
    }

    public static function existsUser($email)
    {
        self::conectarPDO();
        $consulta = self::$conexion->query("select email from usuario where email ='$email'");
        if ($consulta) {
            return true;
        } else {
            return false;
        }
    }

    public static function getThematics(): array
    {
        self::conectarPDO();
        $consulta = self::$conexion->query("select * from tematica");

        while ($tematica_info = $consulta->fetch()) {
            $tematica = new Tematica(array(
                'id' => $tematica_info['id'], 'tema' => $tematica_info['tema']
            ));
            $tematicas[] = $tematica;
        }

        return $tematicas;
    }

    public static function insertThematic($tema)
    {
        self::conectarPDO();
        self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "INSERT INTO `tematica` (`id`, `tema`) VALUES (NULL, '$tema')";
        if (self::$conexion->exec($consulta)) {
            return true;
        } else {
            return false;
        }
    }

    public static function existsThematic($tema)
    {
        self::conectarPDO();
        $consulta = self::$conexion->query("select tema from usuario where tema ='$tema'");
        if ($consulta) {
            return true;
        } else {
            return false;
        }
    }
}
