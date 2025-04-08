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

    public function searchFiches($beneficiaire, $statut, $date_debut, $date_fin, $date_decaissement, $chantier, $affectation)
    {
        $sql = "SELECT * FROM fiche WHERE  etat_fiche = 1 
                AND decaisse = 0 
                AND sauvegarder = 0 
                AND otp_autorise = 1 ";

        if ($beneficiaire) {
            $sql .= " AND beficiaire_fiche LIKE :beneficiaire";
        }
        if ($statut) {
            $sql .= " AND etat_fiche = :statut";
        }
        if ($date_debut) {
            $sql .= " AND date_creat_fiche >= :date_debut";
        }
        if ($date_fin) {
            $sql .= " AND date_creat_fiche <= :date_fin";
        }
        if ($date_decaissement) {
            $sql .= " AND date_decaissement_fiche = :date_decaissement";
        }
        if ($chantier) {
            $sql .= " AND chantier_id = :chantier";
        }
        if ($affectation) {
            $sql .= " AND affectation_id = :affectation";
        }

        $stmt = $this->pdo->prepare($sql);

        if ($beneficiaire) {
            $stmt->bindValue(':beneficiaire', "%$beneficiaire%");
        }
        if ($statut) {
            $stmt->bindValue(':statut', $statut);
        }
        if ($date_debut) {
            $stmt->bindValue(':date_debut', $date_debut);
        }
        if ($date_fin) {
            $stmt->bindValue(':date_fin', $date_fin);
        }
        if ($date_decaissement) {
            $stmt->bindValue(':date_decaissement', $date_decaissement);
        }
        if ($chantier) {
            $stmt->bindValue(':chantier', $chantier);
        }
        if ($affectation) {
            $stmt->bindValue(':affectation', $affectation);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
