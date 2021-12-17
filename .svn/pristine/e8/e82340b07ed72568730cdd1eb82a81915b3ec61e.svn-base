<?php
	$this->load->view('layout/header.php');
?>

<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <!-- <h4 class="card-title">Horizontal Form</h4> -->
                </div>
                <div class="card-content">
                    <div class="card-body">
						<?php
							echo form_open_multipart('admin/configSave/',array('id'=>'config_form'));
						?>
                            <div class="form-body">
                                <div class="row">
                                	<?php 
                                	// print_r($config);
                                	foreach($config as $row) {
                                		echo '
                                		<div class="col-6">
                                        	<div class="form-group row">
	                                            <div class="col-md-4">
	                                                <span>'.$row->title.'</span>
	                                            </div>
	                                            <div class="col-md-8">
	                                                <input type="'.$row->type.'" id="'.$row->key.'" class="form-control" name="'.$row->key.'" placeholder="'.$row->title.'" value="'.$row->value.'">
	                                            </div>
	                                        </div>
	                                    </div>';
                                	}
                                	?>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                        <!-- <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
	$this->load->view('layout/footer.php');
?>
