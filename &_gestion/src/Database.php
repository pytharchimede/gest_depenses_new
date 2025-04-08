<?php
class Database
{
    private $host = 'localhost';
    private $dbname = 'fidestci_app_db'; // Remplace par le nom de ta base de données
    private $username = 'fidestci_ulrich'; // Remplace par ton nom d'utilisateur
    private $password = '@Succes2019'; // Remplace par ton mot de passe
    private $con;

    public function __construct()
    {
        try {
            $this->con = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erreur de connexion : ' . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->con;
    }
}
