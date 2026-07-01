<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminRekap extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'Admin Sekolah') {
            redirect('auth');
        }
        $this->load->model('AdminRekapModel');
        $this->load->model('AdminModel');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['admin'] = $this->AdminModel->get_profil_admin($user_id);
        $data['title'] = 'Rekap Kehadiran Siswa';

        $type     = $this->input->get('type', TRUE) ?? 'harian';
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $tanggal  = $this->input->get('tanggal', TRUE) ?? date('Y-m-d');
        $bulan    = $this->input->get('bulan', TRUE) ?? date('Y-m');

        $data['type_aktif']     = $type;
        $data['kelas_id_aktif'] = $kelas_id;
        $data['tanggal_aktif']  = $tanggal;
        $data['bulan_aktif']    = $bulan;

        $data['kelas'] = $this->AdminRekapModel->get_all_kelas();
        $data['rekap'] = [];

        if (!empty($kelas_id)) {
            if ($type === 'harian') {
                $data['rekap'] = $this->AdminRekapModel->get_rekap_harian($kelas_id, $tanggal);
            } elseif ($type === 'mingguan') {
                $data['rekap'] = $this->AdminRekapModel->get_rekap_mingguan($kelas_id, $tanggal);
            } elseif ($type === 'bulanan') {
                $data['rekap'] = $this->AdminRekapModel->get_rekap_bulanan($kelas_id, $bulan);
            }
        }
        $this->load->view('layouts/sidebar_admin', $data);
        $this->load->view('admin/rekap/index', $data);
    }
}