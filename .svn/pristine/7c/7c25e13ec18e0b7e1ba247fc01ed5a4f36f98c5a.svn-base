<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Secure_area.php');

class Upload extends Secure_area
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
            'title' => 'Upload Data Siswa'
        );

        $this->load->view('master/mvupload', $data);
    }

    public function upload_siswa()
    {
        /*echo "<pre>";
        echo print_r($_POST);
        echo "</pre>";*/
        $counter_success = 0;
        $counter_fail = 0;
        if (isset($_FILES["fileSiswa"]["name"])) {

            $this->load->library('Excel');
            $upload = array();
            $path = $_FILES["fileSiswa"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();

                for ($row = 3; $row <= $highestRow; $row++) {
                    // $data_upload = explode(';', $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                    $nisn = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $npsn = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $no_hp = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $nama = $this->M_sekolah->cek_siswa($nisn)->row()->nama;
                    $get_nama = explode(" ", $nama);
                    $nama_pertama = $get_nama[0];
                    // data.namapertama + '_' +data.nisn_email + '@siswa.id
                    $nisn_email = substr($nisn, 3,10);
                    $email_alternatif = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $alamat = $this->M_sekolah->cek_siswa($nisn)->row()->alamat;
                    $no_orangtua = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $sex = $this->M_sekolah->cek_siswa($nisn)->row()->sex;
                    $email_orangtua = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $tgl_lahir = $this->M_sekolah->cek_siswa($nisn)->row()->tgl_lahir;
                    $nm_orangtua = $this->M_sekolah->cek_siswa($nisn)->row()->nama_orangtua;
                    $id_sekolah = $this->load->get_var("user_info")->id_sekolah;
                    $nama_sekolah = $this->M_upload->getDataSekolah($id_sekolah)->row()->nm_sekolah;
                    $id_regional = $this->M_upload->getDataSekolah($id_sekolah)->row()->id_region;
                    if ($nisn != '' || $nisn != null) {
                        $upload = array(
                            'nisn' => $nisn,
                            'npsn' => $npsn,
                            'nm_sekolah' => $nama_sekolah,
                            'nama' => $nama,
                            'email' => $nama_pertama . '.' . $nisn_email . '@siswa.id',
                            'email_alter' => $email_alternatif,
                            'nama_orangtua' => $nm_orangtua,
                            'no_orangtua' => $no_orangtua,
                            'email_orangtua' => $email_orangtua,
                            'alamat' => $alamat,
                            'sex' => $sex,
                            'tgl_lahir' => $tgl_lahir,
                            'id_sekolah' => $id_sekolah,
                            'id_region' => $id_regional,
                            'xcreate_user' => $this->load->get_var("user_info")->username,
                            'xcreate_date' => date('Y-m-d h:i:s'),
                            'id_region' => $id_regional,
                            'no_hp' => $no_hp
                        );

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, "http://10.10.22.41/zimbra-api/index.php/api/emailexist");
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, "emailaccount=" . $nama_pertama . '.' . $nisn_email . '@siswa.id');
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $result = curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        $response = ($httpCode == 200) ? true : false;
                        curl_close($ch);
                        if ($response) {
                            $counter_fail++;
                        } else {
                            // $result = json_encode(array('success' => false, 'msg' => 'Data Email Tidak Ditemukan'));

                            $ch2 = curl_init();

                            curl_setopt($ch2, CURLOPT_URL, "http://10.10.22.41/zimbra-api/index.php/api/createaccount");
                            curl_setopt($ch2, CURLOPT_POST, 1);
                            curl_setopt(
                                $ch2,
                                CURLOPT_POSTFIELDS,
                                "emailaddress=" . $nama_pertama . '.' . $nisn_email . "@siswa.id&sn=" . $nama . "&password=" . $npsn
                            );
                            curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

                            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

                            $result = curl_exec($ch2);
                            $httpCode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
                            $response = ($httpCode == 200) ? true : false;

                            curl_close($ch2);
                            if ($response) {
                                $result = $this->M_sekolah->insert_siswa($upload);
                                $data1 = array(
                                    'keterangan' => 'create email siswa',
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
            }
            $result = array('success' => true, 'berhasil' => $counter_success, 'gagal' => $counter_fail);
        } else {
            $result = array('success' => false);
        }

        echo json_encode($result);
    }

    function creteEmail($data_upload)
    {


        $ch = curl_init();
        foreach ($data_upload as $row  => $value) {
            print_r($value["email"]);
            curl_setopt($ch, CURLOPT_URL, "http://10.10.22.41/zimbra-api/index.php/api/emailexist");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "emailaccount=" . $this->input->post('email'));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $response = ($httpCode == 200) ? true : false;
        }
        die();




        curl_close($ch);
        if ($response) {
            $result = array('success' => false, 'msg' => 'Email Sudah Terdaftar!');
        } else {
            // $result = json_encode(array('success' => false, 'msg' => 'Data Email Tidak Ditemukan'));

            $ch2 = curl_init();

            curl_setopt($ch2, CURLOPT_URL, "http://10.10.22.41/zimbra-api/index.php/api/createaccount");
            curl_setopt($ch2, CURLOPT_POST, 1);
            curl_setopt(
                $ch2,
                CURLOPT_POSTFIELDS,
                "emailaddress=" . $this->input->post('email') . "&sn=" . $this->input->post('nama') . "&password=" . $this->input->post('npsn')
            );
            curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch2);
            $httpCode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
            $response = ($httpCode == 200) ? true : false;

            curl_close($ch2);
            if ($response) {
                $result = $this->M_sekolah->insert_siswa($data);
                $data1 = array(
                    'keterangan' => 'create email siswa',
                    'ket_waktu' => date('Y-m-d h:i:s'),
                    'userid' => $this->load->get_var('user_info')->userid
                );
                $this->M_sekolah->log_activity($data1);
                $result = array('success' => true, 'msg' => 'Email Berhasil Didaftarkan!');
            } else {
                $result = array('success' => false, 'msg' => 'Terjadi Masalah pada Server Email!');
            }
        }


        echo json_encode($result);
    }

    public function downloadah()
    {
        include APPPATH . 'third_party/PhpSpreadsheet/Spreadsheet.php';
        include APPPATH . 'third_party/PhpSpreadsheet/IOFactory.php';
        include APPPATH . 'third_party/PhpSpreadsheet/Helper/Sample.php';

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Maarten Balliauw')
            ->setLastModifiedBy('Maarten Balliauw')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');

        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

        // Miscellaneous glyphs, UTF-8
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="01simple.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function exceldown($jenis)
    {
        echo json_encode($jenis);
        force_download(APPPATH . 'third_party/download_' . $jenis . '.xlsx', NULL);
    }

    static function SaveViaTempFile($objWriter)
    {
        $filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
        $objWriter->save($filePath);
        readfile($filePath);
        unlink($filePath);
    }
}
