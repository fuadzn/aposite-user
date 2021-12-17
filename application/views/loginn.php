<?php
$this->load->view("layout/header2");
?>



<!-- Bagian Body -->
<!-- <section id="dashboard-analytics"> -->

<!-- <div class="form-group row"> -->
<!-- <div class="col-12 mr-auto"> -->
<div class="container-fluid">
    <div class="row bg-danger">
        <div class="col-sm-6 my-auto">
            <img src="<?= site_url(); ?>assets/images/siswa.png" class="img-fluid" alt="Responsive image" style="margin-top:100px;"><br><br><br><br><br><br><br><br><br>
        </div>
        <div class=" col-sm-6 my-auto">
            <h1 style="font-family: montserrat; color:white; width: 38rem;  margin: 0 auto; float: none;  margin: 0 auto; 
                    float: none; margin-bottom: 10px; font-size:32px;" class=" font-weight-bold">Aposite</h1>
            <p style="color: white; width: 38rem;  margin: 0 auto; float: none;  margin: 0 auto; 
                    float: none; margin-bottom: 10px; margin-bottom: 10px;" class="">Apotek dengan online akan menjadi efisien.</p>
            <div class="card " style="width: 38rem;  margin: 0 auto; float: none;  margin: 0 auto; 
                    float: none; margin-bottom: 10px; margin-bottom: 10px;">
                <div class="card-body">
                    <h4 class="mb-0" style="font-family: montserrat; color:#8779d5; ">Selamat Datang di Aposite</h4><br>
                    <p class="">Silahkan pesan obat di Aposite</p>
                </div>
                <form id="cek_form">
                <div class="card-content">
                    <div class="card-body pt-1">
                    <fieldset class="form-group">
                            <label for="nama_pembeli">Nama Pembeli</label>
                            <input type="text" id="nama_pembeli" class="form-control" name="nama_pembeli" placeholder="Nama Pembeli" autocomplete="off" aria-invalid="false" required>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="nama_obat">Nama Obat</label>
                            <select id="nama_obat" class="custom-select form-control select2 nama_obat" name="nama_obat" required>
                                <option value="">-Pilih Loket Kasir-</option>
                                <?php 
                                    foreach($obat as $row){                                             
                                        echo '<option '; echo 'value="'.$row->kd_obat.'">'.$row->nama_obat.'</option>';
                                        }?>
                            </select>
                            <!-- <small><a onclick="getObat()" class="tambah_obat">+ Tambah Obat</a></small> -->
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Email" autocomplete="off" aria-invalid="false" required>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="tgl_peng">Tanggal Pengambilan</label>
                            <input type="text" id="tgl_peng" class="form-control" name="tgl_peng" placeholder="Tanggal Pengambilan" autocomplete="off" aria-invalid="false" required>
                        </fieldset>
                        <button type="button" onclick="beli_obat()" class="btn waves-effect waves-light btn-primary float-right" name="btn-submit" id="btn-submit">Beli</button>
                        <!-- <a type="button" href="<?php echo site_url('login_portal'); ?>" class="btn btn-warning mr-1 float-right btn-inline">Kembali</a> -->
                    </div>
                </div>
                </form>
                <div class="login-footer">
                    <div class="divider">
                    </div>
                    <div class="footer-btn d-inline">
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

</div>
<!-- Tutup Operator -->
<!-- Tutup Body -->

<!-- </html> -->

<?php
$this->load->view("layout/footer");
?>

<script src="<?= base_url(); ?>/app-assets/vendors/js/charts/chart.min.js"></script>
<script>
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    // var ctx = document.getElementById('myChart').getContext('2d');
    // var myChart = new Chart(ctx, {
    //     type: 'line',
    //     data: {
    //         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    //         datasets: [{
    //             label: '# of Votes',
    //             data: [12, 19, 3, 5, 2, 3],
    //             backgroundColor: [
    //                 'rgba(255, 99, 132, 0.2)',
    //                 'rgba(54, 162, 235, 0.2)',
    //                 'rgba(255, 206, 86, 0.2)',
    //                 'rgba(75, 192, 192, 0.2)',
    //                 'rgba(153, 102, 255, 0.2)',
    //                 'rgba(255, 159, 64, 0.2)'
    //             ],
    //             borderColor: [
    //                 'rgba(255, 99, 132, 1)',
    //                 'rgba(54, 162, 235, 1)',
    //                 'rgba(255, 206, 86, 1)',
    //                 'rgba(75, 192, 192, 1)',
    //                 'rgba(153, 102, 255, 1)',
    //                 'rgba(255, 159, 64, 1)'
    //             ],
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             yAxes: [{
    //                 ticks: {
    //                     beginAtZero: true
    //                 }
    //             }]
    //         }
    //     }
    // });                                           
    var region, sekolah, provinsi;
    var $primary = '#7367F0';
    var $success = '#28C76F';
    var $danger = '#EA5455';
    var $warning = '#FF9F43';
    var $label_color = '#1E1E1E';
    var grid_line_color = '#dae1e7';
    var scatter_grid_color = '#f3f3f3';
    var $scatter_point_light = '#D1D4DB';
    var $scatter_point_dark = '#5175E0';
    var $white = '#fff';
    var $black = '#000';
    var themeColors = [$primary, $success, $danger, $warning, $label_color];
    var horizontalChartctx = $("#myChart");
    var horizontalchartOptions = {
        // Elements options apply to all of the options unless overridden in a dataset
        // In this case, we are setting the border of each horizontal bar to be 2px wide
        legend: {
            display: false,
        },
        title: {
            display: true,
            text: 'Jumlah Siswa yang telah mendaftarkan email'
        }
    };
    $(document).ready(function() {
        // $(".nama_obat").select2();
    });
    $('.nama_obat').select2({
          placeholder: '-- Cari Obat --',
          ajax: {
               url: '<?php echo site_url('login_portal/get_obat'); ?>',
               dataType: 'json',
               delay: 250,
               processResults: function(data) {
                    var results = [];
                    $.each(data, function(index, item) {
                         results.push({
                              id: item.kd_obat,
                              text: item.nama_obat
                         });
                    });
                    return {
                         results: results
                    };
               },
               cache: true
          }
     });
    $('.nama_obat2').select2({
          placeholder: '-- Cari Obat --',
          ajax: {
               url: '<?php echo site_url('login_portal/get_obat'); ?>',
               dataType: 'json',
               delay: 250,
               processResults: function(data) {
                    var results = [];
                    $.each(data, function(index, item) {
                         results.push({
                              id: item.kd_obat,
                              text: item.nama_obat
                         });
                    });
                    return {
                         results: results
                    };
               },
               cache: true
          }
     });
    $(function() {
		$('#tgl_peng').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		}); 
	});
    
    function getObat(){
        $('#nama_obat2').show();
        $('.tambah_obat').hide()
    }

    function beli_obat() {
          document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
          $.ajax({
               type: "POST",
               url: "<?php echo site_url('login_portal/beli_obat'); ?>",
               dataType: "JSON",
               data: $('#cek_form').serialize(),
               success: function(data, result) {
                    if (data == true) {
                         document.getElementById("btn-submit").innerHTML = 'Beli';
                         swal.fire({
                              title: 'Data berhasil dibeli',
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonText: 'Ok',
                              confirmButtonClass: 'btn btn-primary',
                              buttonsStyling: false,
                         }).then(function(result) {
                              window.location.reload();
                         });
                    } else {
                         document.getElementById("btn-submit").innerHTML = 'Beli';
                         Swal.fire({
                              type: 'warning',
                              title: 'Gagal!',
                              text: data.msg
                         });
                    }
               },
               error: function(event, textStatus, errorThrown) {
                    document.getElementById("btn-submit").innerHTML = 'Beli';
                    swal.fire("Error", "Gagal menyimpan data.", "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
               }
          });
        //   $.ajax({
        //     type: "POST",
        //     url: "<?php echo site_url('login_portal/send_mail'); ?>",
        //     dataType: "JSON",
        //     data: $('#cek_form').serialize(),
        //     success: function(response) {
        //         if (response.success) {
        //         } else {
        //         }
        //     }
        // });
     }
</script>