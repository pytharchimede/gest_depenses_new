<?php

class Affectation
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les affectations
     *
     * @return array
     */
    public function getAllAffectation()
    {
        $sql = 'SELECT * FROM affectation';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une affectation par son ID
     *
     * @param int $id_affectation
     * @return array|null
     */
    public function getAffectationById($id_affectation)
    {
        $sql = 'SELECT * FROM affectation WHERE id_affectation = :id_affectation';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_affectation', $id_affectation, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne null si l'affectation n'existe pas
    }
}
