<?php
$this->load->view('layout/header');
?>

<section class="content">
    <div class="row match-height">
    <div class="col-md-12">
				<?php echo $this->session->flashdata('success_msg'); ?>
	</div>
        <?php echo form_open('nisn/update_siswa');?>
                        <!-- Modal Edit Obat -->
                        
                        <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-success">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Ubah Data Siswa</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">NISN</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="edit_nisn" id="edit_nisn" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">NPSN</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="edit_npsn" id="edit_npsn" readonly>
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
                                            <p class="col-sm-3 form-control-label">Kelas</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="edit_kelas" id="edit_kelas">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">Nama</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="edit_nama" id="edit_nama">
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
                    <div class="card-body table-responsive">
                        <table id="table_nisn" class="display table table-hover table-bordered table-striped" cellspacing="0" style="width:100%" style="display:block;overflow:auto;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NISN</th>
                                    <th>NPSN</th>
                                    <th>Asal Sekolah</th>
                                    <th>Kelas</th>
                                    <th>Nama</th>
                                    <!-- <th>Email</th>
                                    <th>Email Alternatif</th> -->
                                    <th id="aksi">Aksi</th>
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
        $('#aksi').attr('hidden', true);
        <?php if ($roleLogin == 9){ ?>
            $('#aksi').attr('hidden', false);
        <?php } ?>
        tabel_detail = $('#table_nisn').DataTable({
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
          ajax: {
            "url": '<?php echo site_url('nisn/show_data_siswa')?>',
            "type": 'POST',
            "data": function ( d ) {
            },
              },
              columns: [
                { data: "no" },
                { data: "nisn" },
                { data: "npsn" },
                { data: "nm_sekolah" },
                { data: "kelas" },
                { data: "nama" },
                { data: "aksi" }
                    // { data: "email_alter" }
              ]
        });
        tabel_detail.on( 'order.table_nisn search.table_nisn', function () {
        tabel_detail.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    });

    function changePassword(id, nisn, email){
        document.getElementById("reset_pass_"+nisn).innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
        $.ajax({
            dataType: "JSON",
            type: 'POST',
            url: "<?php echo base_url('nisn/changePass'); ?>",
            data: {'email' : email},
            success: function(response) {
                if (response.success) {
                    document.getElementById("reset_pass_"+nisn).innerHTML = '<i class="fa fa-lock"></i> Reset Password';
                    tabel_detail.ajax.reload();
                    Swal.fire("Sukses",response.msg, "success");
                } else {
                    document.getElementById("reset_pass_"+nisn).innerHTML = '<i class="fa fa-lock"></i> Reset Password';
                    Swal.fire("Error",response.msg, "error");
                }
            }
        });
        $.ajax({
            dataType: "JSON",
            type: 'POST',
            url: "<?php echo base_url('Nisn/send_mail'); ?>",
            data: {'id' : id},
            success: function(response) {
                if (response.success) {
                } else {
                }
            }
        });
    }

    function edit_siswa(id) {
            $.ajax({
                type:'POST',
                dataType: 'json',
                url:"<?php echo base_url('nisn/edit_siswa')?>",
                data: {
                    id: id
                },
                success: function(data){
                    $('#edit_nisn').val(data[0].nisn);
                    $('#edit_npsn').val(data[0].npsn);
                    $('#edit_sekolah').val(data[0].nm_sekolah);
                    $('#edit_kelas').val(data[0].kelas);
                    $('#edit_nama').val(data[0].nama);
                },
                error: function(){
                    alert("error");
                }
            });
        }

        function hapus_siswa(id) {
        Swal.fire({
          title: 'Hapus Data Siswa?',
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
                    url:"<?php echo base_url('nisn/hapus_siswa')?>",
                    data: {
                        id: id
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

    // function send_email(id) {
    //     $.ajax({
    //         type: 'POST',
    //         dataType: 'json',
    //         url: "<?php echo base_url('Nisn/get_data_email') ?>",
    //         data: {
    //             id: id
    //         },
    //         success: function(data) {
    //             $('#id_siswa').val(data[0].id);
    //             $('#email').val(data[0].email_alter);
    //         },
    //         error: function() {
    //             alert("error");
    //         }
    //     });
    // }
</script>