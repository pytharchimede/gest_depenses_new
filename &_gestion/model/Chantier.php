<?php

class Chantier
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les chantiers
     *
     * @return array
     */
    public function getAllChantier()
    {
        $sql = 'SELECT * FROM chantier';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une chantier par son ID
     *
     * @param int $id_chantier
     * @return array|null
     */
    public function getChantierById($id_chantier)
    {
        $sql = 'SELECT * FROM chantier WHERE id_chantier = :id_chantier';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_chantier', $id_chantier, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne null si l'chantier n'existe pas
    }
}
