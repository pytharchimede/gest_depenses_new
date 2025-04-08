<?php
require_once 'Database.php'; // Assure-toi que le chemin est correct

class Visite
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function enregistrerVisite($ip, $date = null, $heure = null)
    {
        $date = $date ?? date('Y-m-d');
        $heure = $heure ?? time();

        $stmt = $this->db->prepare("INSERT INTO visite (ip, date, heure) VALUES (:ip, :date, :heure)");
        $stmt->bindParam(':ip', $ip);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':heure', $heure);

        return $stmt->execute();
    }
}
