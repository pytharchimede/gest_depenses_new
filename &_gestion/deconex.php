<?php
session_start();

/*include('connex.php');

$req=$con->prepare("UPDATE adm_user SET connecte=:A WHERE id=:B");
$req->execute(array('A'=>'Non', 'B'=>$_SESSION['id_util']));*/

if(isset($_SESSION['pass_hop']) && $_SESSION['pass_hop']!=''){ unset($_SESSION['pass_hop']); }
if(isset($_SESSION['secur_hop']) && $_SESSION['secur_hop']!=''){ unset($_SESSION['secur_hop']); }

header('Location: ../_logger.html'); 
?>
