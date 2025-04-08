
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

$red=$con->prepare("DELETE FROM navire_operation WHERE type_op='".$navi."' "); 
$red->execute();
*/
 
while (!feof($fp))
{
$ligne = fgets($fp,4096);
$liste = explode(";",$ligne);
$liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;


$lib_aff=addslashes($liste[0]);



$cpt++;

$red=$con->prepare("SELECT * FROM serv_log WHERE lib_serv_log =:A "); 
$red->execute(array('A' => $lib_aff ));

if ($red->rowCount())
{

  $ip	= $_SERVER['REMOTE_ADDR'];
  $port = $_SERVER['REMOTE_PORT'];
  $adresse='Adresse IP: '.$ip.' Port: '.$port;
  //$histo=date('d/m/Y').' '.$heure;
  $date=gmdate('Y-m-d H:i:s');

  $lib_doublon='Doublon détecté sur la valeur <b>'.$lib_aff.'</b> Veuillez vérifier votre base de données';

  $req=$con->prepare("INSERT INTO trace(lib_trace, date_trace, secur, adresse_ip) VALUES (:A, :B, :C, :D)");
  $req->execute(array('A'=>$lib_doublon, 'B'=>$date, 'C'=>$_SESSION["secur_hop"], 'D'=>$adresse));
  
}
else
{

  
  $req=$con->prepare("INSERT INTO serv_log(lib_serv_log) VALUES (:A)");
  $req->execute(array('A'=>$lib_aff));
}

$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;
//$histo=date('d/m/Y').' '.$heure;
$date=gmdate('Y-m-d H:i:s');


  $lib_trace="Ajout de l\'serv_log <b>".$lib_aff."</b>";

         $reb=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
         $reb->execute(array('A'=>$lib_trace, 'B'=>$date, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

}
//echo'2';
fclose($fp);
header('Location: parametre.php');
}
else
{
echo'
Probleme avec limportation. Veuillez contacter le support technique SVP.
';
}

?>
 
 