<?php
  $this->load->view('layout/header.php');
?>
<section id="basic-vertical-layouts">
  <div class="row match-height">
      <div class="col-md-12 col-12">
          <div class="card">
              <div class="card-content">
                  <div class="card-body">
                      <form class="form form-vertical" id="formKlinik">
                          <div class="form-body">
                              <div class="row">
                                  <div class="col-6">
                                      <div class="form-group">
                                          <label for="name">Username</label>
                                          <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" id="username_view" required>
                                          <input type="hidden" class="form-control" name="username" id="username">
                                          <input type="hidden" class="form-control" name="id_klinik" value="<?=$klinik->id;?>">
                                      </div>
                                  </div>
                                  <div class="col-6">
                                      <div class="form-group">
                                          <label for="name">Nama Lengkap</label>
                                          <input type="text" id="name" class="form-control" name="name" placeholder="Nama Lengkap" required>
                                      </div>
                                  </div>
                                  <div class="col-12">
                                      <div class="form-group">
                                          <label for="roleid">Role</label>
                                          <select id="roleid" name="roleid" class="form-control select2" style="width:100%">
                                            <option value="" selected>-= Pilih Role=-</option>
                                            <?php
                                              foreach ($role as $row) {
                                                echo '<option value="'.bin2hex($row->id).'">'.$row->role.'</option>';
                                              }
                                            ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="controls">
                                            <input type="password" id="password" name="password" class="form-control" data-validation-required-message="This field is required" placeholder="Password" minlength="6">
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form-group">
                                        <label>Ulangi password</label>
                                        <div class="controls">
                                            <input type="password" id="repassword" name="repassword" data-validation-match-match="password" class="form-control" data-validation-required-message="Password Berbeda" placeholder="Repeat Password">
                                        </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-12">
                          <button id="tambahUserKlinik" type="button" class="btn btn-primary mr-1 mb-1">Tambah</button>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<?php
  $this->load->view('layout/footer.php');
?>

<script type="text/javascript"> 
  $(".select2").select2({
    dropdownAutoWidth: true,
    width: '100%'
  });
  $(function() {
    $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
  });
  $(document).ready(function () {
    
  });

  $('#tambahUserKlinik').on( 'click', function () {
      if($("#username").val()==""){
        toastr.warning('Username tidak boleh kosong!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#username").focus();
      }else if($("#name").val()==""){
        toastr.warning('Nama Lengkap tidak boleh kosong!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#name").focus();
      }else if($("#roleid").val()==""){
        toastr.warning('Role belum dipilih!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#roleid").focus();
      }else if($("#password").val()==""){
        toastr.warning('Password tidak boleh kosong!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#password").focus();
      }else if($("#repassword").val()==""){
        toastr.warning('Password ulang tidak boleh kosong!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#repassword").focus();
      }else{
        Swal.fire({
          title: 'Tambah User?',
          // text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya',
          confirmButtonClass: 'btn btn-primary',
          cancelButtonText: 'Tidak',
          cancelButtonClass: 'btn btn-danger ml-1',
          buttonsStyling: false,
        }).then(function (result) {
          if (result.value) {
            loadingSwal();
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data: $("#formKlinik").serialize(),
                url: "<?php echo site_url('admin/userKlinikSave')?>",
                success: function(data){
                    if(data.success){
                        Swal.fire(
                            'Sukses',
                            'Berhasil Menambah Klinik.',
                            'success'
                        );
                        var link = '<?=site_url('admin/klinik/detail/')?><?=$klinik->id;?>';
                        window.open(link, '_self');
                    }else{
                        Swal.fire(
                            'Maaf',
                            'Menambah Klinik Gagal.',
                            'info'
                        );
                    }
                }
            });
          }
        })
      }
  });
  function loadingSwal(){
    Swal.fire({
      title: 'Menambah Data!',
      html: 'Harap Menunggu.',
      onBeforeOpen: () => {
        Swal.showLoading()
      },
      onClose: () => {
      }
      }).then((result) => {
        if (
          result.dismiss === Swal.DismissReason.timer
        ) {
          console.log('I was closed by the timer') // eslint-disable-line
        }
      });
  }

  // $( "#password" ).change(function() {
  //   if ( ($('#password').val()!= '') && ($('#repassword').val() != '' )){
  //     if ( $('#password').val() != $('#repassword').val() ){
  //     alert('Please retype, password is missmatch!');
  //       $('#password').val('');
  //       $('#repassword').val('');
  //       $('#password').focus();
  //     }
  //   }
  // });
  // $( "#repassword" ).change(function() {
  //   if ( ($('#password').val()!= '') && ($('#repassword').val() != '' )){
  //     if ( $('#password').val() != $('#repassword').val() ){
  //       alert('Please retype, password is missmatch!');
  //       $('#password').val('');
  //       $('#repassword').val('');
  //       $('#password').focus();
  //     }
  //   }
  // });
  $("input#username_view").on({
    keydown: function(e) {
      if (e.which === 32)
        return false;
    },
    change: function() {
      // this.value = this.value.replace(/\s/g, "");
      // this.value = this.value.replace(/[^a-zA-Z0-9]/g, "");
      // this.value = this.value.toLowerCase();
    }
  });
  $('#username_view').bind('keypress blur', function() {
    $(this).val($(this).val().replace(/[^A-Za-z0-9]/g,''))
  });
  $('#name').bind('keypress blur', function() {
    $(this).val($(this).val().replace(/[^A-Za-z0-9.\s]/g,''))
  });

  // $('#username_view').keypress(function( e ) {
  //   if(e.which === 32) 
  //       return false;
  // });
  $( "#username_view" ).change(function() {
    var vnip = $("#username_view").val();
    $.ajax({
      dataType: "json",
      type: 'POST',
      data: {id:vnip},
      url: '<?php echo site_url('admin/userExist'); ?>',
      success: function( response ) {
        if (response.exist){
          // alert("Username "+vnip+" sudah terdaftar!");
          Swal.fire(
            'Maaf',
            'Username '+vnip+' sudah terdaftar!',
            'danger'
          );
          $("#username_view").val('');
          $('#username_view').focus();
        }else{
          $("#username").val(vnip);
        }
      }
    })
  });
</script>