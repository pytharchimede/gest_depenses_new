<?php
session_start();

include('../../../../connex.php');

$red2=$con->prepare("DELETE FROM trace");
$red2->execute();
   
unset($con);
header('Location: ../historique.php');  

?>