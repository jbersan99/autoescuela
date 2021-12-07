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

    public static function insertUser($email, $nombre, $password, $nacimiento, $rol, $foto, $confirmado)
    {
        self::conectarPDO();
        self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "INSERT INTO `usuario` (`id`, `email`, `nombre`, `password`, `nacimiento`, `rol`, `foto`, `confirmado`) VALUES (DEFAULT, '$email', '$nombre', '$password', '$nacimiento','$rol','$foto', '$confirmado')";
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
            $sql = self::$conexion->prepare("INSERT INTO usuario (id, email, nombre, password, nacimiento, rol, foto, confirmado) 
            VALUES (DEFAULT, :email, :nombre, :password, :nacimiento, :rol, :foto, :confirmado)");
            $sql->bindParam(':email', $data[0], PDO::PARAM_STR, 35);
            $sql->bindParam(':nombre', $data[1], PDO::PARAM_STR, 20);
            $sql->bindParam(':password', $data[2], PDO::PARAM_STR, 18);
            $sql->bindParam(':nacimiento', $data[3], PDO::PARAM_STR, 10);
            $sql->bindParam(':rol', $data[4], PDO::PARAM_STR, 10);
            $sql->bindParam(':foto', $data[5], PDO::PARAM_LOB);
            $sql->execute();
        }
    }

    public static function getLastUser(): int
    {
        self::conectarPDO();
        $consulta = self::$conexion->query("SELECT id FROM usuario ORDER BY id DESC LIMIT 0, 1");
        $numero = $consulta->fetch();
        return $numero[0];
    }

    public static function updatePass($password, $id, $confirmado)
    {
        self::conectarPDO();

        $sql = "UPDATE usuario SET password=? WHERE id=?";
        self::$conexion->prepare($sql)->execute([$password, $id]);

        $sql = "UPDATE usuario SET confirmado=? WHERE id=?";
        self::$conexion->prepare($sql)->execute([$confirmado, $id]);
        return true;
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

        if (self::getAllQuestions() > 0) {
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

    public static function getLastQuestion(): int
    {
        self::conectarPDO();
        $consulta = self::$conexion->query("SELECT id FROM preguntas ORDER BY id DESC LIMIT 0, 1");
        $numero = $consulta->fetch();
        return $numero[0] + 1;
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

            $last_question = self::getLastQuestion();

            $sql2 = self::$conexion->prepare("INSERT INTO respuesta (id, enunciado_respuesta, id_pregunta) 
            VALUES (DEFAULT, ':enunciado_respuesta', :id_pregunta)");
            $sql2->bindParam(':enunciado_respuesta', $data[4], PDO::PARAM_STR, 350);
            $sql2->bindParam(':id_pregunta', $last_question, PDO::PARAM_INT, 11);
            $sql2->execute();
            if ($data[1] == 1) {
                $select_01 = self::$conexion->query("SELECT id FROM respuesta ORDER BY id DESC LIMIT 0, 1");
                $numero = $select_01->fetch(PDO::FETCH_ASSOC);
                $update_01 = self::$conexion->query("UPDATE preguntas SET respuesta_correcta=$numero[id] WHERE id=$last_question");
                self::$conexion->query($update_01);
            }
            $sql3 = self::$conexion->prepare("INSERT INTO respuesta (id, enunciado_respuesta, id_pregunta) 
            VALUES (DEFAULT, ':enunciado_respuesta', :id_pregunta)");
            $sql3->bindParam(':enunciado_respuesta', $data[5], PDO::PARAM_STR, 350);
            $sql3->bindParam(':id_pregunta', $last_question, PDO::PARAM_INT, 11);
            $sql3->execute();
            if ($data[1] == 2) {
                $select_02 = self::$conexion->query("SELECT id FROM respuesta ORDER BY id DESC LIMIT 0, 1");
                $numero = $select_02->fetch(PDO::FETCH_ASSOC);
                $update_02 = self::$conexion->query("UPDATE preguntas SET respuesta_correcta=$numero[id] WHERE id=$last_question");
                self::$conexion->query($update_02);
            }

            $sql4 = self::$conexion->prepare("INSERT INTO  respuesta (id, enunciado_respuesta, id_pregunta) 
            VALUES (DEFAULT, ':enunciado_respuesta', :id_pregunta)");
            $sql4->bindParam(':enunciado_respuesta', $data[6], PDO::PARAM_STR, 350);
            $sql4->bindParam(':id_pregunta', $last_question, PDO::PARAM_INT, 11);
            $sql4->execute();
            if ($data[1] == 3) {
                $select_03 = self::$conexion->query("SELECT id FROM respuesta ORDER BY id DESC LIMIT 0, 1");
                $numero = $select_03->fetch(PDO::FETCH_ASSOC);
                $update_03 = self::$conexion->query("UPDATE preguntas SET respuesta_correcta=$numero[id] WHERE id=$last_question");
                self::$conexion->query($update_03);
            }

            $sql5 = self::$conexion->prepare("INSERT INTO respuesta (id, enunciado_respuesta, id_pregunta) 
            VALUES (DEFAULT, ':enunciado_respuesta', :id_pregunta)");
            $sql5->bindParam(':enunciado_respuesta', $data[7], PDO::PARAM_STR, 350);
            $sql5->bindParam(':id_pregunta', $last_question, PDO::PARAM_INT, 11);
            $sql5->execute();
            if ($data[1] == 4) {
                $select_04 = self::$conexion->query("SELECT id FROM respuesta ORDER BY id DESC LIMIT 0, 1");
                $numero = $select_04->fetch(PDO::FETCH_ASSOC);
                $update_04 = self::$conexion->query("UPDATE preguntas SET respuesta_correcta=$numero[id] WHERE id=$last_question");
                self::$conexion->query($update_04);
            }
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

    public static function insertExam($descripcion, $duracion, $id_preguntas)
    {
        self::conectarPDO();
        self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "INSERT INTO examen (id, descripcion, duracion, id_preguntas) VALUES (DEFAULT, '$descripcion', $duracion, '$id_preguntas')";
        if (self::$conexion->exec($consulta)) {
            return true;
        } else {
            return false;
        }
    }
}
