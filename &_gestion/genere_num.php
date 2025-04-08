
<?php
//% permet de retourner la chaine de caractère 
//rand permet de générer de façon aléatoire et unique une chaine de caractère
//strlen permet de retourner la longueur d'une chaîne de caractères
//substr retourne la chaîne de caractères à partir du caractère  ayant l'indice 1
    $se     =  'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$numero     =  'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
	$id   = ''; 
	$num  ='';

	for($i=0;$i < 7;$i++)    //7 est le nombre de caractères
	{ 
        $id .= substr($numero,rand()%(strlen($numero)),1); 
	}
	for($j=0;$j < 10;$j++)    //10 est le nombre de caractères
	{ 
        $num .= substr($numero,rand()%(strlen($numero)),1);
		
	}
	for($j=0;$j < 5;$j++)    //10 est le nombre de caractères
	{ 
        $ser= substr($se,rand()%(strlen($se)),1);
		
	}
	$securite=$num; 
	$pass=$id; 
	//$serv=$ser; 
	
	?>
