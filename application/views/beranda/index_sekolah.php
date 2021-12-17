<?php
$this->load->view("layout/header");
// print_r($sekolah);
// print_r($region);
?>
<section id="dashboard-analytics">
    <div class="row">
        <div class="col-md-12">
            <form id="search_laporan">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" value="<?= $region->nama_region; ?>" readonly>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" value="<?= $sekolah->nm_sekolah; ?>" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="judul_aktif">Jumlah Siswa yang Sudah Terdaftar</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0 row">
                        <div class="height-200 col-sm" id="tinggi_aktif">
                            <canvas id="simple-pie-chart2"></canvas>
                        </div>
                        <div class="col-sm" id="tinggi_aktif">
                            <canvas id="simple-pie-chart3"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="judul_email">Data Siswa Yang Terdaftar</h4>
            </div>
                <div class="card-content">
                    <div class="card-body table-responsive">
                        <table id="table_dashboard" class="display table table-hover table-bordered table-striped" cellspacing="0" style="width:100%" style="display:block;overflow:auto;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NISN</th>
                                    <th>Kota/Kab</th>
                                    <th>Asal Sekolah</th>
                                    <th>Kelas</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Email Alternatif</th>
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

<script src="<?= base_url(); ?>/app-assets/vendors/js/charts/chart.min.js"></script>
<script type="text/javascript">
    // var region,sekolah;
    var region = '<?= $region->id_region; ?>';
    var sekolah = '<?= $sekolah->id_sekolah; ?>';
    var tabel_detail;
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

    var pieChartctx2 = $("#simple-pie-chart2");
    var pieChartctx3 = $("#simple-pie-chart3");
    // Chart Options
    var piechartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration: 500,
        title: {
            display: true,
            text: 'Sekolah'
        }
    };
    var piechartOptions2 = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration: 500,
        title: {
            display: true,
            text: 'Jenis Kelamin'
        }
    };

    $(document).ready(function() {
        getDataSekolah();
        getDataSekolah2();
        searchData();
    });

    function searchData() {
        tabel_detail = $('#table_dashboard').DataTable({
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
                "url": '<?php echo site_url('beranda/get_filtered_siswa/') ?>' + region + '/' + sekolah,
                "type": 'POST',
                "data": function(d) {},
            },
            columns: [{
                    data: "no"
                },
                {
                    data: "nisn"
                },
                {
                    data: "nama_region"
                },
                {
                    data: "nm_sekolah"
                },
                {
                    data: "kelas"
                },
                {
                    data: "nama"
                },
                {
                    data: "email"
                },
                {
                    data: "email_alter"
                }
            ]
        });
            tabel_detail.on( 'order.table_dashboard search.table_dashboard', function () {
            tabel_detail.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
        // tabel_detail.destroy();
    }

    function getDataSekolah() {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('beranda/get_perbandingan_pendaftaran') ?>",
            data: {
                'sekolah': sekolah
            },
            success: function(data) {
                if (data == "") {
                    alert("Data Kosong");
                } else {
                    var piechartData = {
                        labels: [
                            'Sudah',
                            'Belum'
                        ],
                        datasets: [{
                            data: data.pendaftar,
                            backgroundColor: themeColors,
                        }]
                    };

                    var pieChartconfig = {
                        type: 'pie',
                        // Chart Options
                        options: piechartOptions,
                        data: piechartData
                    };

                    var pieSimpleChart = new Chart(pieChartctx2, pieChartconfig);
                }
            },
            error: function() {
                alert("error");
            }
        });
    }

    function getDataSekolah2() {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('beranda/get_perbandingan_pendaftaran2') ?>",
            data: {
                'sekolah': sekolah
            },
            success: function(data) {
                if (data == "") {
                    alert("Data Kosong");
                } else {
                    var piechartData = {
                        labels: [
                            'Laki-laki',
                            'Perempuan'
                        ],
                        datasets: [{
                            data: data.pendaftar,
                            backgroundColor: themeColors,
                        }]
                    };

                    var pieChartconfig = {
                        type: 'pie',
                        // Chart Options
                        options: piechartOptions2,
                        data: piechartData
                    };

                    var pieSimpleChart = new Chart(pieChartctx3, pieChartconfig);
                }
            },
            error: function() {
                alert("error");
            }
        });
    }
</script>