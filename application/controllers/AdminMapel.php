<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminMapel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') !== 'Admin Sekolah') {
            redirect('auth');
        }
        $this->load->model('AdminMapelModel');
        $this->load->model('AdminModel');
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $data['admin'] = $this->AdminModel->get_profil_admin($user_id);
        $data['title'] = 'Manajemen Mata Pelajaran';
        $data['mapel'] = $this->AdminMapelModel->get_all_mapel();

        $this->load->view('layouts/sidebar_admin', $data);
        $this->load->view('admin/mapel/index', $data);
    }

    public function hapus($mapel_id)
    {
        $hapus = $this->AdminMapelModel->delete_mapel($mapel_id);
        if ($hapus) {
            $this->session->set_flashdata('swal', ['icon' => 'success', 'title' => 'Dihapus', 'text' => 'Mata pelajaran berhasil dihapus.']);
        } else {
            $this->session->set_flashdata('swal', ['icon' => 'error', 'title' => 'Gagal', 'text' => 'Data gagal dihapus karena masih terikat pada jadwal/sesi.']);
        }
        redirect('adminmapel');
    }

    public function tambah()
    {
        $user_id = $this->session->userdata('user_id');
        $data['admin'] = $this->AdminModel->get_profil_admin($user_id);
        $data['title'] = 'Tambah Mata Pelajaran';

        $this->load->view('layouts/sidebar_admin', $data);
        $this->load->view('admin/mapel/form_tambah', $data);
    }

    public function simpan()
    {
        $nama_mapel = $this->input->post('nama_mapel', TRUE);

        $data = [
            'nama_mapel' => $nama_mapel
        ];

        $simpan = $this->AdminMapelModel->insert_mapel($data);
        if ($simpan) {
            $this->session->set_flashdata('swal', [
                'icon'  => 'success',
                'title' => 'Berhasil',
                'text'  => 'Mata pelajaran baru berhasil ditambahkan.'
            ]);
        } else {
            $this->session->set_flashdata('swal', [
                'icon'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Terjadi kesalahan sistem saat menyimpan data.'
            ]);
        }

        redirect('adminmapel');
    }

    public function edit($mapel_id)
    {
        $user_id = $this->session->userdata('user_id');
        $data['admin'] = $this->AdminModel->get_profil_admin($user_id);
        $data['title'] = 'Edit Mata Pelajaran';
        $data['mapel'] = $this->AdminMapelModel->get_mapel_by_id($mapel_id);

        if (!$data['mapel']) {
            show_error('Mata pelajaran tidak ditemukan.', 404);
        }

        $this->load->view('layouts/sidebar_admin', $data);
        $this->load->view('admin/mapel/form_edit', $data);
    }

    public function update()
    {
        $mapel_id   = $this->input->post('mapel_id', TRUE);
        $nama_mapel = $this->input->post('nama_mapel', TRUE);

        $data = [
            'nama_mapel' => $nama_mapel
        ];

        $update = $this->AdminMapelModel->update_mapel($mapel_id, $data);

        if ($update) {
            $this->session->set_flashdata('swal', [
                'icon'  => 'success',
                'title' => 'Berhasil',
                'text'  => 'Data mata pelajaran berhasil diperbarui.'
            ]);
        } else {
            $this->session->set_flashdata('swal', [
                'icon'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Terjadi kesalahan sistem saat memperbarui data.'
            ]);
        }

        redirect('adminmapel');
    }
}
