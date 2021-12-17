<?php
$this->load->view('layout/header');
?>

<section class="content">
    <div class="row match-height">
    <div class="col-md-12">
				<?php echo $this->session->flashdata('success_msg'); ?>
    </div>
    <!-- <?php echo form_open('nisn/update_siswa');?> -->
        <!-- Modal Edit Obat -->
        <form id="form_sso">
        
        <div class="modal fade" id="invite_user" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Invite User</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">SSO Members</a>
						<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">New Member SSO</a>
                        </div>
                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">SSO User</p><br>
                            <div class="col-sm-6">
                                <input type="search" class="auto_search_user_sso form-control" name="user_sso" id="user_sso">
                                <input type="text" class="form-control" name="d_name" id="d_name" hidden>
                                <input type="text" class="form-control" name="username" id="username" hidden>
                                <input type="text" class="form-control" name="id_user" id="id_user" hidden>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Role</p>
                            <div class="col-sm-6">
                                <select id="pilih_admin" class="custom-select form-control select2" style="width: 100%" name="pilih_admin" onchange="pilihAdmin(this.value)" required>
                              <option value="0">-- Pilih Role --</option>
                              <option value="2">Admin</option>
                              <option value="11">Admin Provinsi</option>
                              <option value="10">Admin Kota / Kabupaten</option>
                         </select>
                            </div>
                        </div>
                        <div class="form-group row" id="fprovinsi">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Provinsi</p>
                            <div class="col-sm-6">
                            <select id="nama_provinsi" name="nama_provinsi" class="form-control nama_provinsi select2" onchange="pilihProvinsi(this.value)" style="width:221px">
                                   <option value="">-- Pilih Provinsi --</option>
                                        <?php 
                                        foreach($provinsi as $row){
                                             echo '<option value="'.$row->id_provinsi.'">'.$row->nm_provinsi.'</option>';
                                        }
                                        ?>
                              </select>
                            </div>
                        </div>
                        <div class="form-group row" id="fkota">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Kota/Kabupaten</p>
                            <div class="col-sm-6">
                            <input type="hidden" class="form-control" id="nama_kota_v" >
                              <select id="nama_kota" name="nama_kota" class="form-control nama_kota select2" style="width:221px"></select>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="button" id="btn-submit" onclick="insert_sso()">Invite</button>
                    </div>
                    </div>
					<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Email</p><br>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="new_sso" id="new_sso">
                            </div>
                        </div>
                    <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Display Name</p><br>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="dis_name" id="dis_name">
                            </div>
                        </div>
                    <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">New Password</p><br>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="ne_password" id="ne_password">
                            </div>
                        </div>
                    <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Retype Password</p><br>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="re_password" id="re_password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Role</p>
                            <div class="col-sm-6">
                                <select id="pilih_admin2" class="custom-select form-control select2" style="width: 100%" name="pilih_admin2" onchange="pilihAdmin2(this.value)" required>
                              <option value="0">-- Pilih Role --</option>
                              <option value="2">Admin</option>
                              <option value="11">Admin Provinsi</option>
                              <option value="10">Admin Kota / Kabupaten</option>
                         </select>
                            </div>
                        </div>
                        <div class="form-group row" id="fprovinsi2">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Provinsi</p>
                            <div class="col-sm-6">
                            <select id="nama_provinsi2" name="nama_provinsi2" class="form-control nama_provinsi2 select2" onchange="pilihProvinsi2(this.value)" style="width:221px">
                                   <option value="">-- Pilih Provinsi --</option>
                                        <?php 
                                        foreach($provinsi as $row){
                                             echo '<option value="'.$row->id_provinsi.'">'.$row->nm_provinsi.'</option>';
                                        }
                                        ?>
                              </select>
                            </div>
                        </div>
                        <div class="form-group row" id="fkota2">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Kota/Kabupaten</p>
                            <div class="col-sm-6">
                            <input type="hidden" class="form-control" id="nama_kota_v2" >
                              <select id="nama_kota2" name="nama_kota2" class="form-control nama_kota select2" style="width:221px"></select>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="button" id="btn-submit2" onclick="insert_newsso()">Create</button>
                    </div>
					</div>
                    </div>
					</div>
                        
                </div>
            </div>
        </div>
        </form>
        <!-- <?php echo form_close();?> -->
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <button class="btn btn-primary mt-2" type="button" data-toggle="modal" data-target="#invite_user" style="margin-left:1200px;" value="Invite User">
                        <i class="fa fa-plus"></i> Invite User</button>
                    <div class="card-body table-responsive">
                        <table id="table_nisn" class="display table table-hover table-bordered table-striped" cellspacing="0" style="width:100%" style="display:block;overflow:auto;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Display Name</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Last Loggin</th>
                                </tr>
                            </thead>                       
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
$this->load->view("layout/footer");
?>
<script>

    var tabel_detail;
    $(document).ready(function() {
   $('.auto_search_user_sso').autocomplete({
               serviceUrl: '<?php echo site_url(); ?>sso/get_autocomplete',
               onSelect: function (suggestion) {
                $('#user_sso').val('' + suggestion.value);
                $("#d_name").val(suggestion.display);
                $('#username').val(suggestion.user);
                $('#id_user').val(suggestion.user_id);
               }
   });
        $('.select2').select2();

        $('#aksi').attr('hidden', true);
        tabel_detail = $('#table_nisn').DataTable({
            aoColumnDefs: [
                { bSortable: false, aTargets: [ 0 ] }
            ],
          ajax: {
            "url": '<?php echo site_url('sso/show_data_sso')?>',
            "type": 'POST',
            "dataSrc":'',
            "data": function ( d ) {
            },
              },
              columns: [
                { data: "no" },
                { data: "email" },
                { data: "username" },
                { data: "displayname" },
                { data: "role_name" },
                { data: "status" },
                { data: "last_login" }
              ]
        });
        tabel_detail.on( 'order.table_nisn search.table_nisn', function () {
        tabel_detail.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    
    $('#fprovinsi').hide();
    $('#fkota').hide();
    $('#fprovinsi2').hide();
    $('#fkota2').hide();

        $('#sso_user').autocomplete({
        source: function (request, response) {
            $.getJSON("sso.teratai.id/kc-admin/users" + request.term, function (data) {
                response($.map(data.email, function (value, key) {
                    return {
                        label: value,
                        value: key
                    };
                }));
            });
        },
        minLength: 2,
        delay: 100
        });
    });

    function insert_sso() {
        if ($('#user_sso').val() == "") {
            swal.fire("Maaf", "Harap Isi User Email.", "warning")
        } else if ($('#pilih_admin').val() == "0") {
            swal.fire("Maaf", "Harap Isi Role.", "warning")
        } else {
            document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sso/insert_sso'); ?>",
                dataType: "JSON",
                data: $('#form_sso').serialize(),
                success: function(result) {
                         if (result.success) {
                              document.getElementById("btn-submit").innerHTML = 'Invite';
                              $('#invite_user').modal('hide');
                              $('.modal-backdrop').remove();
                              swal.fire({
                                   title: 'Berhasil',
                                   type: 'success',
                                   text: 'Data berhasil disimpan.',
                                   showCancelButton: false,
                                   confirmButtonText: 'Ok',
                                   confirmButtonClass: 'btn btn-primary',
                                   buttonsStyling: false,
                                   customClass: 'swal-wide',
                              }).then(function(result) {
                                tabel_detail.ajax.reload();
                              });
                    } else {
                        if (result.msg !== '') {
                            document.getElementById("btn-submit").innerHTML = 'Simpan';
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
                    document.getElementById("btn-submit").innerHTML = 'Simpan';
                    $('#invite_user').modal('hide');
                    $('.modal-backdrop').remove();
                    swal.fire("Error", "Gagal menyimpan data.", "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                }
            });
        }
    }

    function insert_newsso() {
        if ($('#new_sso').val() == "") {
            swal.fire("Maaf", "Harap Isi User Email.", "warning")
        } else if ($('#dis_name').val() == "") {
            swal.fire("Maaf", "Harap Isi Display Name.", "warning")
        } else if ($('#ne_password').val() == "") {
            swal.fire("Maaf", "Harap Isi Role.", "warning")
        } else if ($('#re_password').val() != $('#ne_password').val()) {
            swal.fire("Maaf", "Password Tidak Sesuai", "warning")
        } else if ($('#pilih_admin2').val() == "0") {
            swal.fire("Maaf", "Harap Isi Role.", "warning")
        } else {
            document.getElementById("btn-submit2").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sso/insert_newsso'); ?>",
                dataType: "JSON",
                data: $('#form_sso').serialize(),
                success: function(result) {
                         if (result.success) {
                              document.getElementById("btn-submit2").innerHTML = 'Create';
                              $('#invite_user').modal('hide');
                              $('.modal-backdrop').remove();
                              swal.fire({
                                   title: 'Berhasil',
                                   type: 'success',
                                   text: 'Data berhasil disimpan.',
                                   showCancelButton: false,
                                   confirmButtonText: 'Ok',
                                   confirmButtonClass: 'btn btn-primary',
                                   buttonsStyling: false,
                                   customClass: 'swal-wide',
                              }).then(function(result) {
                                tabel_detail.ajax.reload();
                              });
                    } else {
                        if (result.msg !== '') {
                            document.getElementById("btn-submit2").innerHTML = 'Simpan';
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
                    document.getElementById("btn-submit2").innerHTML = 'Simpan';
                    $('#invite_user').modal('hide');
                    $('.modal-backdrop').remove();
                    swal.fire("Error", "Gagal menyimpan data.", "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                }
            });
        }
    }




    var val_admin = $('#pilih_admin').val();
     pilihAdmin(val_admin);
     function pilihAdmin(val_admin) {
		if (val_admin == '2' || val_admin == '0') {
			$('#fprovinsi').hide();
			$('#fkota').hide();
		} else if (val_admin == '11'){
			$('#fprovinsi').show();
			$('#fkota').hide();
		} else{
			$('#fprovinsi').show();
			$('#fkota').show();
		}
     }

    var val_admin2 = $('#pilih_admin2').val();
     pilihAdmin2(val_admin2);
     function pilihAdmin2(val_admin2) {
		if (val_admin2 == '2' || val_admin2 == '0') {
			$('#fprovinsi2').hide();
			$('#fkota2').hide();
		} else if (val_admin2 == '11'){
			$('#fprovinsi2').show();
			$('#fkota2').hide();
		} else{
			$('#fprovinsi2').show();
			$('#fkota2').show();
		}
     }

        function pilihProvinsi(){
		$.ajax({
	        type: "POST",
	        dataType: "JSON",
	        data: {
	        	"nama_provinsi" : $('#nama_provinsi').val()
	        },
	        url: "<?php echo site_url('sso/get_data_kota')?>",
	        success: function(response){
	            if(response.success){
	                $("#nama_kota").html(response.data);
		            $("#nama_kota").attr('disabled', false);
	                if($('#nama_kota_v').val()!="")
						$('#nama_kota').val($('#nama_kota_v').val()).change();
	           	}else{
	                $("#nama_kota").html(response.data);
	            	$("#nama_kota").attr('disabled', true);
	           	}
	        }
	    });
     }

        function pilihProvinsi2(){
		$.ajax({
	        type: "POST",
	        dataType: "JSON",
	        data: {
	        	"nama_provinsi" : $('#nama_provinsi2').val()
	        },
	        url: "<?php echo site_url('sso/get_data_kota')?>",
	        success: function(response){
	            if(response.success){
	                $("#nama_kota2").html(response.data);
		            $("#nama_kota2").attr('disabled', false);
	                if($('#nama_kota_v2').val()!="")
						$('#nama_kota2').val($('#nama_kota_v2').val()).change();
	           	}else{
	                $("#nama_kota2").html(response.data);
	            	$("#nama_kota2").attr('disabled', true);
	           	}
	        }
	    });
     }
</script>