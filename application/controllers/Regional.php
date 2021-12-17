<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once("Secure_area.php");
class Regional extends Secure_area
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/M_sekolah', '', TRUE);
    }

    public function index()
    {
        $data = array(
            'title' => 'Daftar Regional'
        );
        $data['data_region'] = $this->M_sekolah->get_user_region()->result();
        $data['provinsi'] = $this->M_sekolah->get_provinsi()->result();
        $this->load->view('regional/formregional', $data);
    }

    public function get_regional() {
		$line  = array();
        $line2 = array();
        $row2  = array();
		$i=1;
        $hasil = $this->M_sekolah->get_user_region()->result();
		foreach ($hasil as $value) {
            $row2['no'] = $i++;
            $row2['name'] = $value->name;
            $row2['username'] = $value->username;
            if($value->id_regional == 0){
            $row2['nm_regional'] = $value->nm_provinsi;
            }else{
            $row2['nm_regional'] = $value->nama_region;
            }
            $row2['aksi'] = "<div>
            <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editModal' onclick='edit_reg(\"$value->userid\")'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-danger' onclick='delete_reg(\"$value->userid\")'><i class='fa fa-trash'></i></button>
            </div>";

            $line2[] = $row2;
        }
        $line['data'] = $line2;

        echo json_encode($line);
	}

    function get_autocomplete()
    {
        // if (isset($_GET['term'])) {
        //     $result = $this->M_sekolah->search_regional($_GET['term']);
        //     if (count($result) > 0) {
        //         foreach ($result as $row)
        //             $arr_result[] = $row->id_region . ' - ' .$row->nama_region;
        //         echo json_encode($arr_result);
        //     }
        // }
        $keyword = $this->input->get("query");
        $data = $this->M_sekolah->search_regional($keyword);

        $arr = [];
        $arr['suggestions'] = [];
        foreach ($data as $row) {
            $arr['query'] = $keyword;
            $arr['suggestions'][] = array(
                'value' => $row->id_region . ' - ' . $row->nama_region
            );
        }
        // minimal PHP 5.2
        echo json_encode($arr);
    }


    public function get_wilayah2()
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
                ->like('nama_region', $this->input->get("q"))
                ->order_by('nama_region', 'ASC')
                ->select('*')->limit(50, 0)->get('master_region');
            $json = $query->result();
        }


        echo json_encode($json);
    }

    function insert_regional()
    {
        if($this->input->post('nama_kota') == null){
        $data = array(
            'name' => $this->input->post('name'),
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'id_regional' => $this->input->post('nama_kota'),
            'id_provinsi' => $this->input->post('nama_provinsi'),
            'roleid' => '11',
            'xcreate_date' => date('Y-m-d h:i:s'),
            'xcreate_user' => $this->load->get_var("user_info")->username,
        );
        } else{
        $data = array(
            'name' => $this->input->post('name'),
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'id_regional' => $this->input->post('nama_kota'),
            'id_provinsi' => $this->input->post('nama_provinsi'),
            'roleid' => '10',
            'xcreate_date' => date('Y-m-d h:i:s'),
            'xcreate_user' => $this->load->get_var("user_info")->username,
        );
        }
        $data1 = array(
            'keterangan' => 'create regional',
            'ket_waktu' => date('Y-m-d h:i:s'),
            'userid' => $this->load->get_var('user_info')->userid
        );
        $cekk = $this->M_sekolah->dyn_user($data['username'])->num_rows();
        if ($cekk > 0) {
            $result = array('success' => false, 'msg' => 'Username Sudah Ada');
        } else {
            $result = array('success' => true);
            $result = $this->M_sekolah->insert_region($data);
            $result = $this->M_sekolah->log_activity($data1);
        }
        echo json_encode($result);
    }

    public function get_data_kota()
	{
		$nama_provinsi = $this->input->post('nama_provinsi');
		$data = $this->M_sekolah->get_kota($nama_provinsi)->result();
		$kota = '';
		if (sizeof((array) $data) > 0) {
			$kota .= "<option value=''>-=Pilih Kota=-</option>";
			foreach ($data as $row) {
				$kota .= "<option value='" . $row->id_region . "'>$row->nama_region</option>";
			}
		}
		if ($kota != "") {
			echo json_encode(array('success' => true, 'data' => $kota));
		} else {
			echo json_encode(array('success' => false, 'data' => '<option value="">-=Data Kota Kosong=-</option>'));
        }
    }
        
    function get_data_reg()
    {
        $id = $this->input->post('id');
        $datajson = $this->M_sekolah->get_data_reg($id)->result();
        echo json_encode($datajson);
    }

    function edit_reg(){
        $where = array('userid' => $this->input->post('edit_id'));
        $data = array(
            'name' => $this->input->post('edit_nama'),
            'username' => $this->input->post('edit_username')
        );
        $data1 = array(
            'keterangan' => 'update regional',
            'ket_waktu' => date('Y-m-d h:i:s'),
            'userid' => $this->load->get_var('user_info')->userid
        );
        $this->M_sekolah->update_table('dyn_user', $data, $where);
        $this->M_sekolah->log_activity($data1);

        $msg = '<div class="alert alert-success alert-dismissible"> <i class="ti-user"></i> Data Berhasil Diubah!
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>';
        $this->session->set_flashdata('success_msgs', $msg);
        redirect('regional');
    }

    function delete_reg()
    {
        $id = $this->input->post('id');
        $data1 = array(
            'keterangan' => 'delete regional',
            'ket_waktu' => date('Y-m-d h:i:s'),
            'userid' => $this->load->get_var('user_info')->userid
        );
        $this->M_sekolah->log_activity($data1);
        $result = $this->M_sekolah->delete_regional($id);

        echo json_decode($result);
    }
}
