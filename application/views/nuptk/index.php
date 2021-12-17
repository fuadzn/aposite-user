<?php
$this->load->view('layout/header');
?>

    <?php echo $this->session->flashdata('msg'); ?>
<section class="content">
    <div class="row match-height">
    <div class="col-md-12">
	</div>
  <?php echo form_open('nuptk/update_operator');?>
                        <!-- Modal Edit Obat -->
                        
                        <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-success">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Ubah Data Operator</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">NUPTK</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="edit_nuptk" id="edit_nuptk" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">Asal Sekolah</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="edit_sekolah" id="edit_sekolah" readonly>
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
                                            <p class="col-sm-3 form-control-label">No Hp</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="edit_no_hp" id="edit_no_hp">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">Email</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="edit_email" id="edit_email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button class="btn btn-primary" type="submit" id="btn-submit">Perbarui</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <table id="table_nuptk" class="display table table-hover table-bordered table-striped" cellspacing="0" style="width:100%" style="display:block;overflow:auto;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NUPTK</th>
                                    <th>Asal Sekolah</th>
                                    <th>Nama</th>
                                    <th>No Hp</th>
                                    <th>Email</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                                <tbody>
                                </tbody>
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
        tabel_detail = $('#table_nuptk').DataTable({
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
        "url": '<?php echo site_url('Nuptk/get_siswa') ?>',
        "type": 'POST',
        "data": function(d) {},
      },
      columns: [{
          data: "no"
        },
        {
          data: "nuptk"
        },
        {
          data: "sekolah"
        },
        {
          data: "nama"
        },
        {
          data: "no_hp"
        },
        {
          data: "email"
        },
        {
          data: "statuss"
        },
        {
          data: "aksi"
        }
      ]
    });

      tabel_detail.on( 'order.table_nuptk search.table_nuptk', function () {
        tabel_detail.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    // tabel_detail.destroy();
    })

    function edit_operator(nuptk) {
            $.ajax({
                type:'POST',
                dataType: 'json',
                url:"<?php echo base_url('nuptk/edit_operator')?>",
                data: {
                    nuptk: nuptk
                },
                success: function(data){
                    $('#edit_nuptk').val(data[0].nuptk);
                    $('#edit_sekolah').val(data[0].sekolah);
                    $('#edit_nama').val(data[0].nama);
                    $('#edit_no_hp').val(data[0].no_hp);
                    $('#edit_email').val(data[0].email);
                },
                error: function(){
                    alert("error");
                }
            });
        }
    
        function hapus_operator(nuptk) {
        Swal.fire({
          title: 'Hapus Operator Sekolah?',
          text: 'Benar Akan Menghapus Data ini?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya',
          confirmButtonClass: 'btn btn-primary',
          cancelButtonText: 'Tidak',
          cancelButtonClass: 'btn btn-danger ml-1',
          buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
            $.ajax({
                    type:'post',
                    dataType: 'json',
                    url:"<?php echo base_url('nuptk/hapus_operator')?>",
                    data: {
                        nuptk: nuptk
                    },
                    success: function(data){
                        if(data.status=='success'){
                            Swal.fire({
                                title: 'Selesai',
                                text: 'Data Sudah Dihapus',
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'Ok',
                                confirmButtonClass: 'btn btn-primary',
                                buttonsStyling: false,
                            }).then(function (result) {
                                window.location.reload();
                            });
                        }else {
                            Swal.fire(data.status, "Terjadi Kesalahan !", "error");
                        }
                    },
                    error: function(data){

                    }
                });
            }
            });
        }

    //     function update_operator() {
    //       document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    //       $.ajax({
    //            type: "POST",
    //            url: "<?php echo site_url('nuptk/update_operator'); ?>",
    //            dataType: "JSON",
    //            data: $(this).serialize(),
    //            success: function(data, result) {
    //                 if (data.success) {

    //                      document.getElementById("btn-submit").innerHTML = 'Perbarui';
    //                      swal.fire({
    //                           title: 'Data berhasil diperbarui',
    //                           type: 'success',
    //                           showCancelButton: false,
    //                           confirmButtonText: 'Ok',
    //                           confirmButtonClass: 'btn btn-primary',
    //                           buttonsStyling: false,
    //                      }).then(function(result) {
    //                           window.location.reload();
    //                      });
    //                 } else {
    //                 }
    //            },
    //            error: function(event, textStatus, errorThrown) {
    //                 document.getElementById("btn-submit").innerHTML = 'Simpan';
    //                 swal.fire("Error", "Gagal memperbarui data.", "error");
    //                 console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
    //            }
    //       });
    //  }
</script>