<?php
	$this->load->view('layout/header.php');
?>
<section id="basic-datatable">
  <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                  <!-- <h4 class="card-title">Zero configuration</h4> -->
                  <a href="<?=site_url();?>admin/klinik/tambah" class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Tambah Klinik</a>
              </div>
              <div class="card-content">
                  <div class="card-body card-dashboard">
                      <div class="table-responsive">
                          <table class="table zero-configuration" id="tableKlinik" style="width:100%;">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Nama</th>
                                      <th>Singkat</th>
                                      <th>Alamat</th>
                                      <th>Telp</th>
                                      <th>Email</th>
                                      <th>Aksi</th>
                                  </tr>
                              </thead>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<?php
	$this->load->view('layout/footer.php');
?>

<script type="text/javascript">
  var objTable;
  $(function() {
    objTable = $('#tableKlinik').DataTable( {
      ajax: "<?php echo site_url('admin/klinikList'); ?>",
      columns: [
        { data: "id" },
        { data: "nama" },
        { data: "namasingkat" },
        { data: "alamat" },
        { data: "telp" },
        { data: "email" },
        { data: "aksi" }
      ],
      columnDefs: [
        { targets: [ 0 ], visible: false }
      ] 
    }); 
  });
</script>