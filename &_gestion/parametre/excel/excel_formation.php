<?php
include('../../../../connex.php');
 session_start ();
$date=gmdate('d/m/Y');

ini_set('memory_limit','512M');
ini_set('max_execution_time', 12000);
	
header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-disposition: attachment; filename=liste_paiement_au_".$date.".xls");

if(isset($_SESSION['recher_cause_sortie']) && ($_SESSION['recher_cause_sortie']!=''))
{
$recher_cause_sortie=$_SESSION['recher_cause_sortie'];
}
else
{
$recher_cause_sortie='';
}

if(isset($_SESSION['recher_localisation']) && ($_SESSION['recher_localisation']!=''))
{
$recher_localisation=$_SESSION['recher_localisation'];
}
else
{
$recher_localisation='';
}

if(isset($_SESSION['recher_etat']) && ($_SESSION['recher_etat']!=''))
{
$recher_etat=$_SESSION['recher_etat'];
}
else
{
$recher_etat='';
}

if(isset($_SESSION['dp1']) && ($_SESSION['dp1']!=''))
{
$recher_date_debut=$_SESSION['dp1'];
}
else
{
$recher_date_debut='';
}

if(isset($_SESSION['dp2']) && ($_SESSION['dp2']!=''))
{
$recher_date_fin=$_SESSION['dp2']; 
}
else
{
$recher_date_fin='';
}

$requete=" SELECT * FROM demande_ambul LEFT JOIN cause_sort_ambul ON cause_sort_ambul.id_cause_ambul=demande_ambul.motif_sortie_ambul_id LEFT JOIN localisation ON localisation.id_localisation=demande_ambul.localisation_id LEFT JOIN utilisateur ON utilisateur.secur=demande_ambul.secur_ajout WHERE id_demande_ambul!='' ";

if($recher_localisation!=""){
    $requete.=" AND localisation_id =".$recher_localisation." ";
} 

if($recher_etat!=""){
    if($recher_etat==0)
        {
            $requete.=" AND etat_demande_ambul='0' ";
        }
        if($recher_etat==1)
        {
            $requete.=" AND etat_demande_ambul='1' ";
        }
        if($recher_etat==2)
        {
            $requete.=" AND etat_demande_ambul='2' ";
        }
}  

if($recher_cause_sortie!=""){
    $requete.=" AND motif_sortie_ambul_id =".$recher_cause_sortie." ";
}          


if($recher_date_debut!='' && $recher_date_fin!='') 
{
    $requete.=" AND (date_demande_ambul>='".$recher_date_debut."' AND date_demande_ambul<='".$recher_date_fin."') ";
}	 
	 $sql = $con->query($requete);
    $copt  = $sql->rowCount();
//$fino=$lst->fetch();
      
$couleur[0]="#F1F1F1";
$couleur[1]="#FFFFFF"; 
$i=1;
	
echo'
<br />
<h1><strong style="font-size:20px; color:red; align:center; text-decoration:underline;">LISTE DES DEMANDES D\'AMBULANCES</strong></h1>
 <strong>G&eacute;n&eacute;r&eacute;e le : </strong>'.gmdate('d/m/Y  H:i').'</strong>
<br /><br />
Nombre de demandes : </strong><strong style="color:green;">'.$copt.'</strong><br/><br/>';

echo '<table class="utilisateur tab_list_client" border="2">
	 <tr class="td tr" bgcolor="#CC6600"  style="color:#FFFFFF">
		<td width="150">ID</td>
		<td width="150">Créée Par</td>
		<td width="150">Motif de sortie</td>
		<td width="150">Destination</td>
		<td width="150">Etat</td>
	</tr>';

foreach($sql as $row)
{

if($row['date_creat_paie']!='0000-00-00')
{
  $date_paie = date("d/m/Y H:i:s", strtotime($row['date_creat_paie']));
}
else
{
  $date_paie = '';
}

$mont=strrev(wordwrap(strrev($row['montant_cotisation']), 3, ' ', true));

$reh=$con->prepare("SELECT * FROM mois WHERE id_mois='".$row['mois_id']."'");
$reh->execute(); 
$roh=$reh->fetch();
				
	   	echo'<tr class="td td_vu" bgcolor="'.$couleur[($i%2)].'" >
		   	<td>'.$date_paie.'</td>
			<td>'.stripslashes($row['nom_personnel']).'</td>	
		   	<td>'.$roh['lib_mois'].' '.$row['annee_paie'].'</td>	
			<td>'.$mont.'</td>  
			</tr>';   
			$i++;	   
			
	}
	
   echo'</table><br/><br/>';

unset($con); 
?>