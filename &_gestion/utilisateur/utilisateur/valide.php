<?php
session_start();
include('../../../connex.php');

$id=$_GET['ref'];

$red=$con->prepare("SELECT * FROM utilisateur WHERE id_utilisateur=:A" ); 
$red->execute(array('A' =>$id));
$ut=$red->fetch();

if($ut['valide_util']==0)
{
$sta=1;
}
else
{
$sta=0;
}

$req=$con->prepare("UPDATE utilisateur SET valide_util=:A WHERE id_utilisateur=:B");
$req->execute(array('A'=>$sta, 'B'=>$id));

$req=$con->prepare("UPDATE personnel_soignant SET valide=:A WHERE id_personnel_soignant=:B");
$req->execute(array('A'=>$sta, 'B'=>$ut['personnel_soignant_id']));

echo $sta;


unset($con);

?>