<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_siswa extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('admin/M_user','',TRUE);
	}
	
	function index()
	{	   
		if($this->M_user->is_logged_in()){
			redirect('beranda');
		} else {
			$this->form_validation->set_rules('username', 'Username', 'callback_login_check');
    	    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == FALSE){
				$data['username']=$this->input->post('username');
				$this->load->view('login_siswa',$data);
			}else
				redirect('beranda');
		}
		
	}

	function login_check($username)
	{
		$password = $this->input->post("password");	

		$user = $this->M_user->get_user($username)->result();
		if(count($user)==0){
			$this->form_validation->set_message('login_check', '<p class="px-2" style="color:red;">Username/Password salah!</p>');
			return false;
		}else{
			foreach ($user as $row) {
				$hashed = $row->password;
				$userid = $row->userid;
			}
			
			if($this->phpass->check($password, $hashed)) {
				$this->session->set_userdata('userid', $userid);
				return true;
			}else{
				$this->form_validation->set_message('login_check', '<p class="px-2" style="color:red;">Username/Password salah!</p>');
				return false;
			}
		}
	}

	function ajax_check() {
		if($this->M_user->is_logged_in()) {
			echo json_encode(1);
		} else {
			echo json_encode(0);
		}
	}

	public function login_siswa_check(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		// $email = "bugy@siswa.id";
		// $password = "123123";
		if($email!="" && $password!=""){
			$ch = curl_init();

	        // curl_setopt($ch, CURLOPT_URL,"http://10.10.22.41/zimbra-api/index.php/api/ceklogin");
	        // curl_setopt($ch, CURLOPT_URL,"http://10.10.22.41/zimbra-api/index.php/api/ceklogin");
	        curl_setopt($ch, CURLOPT_URL,"http://10.10.22.41/zimbra-api/index.php/api/ceklogin");
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, "emailaccount=".$email."&password=".$password);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( array("emailaccount" => $email, "password" => $password) ));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


	  //       curl_setopt($ch, CURLOPT_URL,"http://10.10.22.41/zimbra-api/index.php/api/ceklogin");
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
			// curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
			// curl_setopt($ch, CURLINFO_HEADER_OUT, 1); 
			// curl_setopt($ch, CURLOPT_POST, 1);
			// curl_setopt($ch, CURLOPT_POSTREDIR, 2);
			// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
			// curl_setopt($ch, CURLOPT_POSTFIELDS, array("emailaccount" => $email, "password" => $password));
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));

	        $result = curl_exec($ch);
	        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	        $response = ($httpCode == 200) ? true : false ;

	        curl_close ($ch); 
	        if($response) {
	        	$hasil = json_decode($result);
	        	if($hasil->success){
	            	$result = array('success' => true, 'preauthURL' => $hasil->data->preauthURL);
	            	// header("Location: ".$hasil->data->preauthURL);
	        	}else{
	            	$result = array('success' => false, 'msg' => 'Email/Password Salah!', 'hasil' => $hasil);
	        	}
	        }else{
	            $result = array('success' => false, 'msg' => 'Error API!', 'httpCode'=>$httpCode, 'result'=>json_decode($result));
	        }
		}else{
	        $result = array('success' => false, 'msg' => 'Email&Pass Kosong!');
		}
	    echo json_encode($result);
	}
}

?>