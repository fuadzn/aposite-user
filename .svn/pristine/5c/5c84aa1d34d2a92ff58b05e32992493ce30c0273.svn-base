<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once("Secure_area.php");
class Beranda extends Secure_area {
	public function __construct() {
		parent::__construct();

		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('admin/M_sekolah','',TRUE);
		// $this->load->helper('pdf_helper');
	}
	
	public function index(){
		$data['title'] = 'Beranda';
		$prov = $this->load->get_var("user_info")->id_provinsi;
		$data['provinsi'] = $this->M_sekolah->get_provinsi()->result();
		$data['provinsi2'] = $this->M_sekolah->get_provinsi2($prov)->result();
		$data['region'] = $this->M_sekolah->get_region()->result();
		$user_id = $this->load->get_var("user_info")->userid;
		$role_id = $this->load->get_var("user_info")->roleid;
		$data['user'] = $this->M_sekolah->get_asal_sekolah($user_id,$role_id)->row();
		if($role_id==9){
			$data['region'] = $this->M_sekolah->get_region_by_id($data['user']->id_region)->row();
			$data['sekolah'] = $this->M_sekolah->get_sekolah_by_id_sekolah($data['user']->id_sekolah)->row();
			$this->load->view('beranda/index_sekolah',$data);
		}else {
			$data['sex'] = $this->M_sekolah->jns_kel($this->input->post('nama_region'),$this->input->post('nama_sekolah'))->result();
			$data['kel'] = $this->M_sekolah->jns_kel2($this->input->post('nama_region'))->result();
			$this->load->view('beranda/index',$data);
		}
		// print_r($this->load->get_var("user_info"));
		// print_r($data);
		//Array ( 
		//[title] => Beranda 
		//[region] => Array ( [0] => stdClass Object ( [id_region] => 1 [nama_region] => Bandung ) [1] => stdClass Object ( [id_region] => 2 [nama_region] => Bogor ) ) 
		//[user] => stdClass Object ( [id_sekolah] => [id_region] => ) )
		//
		//Array ( [title] => Beranda [region] => Array ( [0] => stdClass Object ( [id_region] => 1 [nama_region] => Bandung ) [1] => stdClass Object ( [id_region] => 2 [nama_region] => Bogor ) ) 
		//[user] => stdClass Object ( [id_sekolah] => [id_region] => 1 ) )
		//
		//Array ( [title] => Beranda [region] => Array ( [0] => stdClass Object ( [id_region] => 1 [nama_region] => Bandung ) [1] => stdClass Object ( [id_region] => 2 [nama_region] => Bogor ) ) 
		//[user] => stdClass Object ( [id_sekolah] => 3 [id_region] => 1 ) )
		//
		//
	}

	public function show_sekolah_by_region($id_region) {
		$role_id = $this->load->get_var("user_info")->roleid;
		if($role_id==10){
			$data['list_sekolah'] = $this->M_sekolah->get_sekolah_by_region_kota($id_region)->result();
		} else if($role_id == 11){
			$data['list_sekolah'] = $this->M_sekolah->get_sekolah_by_region_prov($id_region)->result();
		}else{
			$data['list_sekolah'] = $this->M_sekolah->get_sekolah_by_region($id_region)->result();
		}
		echo json_encode($data);
	}

	public function show_region_by_provinsi($id_provinsi) {
		$data['list_region'] = $this->M_sekolah->get_region_by_prov($id_provinsi)->result();
		echo json_encode($data);
	}

	public function get_filtered_siswa($id_region, $id_sekolah) {
		$line  = array();
        $line2 = array();
        $row2  = array();
		$i=1;
		$role_id = $this->load->get_var("user_info")->roleid;
		if($role_id==10){
			$hasil = $this->M_sekolah->get_filtered_siswa_kota($id_region,$id_sekolah)->result();
		} else if($role_id == 11){
			$hasil = $this->M_sekolah->get_filtered_siswa_prov($id_region,$id_sekolah)->result();
		} else{
			$hasil = $this->M_sekolah->get_filtered_siswa($id_region,$id_sekolah)->result();
		}
		foreach ($hasil as $value) {
            $row2['no'] = $i++;
            $row2['nisn'] = $value->nisn;
            $row2['nik'] = $value->nik;
            $row2['nama_region'] = $value->nama_region;
            $row2['nm_sekolah'] = $value->nm_sekolah;
            $row2['kelas'] = $value->kelas;
            $row2['nama'] = $value->nama;
            $row2['email'] = $value->email;
            $row2['email_alter'] = $value->email_alter;

            $line2[] = $row2;
        }
        $line['data'] = $line2;

        echo json_encode($line);
	}

	public function getCovid(){
		$ch = curl_init('https://indonesia-covid-19.mathdro.id/api/harian');
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);//json file
		curl_close($ch);
		if(($result == null )||($result == "" )){
			echo json_encode(array('success'=>false));
		}else{
	        $data_result = json_decode($result)->data;
	        $data_size = sizeof($data_result);
	        if($data_result[$data_size-1]->jumlahKasusKumulatif==null){
	        	$data_today = $data_result[$data_size-2];
	        }else{
	        	$data_today = $data_result[$data_size-1];
	        }
	        $data['jumlahKasusBaruperHari'] = $data_today->jumlahKasusBaruperHari;
	        $data['jumlahKasusSembuhperHari'] = $data_today->jumlahKasusSembuhperHari;
	        $data['jumlahKasusMeninggalperHari'] = $data_today->jumlahKasusMeninggalperHari;
	        $data['jumlahKasusDirawatperHari'] = $data_today->jumlahKasusDirawatperHari;
	        $data['jumlahKasusKumulatif'] = $data_today->jumlahKasusKumulatif;
	        $data['jumlahPasienSembuh'] = $data_today->jumlahPasienSembuh;
	        $data['jumlahPasienMeninggal'] = $data_today->jumlahPasienMeninggal;
	        $data['jumlahpasiendalamperawatan'] = $data_today->jumlahpasiendalamperawatan;
			echo json_encode(array('success'=>true,'tanggal'=>date('d-m-Y', $data_today->tanggal/1000),'data'=>$data));
		}
	}

	public function search($value='')
	{
		$arr = array();
		$cek = substr($value, 1);
		if($cek!="%"){
			$data = $this->db->from('data_pasien')->like('no_cm',$value)->
			where('id_klinik',$this->load->get_var("user_info")->id_klinik)->order_by('no_cm', 'ASC')->limit(12, 0)->get()->result();	

			$arr['listItems'] = [];
			foreach($data as $row){
				// $arr['query'] = $keyword;
				$arr['listItems'][] = array(
					'name'	=> $row->nama,
					'no_medrec'	=> $this->lib_encryp->encode($row->no_medrec),
					'no_cm'	=> $row->no_cm
				);
			}
		}

		echo json_encode($arr);
	}

	public function get_data_pendaftaran_by_region(){
		$region=$this->input->post('region');
		$role_id = $this->load->get_var("user_info")->roleid;
		if($role_id == 10){
			$datajson=$this->M_sekolah->get_data_pendaftar_by_region_kota($region)->result();
		} else if($role_id == 11){
			$datajson=$this->M_sekolah->get_data_pendaftar_by_region_prov($region)->result();
		} else{
			$datajson=$this->M_sekolah->get_data_pendaftar_by_region($region)->result();
		}
		$datachart="";
		$i=0;
		$sekolah = array();
		$siswa = array();
		foreach ($datajson as $row) {
			array_push($sekolah, $row->nm_sekolah);
			array_push($siswa, $row->siswa);
		}

	    echo json_encode(array(
	    					'succes' => true,
	    					'sekolah' => $sekolah,
	    					'siswa' => $siswa,
	    				));
	}

	public function get_data_pendaftaran_by_region2(){
		$region=$this->input->post('region');
		$role_id = $this->load->get_var("user_info")->roleid;
		if($role_id == 10){
			$datajson=$this->M_sekolah->jns_kel2_kota($region)->result();
		} else if($role_id == 11){
			$datajson=$this->M_sekolah->jns_kel2_prov($region)->result();
		} else{
			$datajson=$this->M_sekolah->jns_kel2($region)->result();
		}
		$datachart="";
		$dataColor = array();
		$dataset = array();
		$i=0;
		$pendaftar = array();
		foreach ($datajson as $row) {
			$color = '#'.$this->random_color();
			$pendaftar = array($row->laki, $row->perem);
			array_push($dataColor, $color);
		}

	    echo json_encode(array(
	    					'succes' => true,
	    					'pendaftar' => $pendaftar,
	    					'color' => $dataColor
	    				));
	}

	public function get_all_pendaftaran_by_region(){
		$region=$this->input->post('region');
		$role_id = $this->load->get_var("user_info")->roleid;
		if($role_id == 10){
			$datajson=$this->M_sekolah->get_all_pendaftar_by_region_kota($region)->result();
		} else if($role_id == 11){
			$datajson=$this->M_sekolah->get_all_pendaftar_by_region_prov($region)->result();
		} else{
			$datajson=$this->M_sekolah->get_all_pendaftar_by_region($region)->result();
		}
		$datachart="";
		$dataColor = array();
		$dataset=array();
		$i=0;
		$sekolah = array();
		$siswa = array();
		foreach ($datajson as $row) {
			$color = '#'.$this->random_color();
			array_push($sekolah, $row->nm_sekolah);
			array_push($siswa, $row->siswa);
			array_push($dataColor, $color);
		}

	    echo json_encode(array(
	    					'succes' => true,
	    					'sekolah' => $sekolah,
	    					'siswa' => $siswa,
	    					'color' => $dataColor
	    				));
	}
	public function get_perbandingan_pendaftaran(){
		$sekolah=$this->input->post('sekolah');
		$role_id = $this->load->get_var("user_info")->roleid;
		if($role_id == 10){
			$datajson=$this->M_sekolah->get_perbandingan_daftar_sekolah_kota($sekolah)->result();
		} else if($role_id == 11){
			$datajson=$this->M_sekolah->get_perbandingan_daftar_sekolah_prov($sekolah)->result();
		} else{
			$datajson=$this->M_sekolah->get_perbandingan_daftar_sekolah($sekolah)->result();
		}
		$datachart="";
		$dataColor = array();
		$dataset=array();
		$i=0;
		$pendaftar = array();
		foreach ($datajson as $row) {
			$color = '#'.$this->random_color();
			$pendaftar = array($row->daftar, $row->seluruh - $row->daftar);
			array_push($dataColor, $color);
		}

	    echo json_encode(array(
	    					'succes' => true,
	    					'pendaftar' => $pendaftar,
	    					'color' => $dataColor
	    				));
	}
	public function get_perbandingan_pendaftaran2(){
		$sekolah=$this->input->post('sekolah');
		$role_id = $this->load->get_var("user_info")->roleid;
		if($role_id == 10){
			$datajson=$this->M_sekolah->jns_kel_kota($sekolah)->result();
		} else if($role_id == 11){
			$datajson=$this->M_sekolah->jns_kel_prov($sekolah)->result();
		} else{
			$datajson=$this->M_sekolah->jns_kel($sekolah)->result();
		}
		$datachart="";
		$dataColor = array();
		$dataset=array();
		$i=0;
		$pendaftar = array();
		foreach ($datajson as $row) {
			$color = '#'.$this->random_color();
			$pendaftar = array($row->laki, $row->perem);
			array_push($dataColor, $color);
		}

	    echo json_encode(array(
	    					'succes' => true,
	    					'pendaftar' => $pendaftar,
	    					'color' => $dataColor
	    				));
	}
	public function get_all_pendaftaran_by_jenjang(){
		$region=$this->input->post('region');
		$role_id = $this->load->get_var("user_info")->roleid;
		if($role_id == 10){
			$datajson=$this->M_sekolah->get_all_pendaftar_by_jenjang_kota($region)->result();
		} else if($role_id == 11){
			$datajson=$this->M_sekolah->get_all_pendaftar_by_jenjang_prov($region)->result();
		} else{
			$datajson=$this->M_sekolah->get_all_pendaftar_by_jenjang($region)->result();
		}
		$datachart="";
		$i=0;
		$jenjang = array();
		$siswa = array();
		foreach ($datajson as $row) {
			array_push($jenjang, $row->jenjang);
			array_push($siswa, $row->siswa);
		}

	    echo json_encode(array(
	    					'succes' => true,
	    					'jenjang' => $jenjang,
	    					'jumlah_siswa' => $siswa,
	    				));
	}

	private function random_color_part() {
    	return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}

	private function random_color() {
	    return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
	}
}

?>