<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_upload extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    public function insert($table, $data){
        return $this->db->insert($table, $data);
    }

    public function delete($table, $where){
        return $this->db->delete($table, $where);
    }

    public function update($table, $data, $where){
        return $this->db->update($table, $data, $where);
    }

    public function insertbatch($table, $data){
        foreach ($data as $item) {
            $insert_query = $this->db->insert_string($table, $item);
            $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
            $this->db->query($insert_query);
        }
        return true;
    }

    public function getPengeluaran(){
        return $this->db->query("SELECT * FROM petty_cash WHERE tanggal 
            BETWEEN '".$this->getFirstDate()."' AND '".$this->getLastDate()."' ORDER BY created_date DESC");
    }

    public function getSumPengeluaran(){
        return $this->db->query("SELECT SUM(nominal) AS total FROM petty_cash WHERE tanggal 
            BETWEEN '".$this->getFirstDate()."' AND '".$this->getLastDate()."' ");
    }

    public function getPengeluaranMonth($month){
        return $this->db->query("SELECT * FROM petty_cash WHERE tanggal 
            BETWEEN '".date('Y-'.$month.'-01')."' AND '".date('Y-'.$month.'-t')."' 
            ORDER BY created_date DESC");
    }

    public function getSumPengeluaranMonth($month){
        return $this->db->query("SELECT SUM(nominal) AS total FROM petty_cash WHERE tanggal 
            BETWEEN '".date('Y-'.$month.'-01')."' AND '".date('Y-'.$month.'-t')."' ");
    }

    public function getPengeluaranById($id){
        $this->db->where('id', $id);
        return $this->db->get('petty_cash');
    }

    function getFirstDate(){
        return date('Y-m-01');
    }

    function getLastDate(){
        return date('Y-m-t');
    }

    function getDataSekolah($id_sekolah){
        $this->db->where('id_sekolah', $id_sekolah);
        return $this->db->get('master_sekolah');
    }

    function getDataOperator($nik){
        $this->db->where('nik', $nik);
        return $this->db->get('master_admin_sekolah');
    }

    function getDataOperatorRegion($id_sekolah){
        $this->db->where('id_sekolah', $id_sekolah);
        return $this->db->get('master_sekolah');
    }

    function getDataOperatorRegionProvinsi($id_region){
        $this->db->where('id_region', $id_region);
        return $this->db->get('master_region');
    }

    function getDataRegional($provinsi){
        $this->db->like('nm_provinsi', $provinsi, 'after');
        return $this->db->get('master_provinsi');
    }

    function getDataRegional2($region){
        $this->db->where('nama_region', $region);
        return $this->db->get('master_region');
    }

    function insert_regional($data)
	{
		$this->db->insert('dyn_user', $data);

		return true;
	}
}