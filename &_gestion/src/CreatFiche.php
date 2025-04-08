<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class FicheManager
{
    private $con;
    private $mailer;

    public function __construct($dbConnection)
    {
        $this->con = $dbConnection;
        $this->mailer = new PHPMailer(true);
    }

    public function createFiche($data)
    {
        $date_creat_fiche = gmdate('Y-m-d H:i:s');
        $beficiaire_fiche = addslashes($data['beficiaire_fiche']);
        $affectation_id = addslashes($data['affectation_id']);
        $chantier_id = addslashes($data['chantier_id']);
        $montant_fiche = addslashes($data['montant_fiche']);
        $tel_beneficiaire_fiche = addslashes($data['tel_beneficiaire_fiche']);
        $num_piece = addslashes($data['num_piece']);
        $designation_fiche = addslashes($data['designation_fiche']);
        $precision_fiche = addslashes($data['precision_fiche']);
        $serv_bureau_banamur_id = $data['serv_bureau_banamur_id'];
        $serv_bureau_fidest_id = $data['serv_bureau_fidest_id'];
        $serv_rh_id = $data['serv_rh_id'];
        $serv_log_id = $data['serv_log_id'];

        // Nouveaux champs
        $etat_fiche = $data['etat_fiche'];
        $secur_valid = $data['secur_valid'];
        $photo_beneficiaire = $data['photo_beneficiaire'];
        $secur_decaisse = $data['secur_decaisse'];
        $cni_beneficiaire = $data['cni_beneficiaire'];
        $secur_approuve = $data['secur_approuve'];
        $date_approuve = $data['date_approuve'];
        $approuve = $data['approuve'];
        $signature_beneficiaire = $data['signature_beneficiaire'];
        $conforme = $data['conforme'];
        $secur_conforme = $data['secur_conforme'];
        $date_conforme = $data['date_conforme'];

        if ($affectation_id != 1) {
            $designation_fiche = $data['designation_fiche'];
        }

        $fch = $this->con->prepare('SELECT * FROM fiche');
        $fch->execute();
        $nfc = $fch->rowCount();
        $num_fiche = '0' . $nfc;

        $_SESSION['num_fiche'] = $num_fiche;

        $req = $this->con->prepare('
            INSERT INTO fiche (
                beficiaire_fiche, montant_fiche, tel_beneficiaire_fiche, date_creat_fiche, num_fiche, affectation_id, 
                designation_fiche, num_piece, chantier_id, precision_fiche, serv_bureau_banamur_id, 
                serv_bureau_fidest_id, serv_rh_id, serv_log_id, 
                etat_fiche, secur_valid, photo_beneficiaire, secur_decaisse, cni_beneficiaire, 
                secur_approuve, date_approuve, approuve, signature_beneficiaire, conforme, secur_conforme, date_conforme
            ) VALUES (
                :A, :B, :C, :D, :E, :F, :G, :H, :I, :J, :K, :L, :M, :N, 
                :O, :P, :Q, :R, :S, :T, :U, :V, :W, :X, :Y, :Z
            )
        ');

        $req->execute([
            'A' => $beficiaire_fiche,
            'B' => $montant_fiche,
            'C' => $tel_beneficiaire_fiche,
            'D' => $date_creat_fiche,
            'E' => $num_fiche,
            'F' => $affectation_id,
            'G' => $designation_fiche,
            'H' => $num_piece,
            'I' => $chantier_id,
            'J' => $precision_fiche,
            'K' => $serv_bureau_banamur_id,
            'L' => $serv_bureau_fidest_id,
            'M' => $serv_rh_id,
            'N' => $serv_log_id,
            'O' => $etat_fiche,
            'P' => $secur_valid,
            'Q' => $photo_beneficiaire,
            'R' => $secur_decaisse,
            'S' => $cni_beneficiaire,
            'T' => $secur_approuve,
            'U' => $date_approuve,
            'V' => $approuve,
            'W' => $signature_beneficiaire,
            'X' => $conforme,
            'Y' => $secur_conforme,
            'Z' => $date_conforme
        ]);

        if ($affectation_id == 18 || $affectation_id == 19) {
            $this->sendMail($beficiaire_fiche, $montant_fiche, $designation_fiche, $num_fiche, $affectation_id);
        }
    }


    private function sendMail($beficiaire_fiche, $montant_fiche, $designation_fiche, $num_fiche, $affectation_id)
    {
        try {
            $this->mailer->SMTPDebug = 0;
            $this->mailer->isSMTP();
            $this->mailer->Host = 'mail.fidest.ci';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = "support@fidest.ci";
            $this->mailer->Password = "@Succes2019";
            $this->mailer->SMTPSecure = "ssl";
            $this->mailer->Port = 465;

            $this->mailer->From = "support@fidest.ci";
            $this->mailer->FromName = "SUPPORT FIDEST";

            $this->mailer->addAddress("amichia@fidest.org", "Amichia KANE");
            $this->mailer->addBCC("amani_ulrich@outlook.fr", "Ulrich AMANI");
            $this->mailer->addCC("babymelissa777@gmail.com", "Baby HONOKA");

            $this->mailer->isHTML(true);

            $dest_fiche = $affectation_id == 18 ? "BUREAU FIDEST" : "BUREAU BANAMUR";

            $this->mailer->Subject = "CREATION FICHE " . $dest_fiche;
            $this->mailer->Body = "
                <b>{$beficiaire_fiche}</b> a émis une demande d'un montant de <b>{$montant_fiche}</b> pour <b>{$designation_fiche}</b> 
                Détails : fiche N° <b>{$num_fiche}</b><br>
                <a href='https://fidest.ci/logi/&_gestion/exportation/pdf/pdf_fiche.php?num_fiche={$num_fiche}'>Visualiser la fiche</a>
            ";

            $this->mailer->AltBody = "Détails";

            $this->mailer->send();
            echo "Message envoyé avec succès";
        } catch (Exception $e) {
            echo "Erreur d'envoi du mail: " . $this->mailer->ErrorInfo;
        }
    }
}
