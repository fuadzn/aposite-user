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
        <!-- <?php echo form_open('email/insert_email'); ?>	 -->
        <form id="cek_form">
            <div class="col-lg-10" style="margin: 0 auto;">
                <div class="form-group row">
                    <label class="col-sm-3 control-label col-form-label" id="nisn_lbl">NISN</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="nisn" id="nisn" onkeypress="return inputNumbersOnly(event)" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label col-form-label" id="nik_lbl">NPSN</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="npsn" id="npsn" onkeypress="return inputNumbersOnly(event)" maxlength="16" required>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label class="col-sm-3 control-label col-form-label" id="panggil_lbl">Nama Panggilan</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="panggilan" id="panggilan" required>
                        <small>*) Nama ini akan digunakan untuk email.</small>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label class="col-sm-7 control-label col-form-label"></label>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary btn-inline" id="check">Cek</button><br>
                    </div>
                </div>

                <div class="form-group row" id="nma">
                    <label class="col-sm-3 control-label col-form-label">Nama Lengkap</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="nama" id="nama" readonly>
                    </div>
                </div>
                <div class="form-group row" id="sklh">
                    <label class="col-sm-3 control-label col-form-label">Sekolah</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="sekolah" id="sekolah" readonly>
                    </div>
                </div>
                <div class="form-group row" id="eml">
                    <label class="col-sm-3 control-label col-form-label">Email</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="email" id="email" readonly>
                    </div>
                </div>
                <div class="form-group row" id="kls">
                    <label class="col-sm-3 control-label col-form-label">Kelas</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="kelas" id="kelas" readonly>
                    </div>
                </div>
                <div class="form-group row" id="nohp">
                    <label class="col-sm-3 control-label col-form-label">No HP</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="no_hp" id="no_hp" maxlength="13" onkeypress="return inputNumbersOnly(event)">
                    </div>
                </div>
                <div class="form-group row" id="emlal">
                    <label class="col-sm-3 control-label col-form-label">Email Alternatif</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" name="emailal" id="emailal">
                        <input type="text" class="form-control col-md-10" name="id_region" id="id_region" hidden>
                        <input type="text" class="form-control col-md-10" name="alamat" id="alamat" hidden>
                        <input type="text" class="form-control col-md-10" name="tgl_lahir" id="tgl_lahir" hidden>
                        <input type="text" class="form-control col-md-10" name="id_sekolah" id="id_sekolah" hidden>
                    </div>
                </div>
                <br>
                <h4 id="teks">Data Orang Tua / Wali</h4>
                <br>
                <div class="form-group row" id="nama_ortu_lb">
                    <label class="col-sm-3 control-label col-form-label">Nama Orang Tua / Wali *</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="nama_ortu" id="nama_ortu" readonly>
                    </div>
                </div>
                <div class="form-group row" id="no_hp_ortu_lb">
                    <label class="col-sm-3 control-label col-form-label">Nomor Hp Orang Tua / Wali</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="no_hp_ortu" id="no_hp_ortu" maxlength="13" onkeypress="return inputNumbersOnly(event)">
                    </div>
                </div>
                <div class="form-group row" id="email_ortu_lb">
                    <label class="col-sm-3 control-label col-form-label">Email Orang Tua / Wali</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" name="email_ortu" id="email_ortu">
                    </div>
                </div>
                <input type="text" class="form-control" style="border-radius:20px; height:40px;" name="sex" id="sex" hidden>
                <div class="form-actions" id="simpan">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="button" onclick="insert_siswa()" class="btn waves-effect waves-light btn-primary" name="btn-submit" id="btn-submit">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <?php echo form_close(); ?> -->
            </div>
        </form>
    </div>
</div>


<?php
$this->load->view("layout/footer");
?>

<script type='text/javascript'>
    function insert_siswa() {
        if ($('#no_hp').val() == "") {
            swal.fire("Maaf", "Harap Isi No HP.", "error")
        } else if ($('#emailal').val() == "") {
            swal.fire("Maaf", "Harap Isi Email Alternatif.", "error")
        } else if ($('#no_hp_ortu').val() == "") {
            swal.fire("Maaf", "Harap Isi Nomor Orang Tua.", "error")
        } else if ($('#email_ortu').val() == "") {
            swal.fire("Maaf", "Harap Isi Email Orang Tua.", "error")
        } else {
            document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('email/insert_siswa'); ?>",
                dataType: "JSON",
                data: $('#cek_form').serialize(),
                success: function(result) {
                    var str = "Username : " + result.email + "\n" +
                              "Password : " + result.npsn + "\n" +
                              "*Silahkan ubah password anda \n dengan login ke <a href='https://mail.siswa.id/' target='_blank'>https://emailsiswa.layanan.go.id/</a>" + "\n" +
                              "lalu masuk ke menu preferences." + "\n";
                              var red = "<h3>Email Berhasil Dibuat<br><b style ='color:red;'>Harap Catat Email dan Password!</b></h3>";
                         if (result.success) {
                              document.getElementById("btn-submit").innerHTML = 'Buat Email';
                              $('#modal-sd').modal('hide');
                              $('.modal-backdrop').remove();
                              swal.fire({
                                   title: red,
                                   html: '<pre>' + str + '</pre>',
                                   type: 'success',
                                   showCancelButton: false,
                                   confirmButtonText: 'Ok',
                                   confirmButtonClass: 'btn btn-primary',
                                   buttonsStyling: false,
                                   customClass: 'swal-wide',
                              }).then(function(result) {
                                   window.location.reload();
                              });
                    } else {
                        if (result.msg !== '') {
                            document.getElementById("btn-submit").innerHTML = 'Simpan';
                            Swal.fire({
                                type: 'warning',
                                title: 'Gagal!',
                                text: result.msg
                            }).then(function(result) {
                                window.location.reload();
                            });
                        }
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    document.getElementById("btn-submit").innerHTML = 'Simpan';
                    $('#modal-sd').modal('hide');
                    $('.modal-backdrop').remove();
                    swal.fire("Error", "Gagal menyimpan data.", "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                }
            });
            $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('email/email'); ?>",
                    dataType: "JSON",
                    data: $('#cek_form').serialize(),
                    success: function(result) {
                         if (result.success) {
                         } else {
                         }
                    },
               });
        }
    }

    function inputNumbersOnly(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $('#nma').hide();
    $('#sklh').hide();
    $('#eml').hide();
    $('#kls').hide();
    $('#emlal').hide();
    $('#nohp').hide();
    $('#sex').hide();
    $('#teks').hide();
    $('#nama_ortu_lb').hide();
    $('#no_hp_ortu_lb').hide();
    $('#email_ortu_lb').hide();
    $('#nama_ortu').hide();
    $('#no_hp_ortu').hide();
    $('#email_ortu').hide();
    $('#btn-submit').hide();

    $("#cek_form").submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: "<?php echo site_url('email/cek_data_siswa') ?>",
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(data) {
                if (data.success) {
                    $('#nma').show();
                    $('#sklh').show();
                    $('#eml').show();
                    // $('#panggil').show();
                    // $('#panggilan').attr('readonly', true);
                    $('#sex').show();
                    $('#emlal').show();
                    $('#kls').show();
                    $('#nohp').show();
                    $('#teks').show();
                    $('#nama_ortu_lb').show();
                    $('#no_hp_ortu_lb').show();
                    $('#email_ortu_lb').show();
                    $('#nama_ortu').show().val(data.nama_orangtua);
                    $('#no_hp_ortu').show();
                    $('#email_ortu').show();
                    $('#nisn').attr('readonly', true);
                    $('#npsn').attr('readonly', true);
                    $('#sekolah').show().val(data.nm_sekolah);
                    $('#nama').show().val(data.nama);
                    // $('#email').show().val($('#panggilan').val()+'@siswa.id');
                    var str = data.namapertama;
                    var res = str.toLowerCase();
                    $('#email').show().val(res + '.' + data.nisn_email + '@siswa.id');
                    $('#id_region').val(data.id_region);
                    $('#alamat').val(data.alamat);
                    $('#kelas').val(data.kelas);
                    $('#tgl_lahir').val(data.tgl_lahir);
                    $('#sex').val(data.sex);
                    $('#id_sekolah').val(data.id_sekolah);
                    $('#emailal').show();
                    $('#btn-submit').show();
                    $('#check').hide();


                } else {
                    if (data.msg !== '') {
                        Swal.fire({
                            type: 'warning',
                            title: 'Gagal!',
                            text: data.msg
                        });
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Terjadi Kesalahan... Silahkan hubungi Administrator'
                        });
                    }
                }
            }

        });
    });

    // $(function(){
    //     $('#nma').hide();
    //     $('#sklh').hide();
    //     $('#eml').hide();
    //     $('#emlal').hide();
    //     $('#simpan').hide();
    // });
</script>