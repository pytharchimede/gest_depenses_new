<?php
session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{

$red=$con->prepare("SELECT * FROM affectation WHERE id_affectation=:A " ); 
$red->execute(array('A' =>$id));
$util=$red->fetch();

$_SESSION['affectation_sup_code']=$util["id_affectation"];

echo'
<form name="sup_marque" id="sup_marque" action="#">
	<div>';
     echo"<p class='col_sup'>Etes vous sûr de vouloir supprimer l'affectation <b>".stripslashes($util["lib_affectation"])."</b> ?</p>";  
   
   echo'</form>
<?php
';

}

unset($con);
?>
