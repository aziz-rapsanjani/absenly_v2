<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Panelcontrol extends CI_Controller {
    
    public function __construct() {
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
    }

    public function detail($sesi_id = null) {
        $user_id = $this->session->userdata('user_id');
        $guru = $this->GuruModel->get_profil_guru($user_id);

        if (!$this->session->userdata('id_sesi_terbaru')) {
            $this->session->set_flashdata('swal', [
                'icon'  => 'error',
                'title' => 'Belum Ada Sesi',
                'text'  => 'Anda belum membuat sesi absensi satupun.'
            ]);
            redirect('guru');
        }

        if ($sesi_id !== null) {
            $data['title'] = 'Panel Kontrol Kehadiran';
            $data['guru'] = $guru;
            $data['sesi'] = $this->PanelcontrolModel->get_sesi_detail($sesi_id);
            if (!$data['sesi']) {
                show_error('Sesi tidak ditemukan', 404);
            }

            $data['presensi'] = $this->PanelcontrolModel->get_presensi_by_sesi($sesi_id, $data['sesi']['kelas_id']);

            $this->load->view('layouts/sidebar_guru', $data);
            $this->load->view('panelcontrol/panel_kontrol', $data);
        } else {
            redirect('guru');
        }
    }

    public function edit_presensi($siswa_id, $sesi_id) {
        $user_id = $this->session->userdata('user_id');
        $guru = $this->GuruModel->get_profil_guru($user_id);

        $data['title'] = 'Ubah Status Kehadiran';
        $data['guru'] = $guru;
        $data['sesi_id'] = $sesi_id;

        $data['detail'] = $this->PanelcontrolModel->get_detail_presensi_siswa($siswa_id, $sesi_id);

        if (!$data['detail']) {
            show_error('Data siswa tidak ditemukan', 404);
        }

        $this->load->view('layouts/sidebar_guru', $data);
        $this->load->view('panelcontrol/edit_presensi', $data);
    }

    public function update_presensi() {
        $presensi_id = $this->input->post('presensi_id');
        $siswa_id    = $this->input->post('siswa_id');
        $sesi_id     = $this->input->post('sesi_id');
        $kelas_id    = $this->input->post('kelas_id');
        $status      = $this->input->post('status', TRUE);
        $keterangan  = $this->input->post('keterangan', TRUE);

        $data_presensi = [
            'sesi_id'    => $sesi_id,
            'siswa_id'   => $siswa_id,
            'kelas_id'   => $kelas_id,
            'status'     => $status,
            'keterangan' => $keterangan
        ];

        date_default_timezone_set('Asia/Makassar'); 
        if (!$presensi_id) {
            $data_presensi['waktu_scan'] = date('Y-m-d H:i:s');
            $data_presensi['ip_siswa']   = 'Manual via Guru';
        }
        $simpan = $this->PanelcontrolModel->upsert_presensi($presensi_id, $data_presensi);

        if ($simpan) {
            $this->session->set_flashdata('swal', [
                'icon'  => 'success',
                'title' => 'Pembaruan Berhasil!',
                'text'  => 'Status kehadiran siswa telah tersimpan.'
            ]);
        } else {
            $this->session->set_flashdata('swal', [
                'icon'  => 'error',
                'title' => 'Gagal!',
                'text'  => 'Terjadi kesalahan saat menyimpan data.'
            ]);
        }
        redirect('panelcontrol/detail/' . $sesi_id);
    }
}