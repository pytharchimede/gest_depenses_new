<?php
 session_start ();
 
 include('../../../../connex.php');
	 
include("phpToPDF.php");
require('mysql_table.php');

//$code_personnel=$_SESSION['famille_recup'];

class PDF extends PDF_MySQL_Table
{

function Header()
{
           
 
}

// Pied de page
function Footer()
{
	// Position at 1.5 cm from bottom
    $this->SetY(-15);
    $this->Image('../../../img/logo_t_care.jpg', 10,282,17);	
    // Arial italic 8
    $this->SetFont('Arial','',7);
	//$this->Cell(0,10,'CMS/ABJ/BS/PH',0,0,'L');
	
	//$this->Cell(0,10,'CMS/ABJ/BS/PH',0,0,'L');
	/*
	$this->Cell(0,3.5,utf8_decode("SYNDICAT DES ENTREPRENEURS DE MANUTENTION DES PORTS ABIDJAN ET DE COTE D'IVOIRE - SEMPA"),0,1,'C');
	$this->Cell(0,3.5,utf8_decode('Au capital de XXXXX F CFA - Siège Social : Bd de Marseille, vers SODECI - Zone portuaire Treichville'),0,1,'C');
$this->Cell(0,3.5,utf8_decode("01 BP 4082 Abidjan 01 - Abidjan - COTE D'IVOIRE - Téléphone : (+225) 21 21 35 50  -  Fax : (+225) 21 25 69 88"),0,1,'C');
	$this->Cell(0,3.5,utf8_decode('RCCM :  -  N° CC : '),0,1,'C');
	*/
	$this->Image('../../../img/logo_sempa.jpg', 178,282,22);	
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	
}
}
            
			//Paramètres du fichier PDF 
			$pdffilename = 'Exportation de la demande dambulance.pdf';
			clearstatcache();
			if (file_exists($pdffilename)) {
			//Si le fichier PDF existe, il faut le supprimer d'abord
			unlink($pdffilename);
			}
			 
			
			//Création du fichier PDF
			$pdf=new PDF('P','mm','A4');
			 
			$pdf->AliasNbPages();

			$pdf->AddPage();
			
				/*
			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','B',8);
			$cot_ivoir=utf8_decode("Côte d'Ivoire");
			 //$pdf->Image('../../../img/entete-logo.jpg',12,8,43);
			 $pdf->Image("../../../../../img/logo_sempa_.jpg", -20, 5, 250, 'L');
			 //$pdf->Cell(0,2,"Syndicat des Entrepreneurs de Manutention des Ports Abidjan et de ".$cot_ivoir." ",0,1,'C');
			 //$pdf->Line(10, 35, 200, 35); 
			 $pdf->Ln(28);
			 */

			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','',10);
			$cot_ivoir=utf8_decode("Côte d'Ivoire");
			 //$pdf->Image('../../../img/entete-logo.jpg',12,8,43);
			 $pdf->Image("../../../img/logo_sempa.jpg", 80, 5,  40, 'L');
			 $pdf->Ln(15);
			 $pdf->Cell(0,2,"Syndicat des Entreprises de Manutention des Ports de ".$cot_ivoir." ",0,1,'C');
			 //$pdf->Line(10, 35, 200, 35); 
			 $pdf->Ln(10);

			$pdf->SetFont('Arial','',7);
			$mot="N°";
			$num=utf8_decode($mot);
			$date=gmdate('d/m/Y');

			
$id_demande_ambul=$_GET['id_demande_ambul'];
$requete=" SELECT * FROM demande_ambul LEFT JOIN cause_sort_ambul ON cause_sort_ambul.id_cause_ambul=demande_ambul.motif_sortie_ambul_id LEFT JOIN localisation ON localisation.id_localisation=demande_ambul.localisation_id LEFT JOIN utilisateur ON utilisateur.secur=demande_ambul.secur_ajout WHERE id_demande_ambul='".$id_demande_ambul."' ";
$records=$con->query($requete);
$copt=$records->rowCount();
$row=$records->fetch();
$num_dem=$row['num_demande_sa'];

			$pay=utf8_decode("Côte d'Ivoire");
			$pdf->SetFont('Arial','B',15);
			$pdf->Cell(0,3.3,utf8_decode('DEMANDE D\'AMBULANCE N° '.$num_dem),0,1,'C');
			
			$pdf->Ln(6);
			$date_oj=gmdate('d/m/Y');
			
			$pdf->SetFont('Arial','',10);
			//$pdf->Rect(10,31,55,21);
			//$pdf->Cell(0,3.7,'                                                                                                                                                     
			// Abidjan le '.$date_oj.' ',0,1,'L');
			$pdf->Cell(0,4,'Abidjan le '.$date_oj,0,1,'R'); 
																																		  
			$pdf->SetFont('Arial','B',10);                    
			
			$pdf->Ln(4);
			$pdf->SetFont('Arial','B',7);
			
			$pdf->Cell(20);
            $pdf->Ln(8);


$pdf->Cell(20);
$pdf->Ln(3);
			
$width_cell=array(18,55,30,45,45);
$pdf->SetFont('Arial','B',7);

//Couleur d'arrère plan de l'en-tête//
$pdf->SetFillColor(193,229,252);


$pdf->SetFont('Arial','',7);
//Couleur arriere plan en-tête//
$pdf->SetFillColor(235,236,236); 
//Pour donner des couleurs d'arrière plan alternatives// 
$fill=false;

//Req
$depart=date("d/m/Y", strtotime($row['date_demande_ambul']))." &agrave; ".$row["heure_demande_ambul"];

$etat_demande=$row['etat_demande_ambul'];

if($etat_demande==1)
{
$etat_demande='Demande accordée';
}
else if($etat_demande==2)
{
$etat_demande='Demande réfusée';
}
else
{
$etat_demande='Demande en attente...';
}

$motif_demande=$row['lib_cause_ambul'];
$nom_pers=$row['nom_utilisateur'];
$dest_ambul=$row['lib_localisation'];   
$num_dem=$row['num_demande_sa'];
$details_demande=$row['observation'];
//Req

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,3.7,utf8_decode('Créée par : '.$nom_pers.' '),0,1,'L');
$pdf->Ln(5);
$pdf->Cell(0,3.7,utf8_decode('Motif : '.$motif_demande.' '),0,1,'L');
$pdf->Ln(5);
$pdf->Cell(0,3.7,utf8_decode('Destination : '.$dest_ambul.' '),0,1,'L');
$pdf->Ln(5);
$pdf->Cell(0,3.7,utf8_decode('Observations'),0,1,'L');
$pdf->Ln(3);
$pdf->SetFont('Arial','',9);
$pdf->multiCell(0,3.7,utf8_decode($details_demande),0,1,'L');	


$pdf->Ln(8);
/*
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,utf8_decode('Validé par : '),0,1,'R');
$pdf->SetFont('Arial','B',10);

if($uta["valide_sortie_prod"]==1)
{
$reb=$con->prepare("SELECT * FROM utilisateur WHERE secur='".$uta['secur_valide']."'");
$reb->execute();
$rob=$reb->fetch(); 


$pdf->Cell(0,6,stripslashes(strtoupper($rob['nom_utilisateur'])),0,1,'R');
}         
*/
			$pdf->Ln(149);
			$pdf->Line(10, 275, 200, 275);
			
//Sauvegarde du fichier PDF généré
$pdf->Output($pdffilename);
			
echo "<META HTTP-EQUIV='Refresh' CONTENT='2;URL=$pdffilename'>";


?>