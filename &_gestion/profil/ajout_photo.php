<?php
session_start();
include('../../connex.php');


if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0)
{
$tmp_name=$_FILES["photo"]['tmp_name'];
$name=$_FILES["photo"]['name'];
$info = pathinfo($name);
$extension = $info['extension'];
$img="photo_".time().".".$extension;
move_uploaded_file($tmp_name, '../photo/'.$img);
$sql= $con->prepare("UPDATE utilisateur SET photo_util=:A WHERE secur=:B");
$sql->execute(array('A'=>$img, 'B'=>$_SESSION['secur_hop']));

$_SESSION['photo_hop']=$img;

    echo '1';
}
else
{
    echo '0';
}

unset($con);

?>

