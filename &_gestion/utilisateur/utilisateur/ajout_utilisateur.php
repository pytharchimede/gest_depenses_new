<?php
session_start();
include('../../../connex.php');
$date=gmdate("Y-m-d H:i:s");

//Générer Mot de passe auto
$se     =  'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$numero     =  'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
$id   = ''; 
$num  ='';

for($i=0;$i < 7;$i++)    //7 est le nombre de caract�res
{ 
    $id .= substr($numero,rand()%(strlen($numero)),1); 
}
for($j=0;$j < 10;$j++)    //10 est le nombre de caract�res
{ 
    $num .= substr($numero,rand()%(strlen($numero)),1);
    
}
for($j=0;$j < 5;$j++)    //10 est le nombre de caract�res
{ 
    $ser= substr($se,rand()%(strlen($se)),1);
    
}
$securite=$num; 
$pass=$id; 

$pwd= hash("sha512", $pass);
//

$groupe_uti=$_POST['groupe_uti']; 
$personnel_id=$_POST['personnel_id'];



$inf = $con->query("SELECT * FROM personnel_soignant WHERE id_personnel_soignant='".$personnel_id."' ");
$info=$inf->fetch();
$nom_utilisateur=$info['nom_personnel_soignant'];
$photo_util=$info['photo_personnel_soignant'];
$email_utilisateur=$info['email_personnel_soignant'];
$tel_utilisateur=$info['tel_personnel_soignant']; 



$sqlQuery = $con->query("SELECT * FROM utilisateur WHERE email_utilisateur='".$email_utilisateur."' and valide_util!=1 ");
$count = $sqlQuery->rowCount();
$uti=$sqlQuery->fetch();

if($count>0)
{
echo'1';
}
else
{
$req=$con->prepare("INSERT INTO utilisateur(type_groupe_id, motpass_utilisateur, date_creat, secur_ajout, secur, nom_utilisateur, email_utilisateur, tel_utilisateur, photo_util, personnel_soignant_id) VALUES (:A, :B, :C, :D, :E, :F, :G, :H, :I, :J)");
$req->execute(array('A'=>$groupe_uti, 'B'=>$pwd, 'C'=>$date, 'D'=>$_SESSION['secur_hop'], 'E'=>$securite, 'F'=>$nom_utilisateur, 'G'=>$email_utilisateur, 'H'=>$tel_utilisateur, 'I'=>$photo_util, 'J'=>$personnel_id));

//Envoi du mail 
// on génère une frontière
$destinataire=$email_utilisateur;
$sujet= "CREATION DE COMPTE G-FORM";
$headers="From: support@yadecdigital.com \n";
$boundary = '-----=' . md5( uniqid ( rand() ) );
// on génère un identifiant aléatoire pour le fichier
$file_id  = md5( uniqid ( rand() ) ) . $_SERVER['SERVER_NAME'];

$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: multipart/related; boundary=\"$boundary\"";

$message  = "Ceci est un message au format MIME 1.0 multipart/mixed.\n\n";
$message .= "--" . $boundary . "\n";
$message .= "Content-Type: text/html; charset=\"iso-8859-2\"\n";
$message .= "Content-Transfer-Encoding: 8bit\n\n";
$message .= "<html>
                  <body>
                <b>".$nom_utilisateur."</b>, <br><br>";
$message .= " Votre compte utilisateur G-FORM a &eacute;t&eacute; cr&eacute;&eacute;. Veuillez trouver ci-dessous vos param&agrave;tres de connexion. <p>Cliquez sur <a style='color:green;' href='evaluation.yadecdigital.com'>>> ce lien <<</a> pour vous connecter : </p><br/><br/>";
//$message .= "<img src=\"cid:$file_id\" alt='Votre Badge Num&eacute;rique'><br>";
$message .= "Parametres de connexion : <br><br> Identifiant : <b>".$email_utilisateur."</b> <br/>Mot de passe : <b>".$pass."</b> <br/>";
$message .= "<br><br><br> <hr> <br><p><a href='https://www.yadec.ci/'>Yadec Consulting</a>, Cabinet de conseil en strat&eacute;gie et d&eacute;veloppement commercial, vous remercie.</p> ";
$message .= "\n\n";
$message .= "<br><br><br> <b>RESTONS CONNECTES</b> <hr style='background-color:#e40001;'> <br> ";
$message .="<p style='text-align:center;'>";
$message .= "<a href='https://web.facebook.com/yadecconsulting?_rdc=1&_rdr'><img style='height:100px; text-align:center; margin:auto; display:flex' src='https://b2b.yadecdigital.com/dol_app/invite/invite/image/facebook.png'></a> &nbsp;&nbsp; ";
$message .= "<a href='https://www.linkedin.com/company/yadecconsulting/'><img style='height:100px; text-align:center; margin:auto; display:flex' src='https://b2b.yadecdigital.com/dol_app/invite/invite/image/linkedin.png'></a> &nbsp;&nbsp; ";
$message .= "<a href='https://wa.me/2250596864788'><img style='height:100px; text-align:center; margin:auto; display:flex' src='https://b2b.yadecdigital.com/dol_app/invite/invite/image/whatsapp.png'></a> &nbsp;&nbsp; ";
$message .="</p>";
$message .= "--" . $boundary . "\n";
$message .= "Content-Transfer-Encoding: base64\n";
$message .= "Content-ID: <$file_id>\n\n";
$message .= "\n\n";
$message .= "--" . $boundary . "--\n";

mail($destinataire, $sujet, $message, $headers);
//Fin Email

///traçabilité
$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

$red=$con->prepare("SELECT * FROM groupe_utilisateur WHERE id_type_groupe=:A"); 
$red->execute(array('A' =>$groupe_uti));
$util=$red->fetch();


//$lib_trace="Cr&eacute;ation de l'utilisateur <b>".stripslashes($nom_utilisateur)."</b> avec email <b>".$email_utilisateur."</b> ,password : <b>".$pass."</b> avec droit d'utilisateur <b>".stripslashes($util['nom_type_groupe'])."</b> pour le service : <b>".$service_utilisateur."</b>";
$lib_trace="Cr&eacute;ation de l'utilisateur <b>".stripslashes($nom_utilisateur)."</b> avec email <b>".$email_utilisateur."</b> avec droit d'utilisateur <b>".stripslashes($util['nom_type_groupe'])."</b>";


$req=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$req->execute(array('A'=>$lib_trace, 'B'=>$date, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));	


echo'0';

unset($con);
}
?>