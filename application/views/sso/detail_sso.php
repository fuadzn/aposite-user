<?php
$this->load->view('layout/header');
?>

<section class="content">
<div class="row">
<div class="col-md-4 col-12">
			<div class="card">
				<div class="card-content">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-8 offset-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
								<img height="250px" class="users-avatar-shadow rounded" src="<?php
																				echo site_url("assets/images/users/NoImageAvailable.jpg");
																				?>">
                                                                                <br>
                                     <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">User Profile<i class="fa fa-arrow-right float-right"></i></a>
  <a class="nav-link mt-1" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">User Activity<i class="fa fa-arrow-right float-right"></i></a>
									<a href="http://sso.teratai.id/auth/realms/kominfo/account/#/dashboard" class="btn btn-info btn-sm mt-1 btn-block">Manage Your SSO Account</a>
									<a href="<?php echo site_url('sso/')?>" class="btn btn-warning btn-sm btn-block" id="suratKeterangan"><i class="fa fa-arrow-left float-left"></i>Back</a>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<div class="col-md-8 col-12">
			<div class="card">
            <div class="tab-content" id="v-pills-tabContent">
  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
				<div class="card-header pb-1">
					<h3 class="card-title text-center">User Profile</h3>
				</div>
				<div class="card-content">
					<div class="card-body">
                        <div class="col-sm-12">
								<div class="table-responsive">
									<table class="table table-striped" width="100%">
										<tbody>
											<tr>
												<td>Email</td>
												<td>:</td>
                                                <td><?php echo $get_data['email'] ?></td>
											</tr>
											<tr>
												<td>Username</td>
												<td>:</td>
                                                <td><?php echo $get_data['username'] ?></td>
											</tr>
											<tr>
												<td>Display Name</td>
												<td>:</td>
                                                <td><?php echo $get_data['displayname'] ?></td>
											</tr>
											<tr>
												<td>Status</td>
												<td>:</td>
                                                <td>Enabled</td>
											</tr>
											<tr>
												<td>Registered Date</td>
												<td>:</td>
                                                <td><?php echo date('Y-m-d', $get_data['createdTimestamp']/1000) ?></td>
											</tr>
											<tr>
												<td>Last Logged-in</td>
												<td>:</td>
                                                <td><?php echo date('Y-m-d', $get_data['lastLoggedinTimestamp']/1000) ?></td>
											</tr>
											<tr>
												<td>User Role</td>
												<td>:</td>
                                                <td><?php echo $get_role['name'] ?></td>
											</tr>
										</tbody>
										</table>
								</div>
                                </div>
							</div>
					</div>
				</div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <div class="card-header pb-1">
					<h3 class="card-title text-center">User Activity</h3>
				</div>
				<div class="card-body table-responsive">
                        <table id="table_nisn" class="display table table-hover table-bordered table-striped" cellspacing="0" style="width:100%" style="display:block;overflow:auto;">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Event Type</th>
                                    <th>Client Id</th>
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

        tabel_detail = $('#table_nisn').DataTable({
            aoColumnDefs: [
                { bSortable: false, aTargets: [ 0 ] }
            ],
          ajax: {
            "url": '<?php echo site_url('sso/get_log/') ?><?= $get_data['username'];?>',
            "type": 'POST',
            "data": function ( d ) {
            },
              },
              columns: [
                { data: "time" },
                { data: "event" },
                { data: "client_id" }
              ]
        });
    //     tabel_detail.on( 'order.table_nisn search.table_nisn', function () {
    //     tabel_detail.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
    //         cell.innerHTML = i+1;
    //     } );
    // } ).draw();

</script>