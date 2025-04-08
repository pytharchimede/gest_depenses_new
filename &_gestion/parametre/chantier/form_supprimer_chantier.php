<?php
session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{

$red=$con->prepare("SELECT * FROM chantier WHERE id_chantier=:A " ); 
$red->execute(array('A' =>$id));
$util=$red->fetch();

$_SESSION['chantier_sup_code']=$util["id_chantier"];

echo'
<form name="sup_marque" id="sup_marque" action="#">
	<div>';
     echo"<p class='col_sup'>Etes vous sûr de vouloir supprimer l'chantier <b>".stripslashes($util["lib_chantier"])."</b> ?</p>";  
   
   echo'</form>
<?php
';

}

unset($con);
?>
