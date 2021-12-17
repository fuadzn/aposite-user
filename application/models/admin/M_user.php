<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_user extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function insert_dyn_user($data)
	{
		$this->db->insert('dyn_user', $data);
		return $this->db->insert_id();
	}

	function update_dyn_user($data, $userid)
	{
		$this->db->where('userid', $userid);
		$this->db->update('dyn_user', $data);
		return true;
	}

	function exist($username)
	{
		$this->db->from('dyn_user');
		$this->db->where('username', $username);
		return $this->db->count_all_results();
	}

	function check_pass_match($data)
	{
		$this->db->from('dyn_user');
		$this->db->where('userid', $this->session->userdata('userid'));
		$this->db->where('password', $data['currpass']);
		return $this->db->count_all_results();
	}

	function get_all()
	{
		// return $this->db->query("select *
		// 	from dyn_user
		// 	where deleted = 0
		// 	order by username asc");
		
		$this->db->select('*')->from('dyn_user')->where('deleted', '0')->order_by('username', 'asc');
		return $this->db->get();
	}

	function get_all_roleid($roleid)
	{
		// return $this->db->query("select * from dyn_user a LEFT JOIN (SELECT * FROM log_activity order BY ket_waktu DESC ) as b on b.userid=a.userid group by a.userid order by a.userid ASC");
	
		// 	return $this->db->query("SELECT 
	// 	a.*,
	// 	(SELECT 
	// 	  ket_waktu 
	// 	FROM
	// 	  log_activity 
	// 	WHERE userid = a.userid AND keterangan = 'Login'
	// 	ORDER BY id DESC 
	// 	LIMIT 1) AS ket_waktu 
	//   FROM
	// 	dyn_user a 
	//   GROUP BY a.userid 
	//   ORDER BY a.userid ASC ");

	$sql = "SELECT 
	 	a.*,
	 	(SELECT 
	 	  ket_waktu 
	 	FROM
	 	  log_activity 
	 	WHERE userid = a.userid AND keterangan = 'Login'
	 	ORDER BY id DESC 
	 	LIMIT 1) AS ket_waktu 
	   FROM
	 	dyn_user a 
	   GROUP BY a.userid 
	   ORDER BY a.userid ASC";
	   return $this->db->query($sql);
	}

	// function ket_waktu($id)
	// {
	// 	return $this->db->query("select ket_waktu as ket_waktu
	// 	from log_activity
	// 	where a.userid = '$id' and keterangan = 'Login'
	// 	order by ket_waktu desc LIMIT 1");
	// }

	function get_all_superadmin()
	{
		// return $this->db->query("select *
		// 	from dyn_user
		// 	where roleid = 1
		// 	order by username asc");

		$this->db->select('*')->from('dyn_user')->where('roleid', '1')->order_by('username', 'asc');
		return $this->db->get();
	}

	function getall_role()
	{
		// return $this->db->query("SELECT*FROM dyn_role WHERE id!=1 ORDER BY id ASC");
		$this->db->select('*')->from('dyn_role')->where('id !=', '1')->order_by('id', 'asc');
		return $this->db->get();
	}

	function get_role_all($id)
	{
		// return $this->db->query("SELECT b.id, IFNULL(a.roleid,0) as sts, b.role
		// 	from dyn_user a
		// 	RIGHT JOIN 
		// 	dyn_role b
		// 	on a.roleid = b.id
		// 	and a.userid = $id");

		$sql = "SELECT b.id, IFNULL(a.roleid,0) as sts, b.role
		 	from dyn_user a
		 	RIGHT JOIN 
		 	dyn_role b
		 	on a.roleid = b.id
			 and a.userid =?";
		return $this->db->query($sql, array($id));
	}
	function get_role_id()
	{
		$userid = $this->session->userdata('userid');
		// return $this->db->query("Select roleid from dyn_user where userid = '" . $userid . "'");
		$this->db->select('roleid')->from('dyn_user')->where('userid', $userid);
		return $this->db->get();
	}

	/*
	Attempts to login employee and set session. Returns boolean based on outcome.
	*/
	function login($username, $password)
	{
		//$query = $this->db->get_where('dyn_user', array('username' => $username,'password'=>md5($password), 'deleted'=>0), 1);
		$query = $this->db->get_where('dyn_user', array('username' => $username, 'password' => $password, 'deleted' => 0), 1);
		if ($query->num_rows() == 1) {
			$row = $query->row();
			$this->session->set_userdata('userid', $row->userid);
			return true;
		}
		return false;
	}

	/*
	Logs out a user by destorying all session data and redirect to login
	*/
	function logout()
	{
		$this->session->sess_destroy();
		// redirect('login_portal');
	}

	/*
	Determins if a user is logged in
	*/
	function is_logged_in()
	{
		return $this->session->userdata('userid') != false;
	}
	/*
	Gets information about a user loged in
	*/
	function get_logged_in_user_info()
	{
		$userid = $this->session->userdata('userid');
		if (($userid)) {
			return $this->get_info($userid);
		}
	}
	/*
	Gets information about a particular user
	*/
	function get_info($userid)
	{
		$this->db->select('userid, name, username, roleid, logo as logo_klinik, dyn_user.id_sekolah as id_sekolah, id_regional as id_regional, dyn_user.id_provinsi, master_provinsi.nm_provinsi as nm_provinsi, master_region.nama_region as nama_region, master_sekolah.nm_sekolah');
		$this->db->from('dyn_user');
		$this->db->where('userid', $userid);
		$this->db->join('data', 'data.id = dyn_user.id_klinik', 'left');
		$this->db->join('master_provinsi', 'master_provinsi.id_provinsi = dyn_user.id_provinsi', 'left');
		$this->db->join('master_region', 'master_region.id_region = dyn_user.id_regional', 'left');
		$this->db->join('master_sekolah', 'master_sekolah.id_sekolah = dyn_user.id_sekolah', 'left');
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			//Get empty base parent object, as $item_id is NOT an item
			$data_obj = new stdClass();

			//Get all the fields from items table
			$fields = $this->db->list_fields('dyn_user');

			foreach ($fields as $field) {
				$data_obj->$field = '';
			}

			return $data_obj;
		}
	}
	/*
	Determins whether the employee specified employee has access the specific module.
	*/
	function has_permission($url, $userid)
	{
		//if no module_id is null, allow access
		if ($url == null or $url == 'beranda' or $url == 'logout') {
			return true;
		} else {
			if ($this->is_menu($url)) {
				$query = $this->db->query("select count(*) as jml
					from dyn_user ru, dyn_role_menu rm, dyn_menu m
					where ru.userid = $userid
						and ru.roleid = rm.role_id
					  and rm.menu_id = m.page_id
					  and m.url = '$url'");
				return ($query->row()->jml > 0);
			} else {
				return true;
			}
		}
		return false;
	}

	function is_menu($url)
	{
		$query = $this->db->query("select count(show_menu) as jml
					from dyn_menu
					where url = '$url' and show_menu = 1");
		return ($query->row()->jml == 1);
	}

	function save(&$data, $foto)
	{
		$query = $this->db->query("INSERT INTO dyn_user (username, password, name, deleted, foto) VALUES ('" . $data["username"] . "','" . $data["password"] . "','" . $data["name"] . "','0','$foto')");
		if ($query) {
			return true;
		}
		return false;
	}
	function update($data)
	{
		$this->db->set('password', $this->phpass->hash($data["vpassword"]));
		$this->db->where('userid', $data["vuserid"]);
		return $this->db->update('dyn_user');
	}
	// function delete($id)
	// {
	// 	$this->db->where('userid',$id);	
	// 	if ($this->db->delete('dyn_user')){
	// 		return true;
	// 	}else{			
	// 		return false;
	// 	}
	// }
	function delete($id)
	{
		$this->db->set('deleted', '1');
		$this->db->where('userid', $id);
		if ($this->db->update('dyn_user')) {
			return true;
		} else {
			return false;
		}
	}
	function active($id)
	{
		$this->db->set('deleted', '0');
		$this->db->where('userid', $id);
		if ($this->db->update('dyn_user')) {
			return true;
		} else {
			return false;
		}
	}
	function userRoleSave($id, &$data)
	{
		$this->db->where('userid', $id);
		$this->db->delete('dyn_role_user');
		$temp = count($data);
		for ($i = 0; $i < $temp; $i++) {
			$this->db->insert('dyn_role_user', $data[$i]);
		}
		return true;
	}


	function update_photo($uid, $foto)
	{
		// return $this->db->query("update dyn_user set foto = '" . $foto . "' where username = '" . $uid . "'");

		$sql = "UPDATE dyn_user set foto =? where username =?";
		return $this->db->query($sql, array($foto, $uid));
	}
	function update_name($data)
	{
		// return $this->db->query("update dyn_user set name = '" . $data["uname"] . "' where username = '" . $data["uid"] . "'");

		$sql = "UPDATE dyn_user set name =? where username =?";
		return $this->db->query($sql, array($data["uname"], $data["uid"]));
	}
	// function change_pass($data){
	// 	return $this->db->query("update dyn_user set password = '".$data["newpass"]."' where userid = '".$this->session->userdata('userid')."'");
	// }
	function change_pass($data)
	{
		$hash_pwd = $this->phpass->hash($data["newpass"]);
		return $this->db->query("update dyn_user set password = '" . $hash_pwd . "' where userid = '" . $this->session->userdata('userid') . "'");
	}
	function get_user($username)
	{
		return $this->db->query("SELECT * from dyn_user where deleted = 0 and username COLLATE latin1_general_cs LIKE '$username'");
	}
	function get_nisn($nisn)
	{
		// return $this->db->query("SELECT * from siswa where nisn='$nisn'");
		$this->db->select('*')->from('siswa')->where('nisn', $nisn);
		return $this->db->get();
	}

	function cek_adminreg($username)
	{
		// return $this->db->query("SELECT * FROM dyn_user WHERE username = '" . $username . "' ");
		$this->db->select('*')->from('dyn_user')->where('username', $username);
		return $this->db->get();
	}

	function cek_adminreg_email($username, $email)
	{
		// return $this->db->query("SELECT * FROM dyn_user a WHERE a.username = '" . $username . "' AND a.email = '" . $email . "'");
		$sql = "SELECT * FROM dyn_user a WHERE a.username =? AND a.email =?";
		return $this->db->query($sql, array($username, $email));
	}

	function update_reset_key($email, $reset_key, $update){
		$this->db->where('email', $email);
		$data = array('reset_password'=>$reset_key, 'xupdate_reset'=>$update);
		$this->db->update('dyn_user', $data);
		if($this->db->affected_rows()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function check_reset_key($reset_key)
	{
		$this->db->where('reset_password', $reset_key);
		$this->db->from('dyn_user');
		return $this->db->count_all_results();
	}

	public function reset_password($reset_key, $password)
	{
		$this->db->where('reset_password', $reset_key);
		$data = array('password' => $password);
		$this->db->update('dyn_user', $data);
		return ($this->db->affected_rows()>0 )? TRUE:FALSE;
	}

	public function get_time_reset($reset_key){
		$this->db->select('xupdate_reset');
		$this->db->where('reset_password', $reset_key);
		$this->db->from('dyn_user');
		return $this->db->get();
	  }
	public function cek_status($username){
		// return $this->db->query("SELECT * from user_sekolah where statuss = 0 and nuptk = '$username'");
		$sql = "SELECT * from user_sekolah where statuss = 0 and nuptk =?";
		return $this->db->query($sql, array($username));
	  }
}
