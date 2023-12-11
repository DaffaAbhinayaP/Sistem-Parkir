<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gaji extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gaji_model');
        $this->load->model('User_model');
    }

    public function index()
    {
        // Mendapatkan semua data users untuk dropdown
        $data['users'] = $this->User_model->getAllUsers();
        $data['umr'] = 4500000;
        $data['users_pegawai'] = $this->User_model->getUsersByRole('pegawai');
        $data['gajiData'] = $this->Gaji_model->getAllGajiData();
        $this->template->load('layouts/template', 'gaji/index', $data);
        // $this->load->view('input_gaji', $data);
    }
    public function insertGaji()
    {
        // Load library form validation
        $this->load->library('form_validation');

        // Set aturan validasi untuk masing-masing field
        $this->form_validation->set_rules('users_id', 'User ID', 'required');
        $this->form_validation->set_rules('gaji_pokok', 'Gaji Pokok', 'required|numeric');
        $this->form_validation->set_rules('uang_makan', 'Uang Makan', 'required|numeric');
        $this->form_validation->set_rules('uang_transport', 'Uang Transport', 'required|numeric');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');

        // Cek apakah data yang diinput sudah sesuai dengan aturan validasi
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan pesan error
            $this->load->view('input_gaji'); // Ganti 'input_gaji' dengan nama view yang sesuai
        } else {
            // Jika validasi berhasil, lanjutkan dengan menyimpan data gaji
            $users_id = $this->input->post('users_id');
            $gaji_pokok = $this->input->post('gaji_pokok');
            $uang_makan = $this->input->post('uang_makan');
            $uang_transport = $this->input->post('uang_transport');
            $tanggal = $this->input->post('tanggal');

            $existingData = $this->Gaji_model->getGajiByTanggalAndUser($tanggal, $users_id);

            if ($existingData) {
                $this->session->set_flashdata('error_message', 'Data dengan tanggal dan bulan yang sama sudah ada.');
                redirect('gaji');
            } else {
                $data = array(
                    'users_id' => $users_id,
                    'gaji_pokok' => $gaji_pokok,
                    'uang_makan' => $uang_makan,
                    'uang_transport' => $uang_transport,
                    'tanggal' => $tanggal
                );

                // Simpan nilai gaji ke dalam tabel gaji
                $this->db->insert('gaji', $data);

                // Redirect ke halaman input gaji
                redirect('gaji/index');
            }
        }
    }

    public function deleteGaji($id)
    {
        // Panggil model untuk menghapus data gaji berdasarkan ID
        $this->Gaji_model->deleteGajiById($id);

        // Redirect kembali ke halaman gaji setelah berhasil menghapus data
        redirect('gaji/index');
    }
}
