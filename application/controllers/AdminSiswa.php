<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminSiswa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'Admin Sekolah') {
            redirect('auth');
        }
        $this->load->model('AdminSiswaModel');
        $this->load->model('AdminModel');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = 'Manajemen Data Siswa';
        $data['admin'] = $this->AdminModel->get_profil_admin($user_id);
        
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $data['siswa'] = $this->AdminSiswaModel->get_all_siswa($kelas_id);
        $data['kelas'] = $this->AdminSiswaModel->get_all_kelas();
        $data['kelas_id_aktif'] = $kelas_id;

        $this->load->view('layouts/sidebar_admin', $data);
        $this->load->view('admin/siswa/index', $data);
    }

    public function hapus($siswa_id, $user_id) {
        $hapus = $this->AdminSiswaModel->delete_siswa($siswa_id, $user_id);
        if ($hapus) {
            $this->session->set_flashdata('swal', [
                'icon' => 'success',
                'title' => 'Dihapus',
                'text' => 'Data siswa beserta akun loginnya telah dihapus.'
            ]);
        } else {
            $this->session->set_flashdata('swal', [
                'icon' => 'error',
                'title' => 'Gagal',
                'text' => 'Data gagal dihapus.'
            ]);
        }
        redirect('adminsiswa');
    }

    public function tambah() {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = 'Tambah Data Siswa';
        $data['kelas'] = $this->AdminSiswaModel->get_all_kelas();
        $data['admin'] = $this->AdminModel->get_profil_admin($user_id);
        
        $this->load->view('layouts/sidebar_admin', $data);
        $this->load->view('admin/siswa/form_tambah', $data);
    }


    public function simpan() {
        $this->form_validation->set_rules('nisn', 'NISN', 'required|numeric|exact_length[10]|is_unique[siswa.nisn]', [
            'required' => 'NISN wajib diisi.',
            'numeric' => 'NISN hanya boleh berisi angka.',
            'exact_length' => 'NISN harus tepat berukuran 10 digit.',
            'is_unique' => 'NISN ini sudah terdaftar di sistem.'
        ]);

        $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required|trim|min_length[3]', [
            'required' => 'Nama lengkap siswa wajib diisi.',
            'min_length' => 'Nama terlalu pendek, minimal 3 karakter.'
        ]);

        $this->form_validation->set_rules('kelas_id', 'Kelas', 'required', [
            'required' => 'Silakan pilih kelas penempatan untuk siswa.'
        ]);

        $this->form_validation->set_rules('username', 'Username', 'required|trim|alpha_numeric|min_length[4]|is_unique[users.username]', [
            'required' => 'Username wajib diisi.',
            'alpha_numeric' => 'Username hanya boleh kombinasi huruf dan angka.',
            'min_length' => 'Username terlalu pendek, minimal 4 karakter.',
            'is_unique' => 'Username ini sudah digunakan.'
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]', [
            'required' => 'Password awal wajib diisi.',
            'min_length' => 'Password minimal berjumlah 6 karakter.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $user_id = $this->session->userdata('user_id');
            $data['title'] = 'Tambah Data Siswa';
            $data['kelas'] = $this->AdminSiswaModel->get_all_kelas();
            $data['admin'] = $this->AdminModel->get_profil_admin($user_id);

            $this->load->view('layouts/sidebar_admin', $data);
            $this->load->view('admin/siswa/form_tambah', $data);
            return;
        }

        $nisn = $this->input->post('nisn', TRUE);
        $nama_siswa = $this->input->post('nama_siswa', TRUE);
        $kelas_id = $this->input->post('kelas_id', TRUE);
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $data_user = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT), 
            'role' => 'Siswa'
        ];

        $data_siswa = [
            'nisn' => $nisn,
            'nama_siswa' => $nama_siswa,
            'kelas_id' => $kelas_id
        ];

        $simpan = $this->AdminSiswaModel->insert_siswa($data_user, $data_siswa);
        if ($simpan) {
            $this->session->set_flashdata('swal', [
                'icon' => 'success', 
                'title' => 'Berhasil', 
                'text'=> 'Data Siswa baru beserta akun login berhasil ditambahkan.'
            ]);
        } else {
            $this->session->set_flashdata('swal', [
                'icon' => 'error', 
                'title' => 'Gagal', 
                'text' => 'Terjadi kesalahan sistem saat menyimpan data siswa.'
            ]);
        }

        redirect('adminsiswa');
    }

    public function edit($siswa_id) {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = 'Edit Data Siswa';
        $data['siswa'] = $this->AdminSiswaModel->get_siswa_by_id($siswa_id);
        $data['kelas'] = $this->AdminSiswaModel->get_all_kelas(); 
        $data['admin'] = $this->AdminModel->get_profil_admin($user_id);
        
        if (!$data['siswa']) {
            show_error('Data siswa tidak ditemukan.', 404);
        }

        $this->load->view('layouts/sidebar_admin', $data);
        $this->load->view('admin/siswa/form_edit', $data);
    }

    public function update() {
        $siswa_id = $this->input->post('siswa_id', TRUE);
        $user_id = $this->input->post('user_id', TRUE);
        $nisn = $this->input->post('nisn', TRUE);
        $nama_siswa = $this->input->post('nama_siswa', TRUE);
        $kelas_id = $this->input->post('kelas_id', TRUE);
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $data_siswa = [
            'nisn' => $nisn,
            'nama_siswa' => $nama_siswa,
            'kelas_id' => $kelas_id
        ];
        
        $data_user = [
            'username' => $username
        ];

        if (!empty($password)) {
            $data_user['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $update = $this->AdminSiswaModel->update_siswa($siswa_id, $user_id, $data_siswa, $data_user);
        if ($update) {
            $this->session->set_flashdata('swal', [
                'icon' => 'success', 
                'title' => 'Berhasil', 
                'text' => 'Data Siswa berhasil diperbarui.'
            ]);
        } else {
            $this->session->set_flashdata('swal', [
                'icon' => 'error', 
                'title' => 'Gagal', 
                'text' => 'Terjadi kesalahan sistem saat memperbarui data.'
            ]);
        }
        
        redirect('adminsiswa');
    }
}