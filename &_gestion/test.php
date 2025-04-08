<?php 
include('../connex.php');

$rek=$con->prepare("SELECT * FROM adherent WHERE type_patient_id=:A"); 
$rek->execute(array('A' => '1'));
while($utek=$rek->fetch())
{
$rero=$con->prepare("INSERT INTO souscripteur(num_assure, date_souscription, code_personnel_souscripteur) VALUES (:A, :B, :C)");
$rero->execute(array('A'=>$utek['num_adherent'], 'B'=>$utek['date_entree'], 'C'=>$utek['population_id']));
}
?>