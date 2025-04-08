<?php
session_start();
include('../../../../../../connex.php');

if(isset($_SESSION["recher_utilisateur"]) && $_SESSION["recher_utilisateur"]!='')
{
	$recher_utilisateur=$_SESSION["recher_utilisateur"];
}
else
{
	$recher_utilisateur='';
}

if(isset($_SESSION["recher_groupe"]) && $_SESSION["recher_groupe"]!='')
{
	$recher_groupe=$_SESSION["recher_groupe"];
}
else
{
	$recher_groupe='';
}

if(isset($_SESSION["recher_service"]) && $_SESSION["recher_service"]!='')
{
	$recher_service=$_SESSION["recher_service"];
}
else
{
	$recher_service='';
}

if(isset($_SESSION["recher_statut"]) && $_SESSION["recher_statut"]!='')
{
	$recher_statut=$_SESSION["recher_statut"];
}
else
{
	$recher_statut='';
}

if(isset($_SESSION["recher_droit"]) && $_SESSION["recher_droit"]!='')
{
	$recher_droit=$_SESSION["recher_droit"];
}
else
{
	$recher_droit='';
}

$req="SELECT * FROM utilisateur LEFT JOIN utilisateur_service ON utilisateur.id_utilisateur=utilisateur_service.utilisateur_id LEFT JOIN groupe_utilisateur ON utilisateur.type_groupe_id=groupe_utilisateur.id_type_groupe WHERE statut='0' ";

if($recher_utilisateur!=""){
		 
$req.=" and (nom_utilisateur LIKE '%".$recher_utilisateur."%' || email_utilisateur LIKE '%".$recher_utilisateur."%' || tel_utilisateur LIKE '%".$recher_utilisateur."%') ";
                 
    if($recher_statut!=""){
    $req.=" and valide='".$recher_statut."'";
    }

    if($recher_groupe!=""){
    $req.=" and type_groupe_id='".$recher_groupe."'";
    }

    if($recher_service!=""){	 
    $req.=" and (utilisateur_service.service_id='".$recher_service."')"; 
    }

    if($recher_droit!=""){	 
    $req.=" and (ajout_type_groupe='".$recher_droit."' || modif_type_groupe='".$recher_droit."' || sup_type_groupe='".$recher_droit."' || visual_type_groupe='".$recher_droit."' || req_type_groupe='".$recher_droit."' || tele_type_groupe='".$recher_droit."' || parta_type_groupe='".$recher_droit."' || deman_type_groupe='".$recher_droit."' || val_type_groupe='".$recher_droit."' || config_type_groupe='".$recher_droit."' || secur_type_groupe='".$recher_droit."') ";         
    }
         
}
else
{   
    if($recher_statut!=""){
    $req.=" and valide='".$recher_statut."'";
    }
    
    if($recher_groupe!=""){
    $req.=" and type_groupe_id='".$recher_groupe."'";
    }
    
    if($recher_service!=""){	 
    $req.=" and (utilisateur_service.service_id='".$recher_service."')"; 
    }
    
    if($recher_droit!=""){	 
    $req.=" and (ajout_type_groupe='".$recher_droit."' || modif_type_groupe='".$recher_droit."' || sup_type_groupe='".$recher_droit."' || visual_type_groupe='".$recher_droit."' || requete_type_groupe='".$recher_droit."' || tele_type_groupe='".$recher_droit."' || parta_type_groupe='".$recher_droit."' || deman_type_groupe='".$recher_droit."' || val_type_groupe='".$recher_droit."' || config_type_groupe='".$recher_droit."' || secur_type_groupe='".$recher_droit."') ";         
    }
}

$records=$con->query($req);
require('fpdf.php');
$pdf = new FPDF(); 
$pdf->AddPage('L','A4',0);
$pdf->AliasNbPages(); 

// Titre
$pdf->SetFont('Arial','BU',24);
$pdf->Cell(0,6,utf8_decode('LISTE DES UTILISATEURS '),0,1,'C');
$pdf->SetFont('Arial','BI',8);
$pdf->Ln(1);
$pdf->Cell(0,6,utf8_decode('Générée le').' '.Date('d/m/Y  H:i'),0,1,'L');
$pdf->Cell(0,6,utf8_decode('Par'.' '.$_SESSION["nom_utilisateur_rh"].' ('.$_SESSION["email_utilisateur_rh"].')'),0,1,'L');
$pdf->Cell(0,6,utf8_decode('Rôle: '.' '.$_SESSION["nom_type_groupe"]),0,1,'L');
$pdf->Cell(0,6,utf8_decode('Contact: ').' '.$_SESSION["tel_utilisateur"],0,1,'L');
/*
$logo = "../../../../../photo/hosp.jpg";
$pdf->Cell( 10, 10, $pdf->Image($logo, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 'R', false );
$pdf->Ln(25);
*/
$pdf->Ln(10);

$width_cell=array(90,150,40);
$pdf->SetFont('Arial','B',12);

//Couleur d'arrère plan de l'en-tête//
$pdf->SetFillColor(193,229,252);

//EN-TETE /// 
//Colonne 1 //
$pdf->Cell($width_cell[0],10,utf8_decode('Nom et Prénom(s)'),1,0,'C',true);
//Colonne 2//
$pdf->Cell($width_cell[1],10,'Service',1,0,'C',true);
//Colonne 3//
$pdf->Cell($width_cell[2],10,utf8_decode('Rôle'),1,1,'C',true); 
//// FIN EN-TETE ///////

$pdf->SetFont('Arial','',10);
//Couleur arriere plan en-tête//
$pdf->SetFillColor(235,236,236); 
//Pour donner des couleurs d'arrière plan alternatives// 
$fill=false;
///Chaque résultat correspond à une ligne ///
foreach($records as $row) {

//Etat de traitement du bon//	
$rep=$con->prepare("SELECT * FROM service LEFT JOIN utilisateur_service ON utilisateur_service.service_id=service.id_service WHERE utilisateur_id='".$row['id_utilisateur']."'");
    $rep->execute(); 
	while($ro=$rep->fetch())
	{	
        $service=''.strtoupper(stripslashes($ro['lib_service'])).'';
    }
//Etat de traitement du bon//
$pdf->Cell($width_cell[0],10,$row['nom_utilisateur'],1,0,'C',$fill);
$pdf->Cell($width_cell[1],10,utf8_decode($service),1,0,'C',$fill);
$pdf->Cell($width_cell[2],10,utf8_decode($row['nom_type_groupe']),1,1,'C',$fill);
//Pour donner des couleurs d'arrière plan alternatives aux lignes//
$fill = !$fill;
}
///Fin des enregistrements /// 
// Position at 1.5 cm from bottom 
$pdf->SetY(1.5); 
          
// Set font-family and font-size of footer. 
$pdf->SetFont('Arial', 'I', 8); 
   
// set page number 
$pdf->Cell(0, 10, 'Page '. $pdf->PageNo() .'/{nb}', 0, 0, 'R'); 
$pdf->Output();

?>
	
