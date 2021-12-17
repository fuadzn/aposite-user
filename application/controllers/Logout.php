<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ("Secure_area.php");
class Logout extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('admin/M_sekolah','',TRUE);
		$this->load->library(['ion_auth']);

		$keycloak = $this->M_sekolah->keycloak()->row();
		
		// $this->keycloak_baseurl = Settings::get('keycloak_server_url').'/realms/'.Settings::get('keycloak_realm');
		$this->keycloak_baseurl = $keycloak->server_url.'/realms/'.$keycloak->realm;

		$this->provider = new \League\OAuth2\Client\Provider\GenericProvider([
		    'clientId'                => $keycloak->client_id,    // The client ID assigned to you by the provider
		    'clientSecret'            => $keycloak->client_secret,   // The client password assigned to you by the provider
		    'redirectUri'             => site_url('/oauth'),
		    'urlAuthorize'            => $this->keycloak_baseurl.'/protocol/openid-connect/auth',
		    'urlAccessToken'          => $this->keycloak_baseurl.'/protocol/openid-connect/token',
		    'urlResourceOwnerDetails' => $this->keycloak_baseurl.'/protocol/openid-connect/userinfo',
		    'scopes' => array('email')
		  ]);
	}
	
	public function index()
	{
		if($this->ion_auth->logout()){
			if(isset($_SESSION['oauth2state'])) unset($_SESSION['oauth2state']);
			if(isset($_SESSION['oauth2token'])) unset($_SESSION['oauth2token']);
			if(isset($_SESSION['oauth2refreshtoken'])) unset($_SESSION['oauth2refreshtoken']);
		}
		
// redirect them to the login page
		$this->session->set_flashdata('success', $this->ion_auth->messages());

		$redirectUri = $this->keycloak_baseurl.'/protocol/openid-connect/logout?redirect_uri='.urlencode(site_url('/login_portal'));
// $redirectUri = site_url('/login');
		session_start();
		$this->ion_auth->logout();

		
		redirect($redirectUri, 'refresh');
		// $this->M_user->logout();
	}
}

?>