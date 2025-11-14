<?php
class DataBase {
    private static $connection = null;

    public static function connect($host = 'localhost', $user = 'root', $pass = '', $db = 'netflixeats') {
        if (self::$connection === null) {
            self::$connection = new mysqli($host, $user, $pass, $db);

            if (self::$connection->connect_error) {
                die('Error al conectar a la base de datos: ' . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }

    public static function close() {
        if (self::$connection !== null) {
            self::$connection->close();
            self::$connection = null;
        }
    }
}