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
                              <h1 class="h4 text-gray-900 mb-4">Form Lupa Password</h1>
                         </div>
                         <div class="card-block p-b-15 ">
                              <form id="input_siswa">
                                   <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                             <input type="text" class="form-control" name="nisn" id="nisn" onkeypress="return inputNumbersOnly(event)" required style="border-radius:20px; height:40px;" placeholder="Masukan NISN">
                                        </div>
                                        <div class="col-sm-6">
                                             <input type="email" class="form-control" name="emailal" id="emailal" required style="border-radius:20px; height:40px;" placeholder="Masukan Email Alternatif">
                                        </div>
                                   </div>
                                   <button type="submit" class="btn btn-primary btn-user btn-block" id="check" style="border-radius:20px;">
                                        Kirim
                                   </button>
                                   <div class="form-actions" id="simpan">
                              <div class="text-center">
                                   <a class="small" href="<?= site_url('Login_portal'); ?>">Kembali</a>
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

<script type="text/javascript">

$("#input_siswa").submit(function(event) {

event.preventDefault();
$.ajax({
     url: "<?php echo site_url('Lupa_password/cek_data') ?>",
     type: 'POST',
     dataType: 'json',
     data: $(this).serialize(),
     success: function(data) {
          if (data.success) {
              swal.fire('Data Berhasil Dikirim!', 'Silahkan periksa email anda', 'success').then(function(result) {
                                   window.location.reload();
                              });
          } else {
               if (data.msg !== '') {
                    Swal.fire({
                         type: 'warning',
                         title: 'Gagal!',
                         text: data.msg
                    }).then(function(result) {
                         window.location.reload();
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
$.ajax({
     url: "<?php echo site_url('Lupa_password/email') ?>",
     type: 'POST',
     dataType: 'json',
     data: $(this).serialize(),
     success: function(data) {
          if (data.success) {
          } else {
               if (data.msg !== '') {
               } else {
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