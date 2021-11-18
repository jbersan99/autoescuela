<?php
require_once "./entities/User.php";
require_once "Sesion.php";
require_once "DB.php";
class Login
{
    public static function doLogin(string $email, string $password, bool $recuerdame)
    {
        if (self::thereisUser($email, $password)) {
            Sesion::iniciar();
            Sesion::escribir('login_email', $email);
            Sesion::escribir('login_pass', $password);
            if ($recuerdame) {
                setcookie('email_recuerda', $email, time() + 30 * 24 * 60 * 60);
                setcookie('pass_recuerda', $password, time() + 30 * 24 * 60 * 60);
            }
            return true;
        }
        return false;
    }

    private static function thereisUser(string $email, string $password)
    {
        DB::conectarPDO();
        return DB::thereisUser($email, $password);
    }

    public static function UserisLogged()
    {
        if (Sesion::leer('login')) {
            return true;
        } elseif (isset($_COOKIE['email_recuerda']) && isset($_COOKIE['pass_recuerda']) && self::thereisUser($_COOKIE['email_recuerda'], $_COOKIE['pass_recuerda'])) {
            Sesion::iniciar();
            Sesion::escribir('login_email', $_COOKIE['email_recuerda']);
            Sesion::escribir('login_pass', $_COOKIE['pass_recuerda']);
            return true;
        }
        return false;
    }
}
