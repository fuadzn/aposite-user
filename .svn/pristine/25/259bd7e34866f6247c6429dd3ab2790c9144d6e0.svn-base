<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Secure_area.php');

class Upload_regional extends Secure_area
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('admin/M_upload', '', TRUE);
        $this->load->model('admin/M_sekolah', '', TRUE);
    }

    public function index()
    {
        $data = array(
            'title' => 'Upload Regional'
        );

        $this->load->view('master/mvupload_regional', $data);
    }

    public function upload_regional()
    {
        /*echo "<pre>";
        echo print_r($_POST);
        echo "</pre>";*/
        $counter_success = 0;
        $counter_fail = 0;
        if (isset($_FILES["fileRegional"]["name"])) {

            $this->load->library('Excel');
            $upload = array();
            $path = $_FILES["fileRegional"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();

                for ($row = 3; $row <= $highestRow; $row++) {
                    // $data_upload = explode(';', $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                    $nama = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $username = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $password = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $provinsi = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $kota = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    if ($kota != '' || $kota != null) {
                        $id_region = $this->M_upload->getDataRegional2($kota)->row()->id_region;
                        $id_provinsi = $this->M_upload->getDataRegional2($kota)->row()->id_provinsi;
                        $upload = array(
                            'name' => $nama,
                            'username' => $username,
                            'password' => password_hash($password, PASSWORD_BCRYPT),
                            'roleid' => '10',
                            'xcreate_date' => date('Y-m-d h:i:s'),
                            'xcreate_user' => $this->load->get_var('user_info')->username,
                            'id_regional' => $id_region,
                            'id_provinsi' => $id_provinsi
                        );

                            if ($upload) {
                                $result = $this->M_upload->insert_regional($upload);
                                $data1 = array(
                                    'keterangan' => 'create regional',
                                    'ket_waktu' => date('Y-m-d h:i:s'),
                                    'userid' => $this->load->get_var('user_info')->userid
                                );
                                $this->M_sekolah->log_activity($data1);
                                $counter_success++;
                            } else {
                                $counter_fail++;
                            }
                    } else{
                        $id_provinsis = $this->M_upload->getDataRegional($provinsi)->row()->id_provinsi;
                        $upload = array(
                            'name' => $nama,
                            'username' => $username,
                            'password' => password_hash($password, PASSWORD_BCRYPT),
                            'roleid' => '11',
                            'xcreate_date' => date('Y-m-d h:i:s'),
                            'xcreate_user' => $this->load->get_var('user_info')->username,
                            'id_regional' => '0',
                            'id_provinsi' => $id_provinsis
                        );

                            if ($upload) {
                                $result = $this->M_upload->insert_regional($upload);
                                $data1 = array(
                                    'keterangan' => 'create regional',
                                    'ket_waktu' => date('Y-m-d h:i:s'),
                                    'userid' => $this->load->get_var('user_info')->userid
                                );
                                $this->M_sekolah->log_activity($data1);
                                $counter_success++;
                            } else {
                                $counter_fail++;
                            }
                    }
                }
            }
            $result = array('success' => true, 'berhasil' => $counter_success, 'gagal' => $counter_fail);
        } else {
            $result = array('success' => false);
        }

        echo json_encode($result);
    }

    public function exceldown($jenis)
    {
        echo json_encode($jenis);
        force_download(APPPATH . 'third_party/download_' . $jenis . '.xlsx', NULL);
    }

}
