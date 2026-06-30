<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminSiswaModel extends CI_Model {

    public function get_all_siswa($kelas_id = null) {
        $this->db->select('siswa.*, users.username, kelas.nama_kelas');
        $this->db->from('siswa');
        $this->db->join('users', 'users.id = siswa.user_id', 'left');
        $this->db->join('kelas', 'kelas.id = siswa.kelas_id', 'left');
        
        if (!empty($kelas_id)) {
            $this->db->where('siswa.kelas_id', $kelas_id);
        }

        $this->db->order_by('kelas.nama_kelas', 'ASC');
        $this->db->order_by('siswa.nama_siswa', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_siswa_by_id($siswa_id) {
        $this->db->select('siswa.*, users.username');
        $this->db->from('siswa');
        $this->db->join('users', 'users.id = siswa.user_id', 'left');
        $this->db->where('siswa.id', $siswa_id);
        return $this->db->get()->row_array();
    }

    public function get_all_kelas() {
        $this->db->order_by('nama_kelas', 'ASC');
        return $this->db->get('kelas')->result_array();
    }

    public function insert_siswa($data_user, $data_siswa) {
        $this->db->trans_start();

        $this->db->insert('users', $data_user);
        $user_id = $this->db->insert_id();
        $data_siswa['user_id'] = $user_id;
        $this->db->insert('siswa', $data_siswa);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_siswa($siswa_id, $user_id, $data_siswa, $data_user) {
        $this->db->trans_start();

        $this->db->where('id', $siswa_id);
        $this->db->update('siswa', $data_siswa);
        $this->db->where('id', $user_id);
        $this->db->update('users', $data_user);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete_siswa($siswa_id, $user_id) {
        $this->db->trans_start();
        
        $this->db->where('id', $siswa_id);
        $this->db->delete('siswa');
        $this->db->where('id', $user_id);
        $this->db->delete('users');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}