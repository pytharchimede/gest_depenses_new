<?php

session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{
$red=$con->prepare("SELECT * FROM affectation WHERE id_affectation=:A"); 
$red->execute(array('A' =>$id));
$uti=$red->fetch();

$_SESSION['id_affectation_mod']=$uti['id_affectation'];
$_SESSION['lib_affectation_mod']=$uti["lib_affectation"];
?>
		
                                <form action="#" name="form_affectation_mod" id="form_affectation_mod">
									<div class="modal-body">                
														
                                    <div class="row">
        <div class="col-md-12 col-xs-12">
				 <label>Titre du affectation <span class="semi_aste">*</span></label>
				 <input type="text" class="form-control" required id="lib_affectation_mod" name="lib_affectation_mod" value="<?php echo $uti['lib_affectation']; ?>"  />
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
