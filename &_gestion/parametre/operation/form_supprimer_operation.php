<?php
session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{

$red=$con->prepare("SELECT * FROM operation WHERE id_operation=:A " ); 
$red->execute(array('A' =>$id));
$util=$red->fetch();

$_SESSION['operation_sup_code']=$util["id_operation"];

echo'
<form name="sup_marque" id="sup_marque" action="#">
	<div>';
     echo"<p class='col_sup'>Etes vous sûr de vouloir supprimer l'operation <b>".stripslashes($util["lib_operation"])."</b> ?</p>";  
   
   echo'</form>
<?php
';

}

unset($con);
?>
