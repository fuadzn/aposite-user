<?php
$this->load->view("layout/header2");
?>

<?php echo $this->session->flashdata('success_msg'); ?>
<br>
<div class="card o-hidden border-0 col-md-6 offset-3 mt-5">
     <div class="card-body p-0 ">
          <!-- Nested Row within Card Body -->
          <div class="row ">
               <div class="col-lg">
                    <div class="p-5 ">
                         <div class="text-center">
                              <h1 class="h4 text-gray-900 mb-4">Daftar Operator Sekolah</h1>
                         </div>
                         <div class="card-block p-b-15 ">
                              <form id="cek_form">
                                   <!-- <div class="col-lg-12" style="margin: 0 auto;">	
                            <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="nuptk_lbl">NUPTK</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="nuptk" id="nuptk" onkeypress="return inputNumbersOnly(event)" required>
								</div>
							</div>
                            <div class="form-group row" id="sklh">
								<label class="col-sm-3 control-label col-form-label">Sekolah</label>
								<div class="col-sm-6">
                                    <input type="search" class="auto_search_sekolah form-control" name="sekolah" id="sekolah">
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
                                             <input type="text" class="form-control" name="nama2" id="nama2">
                                        </div>
                                   </div>

                                   <div class="form-group row" id="eml">
                                        <p class="col-sm-3 form-control-label">Email Alternatif</p>
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
                                             <input type="password" class="form-control" name="passs" id="passs">
                                        </div>
                                   </div> -->
                                   <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                             <!-- <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password"> -->
                                             <input type="text" class="form-control" name="nik" placeholder="NIK" style="border-radius:20px; height:40px;" id="nik" onkeypress="return inputNumbersOnly(event)" required>
                                        </div>
                                        <div class="col-sm-6">
                                             <!-- <input type="text" class="form-control" name="nuptk" placeholder="NUPTK" style="border-radius:20px; height:40px;" id="nuptk" onkeypress="return inputNumbersOnly(event)" required> -->
                                             <input type="text" class="form-control" name="npsn" placeholder="NPSN" style="border-radius:20px; height:40px;" id="npsn" onkeypress="return inputNumbersOnly(event)" required>
                                        </div>
                                   </div>
                                   <button type="submit" class="btn btn-primary btn-user btn-block" style="border-radius:20px;">
                                        Check
                                   </button><br><br>
                                   <div class="form-group row" id="nma">
                                        <!-- <p class="col-sm-3 form-control-label">Nama</p> -->
                                        <div class="col-sm-12">
                                             <input type="text" class="form-control" name="nama2" id="nama2" style="border-radius:20px; height:40px;" placeholder="Nama" readonly>
                                        </div>
                                   </div>
                                   <div class="form-group row" id="sklh">
                                        <div class="col-sm-12">
                                             <input type="text" class="form-control" placeholder="Sekolah" style="border-radius:20px;  height:40px;" name="sekolah" id="sekolah" readonly>
                                        </div>
                                   </div>
                                   <!-- <div class="form-group row" id="nps">
                                        <div class="col-sm-12">
                                             <input type="text" class="form-control" placeholder="NPSN" style="border-radius:20px;  height:40px;" name="npsn" id="npsn" readonly>
                                        </div>
                                   </div> -->
                                   <div class="form-group row" id="nup">
                                        <div class="col-sm-12">
                                             <input type="text" class="form-control" placeholder="NUPTK" style="border-radius:20px;  height:40px;" name="nuptk" id="nuptk" readonly>
                                        </div>
                                   </div>
                                   <div class="form-group row" id="tgl">
                                        <div class="col-sm-12">
                                             <input type="text" class="form-control" placeholder="Tanggal Lahir" style="border-radius:20px;  height:40px;" name="tgl_lahir" id="tgl_lahir" readonly>
                                        </div>
                                   </div>
                                   <div class="form-group row" id="eml">
                                        <!-- <p class="col-sm-3 form-control-label">Email Alternatif</p> -->
                                        <div class="col-sm-12">
                                             <input type="email" class="form-control" name="email2" id="email2" style="border-radius:20px; height:40px;" placeholder="Email">
                                        </div>
                                   </div>
                                   <div class=" form-group row" id="hp">
                                        <!-- <p class="col-sm-3 form-control-label">No HP</p> -->
                                        <div class="col-sm-12">
                                             <input type="text" onkeypress="return inputNumbersOnly(event)" class="form-control" name="no_hp" id="no_hp" style="border-radius:20px; height:40px;" placeholder="No HP">
                                        </div>
                                   </div>
                                   <div class="form-group row" id="pass">
                                        <!-- <p class="col-sm-3 form-control-label">Password</p> -->
                                        <div class="col-sm-12">
                                             <input type="hidden" class="form-control col-md-10" name="id_sekolah" id="id_sekolah">
                                             <input type="hidden" class="form-control col-md-10" name="id_region" id="id_region">
                                             <input type="hidden" class="form-control col-md-10" name="id_provinsi" id="id_provinsi">
                                             <input type="password" class="form-control" name="passs" id="passs" style="border-radius:20px; height:40px;" placeholder="Password">
                                        </div>
                                   </div>
                                   <div class="form-group row" id="verif">
                                        <!-- <p class="col-sm-3 form-control-label">Password</p> -->
                                        <div class="col-sm-6">
                                             <input type="text" class="form-control" name="verifi" id="verifi" style="border-radius:20px; height:40px;" placeholder="Masukan Kode Verifikasi">
                                        </div>
                                        <div class="col-sm-6">
                                             <button type="button" onclick="verifikasi()" class="btn waves-effect waves-light btn-success form-control" name="btn-kode" id="btn-kode" style="border-radius:20px; height:40px;">Minta Kode</button>
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-md-12">
                                             <div class="row">
                                                  <div class="col-sm-12 text-center">
                                                       <button type="button" onclick="insert_sekolah()" class="btn waves-effect waves-light btn-primary col-sm-12" name="btn-submit" id="btn-submit" style="border-radius:20px; height:40px;" placeholder="Nama">Simpan</button>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                         </div>
                         <div class="form-actions" id="simpan">
                              <div class="text-center">
                                   <a class="small" href="<?= site_url('Login_portal'); ?>">Sudah punya akun? Login!</a>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
</form>
</div>
</div>


<?php
$this->load->view("layout/footer");
?>

<script type='text/javascript'>
     $(document).ready(function() {
          // $( "#sekolah" ).autocomplete({
          //   source: "<?php echo site_url('daftar_sekolah/get_autocomplete'); ?>"
          // });
          $('.auto_search_sekolah').autocomplete({
               serviceUrl: '<?php echo site_url(); ?>daftar_sekolah/get_autocomplete',
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
               url: "<?php echo site_url('Daftar_Sekolah/insert_sekolah'); ?>",
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
                         if (data.msg !== null || data.msg !== '') {
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
               url: "<?php echo site_url('Daftar_Sekolah/email'); ?>",
               dataType: "JSON",
               data: $('#cek_form').serialize(),
               success: function(data, result) {
                    if (data.success) {

                    } else {
                         
                    }
               },
          });
     }

     function verifikasi() {
          // document.getElementById("btn-kode").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
          $.ajax({
               type: "POST",
               url: "<?php echo site_url('Daftar_Sekolah/kode_verif'); ?>",
               dataType: "JSON",
               data: $('#cek_form').serialize(),
               success: function(data, result) {
                    if (data.success) {
                         swal.fire({
                              title: 'Kode berhasil dikirim',
                              text: data.msg,
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonText: 'Ok',
                              confirmButtonClass: 'btn btn-primary',
                              buttonsStyling: false,
                         });
                    } else {
                         swal.fire({
                              type: 'error',
                              title: data.msg,
                         });
                    }
               },
          });
     }

     function inputNumbersOnly(evt) {
          var charCode = (evt.which) ? evt.which : evt.keyCode
          if (charCode > 31 && (charCode < 48 || charCode > 57))
               return false;
          return true;
     }

     $('#nma').hide();
     $('#sklh').hide();
     // $('#nps').hide();
     $('#nup').hide();
     $('#tgl').hide();
     $('#hp').hide();
     $('#eml').hide();
     $('#pass').hide();
     $('#verif').hide();
     $('#btn-submit').hide();

     $("#cek_form").submit(function(event) {

          event.preventDefault();
          $.ajax({
               url: "<?php echo site_url('Daftar_Sekolah/cek_data_sekolah') ?>",
               type: 'POST',
               dataType: 'json',
               data: $(this).serialize(),
               success: function(data) {
                    if (data.success) {
                         // $('#nuptk').attr('readonly', true);
                         $('#npsn').attr('readonly', true);
                         $('#nik').attr('readonly', true);
                         $('#sekolah').attr('readonly', true);
                         $('#cek').hide();
                         $('#nama2').val(data.nama);
                         $('#nma').show();
                         $('#sekolah').val(data.nm_sekolah);
                         $('#sklh').show();
                         // $('#npsn').val(data.npsn);
                         // $('#nps').hide();
                         $('#nuptk').val(data.nuptk);
                         $('#nup').hide();
                         $('#tgl_lahir').val(data.tgl_lahir);
                         $('#tgl').hide();
                         $('#eml').show();
                         $('#hp').show();
                         $('#id_sekolah').val(data.id_sekolah);
                         $('#id_provinsi').val(data.id_provinsi);
                         $('#id_region').val(data.id_region);
                         $('#pass').show();
                         $('#verif').show();
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