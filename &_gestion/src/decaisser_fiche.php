<?php
session_start();
//$_SESSION['time']=time();
include('../../../logi/connex.php');

$num_fiche=$_SESSION['num_fiche_decaisse'];
$montant_decaisser=$_POST['montant_decaisser'];
$date_now=gmdate('Y-m-d');

    $adec=$con->prepare('INSERT INTO decaissement(num_fiche_decaissement, montant, secur_decaissement, date_decaissement) VALUES(:A, :B, :C, :D)');
    $adec->execute(array('A'=>$num_fiche, 'B'=>$montant_decaisser, 'C'=>$_SESSION['secur_hop'], 'D'=>$date_now));

    //Infos fiche
    $rep=$con->prepare('SELECT * FROM fiche LEFT JOIN affectation On affectation.id_affectation=fiche.affectation_id WHERE num_fiche=:A ');
    $rep->execute(array('A'=>$num_fiche));
    $irep=$rep->fetch();

    $montant=number_format($irep['montant_fiche'],0,',',' ');
    $affectation=stripslashes($irep['lib_affectation']);
    $beneficiaire=stripslashes($irep['beficiaire_fiche']);
    $designation_fiche=stripslashes($irep['designation_fiche']);
    $montant_fiche=$irep['montant_fiche'];


   //Calcul financier
   $dec=$con->prepare('SELECT * FROM decaissement WHERE num_fiche_decaissement=:A');
   $dec->execute(array('A'=>$num_fiche));
   $tot_dec=0;
   while($idec=$dec->fetch())
   {
       $tot_dec=floatval($idec['montant'])+$tot_dec;
   }
   $total_decaisse=$tot_dec;
   $montant_restant=$montant_fiche-$total_decaisse;


  //Mettre à jour si décaissement terminé
  if($montant_restant==0)
  {
  $req=$con->prepare('UPDATE fiche SET decaisse=1, secur_decaisse="'.$_SESSION['secur_hop'].'" WHERE num_fiche=:A');
  $req->execute(array('A'=>$num_fiche));
  }


    //tra�abilite
    $ip	= $_SERVER['REMOTE_ADDR'];
    $port = $_SERVER['REMOTE_PORT'];
    $adresse='Adresse IP: '.$ip.' Port: '.$port;
    $date_trace=gmdate('Y-m-d H:i:s');
    
    $lib_trace="Décaissement de la somme de  <b>".$montant_decaisser." a <b>".$beneficiaire."</b> pour <b>".$designation_fiche."</b> ";
    
    $red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
    $red->execute(array('A'=>$lib_trace, 'B'=>$date_trace, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));


unset($con);

?>

