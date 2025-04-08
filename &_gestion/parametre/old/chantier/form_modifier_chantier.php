<?php

session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{
$red=$con->prepare("SELECT * FROM chantier WHERE id_chantier=:A"); 
$red->execute(array('A' =>$id));
$uti=$red->fetch();

$_SESSION['id_chantier_mod']=$uti['id_chantier'];
$_SESSION['lib_chantier_mod']=$uti["lib_chantier"];
$_SESSION['cout_total_chantier_mod']=$uti["cout_total_chantier"];
?>
		
                                <form action="#" name="form_chantier_mod" id="form_chantier_mod">
									<div class="modal-body">                
														
                                    <div class="row">
        <div class="col-md-6 col-xs-6">
				 <label>Titre du chantier <span class="semi_aste">*</span></label>
				 <input type="text" class="form-control" required id="lib_chantier_mod" name="lib_chantier_mod" value="<?php echo $uti['lib_chantier']; ?>"  />
        </div>

        <div class="col-md-6 col-xs-6">
				 <label>Coût total <span class="semi_aste">*</span></label>
				 <input type="text" class="form-control" required id="cout_total_chantier_mod" name="cout_total_chantier_mod" value="<?php echo $uti['cout_total_chantier']; ?>"  />
        </div>

		</div>	

									</div>   
                                    
                                    <div class="modal-footer ajout-footer_file"> 
                                        <button type="submit" id="submit_mod" class="btn button_enregistrer"><i class="fa  fa-floppy"></i> Enregistrer</button>
                                        <button type="button" class="btn button_annuler" data-dismiss="modal"><i class="fa fa-times"></i> Annuler</button>
                                    &nbsp;&nbsp;
                                    </div>
										
								</form>	

<?php
}
unset($con);
?>
