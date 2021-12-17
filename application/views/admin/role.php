<?php
	$this->load->view('layout/header.php');
?>

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <!-- <h4 class="card-title">Zero configuration</h4> -->
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table id="example" class="table zero-configuration">
                                <thead>
                                    <tr>
										<th>#</th>
										<th>Role</th>
										<th>Deskripsi</th>
										<th class="text-center">Akses</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>#</th>
										<th>Role</th>
										<th>Deskripsi</th>
										<th class="text-center">Akses</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<div id="dialog-confirm"></div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title" id="modalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">	
				<form id="detailForm">
            		<div id="show_menu"></div>	
				</form>				
				<!-- <div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="detailTable">
						<thead>
							<tr>
								<th></th>
								<th>urutan</th>
								<th></th>
								<th>Menu</th>
							</tr>
						</thead>
					</table>
				</div> -->
                
            </div>
            <div class="modal-footer">
				<button type="button" onclick="saveSetting()" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<?php
	$this->load->view('layout/footer.php');
?>


<script type='text/javascript'>
	var objTable;
	$(function() {
		$( "#dialog-confirm" ).hide();
		objTable = $('#example').DataTable( {
			ajax: "<?php echo site_url('admin/roleList'); ?>",
			columns: [
				{ data: "id" },
				{ data: "role" },
				{ data: "deskripsi" },
				{ data: "access" }
			],
			columnDefs: [
				{ targets: [ 0 ], visible: false }
			]	
		});	
		
		$('#btnSimpan').click(function(){
			$.ajax({
				data: {id:$('#role').val()},
				type: 'POST',
				url: '<?php echo site_url('admin/roleExist'); ?>',
				dataType:'json',
				success: function( response ) {
					if (response.exist){
						$( "#dialog-confirm" ).html("Sudah ada role dengan nama yang sama!");
						$( "#dialog-confirm" ).dialog({
						  resizable: false,
						  modal: true,
						  buttons: {
							"Oke": function() {
								$( this ).dialog( "close" );
								$('#role').focus();
							}
						  }
						});
					}else{										  
						$.ajax({			
							type: 'POST',				
							url: $('#idform').attr( 'action' ),
							data: $('#idform').serialize(),
							dataType:'json',
							success: function( response ) {
								if (response.success) window.location.reload(true);
								else alert("Gagal menambahkan data");
							}
						});							
					}
				}
			});
		});
		//=========== When (modal) POP-UP closed, remove class from TR Grid =================
		$('#myModal').on('hidden.bs.modal', function (e) {
			// $("tr").removeClass('detailselected');
		});
	});

	// var objTable2;
	function setAccessRole(vid,vname){
		loadingSwal();
		$.ajax({		
			type: 'POST',					
			url:  '<?php echo site_url('admin/roleMenuListDiv'); ?>',
			data: {vid:vid},
			dataType:'json',
			success: function( response ) {
				if (response.success){ 
					// alert("Access Menu Berhasil");
					swal.close();
					$('#show_menu').html(response.data);
				}else {
					alert("Access Menu Gagal");
					swal.close();
				}
			}
		});	

		// if (objTable2!= null)
		// 	objTable2.destroy();

		// objTable2 = $('#detailTable').DataTable( {
		// 	ajax: "<?php echo site_url('admin/roleMenuList'); ?>/"+vid,
		// 	columns: [
		// 		{ data: "id" },
		// 		{ data: "urutan" },
		// 		{
		// 			data:   "sts",
		// 			render: function ( data, type, row ) {
		// 				if ( type === 'display' ) {
		// 					if (data==0){
		// 						// return "<input type='checkbox' name='checkApp' value='"+vid+"' onchange='chooseApp(this)'id='"+row.id+"'/><label for='"+row.id+"'></label>";

		// 						return '<fieldset><div class="vs-checkbox-con vs-checkbox-primary"><input type="checkbox" name="checkApp" value="'+vid+'" onchange="chooseApp(this)" id="'+row.id+'"><span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span><span class="">'+row.menu+'</span></div></fieldset>';
		// 					}else{
		// 						// return "<input type='checkbox' name='checkApp' value='"+vid+"' onchange='chooseApp(this)' id='"+row.id+"' checked/><label for='"+row.id+"'></label>";
		// 						return '<fieldset><div class="vs-checkbox-con vs-checkbox-primary"><input type="checkbox" name="checkApp" value="'+vid+'" onchange="chooseApp(this)" id="'+row.id+'" checked><span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span><span class="">'+row.menu+'</span></div></fieldset>';
		// 					}
		// 				}
		// 				return data;
		// 			},
		// 			className: "dt-body-center"
		// 		},
		// 		{ data: "menu" }
		// 	],
		// 	columnDefs: [
		// 		{ targets: [ 0 ], visible: false },
		// 		{ targets: [ 1 ], visible: false, orderable: false },
		// 		{ targets: [ 2 ], orderable: false },
		// 		{ targets: [ 3 ], orderable: false, visible: false }
		// 	],
		// 	paging: false,			
		// 	searching: false,
		// 	autoWidth: false,
		// 	order: [[ 1, "asc" ]]			
		// } );	
		$('#modalTitle').html( "Set Access Menu for Role : <strong>"+vname+"</strong>");
	}

	function saveSetting(){
		loadingSwal();
		$('#myModal').modal('hide');
		var vdata = [];
		var checkApp = $("#detailForm input:checkbox");
		var x=0;
		// alert(checkApp[2].value);
		for (var i = 0; i < checkApp.length; i++) {
			if (checkApp[i].checked) {
				vdata[x] = {"value":checkApp[i].value};	
				x++;
			}
		}
		
		$.ajax({		
			type: 'POST',					
			url: '<?php echo site_url('admin/roleMenuSave'); ?>',
			data: {vdata:vdata},
			dataType:'json',
			success: function( response ) {
				if (response.success){ 
					Swal.fire({
				      title: "Sukses!",
				      text: "Akses Menu Berhasil",
				      type: "success",
				      confirmButtonClass: 'btn btn-primary',
				      buttonsStyling: false,
				    });
				}else {
					$('#myModal').modal('show');
					// swal("Access Menu Gagal");
					Swal.fire({
				      title: "Maaf!",
				      text: "Akses Menu Gagal",
				      type: "warning",
				      confirmButtonClass: 'btn btn-primary',
				      buttonsStyling: false,
				    });
				}
			}
		});	
	}

	function chooseApp(obj) {
		if (obj.checked){
			//alert("checked!");
			$(obj).parent().parent().addClass("selected");
		}else{
			//alert("unchecked!");
			if ( $(obj).parent().parent().hasClass('selected') ) {
				$(obj).parent().parent().removeClass('selected');
			}
		}
	}	

	function loadingSwal(){
		Swal.fire({
			title: 'Menyimpan Data!',
			html: 'Harap Menunggu.',
			// timer: 2000,
			// timerProgressBar: true,
			onBeforeOpen: () => {
				Swal.showLoading()
				// timerInterval = setInterval(() => {
				// Swal.getContent().querySelector('b')
				// 	.textContent = Swal.getTimerLeft()
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
</script>