<?php
session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{

$red=$con->prepare("SELECT * FROM serv_bureau_fidest WHERE id_serv_bureau_fidest=:A " ); 
$red->execute(array('A' =>$id));
$util=$red->fetch();

$_SESSION['serv_bureau_fidest_sup_code']=$util["id_serv_bureau_fidest"];

echo'
<form name="sup_marque" id="sup_marque" action="#">
	<div>';
     echo"<p class='col_sup'>Etes vous sûr de vouloir supprimer l'serv_bureau_fidest <b>".stripslashes($util["lib_serv_bureau_fidest"])."</b> ?</p>";  
   
   echo'</form>
<?php
';

}

unset($con);
?>
