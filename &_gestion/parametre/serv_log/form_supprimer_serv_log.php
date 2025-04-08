<?php
session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{

$red=$con->prepare("SELECT * FROM serv_log WHERE id_serv_log=:A " ); 
$red->execute(array('A' =>$id));
$util=$red->fetch();

$_SESSION['serv_log_sup_code']=$util["id_serv_log"];

echo'
<form name="sup_marque" id="sup_marque" action="#">
	<div>';
     echo"<p class='col_sup'>Etes vous sûr de vouloir supprimer l'serv_log <b>".stripslashes($util["lib_serv_log"])."</b> ?</p>";  
   
   echo'</form>
<?php
';

}

unset($con);
?>
