<?php
$this->load->view("layout/header2");
?>
<?php
$reset_key = $this->uri->segment(3);
?>
<div class="card o-hidden border-0 col-md-6 offset-3 mt-5">
     <div class="card-body p-0 ">
          <!-- Nested Row within Card Body -->
          <div class="row ">
               <div class="col-lg">
                    <div class="p-5 ">
                         <div class="text-center">
                              <h1 class="h4 text-gray-900 mb-4">Masukkan Password Baru</h1>
                         </div>
                         <div class="card-block p-b-15 ">
                              <?= validation_errors() ?>
                              <form id="input_siswa">
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-1">
                                                  <input type="text" class="form-control" name="reset_key" id="reset_key" required style="border-radius:20px; height:40px;" value="<?= $reset_key; ?>" hidden>
                                             </div>
                                             <div class="col-sm-12 mb-1">
                                                  <input type="password" class="form-control" name="password" id="password" required style="border-radius:20px; height:40px;" placeholder="Password">
                                             </div>
                                             <div class="col-sm-12">
                                                  <input type="password" class="form-control" name="retype_password" id="retype_password" required style="border-radius:20px; height:40px;" placeholder="Confirm Password">
                                             </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" id="check" style="border-radius:20px;">
                                             Submit
                                        </button>
                              </form>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
</body>

</html>
<?php
$this->load->view('layout/footer');
?>

<script type="text/javascript">

$("#input_siswa").submit(function(event) {

event.preventDefault();
    $.ajax({
        url: "<?php echo site_url('Login_portal/reset_password_validation_reg') ?>",
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(data) {
            if (data.success) {
                Swal.fire({
                            type: 'success',
                            title: 'Sukses!',
                            text: data.msg
                        }).then(function(result) {
                                   window.location.href="<?= site_url('Login_portal'); ?>";
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
});

     function inputNumbersOnly(evt) {
          var charCode = (evt.which) ? evt.which : evt.keyCode
          if (charCode > 31 && (charCode < 48 || charCode > 57))
               return false;
          return true;
     }
</script>