
<?php
//% permet de retourner la chaine de caract�re 
//rand permet de g�n�rer de fa�on al�atoire et unique une chaine de caract�re
//strlen permet de retourner la longueur d'une cha�ne de caract�res
//substr retourne la cha�ne de caract�res � partir du caract�re  ayant l'indice 1
    $se     =  'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$numero     =  'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
	$id   = ''; 
	$num  ='';

	for($i=0;$i < 7;$i++)    //7 est le nombre de caract�res
	{ 
        $id .= substr($numero,rand()%(strlen($numero)),1); 
	}
	for($j=0;$j < 10;$j++)    //10 est le nombre de caract�res
	{ 
        $num .= substr($numero,rand()%(strlen($numero)),1);
		
	}
	for($j=0;$j < 5;$j++)    //10 est le nombre de caract�res
	{ 
        $ser= substr($se,rand()%(strlen($se)),1);
		
	}
	$securite=$num; 
	$pass=$id; 
	//$serv=$ser; 
	
	?>
