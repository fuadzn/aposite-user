<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once("Secure_area.php");
class Nuptk extends Secure_area
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('admin/M_sekolah', '', TRUE);
        // $this->load->helper('pdf_helper');
    }

    public function index()
    {
        $data['title'] = 'Data Operator Sekolah';
        // print_r($this->load->get_var("user_info"));
        $id_provinsi = $this->load->get_var('user_info')->id_provinsi;
        $id_region = $this->load->get_var('user_info')->id_regional;
        if ($this->load->get_var('user_info')->roleid == 11) {
            $data['data_sekolah'] = $this->M_sekolah->get_user_sekolah1($id_provinsi)->result();
        } else if ($this->load->get_var('user_info')->roleid == 10){
            $data['data_sekolah'] = $this->M_sekolah->get_user_sekolah2($id_region)->result();
        } else{
            $data['data_sekolah'] = $this->M_sekolah->get_user_sekolah()->result();
        }
        $this->load->view('nuptk/index', $data);
    }

    public function get_siswa() {
		$line  = array();
        $line2 = array();
        $row2  = array();
		$i=1;
        $role_id = $this->load->get_var("user_info")->roleid;
        $id_provinsi = $this->load->get_var('user_info')->id_provinsi;
        $id_region = $this->load->get_var('user_info')->id_regional;
		if ($role_id == 11) {
            $hasil = $this->M_sekolah->get_user_sekolah1($id_provinsi)->result();
        } else if ($role_id == 10){
            $hasil = $this->M_sekolah->get_user_sekolah2($id_region)->result();
        } else{
            $hasil = $this->M_sekolah->get_user_sekolah()->result();
        }
		foreach ($hasil as $value) {
            $row2['no'] = $i++;
            $row2['nuptk'] = $value->nuptk;
            $row2['sekolah'] = $value->sekolah;
            $row2['nama'] = $value->nama;
            $row2['no_hp'] = $value->no_hp;
            $row2['email'] = $value->email;
            if($value->statuss == 1){
            $row2['statuss'] = "Aktif";
            $row2['aksi'] = '
            <td>
            <a href="nuptk/change_status_nonactive/'.$value->id.'" class="btn btn-warning btn-sm col-sm-10 mt-1">Non Aktifkan</a><br>
            <button type="button" class="btn btn-primary btn-sm col-sm-10 mt-1" data-toggle="modal" data-target="#editModal" onclick="edit_operator('.$value->nuptk.')">Ubah</button>
            <button type="button" class="btn btn-danger btn-sm col-sm-10 mt-1" onclick="hapus_operator('.$value->nuptk.')">Hapus</button>
            </td>';
            }else{
            $row2['statuss'] = "Non Aktif";
            $row2['aksi'] = '
            <td>
            <a href="nuptk/change_status_active/'.$value->id.'" class="btn btn-success btn-sm col-sm-10 mt-1">Aktifkan</a><br>
            <button type="button" class="btn btn-primary btn-sm col-sm-10 mt-1" data-toggle="modal" data-target="#editModal" onclick="edit_operator('.$value->nuptk.')">Ubah</button>
            <button type="button" class="btn btn-danger btn-sm col-sm-10 mt-1" onclick="hapus_operator('.$value->nuptk.')">Hapus</button>
            </td>';
            }

            $line2[] = $row2;
        }
        $line['data'] = $line2;

        echo json_encode($line);
	}

    public function change_status_active($id)
    {
        $hasil = $this->M_sekolah->get_sekolah_by_id($id)->result();
        foreach ($hasil as $row) {
            $data['sekolah'] = $row->sekolah;
        }
        $cek = $this->M_sekolah->cek_sekolah($data['sekolah'])->num_rows();
        if ($cek >= 3) {
            $success =     '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            <h4 class="text-danger"><i class="fa fa-ban"></i> Sekolah sudah melebihi batas kuota !</h4>
                        </div>';
        } else {
            $success =     '<div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            <h4 class="text-success"><i class="fa fa-check"></i> Data berhasil diaktifkan </h4>
                        </div>';
            $this->M_sekolah->update_to_active($id);
        }
        $this->session->set_flashdata('msg', $success);
        redirect('nuptk');
    }

    public function change_status_nonactive($id)
    {
        $success =     '<div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            <h4 class="text-success"><i class="fa fa-ban"></i> Data berhasil dinonaktifkan</h4>
                        </div>';
        $this->session->set_flashdata('msg', $success);
        $this->M_sekolah->update_to_nonactive($id);
        redirect('nuptk');
    }

    function edit_operator(){
        $nuptk = $this->input->post('nuptk');
        $datajson = $this->M_sekolah->get_nuptk($nuptk)->result();
        echo json_encode($datajson);
    }

    function update_operator(){
        $where = array( 'nuptk' => $this->input->post('edit_nuptk') );
        $where2 = array( 'username' => $this->input->post('edit_nuptk') );
        // print_r($where2);
        // die();
        $data = array(
                'nuptk' => $this->input->post('edit_nuptk'),
                'sekolah' => $this->input->post('edit_sekolah'),
                'nama' => $this->input->post('edit_nama'),
                'email' => $this->input->post('edit_email'),
                'no_hp' => $this->input->post('edit_no_hp')
                    );
        $data1 = array(
                'name' => $this->input->post('edit_nama'),
                'username' => $this->input->post('edit_nuptk'),
                'xedit_date' => date('Y-m-d h:i:s')
            );
        $data2 = array(
            'keterangan' => 'edit operator sekolah',
            'ket_waktu' => date('Y-m-d h:i:s'),
            'userid' => $this->load->get_var('user_info')->userid
            );

        $this->M_sekolah->update_table('user_sekolah', $data, $where);
        $this->M_sekolah->update_table('dyn_user', $data1, $where2);
        $this->M_sekolah->log_activity($data2);

        $msg = '<div class="alert alert-success alert-dismissible"> <i class="ti-user"></i> Data Berhasil Diubah!
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>';
        $this->session->set_flashdata('success_msg', $msg);
        redirect('nuptk');

        // $nuptk = array('username' => $this->input->post('edit_nuptk'));
        // $nuptk2 = array('nuptk' => $this->input->post('edit_nuptk'));
        // $data = array(
		// 	'nuptk' => $this->input->post('edit_nuptk'),
		// 	'sekolah' => $this->input->post('edit_sekolah'),
		// 	'nama' => $this->input->post('edit_nama'),
		// 	'email' => $this->input->post('edit_email'),
		// 	'no_hp' => $this->input->post('edit_no_hp'),
		// );
		// $data1 = array(
		// 	'name' => $this->input->post('edit_nama'),
		// 	'username' => $this->input->post('edit_nuptk'),
		// 	'xedit_date' => date('Y-m-d h:i:s'),
		// );
		// $data2 = array(
        //     'keterangan' => 'edit operator siswa',
        //     'ket_waktu' => date('Y-m-d h:i:s'),
        //     'userid' => $this->load->get_var('user_info')->userid
        //     );
        //     if ($data) {
        //         $result = $this->M_sekolah->update_table('dyn_user', $data1, $nuptk);
        //         $result = $this->M_sekolah->update_table('user_sekolah', $data, $nuptk2);
        //         $result = $this->M_sekolah->log_activity($data2);
        //         $result = array('success' => true);

        //     } else {
        //         $result = array('success' => false);
        //     }
		// echo json_encode($result);
    }

    function hapus_operator(){
        $where = array( 'nuptk' => $this->input->post('nuptk') );
        $where2 = array( 'username' => $this->input->post('nuptk') );

        $data = array(
            'keterangan' => 'hapus operator sekolah',
            'ket_waktu' => date('Y-m-d h:i:s'),
            'userid' => $this->load->get_var('user_info')->userid
            );

        $save = $this->M_sekolah->delete_table('user_sekolah', $where);
        $save = $this->M_sekolah->delete_table('dyn_user', $where2);
        $save = $this->M_sekolah->log_activity($data);

        if($save >= 1){
            $data = array('status' => 'success');
        }else{
            $data = array('status' => 'failed');
        }

        echo json_encode($data);
    }
}
