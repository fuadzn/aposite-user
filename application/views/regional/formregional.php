<?php
$this->load->view("layout/header");
?>

<?php echo $this->session->flashdata('success_msg'); ?>
<br>
<div class="card card-outline-info">
     <div class="card-header">
          <h4 class="m-b-0 text-white text-center">PENDAFTARAN EMAIL BARU</h4>
     </div>
     <div class="card-block p-b-15">
          <form id="cek_form">
               <div class="col-lg-10" style="margin: 0 auto;">
                    <div class="form-group row">
                         <label class="col-sm-3 control-label col-form-label" id="name">Nama</label>
                         <div class="col-sm-6">
                              <input type="text" class="form-control" name="name" id="name" required>
                         </div>
                    </div>
                    <div class="form-group row">
                         <label class="col-sm-3 control-label col-form-label" id="username">Username</label>
                         <div class="col-sm-6">
                              <input type="text" class="form-control" name="username" id="username" required>
                         </div>
                    </div>
                    <div class="form-group row">
                         <p class="col-sm-3 form-control-label  col-form-label">Password</p>
                         <div class="col-sm-6">
                              <input type="password" class="form-control" name="password" id="password" required>
                         </div>
                    </div>
                    <div class="form-group row">
                         <label class="col-sm-3 control-label col-form-label">Pilih Admin</label>
                         <div class="col-sm-6">
                         <select id="pilih_admin" class="custom-select form-control select2" style="width: 100%" name="pilih_admin" onchange="pilihAdmin(this.value)" required>
                              <option value="0">-- Pilih Admin --</option>
                              <option value="1">Admin Provinsi</option>
                              <option value="2">Admin Kota / Kabupaten</option>
                         </select>
                         </div>
                    </div>
                    <div class="form-group row" id="fprovinsi">
                         <label class="col-sm-3 control-label col-form-label">Provinsi</label>
                         <div class="col-sm-6">
                              <select id="nama_provinsi" name="nama_provinsi" class="form-control nama_provinsi select2" onchange="pilihProvinsi(this.value)" style="width:500px">
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
                         <label class="col-sm-3 control-label col-form-label">Kota / Kabupaten</label>
                         <div class="col-sm-6">
                              <input type="hidden" class="form-control" id="nama_kota_v" >
                              <select id="nama_kota" name="nama_kota" class="form-control nama_kota select2" style="width:500px"></select>
                         </div>
                    </div>
                    <div class="form-actions" id="simpan">
                         <div class="row">
                              <div class="col-md-12">
                                   <div class="row">
                                        <div class="col-md-12 text-center">
                                             <button type="button" onclick="insert_regional()" class="btn waves-effect waves-light btn-primary" name="btn-submit" id="btn-submit">Simpan</button>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </form>
     </div>
</div>
<section class="content-header">
    <?php
    echo $this->session->flashdata('success_msgs');
    ?>
</section>
<div class="card">
     <div class="card-content">
          <div class="card-body">
               <table id="table_regional" class="display table table-hover table-bordered table-striped" cellspacing="0" style="width:100%" style="display:block;overflow:auto;">
                    <thead>
                         <tr>
                              <th>No</th>
                              <th>Nama</th>
                              <th>Username</th>
                              <th>Region</th>
                              <th>Aksi</th>
                         </tr>
                    <tbody>
                    </tbody>
                    </thead>
               </table>
          </div>
     </div>
</div>

<?php echo form_open('Regional/edit_reg'); ?>
<!-- Modal Edit Obat -->

<div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Regional</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_id" id="edit_id" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_nama" id="edit_nama">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Username</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_username" id="edit_username">
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Edit Paket</button>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>



<?php
$this->load->view("layout/footer");
?>

<script type='text/javascript'>
     tabel_detail = $('#table_regional').DataTable({
      paging: true,
      dom: 'fltripB',
      buttons: [{
          extend: 'csv',
          text: 'Export to CSV',
          filename: function() {
            return 'Download CSV';
          }
        },
        {
          extend: 'pdfHtml5',
          text: 'Export to PDF',
          filename: function() {
            return 'Download PDF';
          }
        }
      ],
      aoColumnDefs: [
        { bSortable: false, aTargets: [ 0 ] }
      ],
      searching: true,
      destroy: true,
      ajax: {
        "url": '<?php echo site_url('Regional/get_regional') ?>',
        "type": 'POST',
        "data": function(d) {},
      },
      columns: [{
          data: "no"
        },
        {
          data: "name"
        },
        {
          data: "username"
        },
        {
          data: "nm_regional"
        },
        {
          data: "aksi"
        }
      ]
    });

      tabel_detail.on( 'order.table_regional search.table_regional', function () {
        tabel_detail.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
     $(document).ready(function() {
          // $( "#nama_region" ).autocomplete({
          //   source: "<?php //echo site_url('regional/get_autocomplete');
                         ?>"
          // });
          $('.auto_search_region').autocomplete({
               serviceUrl: '<?php echo site_url(); ?>regional/get_autocomplete',
               // onSelect: function (suggestion) {
               //      $('#cari_no_cm').val(''+suggestion.no_cm);
               //      $('#no_medrec_baru').val(''+suggestion.no_medrec);
               //      // alert(suggestion.no_cm);

               // }
          });

          $('#fprovinsi').hide();
          $('#fkota').hide();
     });

     $('.nama_region').select2({
          placeholder: '-- Cari Provinsi, Kota/Kabupaten atau Kecamatan --',
          ajax: {
               url: '<?php echo site_url('regional/get_wilayah2'); ?>',
               dataType: 'json',
               delay: 250,
               processResults: function(data) {
                    var results = [];
                    $.each(data, function(index, item) {
                         results.push({
                              id: item.id_region,
                              text: item.nama_region
                         });
                    });
                    return {
                         results: results
                    };
               },
               cache: true
          }
     });

     function insert_regional() {
          document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
          $.ajax({
               type: "POST",
               url: "<?php echo site_url('regional/insert_regional'); ?>",
               dataType: "JSON",
               data: $('#cek_form').serialize(),
               success: function(data, result) {
                    if (data == true) {
                         document.getElementById("btn-submit").innerHTML = 'Simpan';
                         swal.fire({
                              title: 'Data berhasil disimpan',
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonText: 'Ok',
                              confirmButtonClass: 'btn btn-primary',
                              buttonsStyling: false,
                         }).then(function(result) {
                              window.location.reload();
                         });
                    } else {
                         document.getElementById("btn-submit").innerHTML = 'Simpan';
                         Swal.fire({
                              type: 'warning',
                              title: 'Gagal!',
                              text: data.msg
                         });
                    }
               },
               error: function(event, textStatus, errorThrown) {
                    document.getElementById("btn-submit").innerHTML = 'Simpan';
                    swal.fire("Error", "Gagal menyimpan data.", "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
               }
          });
     }

     

     var val_admin = $('#pilih_admin').val();
     pilihAdmin(val_admin);
     function pilihAdmin(val_admin) {
		if (val_admin == '1') {
			$('#fprovinsi').show();
			$('#fkota').hide();
		} else{
			$('#fprovinsi').show();
			$('#fkota').show();
		}
     }

     // var val_provinsi = $('#nama_provinsi').val();
     // pilihProvinsi(val_provinsi);
     // function pilihProvinsi(val_provinsi) {
	// 	if (val_provinsi == '1') {
	// 		$('#fprovinsi').show();
	// 		$('#fkota').hide();
	// 	} else{
	// 		$('#fprovinsi').show();
	// 		$('#fkota').show();
	// 	}
     // }

     function pilihProvinsi(){
		$.ajax({
	        type: "POST",
	        dataType: "JSON",
	        data: {
	        	"nama_provinsi" : $('#nama_provinsi').val()
	        },
	        url: "<?php echo site_url('Regional/get_data_kota')?>",
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
     
     function edit_reg(id) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('Regional/get_data_reg') ?>",
            data: {
                id: id
            },
            success: function(data) {
                $('#edit_id').val(data[0].userid);
                $('#edit_nama').val(data[0].name);
                $('#edit_username').val(data[0].username);
            },
            error: function() {
                alert("error");
            }
        });
    }

    function delete_reg(id) {
        Swal.fire({
            title: 'Regional',
            text: 'Yakin akan menghapus data tersebut?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonText: 'Tidak',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'Regional/delete_reg'; ?>",
                    dataType: "JSON",
                    data: {
                        'id': id
                    },
                    success: function(result) {
                        if (result == true) {
                            tabel_detail.ajax.reload();
                            Swal.fire("Sukses", "Data berhasil dihapus.", "success");
                        } else {
                            Swal.fire("Error", "Gagal menghapus data.", "error");
                        }
                    },
                    error: function(event, textStatus, errorThrown) {
                        Swal.fire("Error", "Gagal menghapus data.", "error");
                        console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                    }
                });
            }
        });

    }
</script>