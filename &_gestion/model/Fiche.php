<?php
class Fiche
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les fiches à décaisser aujourd'hui
     *
     * @return array
     */
    public function getFichesADecaisser()
    {
        $sql = 'SELECT * FROM fiche 
                WHERE etat_fiche = 1 
                AND decaisse = 0 
                AND sauvegarder = 0 
                AND otp_autorise = 1 
                ORDER BY id_fiche ASC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne le nombre de fiches à décaisser
     *
     * @return int
     */
    public function countFichesADecaisser()
    {
        $sql = 'SELECT COUNT(*) FROM fiche 
                WHERE etat_fiche = 1 
                AND decaisse = 0 
                AND sauvegarder = 0 
                AND otp_autorise = 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
