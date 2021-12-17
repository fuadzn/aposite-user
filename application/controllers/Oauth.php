<?php defined('BASEPATH') OR exit('No direct script access allowed');

// require_once APPPATH.'libraries/oauth2-client/vendor/autoload.php';

class Oauth extends CI_Controller {

	private $provider;
	private $keycloak_baseurl;

	public function __construct(){
		parent::__construct();		

		$this->load->model('admin/M_sekolah','',TRUE);
		$this->load->library(['ion_auth']);

		// $this->load->model(array(
		// 	'users/user_m', 
		// 	'users/group_m'
		// ));
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

	protected function is_secure_page(){
		return false;
	}

	// redirect if needed, otherwise display the user list
	public function index(){
		$keycloak = $this->M_sekolah->keycloak()->row();
		if($this->M_sekolah->is_logged_in()){
			redirect('beranda');
		} 

		if(!$this->input->get('code')) {
		    // Get the state generated for you and store it to the session.
			$_SESSION['oauth2state'] = $this->provider->getState();

		    // Redirect the user to the authorization URL.
			$this->provider->authorize();
			exit();
		}elseif (empty($this->input->get('state')) || (isset($_SESSION['oauth2state']) && $this->input->get('state') !== $_SESSION['oauth2state'])) {
			if (isset($_SESSION['oauth2state'])) {
				unset($_SESSION['oauth2state']);
			}  
			exit('Invalid state');
		}else {
			try {
		        // Try to get an access token using the authorization code grant.
				$accessToken = $this->provider->getAccessToken('authorization_code', [
					'code' => $this->input->get('code')
				]);

				$resourceOwner = $this->provider->getResourceOwner($accessToken);
				$userProfile = $resourceOwner->toArray();
				if($userProfile){
					// echo json_encode($userProfile);
					if(!isset($userProfile['email']) || empty($userProfile['email'])){
						show_error('The user does not have email attribute', 401, '401 Unauthorized'); 
						exit();
					}
					if(isset($userProfile['resource_access']) && isset($userProfile['resource_access'][$keycloak->client_id])){
						$roleIds = array();
						foreach($userProfile['resource_access'][$keycloak->client_id]['roles'] as $role) {
							if($role == "admin"){
								$rolenama = "Admin";
								$role_id = "2";
							}else if($role == "admin-regional"){
								$rolenama = "Regional";
								$role_id = "10";
							} else if($role == "admin-provinsi"){
								$rolenama = "Provinsi";
								$role_id = "11";
							}
							// $userRole = $this->group_m->get_by('name', $role);
							$userRole = $this->M_sekolah->key_user($rolenama)->row();
							if($userRole){
								$roleIds[] = $userRole->id;
								// print_r($roleIds);
								// die();
							}
						}

						if($roleIds){
							$_SESSION['oauth2token'] = $accessToken->getToken();
							$_SESSION['oauth2refreshtoken'] = $accessToken->getRefreshToken();

							$email = $userProfile['email'];
							foreach($userProfile['resource_access'][$keycloak->client_id]['roles'] as $rolwsad);
							$username = $userProfile['preferred_username'];
							// $dataEmail = [];
							// for($i=0;$i<$userProfile['attributes'];$i++){
							// 	$dataEmail[] = array(
							// 		'value' => $userProfile['email-siswa'][$i]['id_provinsi'],
							// 	);
							// }
							// $id_regional = $userProfile['id_regional'];
							// print_r($id_provinsi);
							// die();
							$phone = isset($userProfile['phone_number']) ? $userProfile['phone_number'] : NULL;
							$display_name = $userProfile['name'];
							$additional_data = array(
								'display_name' => $display_name,
								'phone' => $phone
							);

			                // if(isset($userProfile['penduduk'])){
			                // 	$nik = $userProfile['penduduk']['nik'];
			                // 	$desakel_id = $userProfile['penduduk']['desakel_id'];
			                // 	$nama_sesuai_ktp = $userProfile['penduduk']['nama_sesuai_ktp'];

			                // 	if($nik) $additional_data['extrafield'] = $nik;
			                // 	if($desakel_id) $additional_data['extrafield_admin'] = $desakel_id;
			                // }       

				        	// check users on existing local db by identity (email or username), 
				        	// if exists update rows otherwise insert new one
							$existingUser = $this->M_sekolah->get_by($email)->row();
							$password = 'Password-'.$username;
				        	if($existingUser){ //do update				        		
				        		$data = array(
									// 'email' => $email,
									// 'password' => $password,
				        			// 'username' => $username,
									// 'display_name' => $display_name,
									// 'name' => $display_name,
									// 'role' => $rolwsad,
									// 'roleid' => $role_id,
									'last_login' => date('Y-m-d h:i:s')
				        		);
								$get_userid = $this->M_sekolah->get_userid2($username)->result();
								foreach($get_userid as $row){
									$data1 = array(
										'keterangan' => 'Login SSO',
										'ket_waktu' => date('Y-m-d h:i:s'),
										'userid' => $row->userid
									);
								}
								$this->M_sekolah->log_activity($data1);
				        		$payload = array_merge($data, $additional_data);
				        		if($this->M_sekolah->update_data($existingUser->username, $data, 'dyn_user') ) {
									$existingUserRoles = $this->M_sekolah->get_usersso($existingUser->username)->result();	 
									$existingRoleIds = [];
				        			foreach ($existingUserRoles as $userRole) {
										$existingRoleIds[] = $userRole->username;
				        			}
				        			$this->M_sekolah->remove_usersso($existingUser->username);
				        			// $this->ion_auth->remove_from_group($existingRoleIds, $existingUser->username);
				                	// add user into groups
				        			$this->M_sekolah->add_usersso($data);
				        			// $this->ion_auth->add_to_group($roleIds, $existingUser->username);
				        		}
							}else{ // create an user	
								$id_provinsi = $userProfile['attributes']['email-siswa']['id_provinsi'];
								$id_regional = $userProfile['attributes']['email-siswa']['id_regional'];
								$data = array(
									'name' => $display_name,
									'password' => $password,
				        			'email' => $email,
				        			'username' => $username,
									'display_name' => $display_name,
									'role' => $rolwsad,
									'roleid' => $role_id,
									'id_regional' => $id_regional,
									'id_provinsi' => $id_provinsi,
									'xcreate_date' => date('Y-m-d h:i:s'),
									'xcreate_user' => 'SSO',
									'role' => 'admin',
									'status' => 'enabled',
									'last_login' => date('Y-m-d h:i:s')
				        		);
								$data1 = array(
									'keterangan' => 'Login SSO',
									'ket_waktu' => date('Y-m-d h:i:s'),
									'userid' => $this->load->get_var('user_info')->userid
								);
								$this->M_sekolah->log_activity($data1);
				                $password = 'Password-'.$username; // set password as you want
				                // if($id = $this->M_sekolah->add_usersso($username, $password, $email, $additional_data, $roleIds) ) {
				                if($id = $this->M_sekolah->add_usersso($data) ) {
				                	$existingUser = $this->M_sekolah->get_usersso($username)->row();
				                	// $existingUser = $this->ion_auth->user($id)->row();
				                }else{
				                	exit('Oauth Exception: someting went wrong while copying new user as reference');
				                }
							  }
							  $password = 'Password-'.$username;

				        	// do the login process		        	
				        	$this->M_sekolah->login($username, $password); // set user session
				        	// $this->ion_auth->set_session($existingUser); // set user session
				        	
				        	$this->M_sekolah->update_last_login($existingUser->username);
				        	
				        	// Events::trigger('post_user_login');
				        	
							//if the login is successful then redirect them back to the home page
				        	$this->session->set_flashdata('success', 'Logged in successfully');

				        	redirect(site_url('/beranda'), 'refresh');
				        } // end if user has groups
			        }else{ // end if user has access 
			        	show_error('The user does not have access rights to the content', 403, '403 Forbidden'); 
			        	exit();
			        } // end if user has access 
			      }
			      
			 //      show_error('The user does not have access rights to the content', 401, '401 Unauthorized'); 
			 //      exit();
			    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
		        // Failed to get the access token or user details.
		        // exit('Oauth Exception: '.$e->getMessage());
			    	log_message('error', 'Oauth Exception: '.$e->getMessage());

			    	if (isset($_SESSION['oauth2state'])) {
			    		unset($_SESSION['oauth2state']);
			    	}  
			    	$this->provider->authorize();
			    	exit();
			    }
			  }

			  
			}

	// log the user out
	public function logout(){
		// log the user out
				if($this->ion_auth->logout()){
					if(isset($_SESSION['oauth2state'])) unset($_SESSION['oauth2state']);
					if(isset($_SESSION['oauth2token'])) unset($_SESSION['oauth2token']);
					if(isset($_SESSION['oauth2refreshtoken'])) unset($_SESSION['oauth2refreshtoken']);
				}
				
		// redirect them to the login page
				$this->session->set_flashdata('success', $this->ion_auth->messages());

				$redirectUri = $this->keycloak_baseurl.'/protocol/openid-connect/logout?redirect_uri='.urlencode(site_url('/login'));
		// $redirectUri = site_url('/login');
				$this->ion_auth->logout();

				redirect($redirectUri, 'refresh');

			}		
		}