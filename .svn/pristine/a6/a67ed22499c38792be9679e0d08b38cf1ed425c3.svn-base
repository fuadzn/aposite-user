<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Secure_area.php');

class Upload_operator extends Secure_area
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
            'title' => 'Upload Data Operator Sekolah'
        );

        $this->load->view('master/mvupload_operator', $data);
    }

    public function upload_operator()
    {
        /*echo "<pre>";
        echo print_r($_POST);
        echo "</pre>";*/
        $counter_success = 0;
        $counter_fail = 0;
        if (isset($_FILES["fileOperator"]["name"])) {

            $this->load->library('Excel');
            $upload = array();
            $path = $_FILES["fileOperator"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();

                for ($row = 3; $row <= $highestRow; $row++) {
                    // $data_upload = explode(';', $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                    $nik = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $npsn = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $nama = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $sekolah = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $email = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $no_hp = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $password = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $nuptk = $this->M_upload->getDataOperator($nik)->row()->nuptk;
                    $tgl_lahir = $this->M_upload->getDataOperator($nik)->row()->tgl_lahir;
                    $id_sekolah = $this->M_upload->getDataOperator($nik)->row()->id_sekolah;
                    $id_region = $this->M_upload->getDataOperatorRegion($id_sekolah)->row()->id_region;
                    $id_provinsi = $this->M_upload->getDataOperatorRegionProvinsi($id_region)->row()->id_provinsi;
                    if ($nik != '' || $nik != null) {
                        $upload = array(
                            'nik' => $nik,
                            'npsn' => $npsn,
                            'nama' => $nama,
                            'sekolah' => $sekolah,
                            'email' => $email,
                            'no_hp' => $no_hp,
                            'password' => $password,
                            'statuss' => '1',
                            'nuptk' => $nuptk,
                            'tgl_lahir' => $tgl_lahir,
                            'id_sekolah' => $id_sekolah,
                            'id_region' => $id_region,
                            'id_provinsi' => $id_provinsi
                        );

                        $upload2 = array(
                            'name' => $nama,
                            'username' => $nuptk,
                            'password' => password_hash($password, PASSWORD_BCRYPT),
                            'roleid' => '9',
                            'id_sekolah' => $id_sekolah,
                            'xcreate_date' => date('Y-m-d h:i:s'),
                            'xcreate_user' => $this->load->get_var('user_info')->username,
                            'id_regional' => $id_region,
                            'id_provinsi' => $id_provinsi
                        );

                            if ($upload) {

                                $result = $this->M_sekolah->insert_sekolah($upload);
                                $result = $this->M_sekolah->insert_sekolah_user($upload2);
                                $data1 = array(
                                    'keterangan' => 'create operator sekolah',
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
