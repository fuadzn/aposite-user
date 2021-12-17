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
                                        <label for="username">Username</label>
                                        <div class="input-group">
                                          <input type="text" id="username" class="form-control" name="username" disabled value="<?=$user->username;?>">
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-6">
                                      <div class="form-group">
                                          <label for="name">Nama Lengkap</label>
                                          <input type="text" id="name" class="form-control" name="name" placeholder="Nama Lengkap" required value="<?=$user->name;?>">
                                      </div>
                                  </div>
                                  <div class="col-12">
                                      <div class="form-group">
                                          <label for="roleid">Role</label>
                                          <select id="roleid" name="roleid" class="form-control select2" style="width:100%" onchange="roleChange(this.value)">
                                            <option value="" selected>-= Pilih Role=-</option>
                                            <?php
                                              foreach ($role as $row) {
                                                echo '<option value="'.bin2hex($row->id).'">'.$row->role.'</option>';
                                              }
                                            ?>
                                          </select>
                                      </div>
                                  </div>
                                  <?php 
                                    $txt_username = (sizeof($dokter)==0) ? 'Belum Terhubung dengan Data Dokter' : 'sudah Terhubung dengan Data Dokter ';
                                    $dokter_username = (sizeof($dokter)==0) ? '' : $dokter->username;
                                     ?>
                                  <div class="col-12" id="v_dokter" style="display:none">
                                    <fieldset>
                                        <label for="alamat">Username</label>
                                        <small class="text-muted"><?=$txt_username;?></small>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?=$dokter_username;?>" aria-label="Amount" disabled="">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" onclick="openDataDokter()"><i class="feather icon-arrow-up-right"></i></button>
                                            </div>
                                        </div>
                                    </fieldset>
                                  </div>
                                  <div class="col-12 mt-1">
                                      <input type="hidden" class="form-control" name="id_klinik" value="<?=$klinik->id;?>">
                                      <input type="hidden" class="form-control" name="userid" value="<?php echo bin2hex($user->userid);?>">
                                      <button id="editUserKlinik" type="button" class="btn btn-primary mr-1 mb-1">Edit</button>
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

<script type="text/javascript">
  var dokter_username='<?=$dokter_username;?>'; 
  $(".select2").select2({
    dropdownAutoWidth: true,
    width: '100%'
  });

  $(function() {
    $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
  });
  $(document).ready(function () {
    $("#roleid").val("<?=bin2hex($user->roleid);?>").trigger("change");
    roleChange(<?=bin2hex($user->roleid);?>);
  });

  $('#editUserKlinik').on( 'click', function () {
      if($("#name").val()==""){
        toastr.warning('Nama Lengkap tidak boleh kosong!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#name").focus();
      }else if($("#roleid").val()==""){
        toastr.warning('Role belum dipilih!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#roleid").focus();
      }else{
        Swal.fire({
          title: 'Edit User?',
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
                url: "<?php echo site_url('admin/userKlinikEdit')?>",
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
      // timer: 2000,
      // timerProgressBar: true,
      onBeforeOpen: () => {
        Swal.showLoading()
        // timerInterval = setInterval(() => {
        // Swal.getContent().querySelector('b')
        //  .textContent = Swal.getTimerLeft()
        // }, 100)
      },
      onClose: () => {
        // clearInterval(timerInterval)
      }
      }).then((result) => {
        if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.timer
        ) {
          console.log('I was closed by the timer') // eslint-disable-line
        }
      });
  }
  $('#username_view').keypress(function( e ) {
    if(e.which === 32) 
        return false;
  });
  $( "#username_view" ).change(function() {
    var vnip = "<?=$klinik->namasingkat;?>_"+$("#username_view").val();
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

  function roleChange(roleid){
    if(roleid==37){
      $('#v_dokter').show();
      if(dokter_username!=""){
        $("#roleid").attr('disabled', true);
      }
    }else{
      $('#v_dokter').hide();
      $("#roleid").attr('disabled', false);
    }
  }

  function openDataDokter(){
    Swal.fire({
      title: 'Pindah ke master dokter?',
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
        var link = '<?=site_url('master/dokter')?>';
        window.open(link, '_blank');
      }
    })

  }
</script>