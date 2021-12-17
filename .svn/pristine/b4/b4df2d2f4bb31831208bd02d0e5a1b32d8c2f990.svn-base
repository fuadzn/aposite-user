<?php
  $this->load->view('layout/header.php');
?>
<section id="basic-vertical-layouts">
  <div class="row match-height">
      <div class="col-md-12 col-12">
          <div class="card">
              <div class="card-content">
                  <div class="card-body">
                      <form class="form form-vertical" id="formKlinik">
                          <div class="form-body">
                              <div class="row">
                                  <div class="col-6">
                                      <div class="form-group">
                                          <label for="nama">Nama Klinik</label>
                                          <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama Klinik">
                                      </div>
                                  </div>
                                  <div class="col-6">
                                      <div class="form-group">
                                          <label for="namasingkat">Nama Klinik Singkat</label>
                                          <input type="text" id="namasingkat" class="form-control" name="namasingkat" placeholder="Nama Klinik Singkat">
                                      </div>
                                  </div>
                                  <div class="col-12">
                                      <div class="form-group">
                                          <label for="alamat">Alamat</label>
                                          <fieldset class="form-label-group mb-0">
                                              <textarea data-length=255 class="form-control char-textarea" id="alamat" name="alamat" rows="3" placeholder="Alamat"></textarea>
                                          </fieldset>
                                          <small class="counter-value float-right"><span class="char-count">0</span> / 255 </small>
                                      </div>
                                  </div>
                                  <div class="col-12">
                                      <div class="form-group">
                                          <label for="load_wilayah">Wilayah</label>
                                          <select id="load_wilayah" name="load_wilayah" class="form-control load_wilayah" style="width:100%"></select>
                                      </div>
                                  </div>
                                  <div class="col-12">
                                      <div class="form-group">
                                          <label for="telp">Telp</label>
                                          <input type="number" id="telp" class="form-control" name="telp" placeholder="Telp">
                                      </div>
                                  </div>
                                  <div class="col-12">
                                      <div class="form-group">
                                        <label>Email</label>
                                        <div class="controls">
                                            <input type="email" name="email" id="email" class="form-control" data-validation-required-message="Email salah!" placeholder="Email" autocomplete="off">
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-12">
                                      <button id="tambahKlinik" type="button" class="btn btn-primary mr-1 mb-1">Tambah</button>
                                  </div>
                              </div>
                          </div>
                      </form>
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
  $(".select2").select2({
    dropdownAutoWidth: true,
    width: '100%'
  });

  $('.load_wilayah').select2({
    placeholder: '-- Cari Kota/Kabupaten, Kecamatan atau Kelurahan --',
    ajax: {
      url: '<?=site_url();?>admin/get_wilayah',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        var results = [];

            $.each(data, function(index, item){
                results.push({
                    id: item.id_provinsi + '@' + item.id_kota + '@' + item.id_kecamatan + '@' + item.id_kelurahan,
                    text: item.nm_kelurahan + ', ' + item.nm_kecamatan + ', ' + item.nm_kota + ', ' + item.nm_provinsi
                });
            });
            return { results: results };
      },
      cache: true
    }
  });
  $(function() {
    
  });
  $(document).ready(function () {
    $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
  });

  $('#tambahKlinik').on( 'click', function () {
      if($("#nama").val()==""){
        toastr.warning('Nama klinik tidak boleh kosong!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#nama").focus();
      }else if($("#namasingkat").val()==""){
        toastr.warning('Nama singkat klinik tidak boleh kosong!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#namasingkat").focus();
      }else if($("#alamat").val()==""){
        toastr.warning('Alamat klinik tidak boleh kosong!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#alamat").focus();
      }else if($("#load_wilayah").val()==""){
        toastr.warning('Wilayah klinik tidak boleh kosong!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#load_wilayah").focus();
      }else if($("#telp").val()==""){
        toastr.warning('Telp klinik tidak boleh kosong!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#telp").focus();
      }else if($("#email").val()==""){
        toastr.warning('Email klinik tidak boleh kosong!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#email").focus();
      }else if (!validateEmail($("#email").val())) {
        toastr.warning('Email anda salah!', 'Maaf!', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
        $("#email").focus();
      }else{
        Swal.fire({
          title: 'Tambah Klinik?',
          // text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya',
          confirmButtonClass: 'btn btn-primary',
          cancelButtonText: 'Tidak',
          cancelButtonClass: 'btn btn-danger ml-1',
          buttonsStyling: false,
        }).then(function (result) {
          if (result.value) {
            loadingSwal();
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data: $("#formKlinik").serialize(),
                url: "<?php echo site_url('admin/klinikSave')?>",
                success: function(data){
                    if(data.success){
                        Swal.fire(
                            'Sukses',
                            'Berhasil Menambah Klinik.',
                            'success'
                        );
                        var link = '<?php echo site_url('admin/klinik/detail/')?>'+data.id
                        window.open(link, '_self');
                    }else{
                        Swal.fire(
                            'Maaf',
                            'Menambah Klinik Gagal.',
                            'info'
                        );
                    }
                }
            });
          }
        })
      }
  });
  function loadingSwal(){
    Swal.fire({
      title: 'Menambah Data!',
      html: 'Harap Menunggu.',
      // timer: 2000,
      // timerProgressBar: true,
      onBeforeOpen: () => {
        Swal.showLoading()
        // timerInterval = setInterval(() => {
        // Swal.getContent().querySelector('b')
        //  .textContent = Swal.getTimerLeft()
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
  $("input#namasingkat").on({
    keydown: function(e) {
      if (e.which === 32)
        return false;
    },
    change: function() {
      this.value = this.value.replace(/\s/g, "");
      this.value = this.value.replace(/[^a-zA-Z0-9]/g, "");
      this.value = this.value.toLowerCase();
    }
  });

  // $('#email').keyup(function(){
  //   if (validateEmail($("#email").val())) {
  //     document.getElementById("email").className = "form-control is-valid";
  //   } else {
  //     document.getElementById("email").className = "form-control is-invalid";
  //   }
  // });
  function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }
</script>