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
    $this->Image('../../../img/logo_yadec.jpg', 10,282,17);	
    // Arial italic 8
    $this->SetFont('Arial','',7);
	//$this->Cell(0,10,'CMS/ABJ/BS/PH',0,0,'L');
	
	//$this->Cell(0,10,'CMS/ABJ/BS/PH',0,0,'L');
	
	$this->Cell(0,3.5,utf8_decode("CABINET DE CONSEIL EN STRATEGIE ET DEVELOPPEMENT COMMERCIAL"),0,1,'C');
	$this->Cell(0,3.5,utf8_decode('Au capital de XXXXX F CFA - Siège Social : Abidjan, Cocody Angré, Djibi 1, immeuble CDCI, 2ème étage, porte 7'),0,1,'C');
	$this->Cell(0,3.5,utf8_decode("XX BP XXXX Abidjan XX - Abidjan - COTE D'IVOIRE - Téléphone : (+225) 27 23 49 81 69  -  Email : info@yadec.ci"),0,1,'C');
	$this->Cell(0,3.5,utf8_decode('RCCM :  -  N° CC : '),0,1,'C');
	
	$this->Image('../../../img/logo_epf.jpg', 178,282,22);	
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	
}
}
            
			//Paramètres du fichier PDF 
			$pdffilename = 'Liste des demandes de formation.pdf';
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
			 $pdf->Image("../../../../../img/logo_yadec_.jpg", -20, 5, 250, 'L');
			 //$pdf->Cell(0,2,"Syndicat des Entrepreneurs de Manutention des Ports Abidjan et de ".$cot_ivoir." ",0,1,'C');
			 //$pdf->Line(10, 35, 200, 35); 
			 $pdf->Ln(28);
			 */

			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','',10);
			$cot_ivoir=utf8_decode("Côte d'Ivoire");
			 //$pdf->Image('../../../img/entete-logo.jpg',12,8,43);
			 $pdf->Image("../../../img/logo_yadec.jpg", 80, 5,  40, 'L');
			 $pdf->Ln(15);
			 $pdf->Cell(0,2,"Syndicat des Entreprises de Manutention des Ports de ".$cot_ivoir." ",0,1,'C');
			 //$pdf->Line(10, 35, 200, 35); 
			 $pdf->Ln(10);

			$pdf->SetFont('Arial','',7);
			$mot="N°";
			$num=utf8_decode($mot);
			$date=gmdate('d/m/Y');
					     
			$pay=utf8_decode("Côte d'Ivoire");
			$pdf->SetFont('Arial','B',15);
			$pdf->Cell(0,3.3,'DEMANDES DE FORMATION',0,1,'C');
			
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
			//$pdf->Cell(0,3.7,'SOUCHE',0,1,'L');
			
			/*$pdf->SetFont('Arial','',10);
			$pdf->Cell(0,3.7,' MOTIF DE SORTIE : '.stripslashes(strtoupper($utak["lib_motif_sortie_medicament"])),0,1,'C');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,2,"BON DE SORTIE ".$num." : ".$uta["num_bon_sortie"]."",0,1,'C');*/
			
			$pdf->Cell(20);
            $pdf->Ln(8);
/*                      
$req=" SELECT * FROM adherent LEFT JOIN patient ON patient.adherent_id=adherent.id_adherent LEFT JOIN personnel ON personnel.code_personnel=adherent.population_id WHERE code_personnel!='' AND date_sortie_personnel='0000-00-00' AND code_type_personnel='4' AND absent_liste='0' AND code_personnel=".$code_personnel." AND (type_patient_id=2 || type_patient_id=3)  ";
$records=$con->query($req);
$records=$con->query($req);
$copt=$records->rowCount();

$if=$con->prepare(" SELECT * FROM adherent LEFT JOIN patient ON patient.adherent_id=adherent.id_adherent LEFT JOIN personnel ON personnel.code_personnel=adherent.population_id WHERE code_personnel!='' AND date_sortie_personnel='0000-00-00' AND code_type_personnel='4' AND absent_liste='0' AND code_personnel=:A  ");
$if->execute(array('A'=>$code_personnel));
$inf=$if->fetch();
$nom_doc=$inf['nom_personnel'];
$mat_doc=$inf['matricule_personnel'];
$contact_doc=$inf['tel_personnel'];
*/

if(isset($_SESSION['recher_motif_demande']) && ($_SESSION['recher_motif_demande']!=''))
{
$recher_motif_demande=$_SESSION['recher_motif_demande'];
}
else
{
$recher_motif_demande='';
}

if(isset($_SESSION['recher_etat']) && ($_SESSION['recher_etat']!=''))
{
$recher_etat=$_SESSION['recher_etat'];
}
else
{
$recher_etat='';
}

$req=" SELECT * FROM demande_formation LEFT JOIN utilisateur ON utilisateur.secur=demande_formation.secur_ajout_demande WHERE id_demande_formation!=''  ";
 
 
if($recher_etat!=""){
	if($recher_etat==0)
	{
		$req.=" AND etat_demande_formation='0' ";
	}
	if($recher_etat==1)
	{
		$req.=" AND etat_demande_formation='1' ";
	}
	if($recher_etat==2)
	{
		$req.=" AND etat_demande_formation='2' ";
	}
}      

if($recher_motif_demande!=""){
$req.=" AND (motif_demande_formation LIKE '%".$recher_motif_demande."%' ) ";
}          
	

$req.=" ORDER BY date_demande_formation DESC ";

//$req.=" ORDER BY num_dos_patient ASC ";

$records=$con->query($req);
$copt=$records->rowCount();
/*
$pdf->SetFont('Arial','B',12);                        			
$pdf->Cell(0,6,utf8_decode('DOCKER'),0,1,'L');
			
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,6,utf8_decode('Matricule: '.' '.utf8_decode($mat_doc).' '),0,1,'L');
$pdf->Cell(0,6,utf8_decode('Nom et Prénom(s)'.' : '.utf8_decode($nom_doc).' '),0,1,'L');
$pdf->Cell(0,6,utf8_decode('Contact : '.$contact_doc.''),0,1,'L');
$pdf->Ln(10);
$pdf->Cell(0,6,utf8_decode('Nombre de parents : '.$copt.''),0,1,'L');
*/
$pdf->Cell(20);
$pdf->Ln(3);
			
$width_cell=array(18,55,30,45,45);
$pdf->SetFont('Arial','B',7);

//Couleur d'arrère plan de l'en-tête//
$pdf->SetFillColor(193,229,252);

//EN-TETE /// 
$pdf->Cell($width_cell[0],10,utf8_decode('Code'),1,0,'C',true);
$pdf->Cell($width_cell[1],10,utf8_decode('Motif'),1,0,'C',true);
$pdf->Cell($width_cell[2],10,utf8_decode('Formation'),1,0,'C',true);
$pdf->Cell($width_cell[4],10,utf8_decode('Etat'),1,1,'C',true);
//// FIN EN-TETE ///////

$pdf->SetFont('Arial','',7);
//Couleur arriere plan en-tête//
$pdf->SetFillColor(235,236,236); 
//Pour donner des couleurs d'arrière plan alternatives// 
$fill=false;


//$pdf->SetWidths(array(18,80,20,20,52));

$i=1;
///Chaque résultat correspond à une ligne ///
foreach($records as $row) {

$etat_demande=$row['etat_demande_formation'];

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

$num_demande_formation=$row['num_demande_formation'];
$motif_demande_formation=$row['motif_demande_formation'];
$formation_demande=$row['formation_demande'];   
$etat_demande_formation=$row['etat_demande_formation'];
	//Fin req

$pdf->Cell($width_cell[0],10,utf8_decode($num_demande_formation),1,0,'C',$fill);
$pdf->Cell($width_cell[1],10,utf8_decode(stripslashes($motif_demande_formation)),1,0,'C',$fill);
$pdf->Cell($width_cell[2],10,utf8_decode(stripslashes($formation_demande)),1,0,'C',$fill);
$pdf->Cell($width_cell[3],10,utf8_decode($etat_demande),1,1,'C',$fill);
//Pour donner des couleurs d'arrière plan alternatives aux lignes//
$fill = !$fill;
$i++;

}
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