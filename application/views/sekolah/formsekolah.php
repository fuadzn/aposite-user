<?php
        $this->load->view("layout/header");
?>
	
<?php echo $this->session->flashdata('success_msg'); ?>
<br>
<div class="card card-outline-info">
	<div class="card-header">
        <h4 class="m-b-0 text-white text-center">PENDAFTARAN EMAIL BARU</h4>
    </div>
    <div class="card-block p-b-15">
    <!-- <?php echo form_open('Sekolah/insert_sekolah');?>	 -->
					<form id="cek_form">
						<div class="col-lg-10" style="margin: 0 auto;">	
                              <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="nik_lbl">NIK</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="nik" id="nik" onkeypress="return inputNumbersOnly(event)" required>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="nuptk_lbl">NPSN</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="npsn" id="npsn" onkeypress="return inputNumbersOnly(event)" required>
								</div>
                                   </div>
                            
                            <div class="form-group row">
                            <label class="col-sm-7 control-label col-form-label"></label>
                                <div class="col-sm-3">
                                    <button type="submit" id="cek" class="btn btn-primary btn-inline">Check</button><br>
                                </div>
                            </div>
							<div class="form-group row" id="nma">
                                        <p class="col-sm-3 form-control-label">Nama</p>
                                        <div class="col-sm-6">
                                             <input type="text" class="form-control" name="nama2" id="nama2" readonly>
                                        </div>
                                   </div>
							<div class="form-group row" id="nuptks">
                                        <p class="col-sm-3 form-control-label">NUPTK</p>
                                        <div class="col-sm-6">
                                             <input type="text" class="form-control" name="nuptk" id="nuptk" readonly>
                                        </div>
                                   </div>
                                   <div class="form-group row" id="sklh">
								<p class="col-sm-3 control-label">Sekolah</p>
								<div class="col-sm-6">
                                    <input type="text" class="form-control" name="sekolah" id="sekolah">
								</div>
							</div>
                                   <div class="form-group row" id="tgl">
								<p class="col-sm-3 control-label">Tanggal Lahir</p>
								<div class="col-sm-6">
                                    <input type="text" class="form-control" name="tgl_lahir" id="tgl_lahir">
								</div>
							</div>
                                   <div class="form-group row" id="eml">
                                        <p class="col-sm-3 form-control-label">Email</p>
                                        <div class="col-sm-6">
                                             <input type="email" class="form-control" name="email2" id="email2">
                                        </div>
                                   </div>
                                   <div class=" form-group row" id="hp">
                                        <p class="col-sm-3 form-control-label">No HP</p>
                                        <div class="col-sm-6">
                                             <input type="text" onkeypress="return inputNumbersOnly(event)" class="form-control" name="no_hp" id="no_hp">
                                        </div>
                                   </div>
                                   <div class="form-group row" id="pass">
                                        <p class="col-sm-3 form-control-label">Password</p>
                                        <div class="col-sm-6">
                                            <input type="hidden" class="form-control col-md-10" name="id_sekolah" id="id_sekolah">
                                            <input type="hidden" class="form-control col-md-10" name="id_region" id="id_region">
                                            <input type="hidden" class="form-control col-md-10" name="id_provinsi" id="id_provinsi">
                                             <input type="password" class="form-control" name="passs" id="passs">
                                        </div>
                                   </div>
			<div class="form-actions" id="simpan">
                <div class="row">
                    <div class="col-md-12">
                         <div class="row">
                             <div class="col-md-12 text-center">
								<button type="button" onclick="insert_sekolah()" class="btn waves-effect waves-light btn-primary" name="btn-submit" id="btn-submit">Simpan</button>
                             </div>
                         </div>
                     </div>
                </div>
            </div>
		<!-- <?php echo form_close();?> -->
    </div>
</form>
</div>
</div>

	
<?php 
    $this->load->view("layout/footer");
?> 

<script type='text/javascript'>
        $(document).ready(function(){
            // $( "#sekolah" ).autocomplete({
            //   source: "<?php echo site_url('sekolah/get_autocomplete');?>"
            // });
          $('.auto_search_sekolah').autocomplete({
               serviceUrl: '<?php echo site_url();?>sekolah/get_autocomplete',
               // onSelect: function (suggestion) {
               //      $('#cari_no_cm').val(''+suggestion.no_cm);
               //      $('#no_medrec_baru').val(''+suggestion.no_medrec);
               //      // alert(suggestion.no_cm);

               // }
          });
        });

        function insert_sekolah() {
          document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
          $.ajax({
               type: "POST",
               url: "<?php echo site_url('Sekolah/insert_sekolah'); ?>",
               dataType: "JSON",
               data: $('#cek_form').serialize(),
               success: function(data, result) {
                    var str = "Username : " + data.nuptk + "\n" +
                         "Password : " + data.password + "\n" +
                         "Email Alternatif : " + data.email + "\n" +
                         "*Jangan lupa discreenshoot!" + "\n";
                    if (data.success) {

                         document.getElementById("btn-submit").innerHTML = 'Simpan';
                         $('#modal-sd').modal('hide');
                         $('.modal-backdrop').remove();
                         swal.fire({
                              title: 'Data berhasil disimpan',
                              html: '<pre>' + str + '</pre>',
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonText: 'Ok',
                              confirmButtonClass: 'btn btn-primary',
                              buttonsStyling: false,
                         }).then(function(result) {
                              window.location.reload();
                         });
                    } else {
                         if (data.msg !== null) {
                              document.getElementById("btn-submit").innerHTML = 'Simpan';
                              $('.modal-backdrop').remove();
                              Swal.fire({
                                   type: 'warning',
                                   title: 'Gagal!',
                                   text: data.msg
                              });
                         }
                    }
               },
               error: function(event, textStatus, errorThrown) {
                    document.getElementById("btn-submit").innerHTML = 'Simpan';
                    $('#modal-sd').modal('hide');
                    $('.modal-backdrop').remove();
                    swal.fire("Error", "Gagal menyimpan data.", "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
               }
          });
          $.ajax({
               type: "POST",
               url: "<?php echo site_url('Sekolah/email'); ?>",
               dataType: "JSON",
               data: $('#cek_form').serialize(),
               success: function(data, result) {
                    if (data.success) {
                    } else {
                    }
               },
          });
     }

    function inputNumbersOnly(evt){
	    var charCode = (evt.which) ? evt.which : evt.keyCode
	    if (charCode > 31 && (charCode < 48 || charCode > 57))
	        return false;
	    return true;
	}

    $('#nma').hide();
    $('#sklh').hide();
    $('#nps').hide();
    $('#tgl').hide();
    $('#nuptks').hide();
    $('#hp').hide();
    $('#eml').hide();
    $('#pass').hide();
    $('#btn-submit').hide();

    $("#cek_form").submit(function(event) {

        event.preventDefault();
        $.ajax({
            url: "<?php echo site_url('Sekolah/cek_data_sekolah') ?>",
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(data) {
                if (data.success) {
                    $('#npsn').attr('readonly', true);
                    // $('#nik').attr('readonly', true);
                    $('#sekolah').attr('readonly', true);
                    $('#tgl_lahir').attr('readonly', true);
                    $('#cek').hide();
                    $('#nama2').val(data.nama);
                    $('#nma').show();
                    $('#sekolah').val(data.nm_sekolah);
                    $('#sklh').show();
                    $('#nps').hide();
                    $('#nuptks').hide();
                    $('#tgl_lahir').val(data.tgl_lahir);
                    $('#nuptk').val(data.nuptk);
                    $('#tgl').hide();
                    $('#eml').show();
                    $('#hp').show();
                    $('#id_sekolah').val(data.id_sekolah);
                    $('#id_region').val(data.id_region);
                    $('#id_provinsi').val(data.id_provinsi);
                    $('#pass').show();
                    $('#btn-submit').show();

                } else {
                    if (data.msg !== '') {
                            Swal.fire({
                                type: 'warning',
                                title: 'Gagal!',
                                text: data.msg
                            });
                    } else {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Terjadi Kesalahan... Silahkan hubungi Administrator'
                            });
                    }
                }
            }

        });
    });
</script>