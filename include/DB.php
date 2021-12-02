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
        $consulta = self::$conexion->query("select COUNT(id) from usuario where email ='$email' and password='$password'");
        $numero = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($numero['COUNT(id)'] > 0) {
            return "Las credenciales son validas";
        } else {
            return "Las credenciales son invalidas";
        }
    }

    public static function getUser($email, $password): User
    {
        $consulta = self::$conexion->query("select * from usuario where email ='$email' and password='$password'");

        while ($user_info = $consulta->fetch(PDO::FETCH_ASSOC)) {
            if ($user_info != null) {
                $user = new User($user_info);
            } else {
                $user = "No hay usuario";
            }
        }

        return $user;
    }

    public static function insertUser($email, $nombre, $apellidos, $password, $nacimiento, $rol, $foto)
    {
        self::conectarPDO();
        self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$consulta = "INSERT INTO `usuario` (NULL,'$email','$nombre', '$apellidos', '$password', '$nacimiento','$rol','$foto', 0)";
        $consulta = "INSERT INTO `usuario` (`id`, `email`, `nombre`, `apellidos`, `password`, `nacimiento`, `rol`, `foto`) VALUES (DEFAULT, '$email', '$nombre', '$apellidos', '$password', '$nacimiento','$rol','$foto')";
        if (self::$conexion->exec($consulta)) {
            return true;
        } else {
            return false;
        }
    }

    public static function existsUser($email)
    {
        self::conectarPDO();

        $query = "SELECT * FROM usuario WHERE email = '$email'";
        $query_res = self::$conexion->query($query);
        $count = count($query_res->fetchAll());
        if ($count > 0) {
            return "Existe";
        } else {
            return "No existe";
        }
    }

    public static function getUsers(): array
    {
        self::conectarPDO();
        $consulta = self::$conexion->query("select * from usuario");

        if (self::getAllUsers() > 0) {
            while ($user_info = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $user = new User($user_info);
                $usuarios[] = $user;
            }

            return $usuarios;
        } else {
            $usuarios[] = "No hay usuarios";
            return $usuarios;
        }
    }

    public static function getAllUsers(): int
    {
        self::conectarPDO();

        $stmt = self::$conexion->query("SELECT COUNT(id) FROM usuario");
        $numero = $stmt->fetch();
        return $numero['COUNT(id)'];
    }

    public static function insertMassiveUsers($all_data)
    {
        self::conectarPDO();
        self::$conexion->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 0);
        foreach ($all_data as $data) {
            $sql = self::$conexion->prepare("INSERT INTO usuario (id, email, nombre, apellidos, password, nacimiento, rol, foto) 
            VALUES (DEFAULT, :email, :nombre, :apellidos, :password, :nacimiento, :rol, :foto)");
            $sql->bindParam(':email', $data[0], PDO::PARAM_STR, 35);
            $sql->bindParam(':nombre', $data[1], PDO::PARAM_STR, 20);
            $sql->bindParam(':apellidos', $data[2], PDO::PARAM_STR, 25);
            $sql->bindParam(':password', $data[3], PDO::PARAM_STR, 18);
            $sql->bindParam(':nacimiento', $data[4], PDO::PARAM_STR, 10);
            $sql->bindParam(':rol', $data[5], PDO::PARAM_STR, 10);
            $sql->bindParam(':foto', $data[6], PDO::PARAM_LOB);
            $sql->execute();
        }
    }

    public static function getThematic($id): Tematica
    {
        $consulta = self::$conexion->query("select * from tematica where id = $id");

        while ($tematica_info = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $tematica = new Tematica($tematica_info);
        }

        return $tematica;
    }

    public static function getThematics(): array
    {
        self::conectarPDO();
        $consulta = self::$conexion->query("select * from tematica");

        if (self::getAllThematics() > 0) {
            while ($tematica_info = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $tematica = new Tematica($tematica_info);
                $tematicas[] = $tematica;
            }

            return $tematicas;
        } else {
            $tematicas[] = "No hay tematicas";
            return $tematicas;
        }
    }

    public static function insertThematic($tema)
    {
        self::conectarPDO();
        self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "INSERT INTO `tematica` (`id`, `tema`) VALUES (DEFAULT, '$tema')";
        if (self::$conexion->exec($consulta)) {
            return true;
        } else {
            return false;
        }
    }

    public static function existsThematic($tema)
    {
        self::conectarPDO();

        $query = "SELECT * FROM tematica WHERE tema = '$tema'";
        $query_res = self::$conexion->query($query);
        $count = count($query_res->fetchAll());
        if ($count > 0) {
            return "Existe";
        } else {
            return "No existe";
        }
    }

    public static function getAllThematics(): int
    {
        self::conectarPDO();

        $stmt = self::$conexion->query("SELECT COUNT(id) FROM tematica");
        $numero = $stmt->fetch();
        return $numero['COUNT(id)'];
    }

    public static function insertQuestion($enunciado_pregunta, $id_respuesta_correcta, $recurso, $id_tematica): int
    {
        self::conectarPDO();
        self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "INSERT INTO `preguntas`(`id`, `enunciado_pregunta`, `respuesta_correcta`, `recurso`, `id_tematica`) VALUES (DEFAULT, '$enunciado_pregunta', $id_respuesta_correcta, '$recurso', $id_tematica)";
        if (self::$conexion->exec($consulta)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllQuestions(): int
    {
        self::conectarPDO();

        $stmt = self::$conexion->query("SELECT COUNT(id) FROM preguntas");
        $numero = $stmt->fetch();
        return $numero['COUNT(id)'];
    }

    public static function getQuestions(): array
    {
        self::conectarPDO();
        $consulta = self::$conexion->query("select * from preguntas");

        if (self::getAllQuestions() < 0) {
            while ($pregunta_info = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $pregunta = new Preguntas($pregunta_info);
                $preguntas[] = $pregunta;
            }

            return $preguntas;
        } else {
            $preguntas[] = "No hay preguntas";
            return $preguntas;
        }
    }

    public static function insertMassiveQuestions($all_data)
    {
        self::conectarPDO();
        self::$conexion->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 0);
        foreach ($all_data as $data) {
            $sql = self::$conexion->prepare("INSERT INTO preguntas (id, enunciado_pregunta, respuesta_correcta, recurso, id_tematica)
            VALUES (DEFAULT, :enunciado_pregunta, :respuesta_correcta, :recurso, :id_tematica)");
            $sql->bindParam(':enunciado_pregunta', $data[0], PDO::PARAM_STR, 350);
            $sql->bindParam(':respuesta_correcta', $data[1], PDO::PARAM_INT, 11);
            $sql->bindParam(':recurso', $data[2], PDO::PARAM_LOB);
            $sql->bindParam(':id_tematica', $data[3], PDO::PARAM_INT, 11);
            $sql->execute();

            $sql2 = self::$conexion->prepare("INSERT INTO `respuesta`(`id`, `enunciado_respuesta`, `id_pregunta`) 
            VALUES (DEFAULT, ':enunciado_respuesta', :id_pregunta)");
            $sql->bindParam(':enunciado_respuesta', $data[5], PDO::PARAM_STR, 350);
            $sql->bindParam(':id_pregunta', $data[6], PDO::PARAM_INT, 11);
            $sql2->execute();
        }
    }

    public static function insertAnswer($enunciado_respuesta, $id_pregunta)
    {
        self::conectarPDO();
        self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "INSERT INTO `respuesta`(`id`, `enunciado_respuesta`, `id_pregunta`) VALUES (DEFAULT, '$enunciado_respuesta', $id_pregunta)";
        if (self::$conexion->exec($consulta)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllAnswers(): int
    {
        self::conectarPDO();

        $stmt = self::$conexion->query("SELECT COUNT(id) FROM respuesta");
        $numero = $stmt->fetch();
        return $numero['COUNT(id)'];
    }
}
