<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Danadesa_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_log = 'log_user';
    }

    function sum_danadesa($tahun, $bulan, $id_kabupaten = null)
    {
        $this->db->select_sum('alokasi');
        $this->db->select_sum('tahap1');
        $this->db->select_sum('tahap2');
        $this->db->select_sum('tahap3');
        $this->db->select_sum('total_realisasi');
        $this->db->where(['tahun' => $tahun, 'bulan' => $bulan]);
        if ($id_kabupaten != null) {
            $this->db->where('id_kabupaten', $id_kabupaten);
        }
        return $this->db->get('tbl_dana_desa')->row_array();
    }

    function sum_jumlahdesa($tahun, $bulan, $id_kabupaten = null)
    {
        $this->db->select_sum('desa');
        $this->db->select_sum('desa1');
        $this->db->select_sum('desa2');
        $this->db->select_sum('desa3');
        $this->db->select_sum('belum1');
        $this->db->select_sum('belum2');
        $this->db->select_sum('belum3');
        $this->db->where(['tahun' => $tahun, 'bulan' => $bulan]);
        if ($id_kabupaten != null) {
            $this->db->where('id_kabupaten', $id_kabupaten);
        }
        return $this->db->get('tbl_dana_desa')->row_array();
    }
}
