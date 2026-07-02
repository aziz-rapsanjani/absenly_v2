<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'Admin Sekolah') {
            $this->session->set_flashdata('swal', [
                'icon'  => 'error',
                'title' => 'Akses Ditolak',
                'text'  => 'Anda tidak memiliki hak akses sebagai Administrator!'
            ]);
            redirect('auth');
        }
        $this->load->model('AdminModel');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Dashboard';
        $data['admin'] = $this->AdminModel->get_profil_admin($user_id);

        $data['total_guru']  = $this->AdminModel->get_total_guru();
        $data['total_siswa'] = $this->AdminModel->get_total_siswa();
        $data['total_kelas'] = $this->AdminModel->get_total_kelas();
        $data['sesi_today']  = $this->AdminModel->get_total_sesi_hari_ini();

        $data['sesi_aktif']  = $this->AdminModel->get_sesi_aktif_hari_ini();

        $this->load->view('layouts/sidebar_admin', $data);
        $this->load->view('admin/dashboard', $data);
    }
}