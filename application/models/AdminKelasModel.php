<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminKelasModel extends CI_Model {

    public function get_all_kelas() {
        $this->db->select('kelas.*, guru.nama_guru AS nama_wali');
        $this->db->from('kelas');
        $this->db->join('guru', 'guru.id = kelas.guru_id', 'left');
        $this->db->order_by('kelas.nama_kelas', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_kelas_by_id($kelas_id) {
        $this->db->where('id', $kelas_id);
        return $this->db->get('kelas')->row_array();
    }

    public function get_all_guru() {
        $this->db->order_by('nama_guru', 'ASC');
        return $this->db->get('guru')->result_array();
    }

    public function insert_kelas($data) {
        return $this->db->insert('kelas', $data);
    }

    public function update_kelas($kelas_id, $data) {
        $this->db->where('id', $kelas_id);
        return $this->db->update('kelas', $data);
    }

    public function delete_kelas($kelas_id) {
        $this->db->where('id', $kelas_id);
        return $this->db->delete('kelas');
    }
}