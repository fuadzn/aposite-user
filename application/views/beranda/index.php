<?php
$this->load->view("layout/header");
?>
<section id="dashboard-analytics">
  <div class="form-group row">
    <div class="col-12 mr-auto">
      <!-- <form> -->
      <form id="search_laporan">
        <div class="input-group row">
          <?php
          if($this->load->get_var("user_info")->roleid == 11){
          ?>
          <select name="nama_provinsi" id="prov" class="form-control" style="margin-right: 10px;" disabled>
            <?php
            foreach ($provinsi2 as $value) {
              echo "<option id='val' value=" . $value->id_provinsi . ">" . $value->nm_provinsi . "</option>";
            }
            ?>
          </select>
          <?php } else{ ?>
            <select name="nama_provinsi" id="prov" class="form-control" style="margin-right: 10px;">
            <?php
            foreach ($provinsi as $value) {
              echo "<option id='val' value=" . $value->id_provinsi . ">" . $value->nm_provinsi . "</option>";
            }
            ?>
          </select>
          <?php } ?>
          <select name="nama_region" id="reg" class="form-control" style="margin-right: 10px;">
            <?php
            foreach ($region as $value) {
              echo "<option id='val' value=" . $value->id_region . ">" . $value->nama_region . "</option>";
            }
            ?>
          </select>
          <select name="nama_sekolah" id="sekolah" class="form-control" style="margin-right: 10px;"></select>
          <input type="hidden" class="form-control" id="prov_v" name="prov_v">
          <input type="hidden" class="form-control" id="reg_v" name="reg_v">
          <input type="hidden" class="form-control" id="sekolah_v" name="nama_sekolah_v">
        </div><!-- /input-group -->
      </form>
      <!-- </form> -->
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" id="email">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title" id="judul_email">Pendaftar email berdasarkan sekolah</h4>
          <div class="col-sm-12">
          
          </div>
        </div>
        <div class="card-content">
          <div class="card-body pl-0 row">
            <div class="col-lg-8 height-250">
              <canvas id="bar-chart"></canvas>
            </div>
            <div class="col-sm" id="tinggi_aktif">
              <canvas id="simple-pie-chart4"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <!-- Horizontal Chart -->
    <div class="col-md-6" id="jenjang">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title" id="judul_jenjang">Pendaftar berdasarkan Jenjang Sekolah</h4>
        </div>
        <div class="card-content">
          <div class="card-body pl-0">
            <div class="height-200">
              <canvas id="horizontal-bar"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-md-6" id="aktif">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title" id="judul_aktif">Jumlah Siswa yang Sudah Terdaftar</h4>
        </div>
        <div class="card-content">
          <div class="card-body pl-0 row">
            <div class="height-200 col-sm" id="tinggi_aktif">
              <canvas id="simple-pie-chart"></canvas>
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
  <section class="content">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
        <div class="card-header">
        <h4 class="card-title" id="judul_email">Data Siswa Yang Terdaftar</h4>
        </div>
          <div class="card-content">
            <div class="card-body">
              <table id="table_dashboard" class="display table table-hover table-bordered table-striped" cellspacing="0" style="width:100%" style="display:block;overflow:auto;">
                <!-- <a href="<?= site_url('beranda/pdf'); ?>" class="btn btn-secondary"><i class="fa fa-file"> Export to PDF</i></a>
                <a href="<?= site_url('beranda/excel'); ?>" class="btn btn-secondary" style="margin-left:10px;"><i class="fa fa-download"> Export to CSV</i></a> -->
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
</section>
<?php
$this->load->view("layout/footer");
?>

<script src="<?= base_url(); ?>/app-assets/vendors/js/charts/chart.min.js"></script>
<script type="text/javascript">
  var region, sekolah, provinsi;
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
  var horizontalChartctx = $("#horizontal-bar");
  var horizontalchartOptions = {
    // Elements options apply to all of the options unless overridden in a dataset
    // In this case, we are setting the border of each horizontal bar to be 2px wide
    elements: {
      rectangle: {
        borderWidth: 2,
        borderSkipped: 'right',
        borderSkipped: 'top',
      }
    },
    responsive: true,
    maintainAspectRatio: false,
    responsiveAnimationDuration: 500,
    legend: {
      display: false,
    },
    scales: {
      xAxes: [{
        display: true,
        gridLines: {
          color: grid_line_color,
        },
        scaleLabel: {
          display: true,
        }
      }],
      yAxes: [{
        display: true,
        gridLines: {
          color: grid_line_color,
        },
        scaleLabel: {
          display: true,
        }
      }]
    },
    title: {
      display: true,
      text: 'Jumlah Siswa yang telah mendaftarkan email'
    }
  };
  var pieChartctx = $("#simple-pie-chart");
  var pieChartctx2 = $("#simple-pie-chart2");
  var pieChartctx3 = $("#simple-pie-chart3");
  var pieChartctx4 = $("#simple-pie-chart4");
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
  // var piechartOptions2 = {
  //   responsive: true,
  //   maintainAspectRatio: false,
  //   responsiveAnimationDuration: 500,
  //   title: {
  //     display: true,
  //     text: 'Jenis Kelamin'
  //   }
  // };

  var barChartctx = $("#bar-chart");

  // Chart Options
  var barchartOptions = {
    // Elements options apply to all of the options unless overridden in a dataset
    // In this case, we are setting the border of each bar to be 2px wide
    elements: {
      rectangle: {
        borderWidth: 2,
        borderSkipped: 'left'
      }
    },
    animation: {
      onComplete: function() {
        var ctx = this.chart.ctx;
        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
        ctx.fillStyle = "grey";
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';

        this.data.datasets.forEach(function(dataset) {
          for (var i = 0; i < dataset.data.length; i++) {
            for (var key in dataset._meta) {
              var model = dataset._meta[key].data[i]._model;
              ctx.fillText(dataset.data[i], model.x, model.y - 5);
            }
          }
        });
      }
    },
    responsive: true,
    maintainAspectRatio: false,
    responsiveAnimationDuration: 500,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        display: true,
        gridLines: {
          color: grid_line_color,
        },
        scaleLabel: {
          display: true,
        }
      }],
      yAxes: [{
        display: true,
        gridLines: {
          color: grid_line_color,
        },
        scaleLabel: {
          display: true,
        },
        ticks: {
          stepSize: 1000
        },
      }],
    },
    title: {
      display: true,
      text: ''
    },

  };
  $(document).ready(function() {

    region = $('#reg').val();
    provinsi = $('#prov').val();
    <?php if ($user->id_sekolah != '') { ?>
      $('#reg').val(<?php echo $user->id_region; ?>).change();
      $('#prov').val(<?php echo $user->id_provinsi; ?>).change();
      $('#reg').attr('disabled', true);
      $('#prov').attr('disabled', true);
      $('#sekolah_v').val(<?php echo $user->id_sekolah; ?>).change();
      $('#reg_v').val(<?php echo $user->id_region; ?>).change();
      $('#prov_v').val(<?php echo $user->id_provinsi; ?>).change();
    <?php } else if ($user->id_region && $user->id_provinsi != '') { ?>
      $('#reg').val(<?php echo $user->id_region; ?>).change();
      $('#prov').val(<?php echo $user->id_provinsi; ?>).change();
      $('#reg').attr('disabled', true);
      $('#prov').attr('disabled', true);
      $('#reg_v').val(<?php echo $user->id_region; ?>).change();
      $('#prov_v').val(<?php echo $user->id_provinsi; ?>).change();
      searchData();
      getData();
    <?php } else { ?>
      getData();
      searchData();
      getRegion(provinsi);
      getSekolah(region);
    <?php } ?>
    console.log(provinsi);
    console.log(region);
    sekolah = $('#sekolah').val();
    region = $('#reg').val();
  });

  $('#reg').on('change', function() {
    region = this.value;
    getSekolah(region);
    searchData();
    getData();
  });
  $('#prov').on('change', function() {
    provinsi = this.value;
    getRegion(provinsi);
    searchData();
    getData();
  });

  function getRegion(provinsi) {
    $.ajax({
      url: "<?= site_url(); ?>beranda/show_region_by_provinsi/" + provinsi,
      type: 'GET',
      dataType: 'json',
      contentType: 'application/json',
      success: function(data) {
        option = ""
        $.each(data.list_region, function(i, val) {
          option += "<option id='value' value=" + val.id_region + ">" + val.nama_region + "</option>"
        });
        $('#reg').html(option);
        if ($('#reg_v').val() != "") {
          $('#reg').val($('#reg_v').val()).change();
          $('#reg').attr('disabled', true);
        }
      }
    })
  }

  function getSekolah(region) {
    $.ajax({
      url: "<?= site_url(); ?>beranda/show_sekolah_by_region/" + region,
      type: 'GET',
      dataType: 'json',
      contentType: 'application/json',
      success: function(data) {
        option = "<option value=''>Semua Sekolah</option>"
        $.each(data.list_sekolah, function(i, val) {
          option += "<option id='valueSekolah' value=" + val.id_sekolah + ">" + val.nm_sekolah + "</option>"
        });
        $('#sekolah').html(option);
        if ($('#sekolah_v').val() != "") {
          $('#sekolah').val($('#sekolah_v').val()).change();
          $('#sekolah').attr('disabled', true);
        }
      }
    })
  }

  $('#sekolah').on('change', function() {
    sekolah = this.value;
    searchData();
    console.log(sekolah);
    if (sekolah == '' || sekolah == null) { //untuk setting grafik khusus sekolah
      getData();
      $('#jenjang').show();
      $('#aktif').show();
      $('#tinggi_aktif').removeClass('height-300');
      $('#tinggi_aktif').addClass('height-200');
      document.getElementById("judul_aktif").innerHTML = "Jumlah Siswa yang Sudah Terdaftar";
      $('#aktif').removeClass('col-md-12');
      $('#aktif').addClass('col-md-6');
      $('#email').show();
      $('#simple-pie-chart2').hide();
      $('#simple-pie-chart3').hide();
      $('#simple-pie-chart').show();
    } else {
      getDataSekolah(sekolah);
      getDataSekolah2(sekolah);
      $('#jenjang').hide();
      $('#aktif').show();
      $('#aktif').addClass('col-md-12');
      $('#tinggi_aktif').addClass('height-300');
      document.getElementById("judul_aktif").innerHTML = "Perbandingan data siswa yang telah mendaftar";
      $('#email').hide();
      $('#simple-pie-chart').hide();
      $('#simple-pie-chart2').show();
      $('#simple-pie-chart3').show();
    }
  });

  function searchData() {
    if (sekolah === undefined || sekolah == '') {
      sekolah = null;
    }
    tabel_detail = $('#table_dashboard').DataTable({
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

  function getData() {
    getDataRegion(region)
    $('#jenjang').show();
    $('#aktif').show();
    $('#tinggi_aktif').removeClass('height-300');
    $('#tinggi_aktif').addClass('height-200');
    document.getElementById("judul_aktif").innerHTML = "Jumlah Siswa yang Sudah Terdaftar";
    $('#aktif').removeClass('col-md-12');
    $('#aktif').addClass('col-md-6');
    $('#email').show();
    $('#simple-pie-chart2').hide();
    $('#simple-pie-chart4').show();
    $('#simple-pie-chart').show();
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: "<?php echo base_url('beranda/get_all_pendaftaran_by_jenjang') ?>",
      data: {
        'region': region
      },
      success: function(data) {
        if (data == "") {
          alert("Data Kosong");
        } else {
          var horizontalchartData = {
            labels: data.jenjang,
            datasets: [{
              label: "Siswa",
              data: data.jumlah_siswa,
              backgroundColor: themeColors,
              borderColor: "transparent"
            }]
          };

          var horizontalChartconfig = {
            type: 'horizontalBar',
            // Chart Options
            options: horizontalchartOptions,
            data: horizontalchartData
          };
          // Create the chart
          var horizontalChart = new Chart(horizontalChartctx, horizontalChartconfig);
        }
      },
      error: function() {
        alert("error");
      }
    });

    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: "<?php echo base_url('beranda/get_all_pendaftaran_by_region') ?>",
      data: {
        'region': region
      },
      success: function(data) {
        if (data == "") {
          alert("Data Kosong");
        } else {
          var piechartData = {
            labels: data.sekolah,
            // datasets: data.dataset
            datasets: [{
              label: "Sekolah",
              data: data.siswa,
              backgroundColor: data.color
            }]
          };

          var pieChartconfig = {
            type: 'pie',
            // Chart Options
            options: piechartOptions,
            data: piechartData
          };

          var pieSimpleChart = new Chart(pieChartctx, pieChartconfig);
        }
      },
      error: function() {
        alert("error");
      }
    });
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: "<?php echo base_url('beranda/get_data_pendaftaran_by_region') ?>",
      data: {
        'region': region
      },
      success: function(data) {
        if (data == "") {
          alert("Data Kosong");
        } else {
          var barchartData = {
            labels: data.sekolah,
            datasets: [{
              label: "Siswa",
              data: data.siswa,
              backgroundColor: themeColors,
              borderColor: "transparent"
            }]
          };
          var barChartconfig = {
            type: 'bar',
            options: barchartOptions,
            data: barchartData
          };
          var barChart = new Chart(barChartctx, barChartconfig);
        }
      },
      error: function() {
        alert("error");
      }
    });
  }

  function getDataSekolah(sekolahs) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: "<?php echo base_url('beranda/get_perbandingan_pendaftaran') ?>",
      data: {
        'sekolah': sekolahs
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

  function getDataSekolah2(sekolahs) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: "<?php echo base_url('beranda/get_perbandingan_pendaftaran2') ?>",
      data: {
        'sekolah': sekolahs
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

          // var pieChartconfig = {
          //   type: 'pie',
          //   // Chart Options
          //   options: piechartOptions2,
          //   data: piechartData
          // };

          var pieSimpleChart = new Chart(pieChartctx3);
        }
      },
      error: function() {
        alert("error");
      }
    });
  }

  function getDataRegion(region) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: "<?php echo base_url('beranda/get_data_pendaftaran_by_region2') ?>",
      data: {
        'region': region
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

          // var pieChartconfig = {
          //   type: 'pie',
          //   // Chart Options
          //   options: piechartOptions2,
          //   data: piechartData
          // };
          var pieSimpleChart = new Chart(pieChartctx4);
        }
      },
      error: function() {
        alert("error");
      }
    });
  }
</script>