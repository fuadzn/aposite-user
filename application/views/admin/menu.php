<?php
	$this->load->view('layout/header.php');
?>

<section id="accordion">
    <div class="row">
        <div class="col-sm-8">
            <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
                <div class="card collapse-icon accordion-icon-rotate">
                    <div class="card-header">
                        <h4 class="card-title">Atur Urutan Menu</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                        	<div class="accordion-shadow collapse-bordered dt-module__content-inner" id="accordion">
								<?php echo $sortMenu; ?>
                            </div>
                        </div>
                        <div class="card-footer">
							<button id="btnRefresh" class="btn btn-warning">Refresh</button>
						</div>
                    </div>
                </div>
            </div>
        </div>
	    <div class="col-md-4">
            <div class="card collapse-icon accordion-icon-rotate">
                <div class="card-header">
                    <h4 class="card-title">Form Input <i class="fa fa-chevron-right"></i></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
						<button class="btn btn-success" id="btnAdd">Tambah Menu Baru</button>
						<hr/>
						<form id="idform" action="<?php echo site_url('admin/menuSave'); ?>" method="post">
							<div class='form-group form-group-default'>		
								<label>Title</label>
								<input type="text" id="title" name="title" class="form-control" />
								<input type="hidden" id="id" name="id"/>
							</div>   
							<div class='form-group form-group-default'>		
								<label>URL</label>
								<input type="text" id="url" name="url" class="form-control" />
							</div>   
							<div class='form-group form-group-default'>		
								<label>Icon <a href="<?=site_url('admin/icon_feather');?>" target="_blank" class="badge badge-secondary ml-1">feather</a> or <a href="<?=site_url('admin/icon_fa');?>" target="_blank" class="badge badge-primary">fa</a></label>
								<input type="text" id="icon" name="icon" class="form-control" />
							</div>   
							<div class='form-group form-group-default'>		
								<label>Parent</label>							
								<?php 
									echo form_dropdown(
									array(
										'name'=>'parent_id',
										'id'=>'parent_id',
										'class'=>'form-control'), 
									$parents, 
									' ');
								?>
							</div>  
							<button type="reset" class="btn btn-inverse">Reset</button>&nbsp;
							<button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>    							
						</form>
						<ul id="error_message_box"></ul>
						<div id="feedback_bar"></div>
					</div>
	            </div>
	        </div>
	    </div>
    </div>
</section>
	
<?php
	$this->load->view('layout/footer.php');
?>


<script type='text/javascript'>
$(function() {
	$('#btnAdd').addClass('disabled');
	$( "#dialog-confirm" ).hide();
	$('#btnSimpan').click(function(){
		$.ajax({
			type: 'POST',
			url: $('#idform').attr( 'action' ),
			data: $('#idform').serialize(),
			success: function( response ) {
				if(!response.success)
				{
					//set_feedback(response.message,'error_message',true);
				}
				else
				{
					//set_feedback(response.message,'success_message',false);
					window.location.reload(true);
				}
			},
			dataType:'json'
		});
	});
	$('#accordion').accordion({
        collapsible: true,
        active: false,
        height: 'fill',
        header: '> div > .dt-module__toolbar'
    }).sortable({
        items: '.dt-module__content-inner',
		update: function (event, ui) {
			var a = $(this).sortable("serialize", {
				attribute: "id"
			});
			var r = $(this).sortable( "toArray" );
			$.ajax({
				data: {data:r},
				type: 'POST',
				url: '<?php echo site_url('admin/updateOrderMenu'); ?>',
				success: function( response ) {
					//alert(response);
				}
			});
		}
    });

    $('#accordion').on('accordionactivate', function (event, ui) {
        if (ui.newPanel.length) {
            $('#accordion').sortable('disable');
        } else {
            $('#accordion').sortable('enable');
        }
    });
	
	$( ".sortable" ).sortable({
		update: function (event, ui) {
			var a = $(this).sortable("serialize", {
				attribute: "id"
			});
			var r = $(this).sortable( "toArray" );
			$.ajax({
				data: {data:r},
				type: 'POST',
				url: '<?php echo site_url('admin/updateOrderMenu'); ?>',
				success: function( response ) {
					//alert(response);
				}
			});
		}
	});
		
	$( "#btnRefresh" ).click(function() {
		window.location.reload(true);
	});
	
	$( "#btnAdd" ).click(function() {		
		$("#id").val('');
		$("#title").val('');
		$("#url").val('');
		$("#parent_id").val(0);
	});
});

function editMenu(vid){
	$.ajax({
		data: {id:vid},
		type: 'POST',
		url: '<?php echo site_url('admin/menuInfo'); ?>',
		dataType:'json',
		success: function( response ) {
			$('#btnAdd').removeClass('disabled');
			$("#id").val(response.page_id);
			$("#title").val(response.title);
			$("#url").val(response.url);
			$("#icon").val(response.icon);
			$("#parent_id").val(response.parent_id);			
		}
	});
	return false;
}

function dropMenu(vid){
	$.ajax({
		data: {id:vid},
		type: 'POST',
		url: '<?php echo site_url('admin/hasChildMenu'); ?>',
		dataType:'json',
		success: function( response ) {
			if (response.hasChild){
				$( "#dialog-confirm" ).html("Menu memiliki submenu. <br/>Menu tidak dapat dihapus.");
				$( "#dialog-confirm" ).dialog({
				  resizable: false,
				  modal: true,
				  buttons: {
					"Oke": function() {
					  $( this ).dialog( "close" );
					}
				  }
				});
			}else{
				Swal.fire({
			        title: "Hapus Menu",
			        text: "Yakin akan menghapus menu tersebut?",
			        type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Hapus!'
				}).then((result) => {
				  	if (result.value) {
					  	$.ajax({
							data: {id:vid},
							type: 'POST',
							url: '<?php echo site_url('admin/dropMenu'); ?>',
							dataType:'JSON',
							success: function(response) {
								if (response.success){
									window.location.reload(true);
									Swal.fire("Sukses","Berhasil menghapus data.", "success");
								}else Swal.fire("Error","Gagal menghapus data.", "error");
							}
						});
				  	}
				})			
			}
		}
	});
	
	return false;
}
</script>
<script src="<?php echo site_url(); ?>app-assets/vendors/js/ui/jquery-ui.js" type="text/javascript"></script>