<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('role') !== 'Siswa') {
            $this->session->set_flashdata('swal', [
                'icon' => 'error',
                'title' => 'Akses Ditolak',
                'text' => 'Anda Belum login!'
            ]);
            redirect('auth');
        }
        $this->load->model('SiswaModel');
    }

    public function index() {
    $user_id = $this->session->userdata('user_id');
    $siswa = $this->SiswaModel->get_profil_siswa($user_id);
    
    if (!$siswa) {
        show_error('Data profil siswa tidak ditemukan.', 404);
    }

    $sesi_aktif = $this->SiswaModel->get_sesi_aktif_siswa($siswa['kelas_id']);
    $data['siswa'] = $siswa;
    $data['sesi'] = $sesi_aktif;
    $this->load->view('siswa', $data);
    }

    public function proses_absen(){
        if(!$this->input->is_ajax_request()){
            exit('No direct script access allowed');
        }

        $token_qr = $this->input->post('token_qr', true);
        $user_id = $this->session->userdata('user_id');

        $profile = $this->SiswaModel->get_profil_siswa($user_id);
        $kelas_id = $profile['kelas_id'];
        $siswa_id = $profile['id'];
        $ip_siswa = $_SERVER['REMOTE_ADDR'];
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_siswa = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_siswa = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; 
        }

        $sesi = $this->SiswaModel->cek_sesi_aktif_by_token($token_qr, $kelas_id);
        if(!$sesi){
            echo json_encode([
                'status' => 'error',
                'swal' => [
                    'icon' => 'error',
                    'title' => 'Presensi Gagal',
                    'text' => 'QR Code tidak valid atau bukan jadwal kelas Anda!'
                ]
            ]);
            return;
        }

        if($sesi['is_hotspot_validation'] == 1){
            if($ip_siswa !== $sesi['ip_guru_aktif']){
                echo json_encode([
                    'status' => 'error',
                    'swal' => [
                        'icon' => 'warning',
                        'title' => 'Pelanggaran Jaringan',
                        'text' => 'Anda tidak terhubung ke Wi-Fi / Hotspot Guru di dalam kelas!'
                    ]
                ]);
                return;
            }
        }

        $sudah_absen = $this->SiswaModel->cek_double_input($sesi['id'], $siswa_id);
        if($sudah_absen > 0){
            echo json_encode([
                'status' => 'error',
                'swal' => [
                    'icon' => 'info',
                    'title' => 'Sudah Terdata',
                    'text' => 'Anda telah mengisi daftar hadir pada sesi mata pelajaran ini'
                ]
            ]);
            return;
        }

        date_default_timezone_set('Asia/Makassar');
        $waktu_sekarang = date('Y-m-d H:i:s'); 
        $time = time();
        $jam_mulai_sesi = date('Y-m-d') . ' ' . $sesi['jam_mulai']; 
        $toleransi_menit = 15;
        $batas_waktu_hadir =  strtotime($jam_mulai_sesi) + ($toleransi_menit * 60);

        if($time > $batas_waktu_hadir){
            $status = 'Terlambat';
            $keterangan_absen = 'Terlambat melakukan scan (Lebih dari 15 menit)';
        } else {
            $status = 'Hadir';
            $keterangan_absen = 'Hadir tepat waktu via Scan Mandiri';
        }

        $data_absen = [
            'sesi_id' => $sesi['id'],
            'siswa_id' => $siswa_id,
            'kelas_id' => $kelas_id,
            'waktu_scan' => $waktu_sekarang,
            'ip_siswa' => $ip_siswa,
            'status' => $status,
            'keterangan' => $keterangan_absen
        ];

        $simpan = $this->SiswaModel->insert_presensi($data_absen);
        if($simpan){
            echo json_encode([
                'status' => 'success',
                'swal' => [
                    'icon' => 'success',
                    'title' => 'Presensi Berhasil',
                    'text' => 'Kehadiran Anda berhasil dicata sistem'
                ]
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'swal' => [
                    'icon' => 'error',
                    'title' => 'Sistem Eror',
                    'text' => 'Gagal menyimpan data ke server. Coba dalam beberapa saat lagi'
                ]
            ]);
        }
    }
}
