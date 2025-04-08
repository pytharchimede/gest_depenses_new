
<?php
session_start();

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;
$heure=gmdate("H:i:s", time() + $zone); 

$date_creat=date("Y-m-d").' '.$heure;


$fichier=$_FILES["file1"]["name"];

// ouverture du fichier en lecture
if ($fichier)
{
//ouverture du fichier temporaire
$fp = fopen ($_FILES["file1"]["tmp_name"], "r");
}
else{
echo'1';

exit();
}

$info = pathinfo($_FILES['file1']['name']);
$extension = $info['extension'];
$extension_autoriser = array('csv','CSV');

if(in_array($extension, $extension_autoriser))
{
$cpt=0;

include('../../../connex.php');

/*
$navi=$_POST['navire'];
$date=date("Y-m-d");

$red=$con->prepare("DELETE FROM navire_designation WHERE type_op='".$navi."' "); 
$red->execute();
*/
 
while (!feof($fp))
{
$ligne = fgets($fp,4096);
$liste = explode(";",$ligne);
$liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;
$liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;
$liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;
$liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;
$liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null;
$liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null;
$liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null;


$lib_designation=addslashes($liste[0]);
$operation_id_designation=addslashes($liste[1]);
$qte_designation=addslashes($liste[2]);
$prix_designation=addslashes($liste[3]);
$fourniture_debourse=addslashes($liste[4]);
$main_doeuvre_debourse=addslashes($liste[5]);
$montant_debourse=addslashes($liste[6]);


$cpt++;

$red=$con->prepare("SELECT * FROM designation WHERE lib_designation =:A AND operation_id_designation=:B "); 
$red->execute(array('A' => $lib_designation, 'B'=>$operation_id_designation ));

if ($red->rowCount())
{

  $ip	= $_SERVER['REMOTE_ADDR'];
  $port = $_SERVER['REMOTE_PORT'];
  $adresse='Adresse IP: '.$ip.' Port: '.$port;
  //$histo=date('d/m/Y').' '.$heure;
  $date=gmdate('Y-m-d H:i:s');

  $lib_doublon='Doublon détecté sur la valeur <b>'.$lib_designation.'</b> pour le chantier N° <b>'.$operation_id_designation.'</b>  Veuillez vérifier votre base de données';

  $req=$con->prepare("INSERT INTO trace(lib_trace, date_trace, secur, adresse_ip) VALUES (:A, :B, :C, :D)");
  $req->execute(array('A'=>$lib_doublon, 'B'=>$date, 'C'=>$_SESSION["secur_hop"], 'D'=>$adresse));
  
}
else
{

  
  $req=$con->prepare("INSERT INTO designation(lib_designation, operation_id_designation, qte_designation, prix_designation, fourniture_debourse, main_doeuvre_debourse, montant_debourse) VALUES (:A, :B, :C, :D, :E, :F, :G)");
  $req->execute(array('A'=>$lib_designation, 'B'=>$operation_id_designation, 'C'=>$qte_designation, 'D'=>$prix_designation, 'E'=>$fourniture_debourse, 'F'=>$main_doeuvre_debourse, 'G'=>$montant_debourse));
}

$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;
//$histo=date('d/m/Y').' '.$heure;
$date=gmdate('Y-m-d H:i:s');


  $lib_trace="Ajout de l\'designation <b>".$lib_designation."</b> sur le chantier N° <b>".$operation_id_designation."</b> de quantité <b>".$qte_designation."</b> au prix de <b>".$prix_designation."</b> l'unité ";

         $reb=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
         $reb->execute(array('A'=>$lib_trace, 'B'=>$date, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

}
//echo'2';
fclose($fp);
header('Location: ../parametre.php');
}
else
{
echo'
Probleme avec limportation. Veuillez contacter le support technique SVP.
';
}

?>
 
 