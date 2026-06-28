<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GuruModel extends CI_Model
{

    public function get_profil_guru($user_id)
    {
        $this->db->select('*');
        $this->db->from('guru');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->row_array();
    }

    public function get_daftar_sesi_guru($guru_id)
    {
        $this->db->select('sesi_absensi.*, mapel.nama_mapel, kelas.nama_kelas');
        $this->db->from('sesi_absensi');
        $this->db->join('mapel', 'mapel.id = sesi_absensi.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = sesi_absensi.kelas_id', 'left');
        $this->db->where('sesi_absensi.guru_id', $guru_id);
        $this->db->order_by('sesi_absensi.tanggal_sesi', 'DESC');
        $this->db->order_by('sesi_absensi.jam_mulai', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_semua_kelas()
    {
        $this->db->select('*');
        $this->db->from('kelas');
        $this->db->order_by('nama_kelas', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_semua_mapel()
    {
        $this->db->select('*');
        $this->db->from('mapel');
        $this->db->order_by('nama_mapel', 'ASC');
        return $this->db->get()->result_array();
    }

    public function insert_sesi_absensi($data)
    {
        return $this->db->insert('sesi_absensi', $data);
    }

    public function update_qr_token($sesi_id, $new_token)
    {
        $this->db->where('id', $sesi_id);
        return $this->db->update('sesi_absensi', ['qr_token_aktif' => $new_token]);
    }
}
