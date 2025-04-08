<?php
class Database
{
    private static $host = 'localhost';
    private static $dbname = 'fidestci_app_db';
    private static $username = 'fidestci_ulrich';
    private static $password = '@Succes2019';
    private static $conn = null;

    public static function getConnection()
    {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    'mysql:host=' . self::$host . ';dbname=' . self::$dbname . ';charset=utf8',
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }

        return self::$conn;
    }
}
