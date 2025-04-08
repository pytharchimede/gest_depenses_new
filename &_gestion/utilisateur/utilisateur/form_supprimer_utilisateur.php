<?php
session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{
$red=$con->prepare(" SELECT * FROM utilisateur LEFT JOIN personnel_soignant ON personnel_soignant.id_personnel_soignant=utilisateur.personnel_soignant_id INNER JOIN service ON service.id_service=personnel_soignant.service_id INNER JOIN fonction ON fonction.id_fonction=personnel_soignant.fonction_id WHERE id_utilisateur=:A ");
$red->execute(array('A' =>$id));
$util=$red->fetch();

$_SESSION['id_utilisateur_sup']=$util["id_utilisateur"];

echo'<form name="sup_marque" id="sup_marque" action="#">
	<div>';
echo"<p class='col_sup'>Etes vous sûr de vouloir supprimer l'utilisateur <b>".stripslashes($util['nom_personnel_soignant'])."</b> ?</p>";
echo'</form>';
}
unset($con);
?>
