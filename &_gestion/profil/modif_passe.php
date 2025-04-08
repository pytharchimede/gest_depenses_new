 
<?php
session_start();

include('../../connex.php');

$pass_ac=addslashes($_POST['mot_actuel']);
$pass_co=addslashes($_POST['new_mot']);

$pass_a= hash("sha512", $pass_ac);
$pass_c= hash("sha512", $pass_co);

$rel=$con->prepare("SELECT * FROM utilisateur WHERE motpass_utilisateur=:A AND secur=:B"); 
$rel->execute(array('A' => $pass_a, 'B' => $_SESSION['secur_hop']));
$count = $rel->rowCount();

if($count>0)
{			  
$sql= $con->prepare("UPDATE utilisateur SET motpass_utilisateur='".$pass_c."' WHERE secur='".$_SESSION['secur_hop']."' ");
$sql->execute();
echo'0';
}
else
{
echo'1';
}

unset($con);
?>
 
 