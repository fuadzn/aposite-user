<?php
$this->load->view('layout/header.php');
?>



<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Form Input User</h4>
			</div>
			<div class="card-block">
				<div class="col-md-12">
					<form id="idform" method="POST" enctype="multipart/form-data">
						<div class="form-group row">
							<p class="col-lg-3 form-control-label">Username *</p>
							<div class="col-lg-6">
								<input type="text" class="form-control" placeholder="" id="username" name="username" required>
								<input type="hidden" name="userid" id="userid" value=''>
							</div>
						</div>
						<div class="form-group row">
							<p class="col-lg-3 form-control-label">Full Name *</p>
							<div class="col-lg-6">
								<input type="text" class="form-control" placeholder="" id="name" name="name" required>
							</div>
						</div>
						<div class="form-group row">
							<p class="col-lg-3 form-control-label">Password *</p>
							<div class="col-lg-6">
								<input type="password" class="form-control" placeholder="" name="password" id="password" required>
							</div>
						</div>
						<div class="form-group row">
							<p class="col-lg-3 form-control-label">Retype Password *</p>
							<div class="col-lg-6">
								<input type="password" class="form-control" placeholder="" id="repassword" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="offset-sm-3 col-sm-8">
								<button type="reset" class="btn waves-effect waves-light btn-danger"><i class="fa fa-eraser"></i> Reset</button>
								<button type="button" class="btn waves-effect waves-light btn-primary" id="btn_save"><i class="fa fa-floppy-o"></i> Simpan</button>
								<!--<a href="#" class="btn btn-primary">Cetak Kartu</a>-->
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-block">
				<div class="table-responsive m-t-20">
					<table class="display nowrap table table-hover table-striped table-bordered" id="example">
						<thead>
							<tr>
								<th></th>
								<th>Username</th>
								<th>Name</th>
								<th>Date Create</th>
								<th>User Create</th>
								<th>Status</th>
								<th>Last Login</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

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
											<input type="password" class="form-control" name="vpassword" id="vpassword" required>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-sm-4">Retype Password</label>
										<div class="col-sm-8">
											<input type="password" class="form-control" name="vrepassword" id="vrepassword" required>
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

<div id="last_login" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Last Login</b></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="x">×</button>
			</div>
			<table id="table_last_login" class="display table table-hover table-bordered table-striped" cellspacing="0" style="width:100%" style="display:block;overflow:auto;">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Keterangan</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>


<?php
$this->load->view('layout/footer.php');
?>

<script type='text/javascript'>
	$(function() {
		objTable = $('#example').DataTable({
			ajax: "<?php echo site_url('admin/userListRoleLogin'); ?>",
			columns: [{
					data: "id"
				},
				{
					data: "username"
				},
				{
					data: "name"
				},
				{
					data: "xcreate_date"
				},
				{
					data: "xcreate_user"
				},
				{
					data: "status"
				},
				{
					data: "last_login"
				},
				{
					data: "aksi"
				}
			],
			columnDefs: [{
				targets: [0],
				visible: false
			}]
		});
		$('#browseBtn').on('click', function() {
			$('#userfile').trigger('click');
		});
		$(":reset").click(function() {
			$("#username").prop('disabled', false);
		});
		$('#username').keypress(function(e) {
			if (e.which === 32)
				return false;
		});
		$("#username").change(function() {
			var vnip = $("#username").val();
			$.ajax({
				dataType: "json",
				type: 'POST',
				data: {
					id: vnip
				},
				url: '<?php echo site_url('admin/userExist'); ?>',
				success: function(response) {
					if (response.exist) {
						alert("Username " + vnip + " sudah terdaftar!");
						$("#username").val('');
						$('#username').focus();
					}
				}
			})
		});
		$("#password").change(function() {
			if (($('#password').val() != '') && ($('#repassword').val() != '')) {
				if ($('#password').val() != $('#repassword').val()) {
					alert('Please retype, password is missmatch!');
					$('#password').val('');
					$('#repassword').val('');
					$('#password').focus();
				}
			}
		});
		$("#repassword").change(function() {
			if (($('#password').val() != '') && ($('#repassword').val() != '')) {
				if ($('#password').val() != $('#repassword').val()) {
					alert('Please retype, password is missmatch!');
					$('#password').val('');
					$('#repassword').val('');
					$('#password').focus();
				}
			}
		});
		$('#btn_save').on('click', function(e) {
			document.getElementById("btn_save").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
			var formData = new FormData($('#idform')[0]);
			$.ajax({
				dataType: "JSON",
				type: 'POST',
				// async: true,
				cache: false,
				contentType: false,
				processData: false,
				url: "<?php echo base_url('Admin/user_insert_roleid'); ?>",
				data: formData,
				success: function(response) {
					if (response.success) {
						document.getElementById("btn_save").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
						objTable.ajax.reload();
						$("#idform")[0].reset();
						Swal.fire("Sukses", "Input User Berhasil.", "success");
					} else {
						document.getElementById("btn_save").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
						Swal.fire("Error", "Input User Gagal.", "error");
					}
				}
			});
		});

		//=========== When (modal) POP-UP closed, remove class from TR Grid =================
		$('#myModal').on('hidden.bs.modal', function(e) {
			$("tr").removeClass('detailselected');
		});


		$('#editModal').on('shown.bs.modal', function(e) {
			e.preventDefault();
			$("#editForm")[0].reset();
			var id = $(e.relatedTarget).data('id');
			var nm = $(e.relatedTarget).data('username');
			$('#vuserid').val(id);
			$('#vusername').val(nm);
			$("#vpassword").focus();
			$("#vpassword").change(function() {
				if (($('#vpassword').val() != '') && ($('#vrepassword').val() != '')) {
					if ($('#vpassword').val() != $('#vrepassword').val()) {
						alert('Please retype, password is missmatch!');
						$('#vpassword').val('');
						$('#vrepassword').val('');
						$('#vpassword').focus();
					}
				}
			});
			$("#vrepassword").change(function() {
				if (($('#vpassword').val() != '') && ($('#vrepassword').val() != '')) {
					if ($('#vpassword').val() != $('#vrepassword').val()) {
						alert('Please retype, password is missmatch!');
						$('#vpassword').val('');
						$('#vrepassword').val('');
						$('#vpassword').focus();
					}
				}
			});
		});

		$('#last_login').on('shown.bs.modal', function(e) {
			e.preventDefault();
			var id = $(e.relatedTarget).data('id');
			last_login = $('#table_last_login').DataTable({
				order: [
					[0, 'asc'],
					[0, 'asc']
				],
				ajax: "<?php echo site_url('admin/last_login/'); ?>" + id,
				columns: [{
						data: "id"
					},
					{
						data: "username"
					},
					{
						data: "keterangan"
					}

				],
				columnDefs: [{
					targets: [0],
					visible: false,
				}]
			});
		});

		$('#x').on('click', function() {
			last_login.destroy();
		})

		$('#editForm').on('submit', function(e) {
			//alert("<?php echo site_url(); ?>");
			e.preventDefault();
			$.ajax({
				type: 'POST',
				data: $('#editForm').serialize(),
				url: '<?php echo site_url(); ?>/admin/reset_password',
				dataType: "json",
				success: function(response) {
					//alert(JSON.stringify(response));
					if (response.success) {
						objTable.ajax.reload();
						$('#editModal').modal('hide');
						Swal.fire("Sukses", "Reset Password Berhasil.", "success");
					} else {
						Swal.fire("Error", "Reset Password Gagal.", "error");
					}
				}
			});
		});
	});

	function delete_user(userid) {
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
					url: '<?php echo site_url('admin/dropUser/'); ?>' + userid,
					dataType: 'JSON',
					success: function(response) {
						if (response.success) {
							objTable.ajax.reload();
							Swal.fire("Sukses", "Berhasil menonaktifkan user.", "success");
						} else Swal.fire("Error", "Gagal menonaktifkan user.", "error");
					}
				});
			}
		})
	}

	function active_user(userid) {
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
					url: '<?php echo site_url('admin/activeUser/'); ?>' + userid,
					dataType: 'JSON',
					success: function(response) {
						if (response.success) {
							objTable.ajax.reload();
							Swal.fire("Sukses", "Berhasil mengaktifkan user.", "success");
						} else Swal.fire("Error", "Gagal mengaktifkan user.", "error");
					}
				});
			}
		})
	}
</script>