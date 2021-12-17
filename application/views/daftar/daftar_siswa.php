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
                              <h1 class="h4 text-gray-900 mb-4">Daftar Email Siswa</h1>
                         </div>
                         <div class="card-block p-b-15 ">
                              <!-- <?php echo form_open('daftar_siswa/insert_email'); ?>	 -->
                              <form id="input_siswa">
                                   <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                             <input type="text" class="form-control" name="nisn" id="nisn" onkeypress="return inputNumbersOnly(event)" required style="border-radius:20px; height:40px;" placeholder="NISN">
                                        </div>
                                        <div class="col-sm-6">
                                             <input type="text" class="form-control" name="npsn" id="npsn" onkeypress="return inputNumbersOnly(event)" maxlength="16" required style="border-radius:20px; height:40px;" placeholder="NPSN">
                                        </div>
                                   </div>
                                   <button type="submit" class="btn btn-primary btn-user btn-block" id="check" style="border-radius:20px;">
                                        Cek
                                   </button><br><br>
                                   <div class="form-group row" id="nama_fg">
                                        <!-- <p class="col-sm-3 form-control-label">Nama</p> -->
                                        <div class="col-sm-12">
                                             <input type="text" class="form-control" name="nama" id="nama" readonly style="border-radius:20px; height:40px;" placeholder="Nama">
                                        </div>
                                   </div>

                                   <div class="form-group row" id="sekollah_fg">
                                        <!-- <p class="col-sm-3 form-control-label">Email Alternatif</p> -->
                                        <div class="col-sm-12">
                                             <input type="text" class="form-control" style="border-radius:20px; height:40px;" name="nm_sekolah" id="nm_sekolah" readonly>
                                        </div>
                                   </div>


                         </div>
                         <div class=" form-group row" id="nisn_fg">
                              <!-- <p class="col-sm-3 form-control-label">No HP</p> -->
                              <div class="col-sm-12">
                                   <input type="text" class="form-control col-md-12" style="border-radius:20px; height:40px;" placeholder="@siswa.id" name="nisnn" id="nisnn" readonly>
                              </div>
                         </div>
                         <div class=" form-group row" id="hp_fg">
                              <!-- <p class="col-sm-3 form-control-label">No HP</p> -->
                              <div class="col-sm-12">
                                   <input type="number" class="form-control col-md-12" style="border-radius:20px; height:40px;" placeholder="No Hp" name="no_hps" id="no_hps">
                              </div>
                         </div>
                         <div class="form-group row" id="email_fg">
                              <!-- <label class="col-sm-3 control-label col-form-label">Email Alternatif</label> -->
                              <div class="col-sm-12">
                                   <input type="email" class="form-control col-md-12" style="border-radius:20px; height:40px;" placeholder="Email Rekan Siswa / Email Admin TI Sekolah" name="emailal" id="emailal">
                                   <input type="text" class="form-control col-md-10" name="id_region" id="id_region" hidden>
                                   <input type="text" class="form-control col-md-10" name="alamat" id="alamat" hidden>
                                   <input type="text" class="form-control col-md-10" name="tgl_lahir" id="tgl_lahir" hidden>
                                   <input type="text" class="form-control col-md-10" name="id_sekolah" id="id_sekolah" hidden>
                              </div>
                         </div><br>
                         <h4 id="teks">Data Orang Tua / Wali</h4>
                         <div class=" form-group row" id="nmortu_fg">
                              <!-- <p class="col-sm-3 form-control-label">No HP</p> -->
                              <div class="col-sm-12">
                                   <input type="text" class="form-control col-md-12" style="border-radius:20px; height:40px;" placeholder="Nama Orang Tua / Wali *" name="nama_ortu" id="nama_ortu">
                              </div>
                         </div>
                         <div class=" form-group row" id="no_ortufg">
                              <!-- <p class="col-sm-3 form-control-label">No HP</p> -->
                              <div class="col-sm-12">
                                   <input type="number" class="form-control col-md-12" style="border-radius:20px; height:40px;" placeholder="Nomor Orang Tua / Wali" name="no_ortu" id="no_ortu">
                              </div>
                         </div>
                         <div class=" form-group row" id="email_ortufg">
                              <!-- <p class="col-sm-3 form-control-label">No HP</p> -->
                              <div class="col-sm-12">
                                   <input type="text" class="form-control col-md-12" style="border-radius:20px; height:40px;" placeholder="Email Orang Tua / Wali" name="email_ortu" id="email_ortu">
                              </div>
                         </div>
                         <input type="text" class="form-control" style="border-radius:20px; height:40px;" name="sex" id="sex" hidden>
                         <div class="row">
                              <div class="col-md-12">
                                   <div class="row">
                                        <div class="col-sm-12 text-center">
                                             <button type="button" onclick="insert_siswa()" class="btn waves-effect waves-light btn-primary col-sm-12" name="btn-submit" id="btn-submit" style="border-radius:20px; height:40px;" placeholder="Nama">Simpan</button>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="form-actions" id="simpan">
                              <div class="text-center">
                                   <a class="small" href="<?= site_url('Login_portal'); ?>">Kembali</a>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <!-- <?php echo form_close(); ?> -->
</div>
</form>
</div>
</div>


<?php
$this->load->view("layout/footer");
?>

<script type="text/javascript">
     $(document).ready(function() {
          $('.auto_search_sekolah').autocomplete({
               serviceUrl: '<?php echo site_url(); ?>Login_portal/get_autocomplete',
          });
     });

     function insert_sekolah() {
          document.getElementById("daftar").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
          $.ajax({
               type: "POST",
               url: "<?php echo site_url('login_portal/insert_sd'); ?>",
               dataType: "JSON",
               data: $('#input_form').serialize(),
               success: function(data, result) {
                    var str = "Username : " + data.nuptk + "\n" +
                         "Password : " + data.password + "\n" +
                         "Email Alternatif : " + data.email + "\n" +
                         "*Jangan lupa discreenshoot!" + "\n";
                    if (data.success) {

                         document.getElementById("daftar").innerHTML = 'Tambahkan';
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
                              document.getElementById("daftar").innerHTML = 'Tambahkan';
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
                    document.getElementById("daftar").innerHTML = 'Tambahkan';
                    $('#modal-sd').modal('hide');
                    $('.modal-backdrop').remove();
                    swal.fire("Error", "Gagal menyimpan data.", "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
               }
          });
     }


     function insert_siswa() {
          if ($('#no_hps').val() == "") {
               swal.fire("Maaf", "Harap Isi No HP.", "error")
          } else if ($('#emailal').val() == "") {
               swal.fire("Maaf", "Harap Isi Email Alternatif.", "error")
          } else if ($('#nama_ortu').val() == "") {
               swal.fire("Maaf", "Harap Isi Nama Orang Tua.", "error")
          } else if ($('#no_ortu').val() == "") {
               swal.fire("Maaf", "Harap Isi Nomor Orang Tua.", "error")
          } else if ($('#email_ortu').val() == "") {
               swal.fire("Maaf", "Harap Isi Email Orang Tua.", "error")
          } else {
               document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
               $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('login_portal/insert_siswa'); ?>",
                    dataType: "JSON",
                    data: $('#input_siswa').serialize(),
                    success: function(result) {
                         // var str = "Username : " + result.email + "\n" +
                         //      "Password : " + result.npsn + "\n" +
                         //      "*Silahkan melakukan verifikasi \n dengan login ke <a href='https://mail.siswa.id/'>https://mail.siswa.id/</a> " + "\n";
                         var str = "Username : " + result.email + "\n" +
                              "Password : " + result.npsn + "\n" +
                              "*Silahkan ubah password anda \n dengan login ke <a href='https://mail.siswa.id/' target='_blank'>https://mail.siswa.id/</a>" + "\n" +
                              "lalu masuk ke menu preferences." + "\n";
                         var red = "<h3>Email Berhasil Dibuat<br><b style ='color:red;'>Harap Catat Email dan Password!</b></h3>";
                         if (result.success) {
                              document.getElementById("btn-submit").innerHTML = 'Buat Email';
                              $('#modal-sd').modal('hide');
                              $('.modal-backdrop').remove();
                              swal.fire({
                                   title: red,
                                   html: '<pre>' + str + '</pre>',
                                   type: 'success',
                                   showCancelButton: false,
                                   confirmButtonText: 'Ok',
                                   confirmButtonClass: 'btn btn-primary',
                                   buttonsStyling: false,
                                   customClass: 'swal-wide',
                              }).then(function(result) {
                                   window.location.reload();
                              });
                         } else {
                              if (result.msg !== '') {
                                   document.getElementById("btn-submit").innerHTML = 'Buat Email';
                                   Swal.fire({
                                        type: 'warning',
                                        title: 'Gagal!',
                                        text: result.msg
                                   }).then(function(result) {
                                        window.location.reload();
                                   });
                              }
                         }
                    },
                    error: function(event, textStatus, errorThrown) {
                         document.getElementById("btn-submit").innerHTML = 'Buat Email';
                         $('#modal-sd').modal('hide');
                         $('.modal-backdrop').remove();
                         swal.fire("Error", "Gagal menyimpan data.", "error");
                         console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                    }
               });
               $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('Daftar_Siswa/email'); ?>",
                    dataType: "JSON",
                    data: $('#input_siswa').serialize(),
                    success: function(result) {
                         if (result.success) {
                         } else {
                         }
                    },
               });

          }
     }


     $(function() {
          $('#nm_sekolah').hide();
          $('#nama').hide();
          $('#nisnn').hide();
          $('#emailal').hide();
          $('#btn-submit').hide();
          $('#nma').hide();
          $('#eml').hide();
          $('#hp').hide();
          $('#pass').hide();
          $('#daftar').hide();
          $('#no_hps').hide();
          $('#nama_ortu').hide();
          $('#teks').hide();
          $('#no_ortu').hide();
          $('#email_ortu').hide();
          $('#btn-submit').hide();
          $('#nama_fg').hide();
          $('#sekollah_fg').hide();
          $('#sex_fg').hide();
          $('#nisn_fg').hide();
          $('#hp_fg').hide();
          $('#email_fg').hide();
          $('#nmortu_fg').hide();
          $('#email_ortufg').hide();
          $('#no_ortufg').hide();
     });

     $("#input_form").submit(function(event) {

          event.preventDefault();
          $.ajax({
               url: "<?php echo site_url('login_portal/cek_data') ?>",
               type: 'POST',
               dataType: 'json',
               data: $(this).serialize(),
               success: function(data) {
                    if (data.success) {
                         $('#nuptk').attr('readonly', true);
                         $('#nik').attr('readonly', true);
                         $('#sekolah').attr('readonly', true);
                         $('#cek').hide();
                         $('#nma').show();
                         $('#id_sekolah2').val(data.id_sekolah);
                         $('#id_region2').val(data.id_region);
                         $('#eml').show();
                         $('#hp').show();
                         $('#pass').show();
                         $('#daftar').show();


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

     $("#input_siswa").submit(function(event) {

          event.preventDefault();
          $.ajax({
               url: "<?php echo site_url('Daftar_Siswa/cek_data_siswa') ?>",
               type: 'POST',
               dataType: 'json',
               data: $(this).serialize(),
               success: function(data) {
                    if (data.success) {
                         $('#nisn').attr('readonly', true);
                         $('#npsn').attr('readonly', true);
                         $('#nm_sekolah').show().val(data.nm_sekolah);
                         $('#nama').show().val(data.nama);
                         $('#sex').show().val(data.sex);
                         // $('#nisnn').show().val(data.nisn + '@siswa.id');
                         $('#nisnn').show().val(data.namapertama + '_' +data.nisn_email + '@siswa.id');
                         $('#regional').val(data.regional);
                         $('#alamat').val(data.alamat);
                         $('#tgl_lahir').val(data.tgl_lahir);
                         $('#id_sekolah').val(data.id_sekolah);
                         $('#id_region').val(data.id_region);
                         $('#emailal').show();
                         $('#no_hps').show();
                         $('#bemail').show();
                         $('#btn_cek_nisn').hide();
                         $('#nama_ortu').show();
                         $('#no_ortu').show();
                         $('#teks').show();
                         $('#email_ortu').show();
                         $('#btn-submit').show();
                         $('#nama_fg').show();
                         $('#sekollah_fg').show();
                         $('#nisn_fg').show();
                         $('#hp_fg').show();
                         $('#email_fg').show();
                         $('#nmortu_fg').show();
                         $('#email_ortufg').show();
                         $('#no_ortufg').show();
                         $('#sex_fg').show();

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

     function inputNumbersOnly(evt) {
          var charCode = (evt.which) ? evt.which : evt.keyCode
          if (charCode > 31 && (charCode < 48 || charCode > 57))
               return false;
          return true;
     }
</script>