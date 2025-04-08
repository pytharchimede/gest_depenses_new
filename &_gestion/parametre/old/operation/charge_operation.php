<?php
    session_start();
	
	include('../../../connex.php');
	
    ini_set('memory_limit','512M');
    ini_set('max_execution_time', 12000);
	
	
    ?>
    <script>

	 function change_page_operation(page_id_cons){
       
  var dataString = 'page_id_cons='+ page_id_cons;
	 
     $.ajax({
           type: "POST",
           url: "operation/charge_operation.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../../images/loading.gif" style="width:25px; height:25px;" />').show();
            $(".aff_operation").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../../images/loading.gif" style="width:25px; height:25px;" />').hide();
		  $(".aff_operation").html(result).show();
		   }
      });
    }
	</script>
     

    <?php

$requete=" SELECT * FROM operation LEFT JOIN chantier ON chantier.id_chantier=operation.chantier_id_operation WHERE id_operation!='' ";


    $sqlQuery=$con->query($requete);

	$count  	= $sqlQuery->rowCount();
    $count_1  	= $sqlQuery->rowCount();
	
	$adjacents = 2;
	$records_per_page = 4;
	
	$page = (int) (isset($_POST['page_id_cons']) ? $_POST['page_id_cons'] : 1);
	$page = ($page == 0 ? 1 : $page);
	$start = ($page-1) * $records_per_page;
	
	$next = $page + 1;    
	$prev = $page - 1;
	$last_page = ceil($count/$records_per_page);
	$second_last = $last_page - 1; 

	
	$pagination = "";
	if($last_page > 1){
        $pagination .= "<div class='pagination'>";
        if($page > 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(1);'>&laquo; Debut</a>";
        else
            $pagination.= "<span class='disabled'>&laquo; Debut</span>";
		
		if ($page > 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(".($prev).");'>&laquo; Precedent&nbsp;&nbsp;</a>";
        else
            $pagination.= "<span class='disabled'>&laquo; Precedent&nbsp;&nbsp;</span>";   
		
        if ($last_page < 7 + ($adjacents * 2))
        {   
            for ($counter = 1; $counter <= $last_page; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class='current'>$counter</span>";
                else
                    $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(".($counter).");'>$counter</a>";     
                         
            }
        }
        elseif($last_page > 5 + ($adjacents * 2))
        {
            if($page < 1 + ($adjacents * 2))
            {
                for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                {
                    if($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                    else
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(".($counter).");'>$counter</a>";     
                }
                $pagination.= "...";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(".($second_last).");'> $second_last</a>";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(".($last_page).");'>$last_page</a>";   
           
           }
           elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))
           {
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(1);'>1</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(2);'>2</a>";
               $pagination.= "...";
               for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
               {
                   if($counter == $page)
                       $pagination.= "<span class='current'>$counter</span>";
                   else
                       $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(".($counter).");'>$counter</a>";     
               }
               $pagination.= "..";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(".($second_last).");'>$second_last</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(".($last_page).");'>$last_page</a>";   
           }
           else
           {
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(1);'>1</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(2);'>2</a>";
               $pagination.= "..";
               for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)
               {
                   if($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                   else
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(".($counter).");'>$counter</a>";     
               }
           }
        }
        if($page < $counter - 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(".($next).");'>Suivant &raquo;</a>";
        else
            $pagination.= "<span class='disabled'>Suivant &raquo;</span>";
		
		if($page < $last_page)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_operation(".($last_page).");'>Fin &raquo;</a>";
        else
            $pagination.= "<span class='disabled'>Fin &raquo;</span>";
        
        $pagination.= "</div>";       
    }

    $req=" SELECT * FROM operation LEFT JOIN chantier ON chantier.id_chantier=operation.chantier_id_operation WHERE id_operation!=''   ";
 
    
    $req.=" ORDER BY id_operation ASC LIMIT ".$start.", ".$records_per_page." ";

$records=$con->query($req);    
 
$count  = $records->rowCount();
$HTML='';

$HTML.='
<p style="color:grey;">Nombre de operations : <b>'.$count_1.'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>';
					             
if($count > 0)
{

    $HTML.='<div class="table-responsive">
					                <table class="table table-striped table-vcenter">
					                    <thead>
					                        <tr>
                                                <th>&nbsp;</th>
                                                <th>Chantier</th>
                                                <th>Libellé de l\'opération</th>		
					                            <th>Actions</th>
					                        </tr>
					                    </thead>
					                    <tbody>';

$i=1;

    foreach($records as $row) {
	
$HTML.=' 
<tr>

            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['id_operation']).'</span></td>
            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['lib_chantier']).'</span></td> 
            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['lib_operation']).'</span></td> 
                
            <td>
                                                            <div class="btn-groups">   
        <a href="javascript:void();" data-id='.$row['id_operation'].' class="btn btn-icon icon-lg edit_operation" data-toggle="modal" data-target="#myModal_operation_mod"  title="Modifier" style="color:#006699; font-weight:600; text-transform:uppercase"><i class="fa fa-edit"></i></a>
        <a href="javascript:void();" class="btn btn-icon icon-lg delete_operation" data-toggle="modal" data-target="#myModal_operation_sup" data-id='.$row['id_operation'].' title="Supprimer" style="color:#006699; font-weight:600; text-transform:uppercase"><i class="fa fa-trash"></i></a>
                                                            '; 

                                                
$HTML.='
            </td>';

$HTML.='</tr>'; 

  $i++;		                                                                 
}

$HTML.='</div>';
			
}
 
else
{
    $titre='<br />Aucun operation  trouv&eacute;';
    $donnee=utf8_encode($titre);
    $HTML.='<div><font color="#990000" style="font-size:11px; align="center"">'.$donnee.'</font></div>';
}
	   	
$HTML.='';	   
echo $HTML;
echo $pagination;
echo'<br /><br />';
unset($con);

?>