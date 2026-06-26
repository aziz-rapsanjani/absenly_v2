<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class PanelcontrolModel extends CI_Model {

    public function get_sesi_detail($sesi_id) {
        $this->db->select('sesi_absensi.*, mapel.nama_mapel, kelas.nama_kelas');
        $this->db->from('sesi_absensi');
        $this->db->join('mapel', 'mapel.id = sesi_absensi.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = sesi_absensi.kelas_id', 'left');
        $this->db->where('sesi_absensi.id', $sesi_id);
        return $this->db->get()->row_array();
    }

    public function get_presensi_by_sesi($sesi_id, $kelas_id) {
    $this->db->select('
        siswa.id as siswa_id, 
        siswa.nisn, 
        siswa.nama_siswa, 
        kelas.nama_kelas, 
        presensi.id as presensi_id, 
        presensi.status, 
        presensi.keterangan, 
        presensi.waktu_scan
    ');
    $this->db->from('siswa');
    $this->db->join('kelas', 'kelas.id = siswa.kelas_id', 'left');

    $this->db->join('presensi', 'presensi.siswa_id = siswa.id AND presensi.sesi_id = ' . intval($sesi_id), 'left');
    $this->db->where('siswa.kelas_id', $kelas_id);
    $this->db->order_by('siswa.nama_siswa', 'ASC');
    return $this->db->get()->result_array();
    }

    public function get_detail_presensi_siswa($siswa_id, $sesi_id) {
        $this->db->select('
            siswa.id as siswa_id, 
            siswa.nisn, 
            siswa.nama_siswa, 
            kelas.nama_kelas,
            kelas.id as kelas_id,
            presensi.id as presensi_id, 
            presensi.status, 
            presensi.keterangan
        ');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.id = siswa.kelas_id', 'left');
        $this->db->join('presensi', 'presensi.siswa_id = siswa.id AND presensi.sesi_id = ' . intval($sesi_id), 'left');
        $this->db->where('siswa.id', $siswa_id);
        return $this->db->get()->row_array();
    }

    public function upsert_presensi($presensi_id, $data) {
        if ($presensi_id) {
            $this->db->where('id', $presensi_id);
            return $this->db->update('presensi', $data);
        } else {
            return $this->db->insert('presensi', $data);
        }
    }
}