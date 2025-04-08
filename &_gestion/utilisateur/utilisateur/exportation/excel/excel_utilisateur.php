<?php
date_default_timezone_set("Europe/London");
include('../../../../../../connex.php');
 session_start ();
$date=date('Y-m-d', time());

ini_set('memory_limit','512M');
ini_set('max_execution_time', 12000);
	

	$heure='00:00:00';

header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-disposition: attachment; filename=liste_utilisateur_".$date.".xls");/**/	

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

$lst=$con->prepare($req);
$lst->execute();
//$fino=$lst->fetch();
      
 $couleur[0]="#F1F1F1";
    $couleur[1]="#FFFFFF"; 
	$i=1;

	echo'
	<br />
<h1><strong style="font-size:20px; color:red; align:center; text-decoration:underline;">Liste des Utilisateurs</strong></h1>
 	<strong>G&eacute;n&eacute;r&eacute;e le : </strong>'.Date('d/m/Y  H:i').'
	<br /><br /><br /> Par<br />  ';


	//Liste des bons
	echo'
 	<strong>Nom et Pr&eacute;nom(s): </strong>'.$_SESSION['nom_utilisateur_rh'].' 

<br />
 	<strong>Email : </strong>'.$_SESSION['email_utilisateur_rh'].'
<br />
 	<strong>T&eacute;l&eacute;phone : </strong> '.$_SESSION['tel_utilisateur'].'
<br /><br /><br />';

	echo'<strong style="font-size:18px; font-color:red;">Liste des groupes utilisateurs :</strong>  <br/><br/>';

	echo '<table class="utilisateur tab_list_client"  border="2" >
		<tr class="td tr"  bgcolor="#0e7e70"  >
			<td class="fa_tab">id</td>
			<td>Nom et Pr&eacute;nom(s)</td>
			<td>Service</td>
			<td>Role</td>
		</tr>';

	while($row=$lst->fetch())
   {

	$rep=$con->prepare("SELECT * FROM service LEFT JOIN utilisateur_service ON utilisateur_service.service_id=service.id_service WHERE utilisateur_id='".$row['id_utilisateur']."'");
    $rep->execute(); 
	while($ro=$rep->fetch())
	{	
        $service=''.strtoupper(stripslashes($ro['lib_service'])).'';
    }

	//Liste des bons d'entrée en stock
		       echo ' <tr class="fa_table_">
					                    <td><b>'.$i.'</b></td>
					                    <td><b>'.stripslashes($row['nom_utilisateur']).'</b></td>
					                    <td>'.$service.'</td>
					                    <td>'.stripslashes($row['nom_type_groupe']).'</td>
										</tr>';   $i++;	    
	}
	
   echo'</table><br/><br/>';

  
unset($_SESSION["recher_groupe"]);

unset($con); 
?>


