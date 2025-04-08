<?php
session_start();
include('../../../connex.php');

$id_utilisateur=$_SESSION['id_utilisateur_mod'];
$email_utilisateur=$_POST['email_mod'];
$groupe_uti=$_POST['groupe_uti_mod']; 
$tel_utilisateur=$_POST['tel_personnel_soignant_mod']; 
$personnel_id=$_POST['personnel_id_mod'];
$statut=0;

$statut=0;
$valide=0;
$secur_sup="";
$date_sup="";

$date=gmdate("Y-m-d H:i:s");

$sqlQuery = $con->query("SELECT * FROM utilisateur WHERE email_utilisateur='".$email_utilisateur."' and valide_util!=1 ");
$count = $sqlQuery->rowCount();

$inf = $con->query("SELECT * FROM personnel_soignant WHERE id_personnel_soignant='".$personnel_id."' ");
$info=$inf->fetch();
$nom_utilisateur=$info['nom_personnel_soignant'];
$service_id=$info['service_id'];
$fonction_id=$info['fonction_id'];
$photo_util=$info['photo_personnel_soignant'];

$connecte=0;

if(1)
{

$req=$con->prepare(" UPDATE utilisateur SET type_groupe_id=:A, date_mod=:B, secur_mod=:C, statut=:D, personnel_soignant_id=:E, nom_utilisateur=:F, email_utilisateur=:G, tel_utilisateur=:H, connecte=:I, valide_util=:K, fonction_id=:L, service_id=:M, photo_util=:N  WHERE id_utilisateur=:O ");
$req->execute(array('A'=>$groupe_uti, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$statut, 'E'=>$personnel_id, 'F'=>$nom_utilisateur, 'G'=>$email_utilisateur, 'H'=>$tel_utilisateur, 'I'=>$connecte, 'K'=>$valide, 'L'=>$fonction_id, 'M'=>$service_id, 'N'=>$photo_util, 'O'=>$id_utilisateur));

///traçabilité;
/*
$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

$red=$con->prepare("SELECT * FROM groupe_utilisateur WHERE id_type_groupe=:A"); 
$red->execute(array('A' =>$groupe_uti));
$util=$red->fetch();

$rec=$con->prepare("SELECT * FROM groupe_utilisateur WHERE id_type_groupe=:A"); 
$rec->execute(array('A' =>$_SESSION['type_groupe_id_mod']));
$utic=$rec->fetch();

if($personnel_id!=$_SESSION['personnel_id'])
{
$titre_ac=' <b>'.$personnel.'</b> remplac&eacute; par <b>'.$personnel_new.'</b>';
}

if($email!=$_SESSION['email_utilisateur_mod'])
{
$titre_ac_=$_SESSION['email_utilisateur_mod'].' remplac&eacute; par '.$email;
}

if($tel!=$_SESSION['tel_utilisateur_mod'])
{
$titre_ac_1=$_SESSION['tel_utilisateur_mod'].' remplac&eacute; par '.$tel;
}

if($groupe_uti!=$_SESSION['type_groupe_id_mod'])
{
$titre_ac_2=stripslashes($utic['nom_type_groupe']).' remplac&eacute; par '.stripslashes($util['nom_type_groupe']);
}
  
$lib_trace="Modification de l'utilisateur ".$titre_ac." email ".$titre_ac_." t&eacute;l&eacute;phone ".$titre_ac_1." avec droit d'utilisateur ".$titre_ac_2." pour le(s) service(s) : ";

$req=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$req->execute(array('A'=>$lib_trace, 'B'=>$date, 'C'=>$adresse, 'D'=>$_SESSION['secur_rh']));	
*/
////////

echo'0';

unset($con);
}
?>


