<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminRekapModel extends CI_Model {
    public function get_all_kelas() {
        $this->db->order_by('nama_kelas', 'ASC');
        return $this->db->get('kelas')->result_array();
    }

    public function get_rekap_harian($kelas_id, $tanggal) {
        $this->db->select('siswa.id as siswa_id, siswa.nisn, siswa.nama_siswa, 
        presensi.id as presensi_id, presensi.status, presensi.waktu_scan, presensi.keterangan');
        $this->db->from('siswa');
        $this->db->join('presensi', "presensi.siswa_id = siswa.id AND DATE(presensi.waktu_scan) = " . $this->db->escape($tanggal), 'left');
        $this->db->where('siswa.kelas_id', $kelas_id);
        $this->db->order_by('siswa.nama_siswa', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_rekap_mingguan($kelas_id, $tanggal) {
        $start = date('Y-m-d', strtotime('monday this week', strtotime($tanggal)));
        $end   = date('Y-m-d', strtotime('saturday this week', strtotime($tanggal)));
        return $this->get_rekap_akumulatif($kelas_id, $start, $end);
    }

    public function get_rekap_bulanan($kelas_id, $bulan) {
        $start = $bulan . '-01';
        $end   = date('Y-m-t', strtotime($start));
        return $this->get_rekap_akumulatif($kelas_id, $start, $end);
    }

    private function get_rekap_akumulatif($kelas_id, $start_date, $end_date) {
        $this->db->select('
            siswa.id as siswa_id, 
            siswa.nisn, 
            siswa.nama_siswa,
            SUM(CASE WHEN LOWER(presensi.status) = "hadir" THEN 1 ELSE 0 END) as total_hadir,
            SUM(CASE WHEN LOWER(presensi.status) = "izin" THEN 1 ELSE 0 END) as total_izin,
            SUM(CASE WHEN LOWER(presensi.status) = "sakit" THEN 1 ELSE 0 END) as total_sakit,
            SUM(CASE WHEN LOWER(presensi.status) = "alpa" THEN 1 ELSE 0 END) as total_alpa
        ');
        $this->db->from('siswa');
        $this->db->join('presensi', "presensi.siswa_id = siswa.id AND DATE(presensi.waktu_scan) BETWEEN '$start_date' AND '$end_date'", 'left');
        $this->db->where('siswa.kelas_id', $kelas_id);
        $this->db->group_by('siswa.id');
        $this->db->order_by('siswa.nama_siswa', 'ASC');
        return $this->db->get()->result_array();
    }
}