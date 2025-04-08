<?php
session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{

$red=$con->prepare("SELECT * FROM designation WHERE id_designation=:A " ); 
$red->execute(array('A' =>$id));
$util=$red->fetch();

$_SESSION['designation_sup_code']=$util["id_designation"];

echo'
<form name="sup_marque" id="sup_marque" action="#">
	<div>';
     echo"<p class='col_sup'>Etes vous sûr de vouloir supprimer la désignation <b>".stripslashes($util["lib_designation"])."</b> ?</p>";  
   
   echo'</form>
<?php
';

}

unset($con);
?>
