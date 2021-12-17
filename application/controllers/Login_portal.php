<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once("Secure_area.php");
class Login_portal extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_obat','',TRUE);
	
	}

	function index()
	{
		$data['obat'] = $this->M_obat->get_obat()->result();
		$this->load->view('loginn', $data);
	}

	public function get_obat()
    {
        $json = [];

        $this->load->database();


        if (!empty($this->input->get("q"))) {
            // $this->db->like('nama', $this->input->get("q"));
            // $query = $this->db->select('id,id_kecamatan,nama')
            // 			->limit(10)
            // 			->get("kelurahandesa");
            // $this->db->like('nama_region', $title, 'both');
            // $this->db->order_by('nama_region', 'ASC');
            // $this->db->limit(10);
            // return $this->db->get('master_region')->result();
            $query = $this->db
                ->like('nama_obat', $this->input->get("q"))
                ->order_by('nama_obat', 'ASC')
                ->select('*')->limit(50, 0)->get('obat');
            $json = $query->result();
        }


        echo json_encode($json);
    }

	function beli_obat()
    {
		$data = array(
            'nama_pembeli' => $this->input->post('nama_pembeli'),
            'kd_obat' => $this->input->post('nama_obat'),
            'email' => $this->input->post('email'),
            'tgl_pemesanan' => date('Y-m-d'),
            'tgl_pengambilan' => $this->input->post('tgl_peng')
        );
		$result = array('success' => true);
        $result = $this->M_obat->insert_pembeli($data);
		echo json_encode($result);
        
    }
    // public function send_mail() {
    //     $this->load->library('phpmailer_lib');
       
    //     /* PHPMailer object */
    //     $mail = $this->phpmailer_lib->load();
       
    //     /* SMTP configuration */
    //     $mail->isSMTP();
    //     $mail->Host     = 'smtp.gmail.com';
    //     $mail->SMTPAuth = true;
    //     $mail->Username = 'zfnn122@gmail.com';
    //     $mail->Password = 'Gatau1234';
    //     $mail->SMTPSecure = 'ssl';
    //     $mail->Port     = 465;
       
    //     $mail->setFrom('zfnn122@gmail.com', 'CodexWorld');
    //     $mail->addReplyTo('zfnn122@gmail.com', 'CodexWorld');
       
    //     /* Add a recipient */
    //     $mail->addAddress('fuadzn08@gmail.com');
       
       
    //     /* Email subject */
    //     $mail->Subject = 'Send Email via SMTP using PHPMailer in CodeIgniter';
       
    //     /* Set email format to HTML */
    //     $mail->isHTML(true);
       
    //     /* Email body content */
    //     $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
    //     <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
    //     $mail->Body = $mailContent;
       
    //     /* Send email */
    //     if(!$mail->send()){
    //         echo 'Mail could not be sent.';
    //         echo 'Mailer Error: ' . $mail->ErrorInfo;
    //     }else{
    //         echo 'Mail has been sent';
    //     }
    // }
}
