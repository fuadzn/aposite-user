<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="PT. INTI KONTEN INDONESIA">
    <meta name="keywords" content="klinik, klinik pratama, intens, pt intens, pt inti konten indonesia, hmis, hospital, rumah sakit">
    <meta name="author" content="INTENS">
    <title><?php echo $this->config->item('web_title'); ?></title>
    <link rel="apple-touch-icon" href="<?= site_url(); ?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= site_url(); ?>app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?= site_url(); ?>app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?= site_url(); ?>app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= site_url(); ?>app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?= site_url(); ?>app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?= site_url(); ?>app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?= site_url(); ?>app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?= site_url(); ?>app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= site_url(); ?>app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= site_url(); ?>app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?= site_url(); ?>app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= site_url(); ?>assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column" style="background-image: url('<?= site_url('assets/images/zimbra_admin3.png')  ?>');">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-11 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                                    <img src="<?= site_url(); ?>assets/images/siswa.png" style="width:280px;" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Login Email Siswa</h4>
                                            </div>
                                        </div>
                                        <p class="px-2">Selamat datang user, silahkan login</p>

                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                <?php
                                                $attributes = array('class' => '', 'id' => 'loginform');
                                                echo form_open('login_siswa/login_siswa_check', $attributes);
                                                ?>
                                                <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email Pengguna" required <?php
                                                                                                                                                            if ($username) {
                                                                                                                                                                echo 'value="' . $username . '"';
                                                                                                                                                            } else {
                                                                                                                                                                echo 'autofocus';
                                                                                                                                                            }
                                                                                                                                                            ?>>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                    <label for="email">Email Pengguna</label>
                                                </fieldset>

                                                <fieldset class="form-label-group position-relative has-icon-left">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi" required <?php
                                                                                                                                                                if ($username) {
                                                                                                                                                                    echo 'autofocus';
                                                                                                                                                                }
                                                                                                                                                                ?>>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-lock"></i>
                                                    </div>
                                                    <label for="password">Kata Sandi</label>
                                                </fieldset>
                                                <?php
                                                if (validation_errors()) {
                                                    echo validation_errors();
                                                }
                                                ?>
                                                <div class="form-group d-flex justify-content-between align-items-center">
                                                    <a href="Lupa_password/">Lupa Kata Sandi?</a>
                                                    <!-- <a href="Daftar_Sekolah/"> <i class="feather icon-home"></i> Daftar Sekolah</i></a>
                                                    <a href="Daftar_Siswa/"> <i class="feather icon-user"></i> Daftar Siswa</a> -->
                                                </div>
                                                <!-- <div class="form-group d-flex justify-content-between align-items-center">
                                                        <div class="text-left">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <input type="checkbox">
                                                                    <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span class="">Remember me</span>
                                                                </div>
                                                            </fieldset>
                                                        </div> -->
                                                <!-- <div class="text-right"><a href="auth-forgot-password.html" class="card-link">Forgot Password?</a></div> -->
                                                <!-- </div> -->
                                                <!-- <a href="auth-register.html" class="btn btn-outline-primary float-left btn-inline">Register</a> -->
                                                <button type="submit" class="btn btn-primary float-right btn-inline">Masuk</button>
                                                <a type="button" href="<?php echo site_url('login_portal'); ?>" class="btn btn-warning mr-1 float-right btn-inline">Kembali</a>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                        <div class="login-footer">
                                            <div class="divider">
                                                <!-- <div class="divider-text">OR</div> -->
                                            </div>
                                            <div class="footer-btn d-inline">
                                                <!-- <a href="#" class="btn btn-facebook"><span class="fa fa-facebook"></span></a>
                                                <a href="#" class="btn btn-twitter white"><span class="fa fa-twitter"></span></a>
                                                <a href="#" class="btn btn-google"><span class="fa fa-google"></span></a>
                                                <a href="#" class="btn btn-github"><span class="fa fa-github-alt"></span></a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <?php
    $this->load->view("layout/footer");
    ?>

    <script type="text/javascript">
        // function changePassword(nuptk, nik){
        //     $.ajax({
        //         dataType: "JSON",
        //         type: 'POST',
        //         url: "<?php echo base_url('Login_portal/send_mail_forget'); ?>",
        //         data: {'nik' : nik},
        //         success: function(response) {
        //             if (response.success) {
        //                 Swal.fire("Sukses",response.msg, "success");
        //             } else {
        //                 Swal.fire("Error",response.msg, "error");
        //             }
        //         }
        //     });
        // }
        $("#loginform").submit(function(event) {

            event.preventDefault();
            $.ajax({
                url: "<?php echo site_url('Login_siswa/login_siswa_check') ?>",
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                success: function(result) {
                    var url = result.preauthURL;
                    if (result.success) {
                        // Swal.fire({
                        //     type: 'success',
                        //     title: 'Berhasil Masuk!',
                        // }).
                        // then(function(result) {
                        window.location.replace(url);
                        // });
                    } else {
                        if (result.msg !== '') {
                            Swal.fire({
                                type: 'warning',
                                title: 'Gagal!',
                                text: result.msg
                            }).then(function(result) {
                                window.location.reload();
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
    </script>
    <!-- BEGIN: Vendor JS-->
    <script src="<?= site_url(); ?>app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?= site_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?= site_url(); ?>app-assets/js/core/app-menu.js"></script>
    <script src="<?= site_url(); ?>app-assets/js/core/app.js"></script>
    <script src="<?= site_url(); ?>app-assets/js/scripts/components.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>