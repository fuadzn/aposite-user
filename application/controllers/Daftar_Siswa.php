<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Daftar_Siswa extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        require APPPATH.'libraries/PHPMailer/src/Exception.php';
        require APPPATH.'libraries/PHPMailer/src/PHPMailer.php';
        require APPPATH.'libraries/PHPMailer/src/SMTP.php';
		$this->load->model('admin/M_sekolah','',TRUE);
	}

    public function index(){
        $data = array(
            'title' => 'Daftar Email Siswa'
        );
        $this->load->view('daftar/daftar_siswa', $data);
    }

    public function insert_email() {
        $data['title'] = "Form Email";
        
        $data['nisn'] = $this->input->post('nisn');
        $data['tgl_lahir'] = $this->input->post('tgl_lahir');
        $data['nama'] = $this->input->post('nama');
        $data['sekolah'] = $this->input->post('sekolah');

        $this->load->view('login_portal/', $data);

    }

    public function show_data_email(){
        $line  = array();
        $line2 = array();
        $row2  = array();
        $hasil = $this->M_sekolah->get_siswa()->result();
        $i=1;
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
            $nisn=substr($data->nisn,9,15);
            $result['nisn_email'] = $nisn;
            $cek_nama = $data->nama;
            $get_nama = explode(" ", $cek_nama);
            $nama_pertama = $get_nama[0];
            $result['namapertama'] = $nama_pertama;
			$result['id_region'] = $data->id_region;
			$result['nisn'] = $data->nisn;
			$result['npsn'] = $data->npsn;
			$result['alamat'] = $data->alamat;
			$result['tgl_lahir'] = $data->tgl_lahir;
			$result['id_sekolah'] = $data->id_sekolah;
			$result['sex'] = $data->sex;
		} else {
			$result = array('success' => false, 'msg' => 'NPSN Tidak Cocok');
		}

		echo json_encode($result);
	}
    
    function insert_siswa()
	{ 
        $data = array(
            'nisn' => $this->input->post('nisn'),
            'nik' => $this->input->post('nik'),
            'npsn' => $this->input->post('npsn'),
            'nm_sekolah' => $this->input->post('sekolah'),
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'email_alter' => $this->input->post('emailal'),
            'id_region' => $this->input->post('id_region'),
            'alamat' => $this->input->post('alamat'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'no_hp' => $this->input->post('no_hp'),
            'id_sekolah' => $this->input->post('id_sekolah'),
            'xcreate_user' => $this->load->get_var("user_info")->username,
            'xcreate_date' => date('Y-m-d h:i:s')
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://10.10.22.41/zimbra-api/index.php/api/emailexist");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "emailaccount=".$this->input->post('email'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response = ($httpCode == 200) ? true : false ;

        curl_close ($ch); 
        if($response) {
            $result = array('success' => false, 'msg' => 'Email Sudah Terdaftar!');
        }else{
            // $result = json_encode(array('success' => false, 'msg' => 'Data Email Tidak Ditemukan'));

            $ch2 = curl_init();

            curl_setopt($ch2, CURLOPT_URL,"http://10.10.22.41/zimbra-api/index.php/api/createaccount");
            curl_setopt($ch2, CURLOPT_POST, 1);
            curl_setopt($ch2, CURLOPT_POSTFIELDS, 
                "emailaddress=".$this->input->post('email')."&sn=".$this->input->post('nama')."&password=".$this->input->post('npsn'));

            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch2);
            $httpCode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
            $response = ($httpCode == 200) ? true : false ;

            curl_close ($ch2); 
            if($response) {
                $result = $this->M_sekolah->insert_siswa($data);
                $data1 = array(
                    'keterangan' => 'create email siswa',
                    'ket_waktu' => date('Y-m-d h:i:s'),
                    'userid' => $this->load->get_var('user_info')->userid
                );
                $this->M_sekolah->log_activity($data1);
                $result = array('success' => true, 'msg' => 'Email Berhasil Didaftarkan!');
            }else{
                $result = array('success' => false, 'msg' => 'Terjadi Masalah pada Server Email!');
            }
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

         $mail->setFrom("adminemail@intens.co.id", "Email Siswa");
         $mail->addAddress($this->input->post('emailal'));
         // Email subject
         $mail->Subject = "Data Akun Email Siswa";
         $mail->Body = 'Email Pengguna : ' . $this->input->post('nisnn') . '<br>Kata Sandi : ' . $this->input->post('npsn');
         
         // Send email
         return $mail->send();
     }      

}