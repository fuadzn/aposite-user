<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once("Secure_area.php");
class Nisn extends Secure_area
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
        $data = array(
            'title' => 'Data Siswa',
            'roleLogin' => $this->load->get_var("user_info")->roleid
        );
        $this->load->view('nisn/index', $data);
    }

    // public function check_nisn() 
    // {		
    // 	$nisn = $this->input->post('nisn');		
    // 	$result = $this->M_sekolah->get_nisn($nisn);
    // 	if ($result) {
    // 		echo $result;
    // 	} else {
    // 		$result_error = array(
    //     		'metaData' => array('code' => '503','message' => 'Gagal Koneksi.'),
    //     		'response' => ['peserta' => null]
    //   		);
    // 		echo json_encode($result_error);
    // 	}
    // }

    public function show_data_siswa()
    {
        $roleid = $this->load->get_var("user_info")->roleid;
        if ($roleid == 9) {
            $line  = array();
            $line2 = array();
            $row2  = array();
            $id_sekolah = $this->load->get_var("user_info")->id_sekolah;
            $hasil = $this->M_sekolah->get_siswa2($id_sekolah)->result();
            $i = 1;
            foreach ($hasil as $value) {
                $row2['no'] = $i++;
                $row2['nisn'] = $value->nisn;
                $row2['npsn'] = $value->npsn;
                $row2['nm_sekolah'] = $value->nm_sekolah;
                $row2['kelas'] = $value->kelas;
                $row2['nama'] = $value->nama;
                // $row2['email'] = $value->email;
                // $row2['email_alter'] = $value->email_alter;
                $row2['aksi'] = '<td>
                <button type="button" class="btn btn-success btn-sm col-sm-10 mt-1" data-toggle="modal" data-target="#editModal" onclick="edit_siswa('. $value->id .')">Ubah</button>
                <button type="button" class="btn btn-danger btn-sm col-sm-10 mt-1" onclick="hapus_siswa('. $value->id .')">Hapus</button>
                <button type="button" class="btn btn-warning btn-sm col-sm-10 mt-1" id="reset_pass_' . $value->nisn . '" onclick="changePassword(\'' . $value->id . '\', \'' . $value->nisn . '\', \'' . $value->email . '\')"><i class="fa fa-lock"></i> Reset Password</button>
                </td>';

                $line2[] = $row2;
            }
            $line['data'] = $line2;

            echo json_encode($line);
        } else {
            $line  = array();
            $line2 = array();
            $row2  = array();
            $hasil = $this->M_sekolah->get_siswa()->result();
            $i = 1;
            foreach ($hasil as $value) {
                $row2['no'] = $i++;
                $row2['nisn'] = $value->nisn;
                $row2['npsn'] = $value->npsn;
                $row2['nm_sekolah'] = $value->nm_sekolah;
                $row2['kelas'] = $value->kelas;
                $row2['nama'] = $value->nama;
                $row2['aksi'] = '
                <td>
                <button type="button" class="btn btn-success btn-sm col-sm-10 mt-1" data-toggle="modal" data-target="#editModal" onclick="edit_siswa('. $value->id .')">Ubah</button>
                <button type="button" class="btn btn-danger btn-sm col-sm-10 mt-1" onclick="hapus_siswa('. $value->id .')">Hapus</button>
                </td>';
                // $row2['email'] = $value->email;
                // $row2['email_alter'] = $value->email_alter;

                $line2[] = $row2;
            }
            $line['data'] = $line2;

            echo json_encode($line);
        }
    }

    function cek_nuptk()
    {
        $data = array(
            'nuptk' => $this->input->post('nuptk'),
        );

        $cek = $this->M_sekolah->get_nuptk($data['nuptk'])->num_rows();
        if ($cek > 0) {
            $result = array('success' => false, 'msg' => 'Nama Paket Sudah Terdaftar');
        } else {
            $result = array('success' => true, 'msg' => 'Nama Paket Terdaftar');
        }

        echo json_encode($result);
    }

    function changePass()
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://10.10.22.41/zimbra-api/index.php/api/emailexist");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "emailaccount=" . $this->input->post('email'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $hasil = curl_exec($ch);
        // $hasil = json_encode($hasil);
        $hasil = json_decode($hasil);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response = ($httpCode == 200) ? true : false;

        curl_close($ch);
        if (!$response) {
            $result = array('success' => false, 'msg' => 'Email Tidak Ditemukan!');
        } else {
            // $result = json_encode(array('success' => false, 'msg' => 'Data Email Tidak Ditemukan'));
            $data_siswa = $this->M_sekolah->cek_email($this->input->post('email'))->row();
            $ch2 = curl_init();

            curl_setopt($ch2, CURLOPT_URL, "http://10.10.22.41/zimbra-api/index.php/api/setpassword");
            curl_setopt($ch2, CURLOPT_POST, 1);
            curl_setopt($ch2, CURLOPT_POSTFIELDS, "id=" . $hasil->data->id . "&password=" . $data_siswa->npsn);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

            $hasil2 = curl_exec($ch2);
            $httpCode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
            $response = ($httpCode == 200) ? true : false;

            curl_close($ch2);
            if ($response) {
                $data1 = array(
                    'keterangan' => 'Reset password siswa',
                    'ket_waktu' => date('Y-m-d h:i:s'),
                    'userid' => $this->load->get_var('user_info')->userid
                );
                $this->M_sekolah->log_activity($data1);
                $result = array('success' => true, 'msg' => 'Password berhasil direset!');
            } else {
                $result = array('success' => false, 'msg' => ' Terjadi Masalah pada Server Email!');
            }
        }


        echo json_encode($result);
    }

    function get_data_email()
    {
        $id = $this->input->post('id');
        $datajson = $this->M_sekolah->get_email($id)->result();
        echo json_encode($datajson);
    }

    public function send_mail() {
        $id = $this->input->post('id');
        $datajson = $this->M_sekolah->get_email($id)->result();

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
        foreach($datajson as $row){
        $mail->addAddress($row->email_alter);
        // Email subject
        $mail->Subject = "Permintaan Reset Password";
        $message = "Password telah diganti menjadi :  $row->npsn";
        $mail->Body = $message;
        }   
    
        // Send email
        return $mail->send();
    }

    function edit_siswa(){
        $id = $this->input->post('id');
        $datajson = $this->M_sekolah->get_id_siswa($id)->result();
        echo json_encode($datajson);
    }

    function update_siswa(){
        $where = array( 'nisn' => $this->input->post('edit_nisn') );
        // print_r($where);
        // die();
        $data = array(
                'nisn' => $this->input->post('edit_nisn'),
                'npsn' => $this->input->post('edit_npsn'),
                'nm_sekolah' => $this->input->post('edit_sekolah'),
                'kelas' => $this->input->post('edit_kelas'),
                'nama' => $this->input->post('edit_nama'),
                    );
        $data1 = array(
            'keterangan' => 'edit siswa',
            'ket_waktu' => date('Y-m-d h:i:s'),
            'userid' => $this->load->get_var('user_info')->userid
            );

        $this->M_sekolah->update_table('siswa', $data, $where);
        $this->M_sekolah->log_activity($data1);

        $msg = '<div class="alert alert-success alert-dismissible"> <i class="ti-user"></i> Data Berhasil Diubah!
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>';
        $this->session->set_flashdata('success_msg', $msg);
        redirect('nisn');
    }

    function hapus_siswa(){
        $where = array( 'id' => $this->input->post('id') );
        $data = array(
            'keterangan' => 'hapus data siswa',
            'ket_waktu' => date('Y-m-d h:i:s'),
            'userid' => $this->load->get_var('user_info')->userid
            );

        $save = $this->M_sekolah->delete_table('siswa', $where);
        $save = $this->M_sekolah->log_activity($data);

        if($save >= 1){
            $data = array('status' => 'success');
        }else{
            $data = array('status' => 'failed');
        }

        echo json_encode($data);
    }

}
