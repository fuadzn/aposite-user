<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 class Lupa_password extends CI_Controller {  
   
    public function __construct() {
    parent::__construct();
    require APPPATH.'libraries/PHPMailer/src/Exception.php';
    require APPPATH.'libraries/PHPMailer/src/PHPMailer.php';
    require APPPATH.'libraries/PHPMailer/src/SMTP.php';
		$this->load->model('admin/M_account','',TRUE);
    $this->load->model('admin/M_sekolah','',TRUE);
    $this->load->library('session');
	}
   
     public function index()  
     {  
         
         $this->form_validation->set_rules('email', 'Email', 'required|valid_email');   
         
         if($this->form_validation->run() == FALSE) {  
             $data['title'] = 'Halaman Reset Password';  
             $this->load->view('daftar/lupa_password',$data);  
         }else{  
             $email = $this->input->post('email');   
             $clean = $this->security->xss_clean($email);  
             $userInfo = $this->m_account->getUserInfoByEmail($clean);  
               
             if(!$userInfo){  
               $this->session->set_flashdata('sukses', 'email address salah, silakan coba lagi.');  
               redirect(site_url('login'),'refresh');   
             }    
               
             //build token   
                       
            //  $token = $this->M_account->insertToken($userInfo->id_user);              
            //  $qstring = $this->base64url_encode($token);           
            //  $url = site_url() . '/lupa_password/reset_password/token/' . $qstring;  
            //  $link = '<a href="' . $url . '">' . $url . '</a>';   
               
            //  $message = '';             
            //  $message .= '<strong>Hai, anda menerima email ini karena ada permintaan untuk memperbaharui  
            //      password anda.</strong><br>';  
            //  $message .= '<strong>Silakan klik link ini:</strong> ' . $link;         
   
            //  echo $message;
            //  exit;  
           
         }  
         
     } 
     
     public function cek_data()
     {
        $data = array(
			'nisn' => $this->input->post('nisn'),
			'email_alter' => $this->input->post('emailal')
        );
        
        $cek = $this->M_account->cek_siswa($data['nisn'])->num_rows();
        $cekk = $this->M_account->cek_emailal($data['nisn'], $data['email_alter'])->num_rows();
        if ($cek == 0) {
			$result = array('success' => false, 'msg' => 'NISN Belum Terdaftar!');
		} else if ($cekk > 0) {
			$result = array('success' => true);
            $data = $this->M_account->cek_emailal($data['nisn'], $data['email_alter'])->row();

		} else {
			$result = array('success' => false, 'msg' => 'Email Alternatif Tidak Cocok!');
		}

		echo json_encode($result);
     }
   

   public function email()
   {
    $this->load->helper('string');
    $email = $this->input->post('emailal');
    $get_email = $this->M_account->cek_emailal($this->input->post('nisn'), $this->input->post('emailal'))->result();
    $reset_key =  random_string('alnum', 50);
    $update = date("Y-m-d H:i:s");
    foreach($get_email as $row){
    // $message = '<p>Kepada pemilik akun siswa '. $row->email .' saat ini anda mengajukan permohonan lupa password.klik link dibawah ini utk merubah password anda.</p>';
    // $message .= "<a href='".site_url('lupa_password/reset_password/'.$reset_key)."'>ganti password</a>";
    // $message .= "<p>Harap berhati-hati dalam membuat password baru anda.kami sarankan untuk tidak menggunakan tanggal lahir,nomor telepon yang bisa diketahui orang lain.Segala bentuk penyalahgunaan password bukan tanggung jawab Tim Pengelola Email Siswa.</p>";
    // $message .= "<p>Regards</p><br>";
    // $message .= "Tim Pengelola Email Siswa";

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
                          Permintaan Pergantian Password!
                        </td>
                      </tr>
                      <tr>
                          <td class="mobile-center" align="left" style="padding-bottom:20px; padding:40px 0;">
                          Kepada pemilik akun siswa '. $row->email .' saat ini anda mengajukan permohonan lupa password.klik tombol dibawah ini untuk merubah password anda. Link akan kedaluarsa dalam beberapa menit!
                          <br>
                          <div class="mobile-center" align="center"><!--[if mso]>
                          <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="#" style="height:38px;v-text-anchor:middle;width:190px;" arcsize="11%" strokecolor="#407429" fill="t">
                          <v:fill type="tile" src="https://www.filepicker.io/api/file/N8GiNGsmT6mK6ORk00S7" color="#41CC00" />
                          <w:anchorlock/>
                          <center style="color:#ffffff;font-family:sans-serif;font-size:17px;font-weight:bold;">Ubah Password</center>
                          </v:roundrect>
                        <![endif]--><a href="'.site_url('lupa_password/reset_password/'.$reset_key).'"
                        style="background-color:#41CC00;background-image:url(https://www.filepicker.io/api/file/N8GiNGsmT6mK6ORk00S7);border:1px solid #407429;border-radius:4px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:17px;font-weight:bold;text-shadow: -1px -1px #47A54B;line-height:37px;text-align:center;text-decoration:none;width:190px;-webkit-text-size-adjust:none;mso-hide:all;">Ubah Password</a></div>
                          <br>
                          Harap berhati-hati dalam membuat password baru anda.kami sarankan untuk tidak menggunakan tanggal lahir,nomor telepon yang bisa diketahui orang lain.Segala bentuk penyalahgunaan password bukan tanggung jawab Tim Pengelola Email Siswa.
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
    }
    if($this->M_account->update_reset_key($email,$reset_key,$update))
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

         $mail->setFrom("adminemail@intens.co.id", "Email Siswa");
         $mail->addAddress($this->input->post('emailal'));
         // Email subject
         $mail->Subject = "Permintaan Ganti Password";
         $mail->Body = $message;
         
         // Send email
         return $mail->send();

  }else {
      die("Email belum terdaftar!");
    }
  
    }

    
      public function reset_password(){
        $reset_key = $this->uri->segment(3);
        
        if(!$reset_key){
          die('Jangan Dihapus');
        }

        
        if($this->M_account->check_reset_key($reset_key) == 1)
        {
          $time = $this->M_account->get_time_reset($reset_key)->result();
          //add 1 hour to time
          foreach($time as $row){
            $update = $row->xupdate_reset;
          }
          $expired = date("Y-m-d H:i:s",strtotime('1 day',strtotime($update)));

          if(time() <= strtotime($expired)){
            $data['email'] = $this->M_account->cek_email($reset_key)->result();
            $this->load->view('daftar/reset_password_siswa', $data);
          } else{
            die("<h1 style='color: red;'><center>LINK KADALUARSA</h1>");
          }
        } else{
          die("<h1 style='color: red;'><center>LINK KADALUARSA</h1>");
        }
      
      }
      
      public function reset_password_validation(){
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[retype_password]');
        $this->form_validation->set_rules('retype_password', 'Retype Password', 'required|min_length[6]|matches[password]');
        $reset_key = $this->input->post('reset_key');
        $password = $this->input->post('password');

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://10.10.22.41/zimbra-api/index.php/api/emailexist");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "emailaccount=" . $this->input->post('email'));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $hasil = curl_exec($ch);
            // $hasil = json_encode($hasil);
            $hasil = json_decode($hasil);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $response = ($httpCode == 200) ? true : false;
            curl_close($ch);

            $ch2 = curl_init();

            curl_setopt($ch2, CURLOPT_URL, "http://10.10.22.41/zimbra-api/index.php/api/setpassword");
            curl_setopt($ch2, CURLOPT_POST, 1);
            curl_setopt($ch2, CURLOPT_POSTFIELDS, "id=" . $hasil->data->id . "&password=" . $this->input->post('password'));

            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

            $hasil2 = curl_exec($ch2);
            $httpCode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
            $response = ($httpCode == 200) ? true : false;

            curl_close($ch2);
            if ($response) {
              if ($this->form_validation->run()) {
                $data1 = array(
                    'keterangan' => 'Ubah password siswa',
                    'ket_waktu' => date('Y-m-d h:i:s'),
                    // 'userid' => $this->load->get_var('user_info')->userid
                  );
                  $this->M_sekolah->log_activity($data1);
                  $result = array('success' => true, 'msg' => 'Password berhasil direset!');
              }
            } else {
                $result = array('success' => false, 'msg' => ' Terjadi Masalah pada Server Email!');
            }
        echo json_encode($result);

        //  if($this->form_validation->run() && $this->M_account->reset_password($reset_key, $password))
        // {   
        //   $result = array('success' => true);
        // } else{
        //   $result = array('success' => false, 'msg' => 'Error!');
        // }
        // echo json_encode($result);
      }
 }  