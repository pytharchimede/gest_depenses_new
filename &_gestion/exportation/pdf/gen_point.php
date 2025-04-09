<?php

session_start ();

$_SESSION['recher_date_debut']=gmdate('Y-m-d 00:00:00');
$_SESSION['recher_affectation']='';
$_SESSION['recher_chantier']='';
$_SESSION['recher_date_fin']='';

$date_decaissement=date("Y-m-d", strtotime($_SESSION['recher_date_debut']));
//Send mail

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/phpmailer/src/Exception.php';
require_once __DIR__ . '/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->SMTPDebug = 0;
$mail->isSMTP();
$mail->Host = 'mail.fidest.ci';
$mail->SMTPAuth = true;
$mail->Username = "support@fidest.ci";
$mail->Password = "@Succes2019";
$mail->SMTPSecure = "ssl";
$mail->Port = 465;

$mail->From = "support@fidest.ci";
$mail->FromName = "SUPPORT FIDEST";

//$mail->addAddress("braud@banamur.com", "Alex BRAUD");
$mail->addAddress("amani_ulrich@outlook.fr", "Ulrich AMANI");

$mail->isHTML(true);

$mail->Subject = "POINT JOURNALIER";
$mail->Body = "Ce mail contient une pi&egrave;ce jointe : <br> <ol><li>La liste des d&eacute;caissements du jour (nomm&eacute; demande_decaissees..pdf)</li></ol>";
$mail->AltBody = "DETAILS";

//Creation PDF
 include('../../../connex.php');
	 
	include("../../../pdf/phpToPDF.php");

	require('../../../pdf/mysql_table.php');

class PDF extends PDF_MySQL_Table
{
    
function Header()
{
           
 
}
// Pied de page
function Footer()
{
	// Position at 1.5 cm from bottom
    $this->SetY(-22);
	
    $this->Image('../../../img/logo_veritas.jpg', 10,275,30);	
    // Arial italic 8
    $this->SetFont('Arial','',7);

	$this->Cell(0,3.5,utf8_decode("FOURNITURES INDUSTRIELLES, DEPANNAGE ET TRAVAUX PUBLIQUES"),0,1,'C');
	$this->Cell(0,3.5,utf8_decode('Au capital de 10 000 000 F CFA - Siège Social : Abidjan, Koumassi, Zone industrielle '),0,1,'C');
	$this->Cell(0,3.5,utf8_decode("01 BP 1642 Abidjan 01 - Téléphone : (+225) +225 27-21-36-27-27  -  Email : info@fidest.org"),0,1,'C');
	$this->Cell(0,3.5,utf8_decode('RCCM : CI-ABJ-2017-B-20163  -  N° CC : 010274200088 '),0,1,'C');
	
	$this->Image('../../../img/logo_connex.jpg', 172,275,30);	
	
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	
} 
}
            
			//Paramètres du fichier PDF 
			$pdffilename = 'demandes_decaissees_'.gmdate('d_m_Y_H_i').'_.pdf';
			clearstatcache();
			if (file_exists($pdffilename)) {
			//Si le fichier PDF existe, il faut le supprimer d'abord
			unlink($pdffilename);
			}
			 
			//Création du fichier PDF
			$pdf=new PDF('L','mm','A4');
			 
			$pdf->AliasNbPages();

			//$pdf->AddPage('L');
			$pdf->AddPage();
			
		
			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','',10);
			$entreprise=utf8_decode("Fidest Entreprises");
			$pdf->Image("../../../img/entete_fiche.jpg", 50, 10,  200, 'C');
			$pdf->Ln(25);
			//$pdf->Cell(0,2,utf8_decode("Application de Gestion des Formations "),0,1,'C');
			//$pdf->Line(10, 35, 200, 35); 
			$pdf->Ln(5);

			$pdf->SetFont('Arial','',7);
			$mot="N°";
			$num=utf8_decode($mot);
			$date=gmdate('d/m/Y');

/*
	if(isset($_SESSION['recher_date_debut']) && $_SESSION['recher_date_debut']!='')
	{
	$recher_date_debut=$_SESSION['recher_date_debut'];
	}
	else
	{
	$recher_date_debut='';
	}
	*/
	
	$recher_date_debut=$_SESSION['recher_date_debut'];
	
	if(isset($_SESSION['recher_date_fin']) && $_SESSION['recher_date_fin']!='')
	{
	$recher_date_fin=$_SESSION['recher_date_fin'];
	}
	else
	{
	$recher_date_fin='';
	}
	
    if(isset($_SESSION['recher_demandeur']) && $_SESSION['recher_demandeur']!='')
	{
	$recher_demandeur=$_SESSION['recher_demandeur'];
	}
	else
	{
	$recher_demandeur='';
	}
	
	if(isset($_SESSION['recher_chantier']) && $_SESSION['recher_chantier']!='')
	{
	$recher_chantier=$_SESSION['recher_chantier'];
	}
	else
	{
	$recher_chantier='';
	}
	
	if(isset($_SESSION['recher_affectation']) && $_SESSION['recher_affectation']!='')
	{
	$recher_affectation=$_SESSION['recher_affectation'];
	}
	else
	{
	$recher_affectation='';
	}
	
	
			
	$req=" SELECT * FROM fiche LEFT JOIN decaissement ON decaissement.num_fiche_decaissement=fiche.num_fiche LEFT JOIN affectation ON affectation.id_affectation=fiche.affectation_id WHERE etat_fiche=1 AND sauvegarder=0 AND approuve=1 AND date_decaissement='".$date_decaissement."'  ";
	
		 
	 if($recher_date_debut!=""){
	 $req.=" AND date_creat_fiche>='".$recher_date_debut."'  ";
	 }
	 
	 if($recher_date_fin!=""){
	 $req.=" AND date_creat_fiche<='".$recher_date_fin."' ";
	 }

     if($recher_demandeur!=""){
        $req.=" AND beficiaire_fiche LIKE '%".$recher_demandeur."%' ";
     }
     
     if($recher_chantier!=""){
        $req.=" AND chantier_id='".$recher_chantier."' ";
     }

     if($recher_affectation!=""){
        $req.=" AND affectation_id='".$recher_affectation."' ";
     }
	 
     
     $req.=" ORDER BY chantier_id ASC ";
			 
	$reta=$con->prepare($req); 
    $reta->execute();
	$nbre_serv=$reta->rowcount();


	$req0_=" SELECT * FROM fiche LEFT JOIN decaissement ON decaissement.num_fiche_decaissement=fiche.num_fiche LEFT JOIN affectation ON affectation.id_affectation=fiche.affectation_id WHERE etat_fiche=1 AND sauvegarder=0 AND approuve=1 AND date_decaissement='".$date_decaissement."' ";
	
		 
	 if($recher_date_debut!=""){
	 $req0_.=" AND date_creat_fiche>='".$recher_date_debut."'  ";
	 }
	 
	 if($recher_date_fin!=""){
	 $req0_.=" AND date_creat_fiche<='".$recher_date_fin."' ";
	 }

     if($recher_demandeur!=""){
        $req0_.=" AND beficiaire_fiche LIKE '%".$recher_demandeur."%' ";
     }
     
     if($recher_chantier!=""){
        $req0_.=" AND chantier_id='".$recher_chantier."' ";
     }

     if($recher_affectation!=""){
        $req0_.=" AND affectation_id='".$recher_affectation."' ";
     }
	 
     
     	$req0=$con->prepare($req0_);
	
	$req0->execute();
	$info_fiche0=$req0->fetch();	
			
$date_oj=gmdate('d/m/Y');
			
$pdf->SetFont('Arial','',10);

$pdf->Cell(0,4,'		                                                                                                                                                                 Date :'.$date_oj,0,1,'L'); 	

$pdf->Ln(6);

$aff=$con->prepare('SELECT * FROM affectation WHERE id_affectation=:A');
$aff->execute(array('A'=>$recher_affectation));
$iaff=$aff->fetch();
$lib_affectation=$iaff['lib_affectation'];

$cha=$con->prepare('SELECT * FROM chantier WHERE id_chantier=:A');
$cha->execute(array('A'=>$recher_chantier));
$icha=$cha->fetch();
$lib_chantier=$icha['lib_chantier'];

$pay=utf8_decode("Côte d'Ivoire");
$pdf->SetFont('Arial','BU',15);
$pdf->Cell(0,3.3,utf8_decode('DECAISSEMENTS DU JOUR'),0,1,'C');
$pdf->Ln(6);
$pdf->SetFont('Arial','',15);
$pdf->Cell(0,3.3,utf8_decode('Debut : '.date("d/m/Y", strtotime($recher_date_debut)).' - Fin :'.date("d/m/Y", strtotime($recher_date_fin)).' - '.$lib_affectation.' - '.$lib_chantier.' '),0,1,'C');
$pdf->SetFont('Arial','I',13);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial','B',7);
			
$pdf->Cell(20);
$pdf->Ln(8);

$req1_=" SELECT * FROM fiche LEFT JOIN decaissement ON decaissement.num_fiche_decaissement=fiche.num_fiche LEFT JOIN affectation ON affectation.id_affectation=fiche.affectation_id WHERE etat_fiche=1 AND sauvegarder=0 AND approuve=1 AND date_decaissement='".$date_decaissement."' ";

	 
	 if($recher_date_debut!=""){
	 $req1_.=" AND date_creat_fiche>='".$recher_date_debut."'  ";
	 }
	 
	 if($recher_date_fin!=""){
	 $req1_.=" AND date_creat_fiche<='".$recher_date_fin."' ";
	 }

     if($recher_demandeur!=""){
        $req1_.=" AND beficiaire_fiche LIKE '%".$recher_demandeur."%' ";
     }
     
     if($recher_chantier!=""){
        $req1_.=" AND chantier_id='".$recher_chantier."' ";
     }

     if($recher_affectation!=""){
        $req1_.=" AND affectation_id='".$recher_affectation."' ";
     }
	 
     
     $req1=$con->prepare($req1_);

$req1->execute();
$info_fiche=$req1->fetch();	

$pdf->SetTextColor(0, 0, 0);

$pdf->Ln(8);
	
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,3.7,utf8_decode('Nombre d\'éléments : '.$nbre_serv.' '),0,1,'L');
			
$pdf->Cell(20);
$pdf->Ln(3);
	
$width_cell=array(8,70,70,50,29,29,29);
$pdf->SetFont('Arial','B',8);

//Couleur d'arrère plan de l'en-tête//
$pdf->SetFillColor(193,229,252);

//EN-TETE /// 

//Colonne 1 //
$pdf->Cell($width_cell[0],7,utf8_decode('N°'),1,0,'C',true);
$pdf->Cell($width_cell[1],7,utf8_decode('Affectation'),1,0,'C',true);
$pdf->Cell($width_cell[2],7,utf8_decode('Designation'),1,0,'C',true);
$pdf->Cell($width_cell[3],7,utf8_decode('Detail'),1,0,'C',true);
$pdf->Cell($width_cell[4],7,utf8_decode('Bénéficiaire'),1,0,'C',true);
$pdf->Cell($width_cell[5],7,utf8_decode('Téléphone'),1,0,'C',true);
$pdf->Cell($width_cell[6],7,utf8_decode('Montant'),1,1,'C',true);
//// FIN EN-TETE ///////
$pdf->SetFont('Arial','',7);
//Couleur arriere plan en-tête//
$pdf->SetFillColor(235,236,236); 
//Pour donner des couleurs d'arrière plan alternatives// 
$fill=false;

//$pdf->SetWidths(array(18,80,20,20,52));
$i=0;
foreach($reta as $row) {
    $i++;
    
    if($row['affectation_id']==1){ 
        $designation=$row['designation_fiche']; 
        
        $ch=$con->prepare('SELECT * FROM chantier WHERE id_chantier=:A');
        $ch->execute(array('A'=>$row['chantier_id']));
        $ich=$ch->fetch();
        $lib_chantier=$ich['lib_chantier'];
        
        $affectation=$row['lib_affectation'].' '.$lib_chantier;
        
    }else{ 
        $designation=$row['designation_fiche']; 
        $affectation=$row['lib_affectation']; 
    }
    
    
    $pdf->Cell($width_cell[0],7,utf8_decode(substr($row['num_fiche'], 0, 45)),1,0,'C',false);
    $pdf->Cell($width_cell[1],7,utf8_decode(substr($affectation, 0, 45)),1,0,'C',false);
    $pdf->Cell($width_cell[2],7,utf8_decode(substr($designation, 0, 45)),1,0,'C',false);
    
    $pdf->Cell($width_cell[3],7,utf8_decode(substr($row['precision_fiche'], 0, 45)),1,0,'C',false);

    $pdf->Cell($width_cell[4],7,utf8_decode($row['beficiaire_fiche']),1,0,'C',false);
    $pdf->Cell($width_cell[5],7,utf8_decode($row['tel_beneficiaire_fiche']),1,0,'C',false);
    $pdf->Cell($width_cell[6],7,utf8_decode($row['montant_fiche']),1,1,'C',false);
    
    
    $fill = !$fill;
}

    //Calcul Total
    $tota=' SELECT * FROM fiche LEFT JOIN decaissement ON decaissement.num_fiche_decaissement=fiche.num_fiche LEFT JOIN affectation ON affectation.id_affectation=fiche.affectation_id WHERE etat_fiche=1 AND sauvegarder=0 AND approuve=1 AND date_decaissement="'.$date_decaissement.'" ';

	 
	 if($recher_date_debut!=""){
	 $tota.=" AND date_creat_fiche>='".$recher_date_debut."'  ";
	 }
	 
	 if($recher_date_fin!=""){
	 $tota.=" AND date_creat_fiche<='".$recher_date_fin."' ";
	 }

     if($recher_demandeur!=""){
        $tota.=" AND beficiaire_fiche LIKE '%".$recher_demandeur."%' ";
     }
     
     if($recher_chantier!=""){
        $tota.=" AND chantier_id='".$recher_chantier."' ";
     }

     if($recher_affectation!=""){
        $tota.=" AND affectation_id='".$recher_affectation."' ";
     }
	 
     
     $tot=$con->prepare($tota);

$tot->execute();
$montant_total=0;
while($itot=$tot->fetch())
{
	$montant_total=$montant_total + ($itot['montant_fiche']);
}

//Affiche Total
$pdf->SetFillColor(255,255,255); 
$pdf->Cell($width_cell[0],7,utf8_decode(''),0,0,'C',false);
$pdf->Cell($width_cell[1],7,utf8_decode(''),0,0,'C',false);
$pdf->Cell($width_cell[2],7,utf8_decode(''),0,0,'C',false);
$pdf->Cell($width_cell[3],7,utf8_decode(''),0,0,'C',false);
$pdf->Cell($width_cell[4],7,utf8_decode(''),0,0,'C',false);
$pdf->SetFont('Arial','B',9);
$pdf->Cell($width_cell[5],7,utf8_decode('TOTAL'),1,0,'R',false);
$pdf->Cell($width_cell[6],7,utf8_decode(number_format($montant_total,0,',',' ').' FCFA'),1,1,'C',true);
$pdf->SetFont('Arial','',7);
$fill = !$fill;

$pdf->Ln(8);
      
$pdf->SetFont('Arial','I',10);
$pdf->Cell(0,4,utf8_decode('                                                                                                                                          Le Directeur Général (nom, date et visa) '),0,1,'R'); 
/*
$pdf->Ln(20);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,4,utf8_decode('Approbation du DG (nom, date et visa)'),0,1,'R'); 
*/

$pdf->Ln(149);
$pdf->Line(10, 272, 200, 272);
			
//Sauvegarde du fichier PDF généré
$pdf->Output($pdffilename);
			
echo "<META HTTP-EQUIV='Refresh' CONTENT='2;URL=$pdffilename'>";
//End Creation PDF

// Add Static Attachment
$attachment = $pdffilename;
$mail->AddAttachment($attachment , $pdffilename);


try {
    $mail->send();
    echo "Message envoyé avec succes";
} catch (Exception $e) {
    echo "Erreur d'envoi du mail: " . $mail->ErrorInfo;
}
//End mail
 
//header('Location: pdf_liste.php');
	

?>