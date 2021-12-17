<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
<script type='text/javascript'>
var intervalSetting = function () { 
location.reload(); 
}; 
setInterval(intervalSetting, 120000);

	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
	});
	
	$(document).ready(function() {
		$('#date_picker1').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		}); 
		$('#date_picker2').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		}); 
		$('#tabel_kwitansi').DataTable();
		$(".select2").select2();
	
	//-----------------------------------------------Data Table
		$('#tabel_tindakan').DataTable();
		$('#tabel_farm').DataTable();
		$('#tabel_cetak_farm').DataTable();
	} );

</script>

	
<?php
	echo $this->session->flashdata('message_cetak'); 
?>

<section class="content-header">
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group row">
				<div class="col-md-8">
					<?php echo form_open('user/cuser/penunjang/');?>
						<div class="form-group ">
							<input type="text" id="date_picker1" class="form-control" placeholder="Tanggal Awal" name="date0">
							<input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="date1">
							
								<button class="btn btn-primary" type="submit">Cari</button>
							
						</div>
					<?php echo form_close();?>
				</div>
			</div>
			<div class="card card-outline-success">
				<ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item text-center"> 
                    	<a class="nav-link" data-toggle="tab" href="#tabFarmasi" role="tab"><span class="hidden-xs-down">Farmasi</span></a> 
                    </li>
                </ul>
				<div class="tab-content">
					<div id="tabFarmasi" class="tab-pane p-20">
						<div class="p-20">
							<?php include('user_farmasi.php');  ?>
						</div>
					</div> <!-- end div tab lab -->
				</div>
			</div>
		</div>
	</div>
</section>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>