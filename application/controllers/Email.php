<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once("Secure_area.php");
class Email extends Secure_area
{
    public function __construct()
    {
        parent::__construct();
        require APPPATH.'libraries/PHPMailer/src/Exception.php';
		require APPPATH.'libraries/PHPMailer/src/PHPMailer.php';
		require APPPATH.'libraries/PHPMailer/src/SMTP.php';
        $this->load->model('admin/M_sekolah', '', TRUE);
    }

    public function index()
    {
        $data['title'] = 'Daftar Email Siswa';
        $this->load->view('email/formemail', $data);
    }

    public function insert_email()
    {
        $data['title'] = "Form Email";

        $data['nisn'] = $this->input->post('nisn');
        $data['tgl_lahir'] = $this->input->post('tgl_lahir');
        $data['nama'] = $this->input->post('nama');
        $data['sekolah'] = $this->input->post('sekolah');

        $this->load->view('email/email', $data);
    }

    public function show_data_email()
    {
        $line  = array();
        $line2 = array();
        $row2  = array();
        $hasil = $this->M_sekolah->get_siswa()->result();
        $i = 1;
        foreach ($hasil as $value) {
            $row2['no'] = $i++;
            $row2['nisn'] = $value->nisn;
            $row2['nik'] = $value->nik;
            $row2['npsn'] = $value->npsn;
            $row2['sekolah'] = $value->sekolah;
            $row2['email_alter'] = $value->email_alter;

            $line2[] = $row2;
        }
        $line['data'] = $line2;

        echo json_encode($line);
    }

    function cek_data_siswa()
    {
        $data = array(
            'nisn' => $this->input->post('nisn'),
            'npsn' => $this->input->post('npsn')
            // 'panggilan' => $this->input->post('panggilan')
        );
        $email = $this->M_sekolah->cek_siswa_exist($data['nisn'])->num_rows();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://10.10.22.41/zimbra-api/index.php/api/emailexist");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "emailaccount=". $this->input->post('email'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response = ($httpCode == 200) ? true : false ;

        curl_close ($ch);

        $roleid = $this->load->get_var("user_info")->roleid;
        if ($roleid == 9) {
            $id_sekolah = $this->load->get_var("user_info")->id_sekolah;
            $cek = $this->M_sekolah->cek_siswa_by_id($data['nisn'], $id_sekolah)->num_rows();
            $cekk = $this->M_sekolah->cek_npsn_by_id($data['nisn'], $data['npsn'], $id_sekolah)->num_rows();
            if ($response || $email == 1) {
                $result = array('success' => false, 'msg' => 'Email Sudah Terdaftar!');
            } else if ($cek == 0) {
                $result = array('success' => false, 'msg' => 'NISN Tidak Ditemukan');
            } else if ($cekk > 0) {
                $result = array('success' => true);
                $data = $this->M_sekolah->cek_npsn_by_id($data['nisn'], $data['npsn'], $id_sekolah)->row();
                $result['nama'] = $data->nama;
                $result['nm_sekolah'] = $data->nm_sekolah;
                $nisn=substr($data->nisn,3,10);
                $result['nisn_email'] = $nisn;
                $cek_nama = $data->nama;
                $get_nama = explode(" ", $cek_nama);
                $nama_pertama = $get_nama[0];
                $result['namapertama'] = $nama_pertama;
                $result['nisn'] = $data->nisn;
                $result['kelas'] = $data->kelas;
                $result['npsn'] = $data->npsn;
                $result['sex'] = $data->sex;
                $result['id_region'] = $data->id_region;
                $result['alamat'] = $data->alamat;
                $result['tgl_lahir'] = $data->tgl_lahir;
                $result['id_sekolah'] = $data->id_sekolah;
                $result['nama_orangtua'] = $data->nama_orangtua;
            } else {
                $result = array('success' => false, 'msg' => 'NPSN Tidak Cocok');
            }

            echo json_encode($result);
        } else {
            $cek = $this->M_sekolah->cek_siswa($data['nisn'])->num_rows();
            $cekk = $this->M_sekolah->cek_npsn($data['nisn'], $data['npsn'])->num_rows();
            if ($response || $email == 1) {
                $result = array('success' => false, 'msg' => 'Email Sudah Terdaftar!');
            } else if ($cek == 0) {
                $result = array('success' => false, 'msg' => 'NISN Tidak Ditemukan');
            } else if ($cekk > 0) {
                $result = array('success' => true);
                $data = $this->M_sekolah->cek_npsn($data['nisn'], $data['npsn'])->row();
                $result['nama'] = $data->nama;
                $result['nm_sekolah'] = $data->nm_sekolah;
                $nisn=substr($data->nisn,3,10);
                $result['nisn_email'] = $nisn;
                $cek_nama = $data->nama;
                $get_nama = explode(" ", $cek_nama);
                $nama_pertama = $get_nama[0];
                $result['namapertama'] = $nama_pertama;
                $result['nisn'] = $data->nisn;
                $result['kelas'] = $data->kelas;
                // $panggilan = $this->input->post('panggilan');
                // $result['panggilan'] = $data['panggilan'];
                $result['npsn'] = $data->npsn;
                $result['sex'] = $data->sex;
                $result['id_region'] = $data->id_region;
                $result['alamat'] = $data->alamat;
                $result['tgl_lahir'] = $data->tgl_lahir;
                $result['id_sekolah'] = $data->id_sekolah;
                $result['nama_orangtua'] = $data->nama_orangtua;
            } else {
                $result = array('success' => false, 'msg' => 'NPSN Tidak Cocok');
            }

            echo json_encode($result);
        }
    }

    function insert_siswa()
    {
      ini_set('max_execution_time', '300');
        $data = array(
            'nisn' => $this->input->post('nisn'),
            'nik' => $this->input->post('nik'),
            'npsn' => $this->input->post('npsn'),
            'nm_sekolah' => $this->input->post('sekolah'),
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'kelas' => $this->input->post('kelas'),
            'panggilan' => $this->input->post('panggilan'),
            'email_alter' => $this->input->post('emailal'),
            'id_region' => $this->input->post('id_region'),
            'alamat' => $this->input->post('alamat'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'no_hp' => $this->input->post('no_hp'),
            'sex' => $this->input->post('sex'),
            'kelas' => $this->input->post('kelas'),
            'id_sekolah' => $this->input->post('id_sekolah'),
            'nama_orangtua' => $this->input->post('nama_ortu'),
            'no_orangtua' => $this->input->post('no_hp_ortu'),
            'email_orangtua' => $this->input->post('email_ortu'),
            'xcreate_user' => $this->load->get_var("user_info")->username,
            'xcreate_date' => date('Y-m-d h:i:s')
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://10.10.22.41/zimbra-api/index.php/api/emailexist");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "emailaccount=" . $this->input->post('email'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response = ($httpCode == 200) ? true : false;

        curl_close($ch);
        if ($response) {
            $result = array('success' => false, 'msg' => 'Email Sudah Terdaftar!');
        } else {
            // $result = json_encode(array('success' => false, 'msg' => 'Data Email Tidak Ditemukan'));

            $ch2 = curl_init();

            curl_setopt($ch2, CURLOPT_URL, "http://10.10.22.41/zimbra-api/index.php/api/createaccount");
            curl_setopt($ch2, CURLOPT_POST, 1);
            curl_setopt(
                $ch2,
                CURLOPT_POSTFIELDS,
                "emailaddress=" . $this->input->post('email') . "&sn=" . $this->input->post('nama') . "&password=" . $this->input->post('npsn')
            );

            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch2);
            $httpCode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
            $response = ($httpCode == 200) ? true : false;

            curl_close($ch2);
            if ($response) {
                $result = $this->M_sekolah->insert_siswa($data);
                $data1 = array(
                    'keterangan' => 'create email siswa',
                    'ket_waktu' => date('Y-m-d h:i:s'),
                    'userid' => $this->load->get_var('user_info')->userid
                );
                $this->M_sekolah->log_activity($data1);
                $result = array('success' => true, 'email' => $data['email'], 'npsn' => $data['npsn'], 'msg' => 'Email Berhasil Didaftarkan!');
            } else {
                $result = array('success' => false, 'msg' => 'Terjadi Masalah pada Server Email!');
            }
        }

        echo json_encode($result);
    }

    public function email()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host     = 'mail.intens.co.id';
        $mail->Port     = 465;
        $mail->SMTPAuth = true;
        $mail->Username = "adminemail@intens.co.id";
        $mail->Password = "adminemail1234";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      
        $mail->isHTML(true);

        $mail->setFrom("adminemail@intens.co.id", "Portal Email");
        $mail->addAddress($this->input->post('emailal'));
        // Email subject
        $mail->Subject = "Pendaftaran Akun Email";
        $message= '
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <meta name="viewport" content="width=320, initial-scale=1" />
          <title>Airmail Confirm</title>
          <style type="text/css">
        
            /* ----- Client Fixes ----- */
        
            /* Force Outlook to provide a "view in browser" message */
            #outlook a {
              padding: 0;
            }
        
            /* Force Hotmail to display emails at full width */
            .ReadMsgBody {
              width: 100%;
            }
        
            .ExternalClass {
              width: 100%;
            }
        
            /* Force Hotmail to display normal line spacing */
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
              line-height: 100%;
            }
        
        
             /* Prevent WebKit and Windows mobile changing default text sizes */
            body, table, td, p, a, li, blockquote {
              -webkit-text-size-adjust: 100%;
              -ms-text-size-adjust: 100%;
            }
        
            /* Remove spacing between tables in Outlook 2007 and up */
            table, td {
              mso-table-lspace: 0pt;
              mso-table-rspace: 0pt;
            }
        
            /* Allow smoother rendering of resized image in Internet Explorer */
            img {
              -ms-interpolation-mode: bicubic;
            }
        
             /* ----- Reset ----- */
        
            html,
            body,
            .body-wrap,
            .body-wrap-cell {
              margin: 0;
              padding: 0;
              background: #ffffff;
              font-family: Arial, Helvetica, sans-serif;
              font-size: 14px;
              color: #464646;
              text-align: left;
            }
        
            img {
              border: 0;
              line-height: 100%;
              outline: none;
              text-decoration: none;
            }
        
            table {
              border-collapse: collapse !important;
            }
        
            td, th {
              text-align: left;
              font-family: Arial, Helvetica, sans-serif;
              font-size: 14px;
              color: #464646;
              line-height:1.5em;
            }
        
            b a,
            .footer a {
              text-decoration: none;
              color: #464646;
            }
        
            a.blue-link {
              color: blue;
              text-decoration: underline;
            }
        
            /* ----- General ----- */
        
            td.center {
              text-align: center;
            }
        
            .left {
              text-align: left;
            }
        
            .body-padding {
              padding: 24px 40px 40px;
            }
        
            .border-bottom {
              border-bottom: 1px solid #D8D8D8;
            }
        
            table.full-width-gmail-android {
              width: 100% !important;
            }
        
        
            /* ----- Header ----- */
            .header {
              font-weight: bold;
              font-size: 16px;
              line-height: 16px;
              height: 16px;
              padding-top: 19px;
              padding-bottom: 7px;
            }
        
            .header a {
              color: #464646;
              text-decoration: none;
            }
        
            /* ----- Footer ----- */
        
            .footer a {
              font-size: 12px;
            }
          </style>
        
          <style type="text/css" media="only screen and (max-width: 650px)">
            @media only screen and (max-width: 650px) {
              * {
                font-size: 16px !important;
              }
        
              table[class*="w320"] {
                width: 320px !important;
              }
        
              td[class="mobile-center"],
              div[class="mobile-center"] {
                text-align: center !important;
              }
        
              td[class*="body-padding"] {
                padding: 20px !important;
              }
        
              td[class="mobile"] {
                text-align: right;
                vertical-align: top;
              }
            }
          </style>
        
        </head>
        <body style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
         <td valign="top" align="left" width="100%" style="background:repeat-x url(https://www.filepicker.io/api/file/al80sTOMSEi5bKdmCgp2) #f9f8f8;">
         <center>
        
           <table class="w320 full-width-gmail-android" bgcolor="#f9f8f8" background="https://www.filepicker.io/api/file/al80sTOMSEi5bKdmCgp2" style="background-color:transparent" cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td width="100%" height="48" valign="top">
                    <!--[if gte mso 9]>
                    <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:49px;">
                      <v:fill type="tile" src="https://www.filepicker.io/api/file/al80sTOMSEi5bKdmCgp2" color="#ffffff" />
                      <v:textbox inset="0,0,0,0">
                    <![endif]-->
                      <table class="full-width-gmail-android" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                          <td class="header center" width="100%">
                            <a href="https://emailsiswa.layanan.go.id/">
                              Email Siswa Nasional
                            </a>
                          </td>
                        </tr>
                      </table>
                    <!--[if gte mso 9]>
                      </v:textbox>
                    </v:rect>
                    <![endif]-->
                </td>
              </tr>
            </table>
        
            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff">
              <tr>
                <td align="center">
                  <center>
                    <table class="w320" cellspacing="0" cellpadding="0" width="500">
                      <tr>
                        <td class="body-padding mobile-padding">
        
                        <table cellpadding="0" cellspacing="0" width="100%">
                          <tr>
                            <td style="text-align:center; font-size:30px; padding-bottom:20px;">
                            Selamat akun email anda sudah berhasil dibuat!
                            </td>
                          </tr>
                          <tr>
                            <td style="padding-bottom:20px;">
                              Data email siswa anda sebagai berikut : <br>
                              <br>
                              <b><p>Email Pengguna : ' . $this->input->post('email') . '</p></b>
                              <b><p>Kata Sandi : ' . $this->input->post('npsn') . '</p></b>
                              <br>
                              Harap simpan baik-baik nama dan password akun email anda. Penggunaan akun email diluar ketentuan yang sudah ditetapkan bukan tanggung jawab Tim Pengelola Email Siswa Nasional.
                            </td>
                          </tr>
                        </table>
        
                        <table cellspacing="0" cellpadding="0" width="100%">
                          <tr>
                            <td class="left" style="text-align:left;">
                              Regards,
                              <br>
                            </td>
                          </tr>
                          <tr>
                            <td class="left" width="129" height="20" style="text-align:left;">
                            <br>
                             Tim Pengelola Email Nasional
                            </td>
                          </tr>
                        </table>
        
                        </td>
                      </tr>
                    </table>
                  </center>
                </td>
              </tr>
            </table>
        
            <table class="w320" bgcolor="#E5E5E5" cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td style="border-top:1px solid #B3B3B3; border-bottom:1px solid #B3B3B3;" align="center">
                  <center>
                    <table class="w320" cellspacing="0" cellpadding="0" width="500" bgcolor="#E5E5E5">
                      <tr>
                        <td align="center" style="padding:25px; text-align:center">
                          <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#E5E5E5">
                            <tr>
                              <td class="center footer" style="font-size:12px;">
                                <a href="#">Contact Us</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <span class="footer-group">
                                  <a href="#">Support</a>
                                </span>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </center>
                </td>
              </tr>
            </table>
        
          </center>
          </td>
        </tr>
        </table>
        </body>
        </html>';
        $mail->Body = $message;

        $email = $this->M_sekolah->cek_siswa_exist($this->input->post('nisn'))->num_rows();
    
        // Send email
        if ($email) {
			$result = $mail->send();
			$result = array('success' => true);
	   } else {
		   $result = array('success' => false);
		}
		echo json_encode($result);
     }
}
