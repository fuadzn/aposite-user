<?php
        $this->load->view("layout/header");
?>
	
<?php echo $this->session->flashdata('success_msg'); ?>
<br>
<div class="card card-outline-info">
    <div class="card-block p-b-15">
    <?php echo form_open('email/insert_email');?>	
    <section id="basic-horizontal-layouts">
	<div class="row">
		<div class="col-md-12 col-12">			
    <div class="card">
				<div class="card-header bg-danger pb-1">
					<h3 class="card-title text-center text-white">Data Siswa</h3>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="table-responsive" style="clear: both;">
									<table class="table-xs table-striped" width="100%">
										<tbody>
											<tr>
												<td style="width: 38%;color:green">Email</td>
												<td style="width: 5%;">:
                                                <!-- <?php echo $data_pasien_daftar_ulang->no_antrian; ?>@siswa.id -->
                                                </td>
											</tr>
											<tr>
												<td style="width: 38%;">NISN</td>
												<td style="width: 5%;">:</td>
												<!-- <td><?php echo $data_pasien_daftar_ulang->no_cm; ?></td> -->
											</tr>
											<tr>
												<td style="width: 38%;">Tanggal Lahir</td>
												<td style="width: 5%;">:</td>
												<!-- <td><?php echo strtoupper($data_pasien_daftar_ulang->nama); ?></td> -->
											</tr>
											<tr>
												<td style="width: 38%;">Nama</td>
												<td style="width: 5%;">:</td>
												<!-- <td><?php echo $no_register; ?></td> -->
											</tr>
											<tr>
												<td style="width: 38%;">Sekolah</td>
												<td style="width: 5%;">:</td>
												<!-- <td><?php echo $data_pasien_daftar_ulang->umurrj . ' Thn ' . $data_pasien_daftar_ulang->ublnrj . ' Bln ' . $data_pasien_daftar_ulang->uharirj . ' Hr'; ?></td> -->
											</tr>
										</tbody>
									</table>
								</div>
							</div>
                        </div>
                    </div>
                </div>
			</div>
        </div>
    </div>
</section>
		<?php echo form_close();?>
	</div>
</div>

	
<?php 
    $this->load->view("layout/footer");
?> 

<script type='text/javascript'>

    $('.date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
			orientation: "auto bottom",
		}); 

    function inputNumbersOnly(evt){
	    var charCode = (evt.which) ? evt.which : evt.keyCode
	    if (charCode > 31 && (charCode < 48 || charCode > 57))
	        return false;
	    return true;
	}
</script>