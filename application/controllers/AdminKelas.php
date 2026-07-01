<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminKelas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'Admin Sekolah') {
            redirect('auth/login');
        }
        $this->load->model('AdminKelasModel');
        $this->load->model('AdminModel');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['admin'] = $this->AdminModel->get_profil_admin($user_id);
        $data['title'] = 'Manajemen Data Kelas';
        $data['kelas'] = $this->AdminKelasModel->get_all_kelas();

        $this->load->view('layouts/sidebar_admin', $data);
        $this->load->view('admin/kelas/index', $data);
    }

    public function hapus($kelas_id) {
        $hapus = $this->AdminKelasModel->delete_kelas($kelas_id);
        if ($hapus) {
            $this->session->set_flashdata('swal', [
                'icon' => 'success', 
                'title' => 'Dihapus', 
                'text' => 'Data kelas berhasil dihapus.'
            ]);
        } else {
            $this->session->set_flashdata('swal', [
                'icon' => 'error', 
                'title' => 'Gagal', 
                'text' => 'Data gagal dihapus karena masih terikat data lain.'
            ]);
        }
        
        redirect('adminkelas');
    }

    public function tambah() {
        $user_id = $this->session->userdata('user_id');
        $data['admin'] = $this->AdminModel->get_profil_admin($user_id);
        $data['title'] = 'Tambah Data Kelas';
        $data['guru'] = $this->AdminKelasModel->get_all_guru();
        
        $this->load->view('layouts/sidebar_admin', $data);
        $this->load->view('admin/kelas/form_tambah', $data);
    }

    public function simpan() {
        $nama_kelas = $this->input->post('nama_kelas', TRUE);
        $guru_id = $this->input->post('guru_id', TRUE);
        $data_kelas = [
            'nama_kelas' => $nama_kelas,
            'guru_id' => !empty($guru_id) ? $guru_id : NULL
        ];

        $simpan = $this->AdminKelasModel->insert_kelas($data_kelas);
        if ($simpan) {
            $this->session->set_flashdata('swal', [
                'icon' => 'success', 
                'title' => 'Berhasil', 
                'text' => 'Data Kelas baru berhasil ditambahkan.'
            ]);
        } else {
            $this->session->set_flashdata('swal', [
                'icon' => 'error', 
                'title' => 'Gagal', 
                'text' => 'Terjadi kesalahan sistem saat menyimpan data kelas.'
            ]);
        }
        
        redirect('adminkelas');
    }

    public function edit($kelas_id) {
        $user_id = $this->session->userdata('user_id');
        $data['admin'] = $this->AdminModel->get_profil_admin($user_id);
        $data['title'] = 'Edit Data Kelas';
        $data['kelas'] = $this->AdminKelasModel->get_kelas_by_id($kelas_id);
        $data['guru'] = $this->AdminKelasModel->get_all_guru(); // Untuk Dropdown Wali Kelas
        
        if (!$data['kelas']) {
            show_error('Data kelas tidak ditemukan.', 404);
        }

        $this->load->view('layouts/sidebar_admin', $data);
        $this->load->view('admin/kelas/form_edit', $data);
    }

    public function update() {
        $kelas_id = $this->input->post('kelas_id', TRUE);
        $nama_kelas = $this->input->post('nama_kelas', TRUE);
        $guru_id = $this->input->post('guru_id', TRUE);

        $data_kelas = [
            'nama_kelas' => $nama_kelas,
            'guru_id'=> !empty($guru_id) ? $guru_id : NULL
        ];

        $update = $this->AdminKelasModel->update_kelas($kelas_id, $data_kelas);
        if ($update) {
            $this->session->set_flashdata('swal', [
                'icon' => 'success', 
                'title' => 'Berhasil', 
                'text' => 'Data Kelas berhasil diperbarui.'
            ]);
        } else {
            $this->session->set_flashdata('swal', [
                'icon' => 'error', 
                'title' => 'Gagal', 
                'text' => 'Terjadi kesalahan sistem saat memperbarui data kelas.'
            ]);
        }
        
        redirect('adminkelas');
    }
}