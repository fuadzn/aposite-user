<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once("Secure_area.php");
class Admin extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/M_user', '', TRUE);
		$this->load->model('admin/M_sekolah', '', TRUE);
		$this->load->model('admin/M_menu', '', TRUE);
		$this->load->model('admin/M_role', '', TRUE);
		$this->load->model('admin/Appconfig', '', TRUE);
	}
	/*================================== ROLE ========================================*/

	public function role()
	{
		$data["title"] = "Data Role";
		$this->load->view('admin/role', $data);
	}

	public function roleExist()
	{
		$role = $this->input->post('id');
		$exist = $this->M_role->exist($role);
		if ($exist > 0) {
			echo json_encode(array('exist' => true));
		} else {
			echo json_encode(array('exist' => false));
		}
	}

	public function roleList()
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		if ($this->load->get_var("user_info")->roleid == 1) {
			$hasil = $this->M_role->get_all()->result();
		} else {
			$hasil = $this->M_role->get_all_withoutadministrator()->result();
		}
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id;
			$row2['role'] = $value->role;
			$row2['deskripsi'] = $value->deskripsi;
			$row2['access'] = '<center><a href="#" title="Set Access Menu" data-toggle="modal" data-target="#myModal" onclick="setAccessRole(' . $value->id . ',\'' . $value->role . '\')" class="btn btn-icon btn-primary"><i class="fa fa-user-secret fa-fw"></i></a></center>';
			$row2['edit'] = '<center><a href="#" title="Set Inactive"><i class="fa fa-edit fa-fw"></i></a></center>';
			$row2['drop'] = '<center><a href="#" title="Delete"><i class="fa fa-trash fa-fw"></i></a></center>';


			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function roleMenuList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$i = 1;
		$datas = $this->M_menu->get_child_role(0, $id)->result();
		foreach ($datas as $data) {
			$row2['id'] = $data->page_id;
			$row2['urutan'] = $i++;
			$row2['sts'] = $data->sts;
			$row2['menu'] = $data->title;
			$line2[] = $row2;
			if ($data->is_parent == 1) {
				$datasc = $this->M_menu->get_child_role($data->page_id, $id)->result();
				foreach ($datasc as $datac) {
					$row2['id'] = $datac->page_id;
					$row2['urutan'] = $i++;
					$row2['sts'] = $datac->sts;
					$row2['menu'] = "<i class='fa fa-angle-double-right fa-fw'></i>" . $datac->title;
					$line2[] = $row2;
				}
			}
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function roleMenuListDiv()
	{
		$id = $this->input->post('vid');

		$i = 1;
		$datas = $this->M_menu->get_child_role(0, $id)->result();
		$div_data = '<section id="content-types">
                    <div class="row match-height">';
		foreach ($datas as $data) {
			$div_data .= '
			    <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">';
			if ($data->sts == 0) {
				$div_data .=  '<fieldset><div class="vs-checkbox-con vs-checkbox-primary"><input type="checkbox" name="checkApp" value="' . $id . '@#' . $data->page_id . '@#' . $data->title . '" onchange="chooseApp(this)" id="' . $data->page_id . '"><span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span><span class=""><b>' . $data->title . '</b></span></div></fieldset>';
			} else {
				$div_data .=  '<fieldset><div class="vs-checkbox-con vs-checkbox-primary"><input type="checkbox" name="checkApp" value="' . $id . '@#' . $data->page_id . '@#' . $data->title . '" onchange="chooseApp(this)" id="' . $data->page_id . '" checked><span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span><span class=""><b>' . $data->title . '</b></span></div></fieldset>';
			}
			if ($data->is_parent == 1) {
				$datasc = $this->M_menu->get_child_role($data->page_id, $id)->result();
				foreach ($datasc as $datac) {
					if ($datac->sts == 0) {
						$div_data .=  '<fieldset><div class="vs-checkbox-con vs-checkbox-primary"><input type="checkbox" name="checkApp" value="' . $id . '@#' . $datac->page_id . '@#' . $datac->title . '" onchange="chooseApp(this)" id="' . $datac->page_id . '"><span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span><span class=""> &nbsp;&nbsp;&nbsp;<i class="feather icon-chevrons-right"></i>' . $datac->title . '</span></div></fieldset>';
					} else {
						$div_data .=  '<fieldset><div class="vs-checkbox-con vs-checkbox-primary"><input type="checkbox" name="checkApp" value="' . $id . '@#' . $datac->page_id . '@#' . $datac->title . '" onchange="chooseApp(this)" id="' . $datac->page_id . '" checked><span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span><span class=""> &nbsp;&nbsp;&nbsp;<i class="feather icon-chevrons-right"></i>' . $datac->title . '</span></div></fieldset>';
					}
				}
			}
			$div_data .= '
			    
                                    </div>
                                </div>
                            </div>
                        </div>';
		}
		$div_data .= '
		  	</div>
                </section>';

		echo json_encode(array('success' => true, 'data' => $div_data));
	}

	public function roleMenuSave()
	{
		$vdata = $this->input->post('vdata');
		$line2 = array();
		// $id = 0;
		foreach ($vdata as $row) {
			$vexplode = explode("@#", $row['value']);
			$id = $vexplode[0];
			$data['role_id'] = $vexplode[0];
			$id = $data['role_id'];
			$data['menu_id'] = $vexplode[1];
			$data['menu'] = $vexplode[2];
			$line2[] = $data;
		}
		// echo json_encode($line2);
		/**/
		if ($this->M_role->roleMenuSave($id, $line2)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}



	// public function roleMenuSave(){
	// 	$data = $this->input->post('vdata');
	// 	$id = $data[0]['role_id'];
	// 	/**/
	// 	if($this->M_role->roleMenuSave($id,$data)){
	// 		echo json_encode(array('success'=>true));
	// 	}else{
	// 		echo json_encode(array('success'=>false));
	// 	}		
	// }
	/*======================================== ROLE =================================================*/

	/*======================================== KASTEM =================================================*/
	function config()
	{
		$data["title"] = "Kastemisasi Aplikasi";
		$data["config"] = $this->Appconfig->get_all()->result();
		$this->load->view('admin/config', $data);
	}

	function configSave()
	{
		$data = array(
			'web_title' => $this->input->post('web_title'),
			'header_title' => $this->input->post('header_title'),
			'nama' => $this->input->post('nama'),
			'namasingkat' => $this->input->post('namasingkat'),
			'alamat' => $this->input->post('alamat'),
			'telp' => $this->input->post('telp'),
			'kota' => $this->input->post('kota'),
			'email' => $this->input->post('email')
		);

		if ($this->Appconfig->batch_save($data)) {
			redirect(site_url("admin/config"), 'refresh');
		}
	}
	/*======================================== KASTEM =================================================*/

	/*======================================== MENU =================================================*/
	public function menu()
	{
		$data["title"] = "Data Menu";
		$data['parents'] = $this->M_menu->get_all_menu();
		$data['sortMenu'] = sortMenu();
		$this->load->view('admin/menu', $data);
	}

	public function menuSave()
	{
		$data = array(
			'page_id' => $this->input->post('id'),
			'title' => $this->input->post('title'),
			'url' => $this->input->post('url'),
			'icon' => $this->input->post('icon'),
			'parent_id' => $this->input->post('parent_id')
		);
		if ($this->M_menu->save($data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function icon_feather()
	{
		$data["title"] = "Icon Feather";
		$this->load->view('admin/icon_feather', $data);
	}

	public function icon_fa()
	{
		$data["title"] = "Icon Font Awesome";
		$this->load->view('admin/icon_fa', $data);
	}

	public function updateOrderMenu()
	{
		$arr = $this->input->post('data');
		echo $this->M_menu->updatePosition($arr);
	}

	public function menuInfo()
	{
		$page_id = $this->input->post('id');
		$data = $this->M_menu->get_info($page_id);
		echo json_encode($data);
	}

	public function hasChildMenu()
	{
		$page_id = $this->input->post('id');
		$child = $this->M_menu->has_child($page_id);
		if ($child > 0) {
			echo json_encode(array('hasChild' => true));
		} else {
			echo json_encode(array('hasChild' => false));
		}
	}

	public function dropMenu()
	{
		$page_id = $this->input->post('id');
		if ($this->M_menu->delete($page_id)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	// public function menuSave(){	
	// 	if ($this->input->post('id') == '') {
	// 		$data = array(
	// 			'title'=>$this->input->post('title'),
	// 			'url'=>$this->input->post('url'),
	// 			'parent_id'=>$this->input->post('parent_id')
	// 		);			
	// 	} else {
	// 		$data = array(
	// 			'page_id'=>$this->input->post('id'),
	// 			'title'=>$this->input->post('title'),
	// 			'url'=>$this->input->post('url'),
	// 			'parent_id'=>$this->input->post('parent_id')
	// 		);
	// 	}					

	// 	if($this->M_menu->save($data)){
	// 		echo json_encode(array('success'=>true));
	// 	}else{
	// 		echo json_encode(array('success'=>false));
	// 	}
	// }
	/*======================================== MENU =================================================*/

	/*=================================== USER ============================================*/
	public function user()
	{
		$data["title"] = "Data Superuser";
		$this->load->view('admin/user', $data);
	}

	public function userListRoleLogin()
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_all_roleid($this->load->get_var("user_info")->roleid)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			// $hasil2 = $this->M_user->ket_waktu($value->userid)->result();
			// foreach ($hasil2 as $row) {
			$row2['id'] = $value->userid;
			$row2['username'] = $value->username;
			$row2['name'] = $value->name;
			$row2['xcreate_date'] = $value->xcreate_date;
			$row2['xcreate_user'] = $value->xcreate_user;
			$row2['status'] = "<span class='label label-info'>Active</span>";
			if ($value->deleted == 0) {
				// if ($row->ket_waktu == null) {
				// $row2['last_login'] = '
				// 		<div class="btn-group" role="group" aria-label="Basic example">
				// 			<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#last_login" data-id="' . $value->userid . '" data-username="' . $value->username . '"></button>
				// 		</div>';
				// } else {
				// 	$row2['last_login'] = '
				// 		<div class="btn-group" role="group" aria-label="Basic example">
				//             <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#last_login" data-id="' . $value->userid . '" data-username="' . $value->username . '">' . $row->ket_waktu . '</button>
				//         </div>';
				// }

				$row2['aksi'] = '
						<center>
							<div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#editModal" data-id="' . $value->userid . '" data-username="' . $value->username . '"><i class="feather icon-edit"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="delete_user(' . $value->userid . ')"><i class="feather icon-trash"></i></button>
                            </div>
						</center>';
			} else {
				$row2['status'] = "<span class='label label-danger'>Non Active</span>";
				$row2['aksi'] = '
						<center>
							<div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#editModal" data-id="' . $value->userid . '" data-username="' . $value->username . '"><i class="feather icon-edit"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="active_user(' . $value->userid . ')"><i class="feather icon-check"></i></button>
                            </div>
						</center>';
			}
			if ($value->ket_waktu == "") {
				$row2['last_login'] = '	
					';
			} else {
				$row2['last_login'] = '
					<div class="btn-group" role="group" aria-label="Basic example">
						<button type="button" class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#last_login" data-id="' . $value->userid . '" data-username="' . $value->username . '">' . $value->ket_waktu . '</button>
					</div>';
			}

			$line2[] = $row2;
			// }
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function last_login($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_sekolah->last_login($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->userid;
			$row2['username'] = $value->ket_waktu;
			$row2['keterangan'] = $value->keterangan;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	function user_insert_roleid()
	{
		$hash_pwd = $this->phpass->hash($this->input->post("password"));

		$data['username'] = $this->input->post('username');
		$data['password'] = $hash_pwd;
		$data['name'] = $this->input->post("name");
		$data['roleid'] = $this->load->get_var("user_info")->roleid;
		$data['xcreate_date'] = date('Y-m-d H:i:s');
		$data['xcreate_user'] = $this->load->get_var("user_info")->username;
		$id = $this->M_user->insert_dyn_user($data);
		if ($id > 0) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function userExist()
	{
		$username = $this->input->post('id');
		$exist = $this->M_user->exist($username);
		if ($exist > 0) {
			echo json_encode(array('exist' => true));
		} else {
			echo json_encode(array('exist' => false));
		}
	}

	public function userInfo()
	{
		$userid = $this->input->post('id');
		$data = $this->M_user->get_info($userid);
		echo json_encode($data);
	}

	public function userList()
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_all()->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->userid;
			$row2['username'] = $value->username;
			$row2['name'] = $value->name;
			$row2['role'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Set Roles" data-toggle="modal" data-target="#myModal" onclick="setUserRole(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-user-secret fa-fw"></i></button></center>';
			$row2['plus'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Akses Gudang" data-toggle="modal" data-target="#myModalGdg" onclick="setUserGudang(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['poli'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Akses Poli" data-toggle="modal" data-target="#myModalPoli" onclick="setUserPoli(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['ruang'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Akses Ruang" data-toggle="modal" data-target="#myModalRuang" onclick="setUserRuang(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['hakakses'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Hak Akses Kasir" data-toggle="modal" data-target="#myModalAkses" onclick="setUserAkses(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['aksi'] = '<center><button type="button" class="btn btn-success btn-xs" title="Reset Password" data-toggle="modal" data-target="#editModal" data-id="' . $value->userid . '" data-username="' . $value->username . '"><i class="fa fa-edit fa-fw"></i></button>&nbsp;<a href="' . base_url() . 'admin/dropUser/' . $value->userid . '" class="btn btn-danger btn-xs delete_user" title="Delete"><i class="fa fa-trash fa-fw"></i></a></center>';

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function userRoleList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_role_all($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id;
			$row2['sts'] = $value->sts;
			$row2['role'] = $value->role;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function userRoleSave()
	{
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if ($this->M_user->userRoleSave($id, $data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}
	public function userAksesSave()
	{
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if ($this->M_user->userAksesSave($id, $data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}
	public function userGdgList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_role_gudang($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id_gudang;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nama_gudang;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}
	public function userPoliList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_role_poli($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id_poli;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nm_poli;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}
	public function userRuangList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_role_ruang($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id_ruang;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nm_ruang;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function userAksesList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_role_akses($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id;
			$row2['sts'] = $value->sts;
			$row2['kasir'] = $value->kasir;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function userGdgDelete()
	{
		$id = $this->input->post('vdata');
		/**/
		$this->M_user->userGdgDelete($id);
		echo json_encode(array('success' => true));
	}

	public function userGdgSave()
	{
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if ($this->M_user->userGdgSave($id, $data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function userPoliDelete()
	{
		$id = $this->input->post('vdata');
		/**/
		$this->M_user->userPoliDelete($id);
		echo json_encode(array('success' => true));
	}

	public function userPoliSave()
	{
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if ($this->M_user->userPoliSave($id, $data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function userRuangDelete()
	{
		$id = $this->input->post('vdata');
		/**/
		$this->M_user->userRuangDelete($id);
		echo json_encode(array('success' => true));
	}

	public function userRuangSave()
	{
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if ($this->M_user->userRuangSave($id, $data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	function user_insert()
	{
		$hash_pwd = $this->phpass->hash($this->input->post("password"));

		$data['username'] = $this->input->post('username');
		$data['password'] = $hash_pwd;
		$data['name'] = $this->input->post("nama");
		$data['roleid'] = 2;
		$data['xcreate_date'] = date('Y-m-d H:i:s');
		$data['xcreate_user'] = $this->load->get_var("user_info")->username;
		$id = $this->M_user->insert_dyn_user($data);
		if ($id > 0) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}
	public function reset_password()
	{
		if ($this->M_user->update($this->input->post())) {
			echo json_encode(array('success' => true));
			//redirect(site_url("Admin/user"), 'refresh');
		} else {
			echo json_encode(array('success' => false));
			//redirect(site_url("Admin/user"), 'refresh');
		}
	}
	public function userSave($data, $foto)
	{
		if ($this->M_user->save($data, $foto)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function dropUser($userid)
	{
		if ($this->M_user->delete($userid)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function activeUser($userid)
	{
		if ($this->M_user->active($userid)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	function update_photo()
	{
		$uid = $this->input->post('uid');
		//upload logo
		$config['upload_path'] = './upload/user/';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$config['file_name'] = $uid;
		$this->upload->initialize($config);

		$userfile = $_FILES['userfile']['name'];
		$data = $this->input->post();

		if ($userfile) {
			$ext = pathinfo($userfile, PATHINFO_EXTENSION);
			$file = $config['upload_path'] . $config['file_name'] . '.' . $ext;
			if (is_file($file))
				unlink($file);

			if (!$this->upload->do_upload()) {
				$error = $this->upload->display_errors();
				echo $error;
			} else {
				$upload = $this->upload->data();
				$foto = $upload['file_name'];

				if ($this->M_user->update_photo($uid, $foto)) {
					echo json_encode(array('success' => true, 'photo' => $foto));
				} else {
					echo json_encode(array('success' => true, 'photo' => 'unknown.png'));
				}
			}
		}
	}
	function update_name()
	{
		$name = $this->input->post('uname');
		if ($this->M_user->update_name($this->input->post())) {
			echo json_encode(array('success' => true, 'name' => $name));
		}
	}
	/*=================================== USER ============================================*/

	private function clean($string)
	{
		// $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
}
