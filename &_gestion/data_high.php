<?php

include('../connex.php');

$category = array();
$category['name'] = 'Jours';

$series1 = array();
$series1['name'] = 'Visiteurs';


$resu= $con->prepare("select date from visite group by date ");      
$resu->execute();

while($ro=$resu->fetch()) {

    $foh =explode("-",$ro['date']);
    $dat=$foh[2].'-'.$foh[1].'-'.$foh[0];
    $category['data'][] = $dat;
}

$result= $con->prepare("select COUNT(*) as cpt from visite group by date ");      
$result->execute();
$rows = array();
while( $row=$result->fetch() ) {
      //$rows[] = array( '0' => $row['0'] , '1' => $row['1'] );
	  $series1['data'][] =  (float)$row['cpt'];
}


//print json_encode($rows, JSON_NUMERIC_CHECK);


$result = array();
array_push($result,$category);
array_push($result,$series1);

print json_encode($result);



?> 
