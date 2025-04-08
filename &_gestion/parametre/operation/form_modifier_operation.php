<?php

session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{
$red=$con->prepare("SELECT * FROM operation WHERE id_operation=:A"); 
$red->execute(array('A' =>$id));
$uti=$red->fetch();

$_SESSION['id_operation_mod']=$uti['id_operation'];
$_SESSION['lib_operation_mod']=$uti["lib_operation"];
$_SESSION['chantier_id_operation_mod']=$uti["chantier_id_operation"];
?>
		
                                <form action="#" name="form_operation_mod" id="form_operation_mod">
									<div class="modal-body">                
														
                                    <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <label>Chantier concerné <span class="semi_aste">*</span></label>
                                    <select class="form-control selectpicker" data-placeholder="Choisir" id="chantier_id_operation_mod" title="Choisir..." style="width: 100%;" data-live-search="true" data-width="100%">
                                        <option value="">---Choisir---</option>
                                                <?php
                                    $red=$con->prepare("SELECT * FROM chantier ORDER BY lib_chantier ASC");
                                    $red->execute();
                                    while($ro=$red->fetch())
                                    {
                                    ?>
                                    <option value="<?php echo''.$ro['id_chantier'].''; ?>" <?php if($ro['id_chantier']==$uti["chantier_id_operation"]){ echo ' selected '; }?>><?php echo''.stripslashes($ro['lib_chantier']).'' ; ?></option>
                                            <?php
                                    }
                                                ?>
                                    </select>
                                </div>
                                <div class="col-md-8 col-xs-12">
                                    <label>Libellé operation <span class="semi_aste">*</span></label>
                                    <input type="text" class="form-control" required id="lib_operation_mod" name="lib_operation_mod" value="<?php echo $uti["lib_operation"]; ?>"  />
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
