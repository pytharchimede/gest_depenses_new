<?php
date_default_timezone_set("Europe/London");
	include('../../../../connex.php');
 session_start ();
$date=date('Y-m-d', time());

ini_set('memory_limit','512M');
ini_set('max_execution_time', 12000);
	

	$heure='00:00:00';

header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-disposition: attachment; filename=liste_utilisateurs_".$date.".xls");/**/	



$lst=$con->prepare("SELECT * FROM utilisateur LEFT JOIN groupe_utilisateur ON utilisateur.type_groupe_id =groupe_utilisateur.id_type_groupe LEFT JOIN utilisateur_service ON utilisateur_service.utilisateur_id=utilisateur.id_utilisateur LEFT JOIN service ON service.id_service=utilisateur_service.service_id WHERE id_utilisateur!='' ");
$lst->execute();
$fino=$lst->fetch();
      
 $couleur[0]="#F1F1F1";
    $couleur[1]="#FFFFFF"; 
	$i=1;

	echo'
	<br />
<h1><strong style="font-size:20px; color:red; align:center; text-decoration:underline;">LISTE DU PERSONNEL</strong></h1>
 	<strong>G&eacute;n&eacute;r&eacute;e le : </strong>'.Date('d/m/Y  H:i').'
	<br /><br /><br /> Par ';


	//Details du formateur
	echo'
 	<strong>Nom et Pr&eacute;nom(s): </strong>'.$_SESSION['nom_utilisateur_rh'].' 

<br />
 	<strong>Email : </strong>'.$_SESSION['email_utilisateur_rh'].'
<br />
 	<strong>T&eacute;l&eacute;phone : </strong> '.$_SESSION['tel_utilisateur'].'
<br /><br /><br />';

	echo'<strong style="font-size:18px; font-color:red;">Liste du personnel :</strong>  <br/><br/>';

	echo '<table class="utilisateur tab_list_client"  border="2" >
		 <tr class="td tr"  bgcolor="#0e7e70"  >
		 	<td width="150">Nom et pr&eacute;nom(s)</td>
			<td width="150">Service</td>
			<td width="150">Groupe</td>
			<td width="150">Email</td>
			<td width="150">T&eacute;l&eacute;phone</td>
		</tr>';

	while($fin=$lst->fetch())
   {

	//Liste des formations
	  
	   	echo'<tr class="td td_vu" bgcolor="'.$couleur[($i%2)].'" >
		   	<td>'.stripslashes(utf8_decode($fin['nom_utilisateur'])).'</td>	  
		   	<td>'.stripslashes(utf8_decode($fin['lib_service'])).'</td>
			<td>'.stripslashes(utf8_decode($fin['nom_type_groupe'])).'</td>
			<td>'.stripslashes($fin['email_utilisateur']).'</td>
			<td>'.stripslashes($fin['tel_utilisateur']).'</td>
			</tr>';   $i++;	   
	}
	
   echo'</table><br/><br/>';

  
	
unset($con); 
?>