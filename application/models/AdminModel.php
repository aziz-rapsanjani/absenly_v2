<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_Model {

    public function get_profil_admin($user_id) {
        $this->db->select('id, username, role');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        return $this->db->get()->row_array();
    }

    public function get_total_guru() {
        return $this->db->count_all('guru');
    }

    public function get_total_siswa() {
        return $this->db->count_all('siswa');
    }

    public function get_total_kelas() {
        return $this->db->count_all('kelas');
    }

    public function get_total_sesi_hari_ini() {
        $this->db->where('tanggal_sesi', date('Y-m-d'));
        return $this->db->count_all_results('sesi_absensi');
    }

    public function get_sesi_aktif_hari_ini() {
        $this->db->select('sesi_absensi.*, guru.nama_guru, kelas.nama_kelas, mapel.nama_mapel');
        $this->db->from('sesi_absensi');
        $this->db->join('guru', 'guru.id = sesi_absensi.guru_id', 'left');
        $this->db->join('kelas', 'kelas.id = sesi_absensi.kelas_id', 'left');
        $this->db->join('mapel', 'mapel.id = sesi_absensi.mapel_id', 'left');
        $this->db->where('sesi_absensi.tanggal_sesi', date('Y-m-d'));
        $this->db->order_by('sesi_absensi.jam_mulai', 'DESC');
        $this->db->limit(5); 
        return $this->db->get()->result_array();
    }
}