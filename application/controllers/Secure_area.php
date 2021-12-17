<?php
class Secure_area extends CI_Controller 
{
	/*
	Controllers that are considered secure extend Secure_area, optionally a $module_id can
	be set to also check if a user can access a particular module in the system.
	*/
	function __construct($module_id=null)
	{
		parent::__construct();	
		$this->load->model('admin/M_user','',TRUE);
		$this->load->library(['ion_auth']);
		if(!$this->M_user->is_logged_in() && !$this->ion_auth->logged_in())
		{
			redirect('login_portal');
		}
		
		$url = $this->uri->uri_string();
		
		if(!($this->M_user->has_permission($url,$this->M_user->get_logged_in_user_info()->userid)))
		{
			redirect('no_access');
		}
		
		//load up global data
		$logged_in_user_info=$this->M_user->get_logged_in_user_info();
		// $role_id = $this->M_user->get_role_id()->row()->roleid;
		//$data['allowed_modules']=$this->Module->get_allowed_modules($logged_in_employee_info->person_id);
		$data['user_info']=$logged_in_user_info;
		$data['role_id']=$logged_in_user_info->roleid;
		$this->load->vars($data);
	}
}
?>