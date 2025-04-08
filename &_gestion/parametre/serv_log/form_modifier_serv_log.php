<?php

session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{
$red=$con->prepare("SELECT * FROM serv_log WHERE id_serv_log=:A"); 
$red->execute(array('A' =>$id));
$uti=$red->fetch();

$_SESSION['id_serv_log_mod']=$uti['id_serv_log'];
$_SESSION['lib_serv_log_mod']=$uti["lib_serv_log"];
?>
		
                                <form action="#" name="form_serv_log_mod" id="form_serv_log_mod">
									<div class="modal-body">                
														
                                    <div class="row">
        <div class="col-md-12 col-xs-12">
				 <label>Titre du serv_log <span class="semi_aste">*</span></label>
				 <input type="text" class="form-control" required id="lib_serv_log_mod" name="lib_serv_log_mod" value="<?php echo $uti['lib_serv_log']; ?>"  />
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
