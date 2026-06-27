<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') !== 'Guru') {
            $this->session->set_flashdata('swal', [
                'icon'  => 'error',
                'title' => 'Akses Ditolak',
                'text'  => 'Anda tidak memiliki hak akses Guru!'
            ]);
            redirect('auth');
        }
        $this->load->model('GuruModel');
        $this->load->model('PanelcontrolModel');
        $this->load->model('AdminRekapModel');
    }
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $guru = $this->GuruModel->get_profil_guru($user_id);

        $sesi_tratas = $this->GuruModel->get_daftar_sesi_guru(($guru['id']));
        if ($sesi_tratas) {
            $this->session->set_userdata('id_sesi_terbaru', $sesi_tratas[0]['id']);
        }

        $data['title'] = 'Dashboard Guru';
        $data['guru'] = $guru;
        $data['daftar_sesi'] = $this->GuruModel->get_daftar_sesi_guru($guru['id']);

        $this->load->view('layouts/sidebar_guru', $data);
        $this->load->view('guru/index', $data);
    }

    public function tambah_sesi()
    {
        $user_id = $this->session->userdata('user_id');
        $guru = $this->GuruModel->get_profil_guru($user_id);

        $data['title'] = 'Tambah Sesi Absensi';
        $data['guru']  = $guru;

        $data['kelas'] = $this->GuruModel->get_semua_kelas();
        $data['mapel'] = $this->GuruModel->get_semua_mapel();

        $this->load->view('layouts/sidebar_guru', $data);
        $this->load->view('guru/form', $data);
    }

    public function simpan_sesi()
    {
        $user_id = $this->session->userdata('user_id');
        $guru = $this->GuruModel->get_profil_guru($user_id);

        $mapel_id     = $this->input->post('mapel_id', TRUE);
        $kelas_id     = $this->input->post('kelas_id', TRUE);
        $tanggal_sesi = $this->input->post('tanggal_sesi', TRUE);
        $jam_mulai    = $this->input->post('jam_mulai', TRUE);

        $is_hotspot_validation = $this->input->post('is_hotspot_validation') ? 1 : 0;

        $qr_token_aktif = bin2hex(random_bytes(16));

        $ip_guru_aktif = $_SERVER['REMOTE_ADDR'];

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_guru_aktif = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_guru_aktif = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }

        $data_sesi = array(
            'guru_id'               => $guru['id'],
            'kelas_id'              => $kelas_id,
            'mapel_id'              => $mapel_id,
            'tanggal_sesi'          => $tanggal_sesi,
            'jam_mulai'             => $jam_mulai,
            'qr_token_aktif'        => $qr_token_aktif,
            'is_hotspot_validation' => $is_hotspot_validation,
            'ip_guru_aktif'         => $ip_guru_aktif
        );

        $simpan = $this->GuruModel->insert_sesi_absensi($data_sesi);
        if ($simpan) {
            $this->session->set_flashdata('swal', [
                'icon'  => 'success',
                'title' => 'Sesi Berhasil Dibuat!',
                'text'  => 'Sesi absensi baru telah berhasil ditambahkan dan siap digunakan.'
            ]);
            $daftar_sesi = $this->GuruModel->get_daftar_sesi_guru($guru['id']);
            $this->session->set_userdata('id_sesi_terbaru', $daftar_sesi[0]['id']);
        } else {
            $this->session->set_flashdata('swal', [
                'icon'  => 'error',
                'title' => 'Gagal Menyimpan',
                'text'  => 'Terjadi kesalahan pada sistem saat menyimpan sesi.'
            ]);
        }

        redirect('guru');
    }

    public function tampilkan_qr($sesi_id)
    {
        if ($this->session->userdata('role') !== 'Guru') {
            redirect('auth');
        }

        $data['sesi'] = $this->PanelcontrolModel->get_sesi_detail($sesi_id);

        if (!$data['sesi']) {
            show_error('Maaf, sesi absensi tidak ditemukan.', 404);
        }

        $this->load->view('guru/tampil_qr', $data);
    }

    public function perbarui_token_qr()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $sesi_id = $this->input->post('sesi_id', TRUE);
        if (!$sesi_id) {
            echo json_encode(['status' => 'error', 'message' => 'Sesi ID Kosong']);
            return;
        }

        $new_token = bin2hex(random_bytes(16));

        $update = $this->GuruModel->update_qr_token($sesi_id, $new_token);

        if ($update) {
            echo json_encode([
                'status' => 'success',
                'token'  => $new_token
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal memperbarui database'
            ]);
        }
    }
}
