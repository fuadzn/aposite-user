<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once ("Secure_area.php");
class Sekolah extends Secure_area {
    public function __construct() {
		parent::__construct();
		require APPPATH.'libraries/PHPMailer/src/Exception.php';
    require APPPATH.'libraries/PHPMailer/src/PHPMailer.php';
    require APPPATH.'libraries/PHPMailer/src/SMTP.php';
		$this->load->model('admin/M_sekolah','',TRUE);
	}

    public function index(){
        $data = array(
            'title' => 'Daftar Operator Sekolah'
        );
        $this->load->view('sekolah/formsekolah', $data);
    }

    function get_autocomplete(){
        // if (isset($_GET['term'])) {
        //     $result = $this->M_sekolah->search_blog($_GET['term']);
        //     if (count($result) > 0) {
        //     foreach ($result as $row)
        //         $arr_result[] = $row->nm_sekolah;
        //         echo json_encode($arr_result);
        //     }
        // }
        $keyword = $this->input->get("query");
        $data = $this->M_sekolah->search_blog($keyword);   

        $arr = [];
		$arr['suggestions']=[];
        foreach($data as $row)
        {
            $arr['query'] = $keyword;
            $arr['suggestions'][] = array(
                'value' =>$row->id_sekolah. '. ' .$row->nm_sekolah
            );
        }
        // minimal PHP 5.2
        echo json_encode($arr);
    }

    function cek_data_sekolah()
	{
		$get_sekolah = explode('.', $this->input->post('sekolah'));
		$data = array(
			'nik' => $this->input->post('nik'),
			'npsn' => $this->input->post('npsn'),
			'sekolah' => $get_sekolah[0]
		);

		$cek = $this->M_sekolah->get_nik($data['nik'])->num_rows();
		$cekk = $this->M_sekolah->cek_sekolah($data['npsn'])->num_rows();
		$cek_nik = $this->M_sekolah->cek_nikk($data['nik'])->num_rows();
		$cek_nik2 = $this->M_sekolah->cek_niknpsn($data['nik'], $data['npsn'])->num_rows();
		if ($cek > 0) {
			$result = array('success' => false, 'msg' => 'NIK sudah terdaftar');
		} else if ($cek_nik == 0) {
			$result = array('success' => false, 'msg' => 'NIK tidak ada');
		} else if ($cekk >= 3) {
			$result = array('success' => false, 'msg' => 'Sekolah sudah melebih batas kuota');
		}
		 else if ($this->input->post('nik') == null) {
			$result = array('success' => false, 'msg' => 'Harap semua data diisi!');
		}
		 else if ($cek_nik2 > 0) {
			$result = array('success' => true);
			$data = $this->M_sekolah->cek_niknpsn($data['nik'], $data['npsn'])->row();
			// $data = $this->M_sekolah->cek_sekolah2($data['sekolah'])->row();
			$result['nama'] = $data->nama;
			// $result['npsn'] = $data->npsn;
			$result['nuptk'] = $data->nuptk;
			$result['tgl_lahir'] = $data->tgl_lahir;
			$result['nm_sekolah'] = $data->nm_sekolah;
			$result['id_sekolah'] = $data->id_sekolah;
			$result['id_provinsi'] = $data->id_provinsi;
			$result['id_region'] = $data->id_region;
		}
		 else{
			$result = array('success' => false, 'msg' => 'NIK tidak sesuai NPSN');
		}

		echo json_encode($result);
    }
    
    function insert_sekolah()
	{
		$data = array(
			'nuptk' => $this->input->post('nuptk'),
			'nik' => $this->input->post('nik'),
			'sekolah' => $this->input->post('sekolah'),
			'npsn' => $this->input->post('npsn'),
			'tgl_lahir' => $this->input->post('tgl_lahir'),
			'nama' => $this->input->post('nama2'),
			'email' => $this->input->post('email2'),
			'no_hp' => $this->input->post('no_hp'),
			'id_sekolah' => $this->input->post('id_sekolah'),
			'id_region' => $this->input->post('id_region'),
			'id_provinsi' => $this->input->post('id_provinsi'),
			'password' => $this->input->post('passs'),
			'statuss' => '1'
		);
		$data1 = array(
			'name' => $this->input->post('nama2'),
			'username' => $this->input->post('nuptk'),
			'password' => password_hash($this->input->post('passs'), PASSWORD_BCRYPT),
			'roleid' => '9',
			'id_sekolah' => $this->input->post('id_sekolah'),
			'xcreate_date' => date('Y-m-d h:i:s'),
			'xcreate_user' => $this->load->get_var("user_info")->username
		);
		$data2 = array(
            'keterangan' => 'create email sekolah',
            'ket_waktu' => date('Y-m-d h:i:s'),
            'userid' => $this->load->get_var('user_info')->userid
      );
    $email = $this->M_sekolah->cek_emailal($this->input->post('email2'))->num_rows();
		if ($this->input->post('nama2') == null) {
			$result = array('success' => false, 'msg' => 'Harap semua data diisi');
		} else if ($this->input->post('email2') == null) {
			$result = array('success' => false, 'msg' => 'Harap Isi Email');
		} else if ($this->input->post('no_hp') == null) {
			$result = array('success' => false, 'msg' => 'Harap Isi No Hp');
		} else if ($this->input->post('passs') == null) {
			$result = array('success' => false, 'msg' => 'Harap Isi Password');
		} else if ($email) {
			$result = array('success' => false, 'msg' => 'Email Sudah Terdaftar');
		} else {
			$result = $this->M_sekolah->insert_dyn_user($data1);
			$result = $this->M_sekolah->insert_sekolah($data);
			$result = $this->M_sekolah->log_activity($data2);
			$result = array('success' => true, 'nuptk' => $data['nuptk'], 'password' => $data['password'], 'email' => $data['email']);
		}
		echo json_encode($result);
	}

	public function email()
    {    
         // SMTP configuration
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host     = 'mail.intens.co.id';
         $mail->Port     = 465;
         $mail->SMTPAuth = true;
         $mail->Username = "adminemail@intens.co.id";
         $mail->Password = "adminemail1234";
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      
         $mail->isHTML(true);

         $mail->setFrom("adminemail@intens.co.id", "Admin Sekolah");
         $mail->addAddress($this->input->post('email2'));
         // Email subject
         $mail->Subject = "Pendaftaran Akun Operator Sekolah";
		$message = '
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
                            Selamat akun anda sudah berhasil dibuat!
                            </td>
                          </tr>
                          <tr>
                            <td style="padding-bottom:20px;">
                              Data akun anda sebagai berikut : <br>
                              <br>
                              <b><p>NUPTK : ' . $this->input->post('nuptk') . '</p></b>
                              <b><p>Kata Sandi : ' . $this->input->post('passs') . '</p></b>
                              <br>
                              Harap simpan baik-baik nuptk dan password akun anda. Penggunaan akun diluar ketentuan yang sudah ditetapkan bukan tanggung jawab Tim Pengelola Email Siswa Nasional.
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
		 // Send email
		 $cek = $this->M_sekolah->get_nik($this->input->post('nik'))->num_rows();
         if ($cek) {
			$result = $mail->send();
			$result = array('success' => true);
	   } else {
		   $result = array('success' => false);
		}
		echo json_encode($result);
     }          

}