<?php
	$this->load->view('layout/header.php');
  // print_r($poli);
  echo $this->session->flashdata('success_msg');
?>
<!-- <link rel="stylesheet" type="text/css" href="<?=site_url();?>app-assets/vendors/css/tables/ag-grid/ag-grid.css">
<link rel="stylesheet" type="text/css" href="<?=site_url();?>app-assets/vendors/css/tables/ag-grid/ag-theme-material.css"> -->
<link rel="stylesheet" type="text/css" href="<?=site_url();?>app-assets/css/pages/app-user.css">
<!-- <link rel="stylesheet" type="text/css" href="<?=site_url();?>app-assets/css/pages/aggrid.css"> -->

<section class="page-users-view">
  <div class="row">
    <div class="col-12 col-lg-9">
      <div class="card border-danger">
        <div class="card-header border-bottom mx-2 px-0">
          <h4 class="border-bottom py-1 mb-0 font-medium-2">
            <i class="fa fa-hospital-o mr-50 "></i>Detail
          </h4>
          <?php //if($this->load->get_var("user_info")->roleid==1){?>
            <p class="mb-0"><a href="<?php echo site_url().'admin/klinik/edit/'.$klinik->id;?>" class="btn btn-icon rounded-circle btn-sm btn-outline-primary waves-effect waves-light" data-toggle="tooltip" data-placement="left" title="Edit Detail"><i class="feather icon-edit font-medium-3 text-muted cursor-pointer"></i></a></p>
        <?php //}?>
        </div>
        <div class="card-body">
          <div class="row">
            <!-- <div class="users-view-image">
                <img src="../../../app-assets/images/portrait/small/avatar-s-12.jpg" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
            </div> -->
            <?php if($klinik->logo!=NULL){
              echo '
            <div class="users-view-image">
              <img height="100px" src="data:image/png;base64,'.$klinik->logo.'" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1">
            </div>';
            }?>
            <div class="col-12 col-sm-9 col-md-6 col-lg-5">
              <table>
                <tr>
                  <td class="font-weight-bold">Klinik</td>
                  <td><?=$klinik->nama;?> - <?=$klinik->namasingkat;?></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Telp</td>
                  <td><?=$klinik->telp;?></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Email</td>
                  <td><?=$klinik->email;?></td>
                </tr>
              </table>
            </div>
            <div class="col-12 col-md-12 col-lg-5">
              <table class="ml-0 ml-sm-0 ml-lg-0">
                <tr>
                  <td class="font-weight-bold">Alamat</td>
                  <td><?=$klinik->alamat;?></td>
                </tr>
                <tr>
                  <td class="font-weight-bold"></td>
                  <td><?=$klinik->kelurahandesa;?>, <?=$klinik->kecamatan;?>, <?=$klinik->kotakabupaten;?></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Provinsi</td>
                  <td><?=$klinik->provinsi;?></td>
                </tr>
              </table>
            </div>
            <!-- <div class="col-12">
                <a href="app-user-edit.html" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> Edit</a>
                <button class="btn btn-outline-danger"><i class="feather icon-trash-2"></i> Delete</button>
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-3">
        <div class="card border-danger">
            <div class="card-header border-bottom mx-2 px-0">
              <h4 class="border-bottom py-1 mb-0 font-medium-2">
                Poliklinik
              </h4>
            </div>
            <div class="card-body">
              <div class="form-group">
              <?php 
                // $disabled_select = ($this->load->get_var("user_info")->roleid!=1) ? 'disabled' : '' ;
                $disabled_select = '';
                echo '
                  <select class="select2-size-sm form-control" multiple="multiple" id="poliklinik" style="width:100%" placeholder="Pilih Poliklinik" '.$disabled_select.'>
                ';
                foreach ($poli as $row) {
                  $selected = ($row->id!=NULL) ? 'selected' : '' ;
                  echo '<option '.$selected.' value="'.$row->id_poli.'@'.$row->nm_poli.'">'.$row->nm_poli.'</option>';
                }
                echo '
                  </select>
                ';
              ?>
              </div>
                <?php //if($this->load->get_var("user_info")->roleid==1){?><button id="simpanPoli" type="button" class="btn btn-primary btn-block">Simpan Poliklinik</button><?php //}?>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-6 col-12 ">
        <div class="card">
            <div class="card-header">
                <div class="card-title mb-2">Social Links</div>
            </div>
            <div class="card-body">
                <table>
                    <tr>
                        <td class="font-weight-bold">Twitter</td>
                        <td>https://twitter.com/adoptionism744
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Facebook</td>
                        <td>https://www.facebook.com/adoptionism664
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Instagram</td>
                        <td>https://www.instagram.com/adopt-ionism744/
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Github</td>
                        <td>https://github.com/madop818
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">CodePen</td>
                        <td>https://codepen.io/adoptism243
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Slack</td>
                        <td>@adoptionism744
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div> -->
    <div class="col-12">
      <div class="card">
        <div class="card-header border-bottom mx-2 px-0">
          <h4 class="border-bottom py-1 mb-0 font-medium-2">
            <i class="feather icon-users mr-50 "></i>Users
          </h4>
          <p class="mb-0"><a href="<?php echo site_url().'admin/klinik/tambah_user/'.$klinik->id;?>" class="btn btn-icon rounded-circle btn-sm btn-outline-primary waves-effect waves-light" data-toggle="tooltip" data-placement="left" title="Tambah User"><i class="feather icon-plus font-medium-3 text-muted cursor-pointer"></i></a></p>
        </div>
        <div class="card-body px-75">
          <div class="table-responsive users-view-permission">
            <table class="display nowrap table table-hover table-striped table-bordered" id="tableUserKlinik" style="width:100%;">
            <!-- <table class="table zero-configuration" id="tableUserKlinik" style="width:100%;"> -->
              <thead>
                <tr>
                  <th>NO</th>
                  <th>USERNAME</th>
                  <th>NAMA</th>
                  <th>ROLE</th>
                  <th>STATUS</th>
                  <th>AKSI</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Reset Password</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="editForm" class="form-horizontal">
                <div class="modal-body">
          <div class="row">
            <div class="col-md-12">                   
                <div class="row">
                  <div class="col-md-12"> 
                    <div class="form-group">
                      <label class="control-label col-sm-4">Username</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="vusername" id="vusername" readonly>
                        <input type="hidden" name="vuserid" id="vuserid">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12"> 
                    <div class="form-group">
                      <label class="control-label col-sm-4">Password</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" name="vpassword" id="vpassword" required data-validation-required-message="This field is required" placeholder="Password" minlength="6">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12"> 
                    <div class="form-group">
                      <label class="control-label col-sm-4">Retype Password</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" name="vrepassword" id="vrepassword" required data-validation-required-message="This field is required" placeholder="Password" minlength="6">
                      </div>
                    </div>
                  </div>
                </div>          
            </div>
          </div>
        </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
          <button class="btn btn-info waves-effect" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
	$this->load->view('layout/footer.php');
?>
<!-- <script src="<?=site_url();?>app-assets/vendors/js/tables/ag-grid/ag-grid-community.min.noStyle.js"></script> -->

<script type="text/javascript">
  var tblUserKlinik;
  $('.select2-size-sm').select2({
      dropdownAutoWidth: true,
      width: '100%',
      containerCssClass: 'select-sm'
  });
  $(function() {
    $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    tblUserKlinik = $('#tableUserKlinik').DataTable( {
      ajax: "<?php echo site_url('admin/userKlinikList'); ?>/<?=$klinik->id;?>",
      columns: [
        { data: "no" },
        { data: "username" },
        { data: "nama" },
        { data: "role" },
        { data: "status" },
        { data: "aksi" }
      ],
      columnDefs: [
        { targets: [ 0 ], visible: false }
      ] 
    }); 
    
      
    $('#editModal').on('shown.bs.modal', function(e) {
      e.preventDefault();
      $("#editForm")[0].reset();    
      var id = $(e.relatedTarget).data('id');
      var nm = $(e.relatedTarget).data('username');
      $('#vuserid').val(id);
      $('#vusername').val(nm);
      $( "#vpassword" ).focus();
      $( "#vpassword" ).change(function() {
        if ( ($('#vpassword').val()!= '') && ($('#vrepassword').val() != '' )){
          if ( $('#vpassword').val() != $('#vrepassword').val() ){
          alert('Please retype, password is missmatch!');
            $('#vpassword').val('');
            $('#vrepassword').val('');
            $('#vpassword').focus();
          }
        }
      });
      $( "#vrepassword" ).change(function() {
        if ( ($('#vpassword').val()!= '') && ($('#vrepassword').val() != '' )){
          if ( $('#vpassword').val() != $('#vrepassword').val() ){
            alert('Please retype, password is missmatch!');
            $('#vpassword').val('');
            $('#vrepassword').val('');
            $('#vpassword').focus();
          }
        }
      });
    });

    $('#editForm').on('submit', function (e) {
      //alert("<?php echo site_url(); ?>");
      e.preventDefault();
      $.ajax({
        type: 'POST',
        data: $('#editForm').serialize(),
        url: '<?php echo site_url(); ?>Admin/reset_password',
        dataType: "json",
        success: function (response) {
          //alert(JSON.stringify(response));
          if(response.success){           
            tblUserKlinik.ajax.reload();
            $('#editModal').modal('hide');
            Swal.fire("Sukses","Reset Password Berhasil.", "success");                     
          } else {
            Swal.fire("Error","Reset Password Gagal.", "error");   
          }
        }
      });
    });
  });
  $(document).ready(function () {
    
  });

  $('#simpanPoli').on( 'click', function () {
    Swal.fire({
      title: 'Update Poliklinik?',
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
        loadingSwal('Simpan Data Poliklinik');
        $.ajax({
          type: 'POST',
          data: {
            poliklinik:$('#poliklinik').val(),
            id_klinik:'<?=$klinik->id;?>',
          },
          url: '<?php echo site_url(); ?>admin/savePoliklinik',
          dataType: "json",
          success: function (response) {
            if(response.success){   
              Swal.fire("Sukses","Update Poliklinik Berhasil.", "success");   
            } else {
              Swal.fire("Error","Update Poliklinik Gagal.", "error");   
            }
          }
        });
      }
    });
  });

  function delete_user(userid){
    Swal.fire({
      title: "Disable User",
      text: "Yakin akan menonaktifkan user tersebut?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: 'POST',
          url: '<?php echo site_url('admin/dropUser/'); ?>'+userid,
          dataType:'JSON',
          success: function(response) {
            if (response.success){
              tblUserKlinik.ajax.reload();
              Swal.fire("Sukses","Berhasil menonaktifkan user.", "success");
            }else Swal.fire("Error","Gagal menonaktifkan user.", "error");
          }
        });
      }
    })
  }

  function active_user(userid){
    Swal.fire({
      title: "Aktifkan User",
      text: "Yakin akan mengaktifkan user tersebut?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aktif'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: 'POST',
          url: '<?php echo site_url('admin/activeUser/'); ?>'+userid,
          dataType:'JSON',
          success: function(response) {
            if (response.success){
              tblUserKlinik.ajax.reload();
              Swal.fire("Sukses","Berhasil mengaktifkan user.", "success");
            }else Swal.fire("Error","Gagal mengaktifkan user.", "error");
          }
        });
      }
    })
  }

  function loadingSwal(get_string){
    Swal.fire({
      title: get_string,
      html: 'Harap Menunggu.',
      onBeforeOpen: () => {
        Swal.showLoading()
      },
      onClose: () => {
        // clearInterval(timerInterval)
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer)
        console.log('I was closed by the timer')
    });
  }
</script>