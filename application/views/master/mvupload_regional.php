<?php
$this->load->view("layout/header");

?>


<section class="content-header">
    <?php
    echo $this->session->flashdata('success_msg');
    ?>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card card-outline-info">
                <div class="card-header border-bottom mx-2 px-0">
                    <h3 class="border-bottom py-1 mb-0 font-medium-2">
                        <i class="fa fa-user mr-50 "></i>Data Regional
                    </h3>
                    <div align="right">
                        <button class="btn btn-outline-primary" onclick="getexcel_operator()"><i class="fa fa-cloud-download"></i> Template Regional</button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="uploadRegional" method="post" enctype="multipart/form-data">
                        <div class="form-group mt-2">
                            <div class="alert alert-danger" role="alert">Data Regional tidak boleh mengandung simbol atau Tanda Petik ( ' )</div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="fileRegional" id="fileRegional" required>
                                <label class="custom-file-label" id="label_file" for="fileRegional">Cari file Excel Regional</label>
                            </div>
                        </div>
                        <button class="btn btn-danger" type="submit"><i class="fa fa-cloud-upload"></i> Upload Regional</button>
                    </form> <br>
                    <div class="progress" style="height:15px; display:none;">
                        <div class="progress-bar progress-bar-striped bg-success" id="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php
$this->load->view("layout/footer");
?>
<script src="<?= site_url(); ?>assets/js/numeral.js"></script>
<script type='text/javascript'>
    var site = "<?php echo site_url(); ?>";
    var tableTindakan, tableTarif;
    var progressBar = $('#progress-bar');
    $(document).ready(function() {
        $(".select2").select2();
        // $('#label_file').val('Cari file Excel Regional');
        $('#uploadRegional').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= base_url('upload_regional/upload_regional') ?>",
                method: "POST",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function(response) {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(event) {
                        if (event.lengthComputable) {
                            var percentComplete = Math.round((event.loaded / event.total) * 100);
                            $('.progress').show();
                            progressBar.css({
                                width: percentComplete + "%"
                            });
                            progressBar.text(percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Upload Berhasil", "Email yang Berhasil dibuat " + response.berhasil + " akun, gagal dibuat " + response.gagal, "info").then(function(result) {
                                   window.location.reload();
                              });;
                        document.getElementById("uploadRegional").reset();
                        document.getElementById("label_file").innerHTML = 'Cari file Excel Regional';
                    } else {
                        alert('Gagal').then(function(result) {
                                   window.location.reload();
                              });;
                    }
                }
            })
        });
    });

    function getexcel_operator() {
        window.open(site + 'upload_regional/exceldown/regional', "_blank");
        window.focus();
    }

    function getCaraBayar(carabayar) {
        $('#penjamin').empty();

        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: "<?php echo base_url('master/upload/getDetailCB') ?>",
            data: {
                carabayar: carabayar
            },
            success: function(data) {
                //alert(data);
                $('#penjamin').html(data);
            },
            error: function() {
                alert("error");
            }
        });
    }

    function loadingSwal() {
        Swal.fire({
            title: 'Menyimpan Data!',
            html: 'Harap Menunggu.',
            // timer: 2000,
            // timerProgressBar: true,
            onBeforeOpen: () => {
                Swal.showLoading()
                // timerInterval = setInterval(() => {
                // Swal.getContent().querySelector('b')
                // 	.textContent = Swal.getTimerLeft()
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

    
</script>