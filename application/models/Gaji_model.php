<?php

class Gaji_model extends CI_Model
{
    // Mendapatkan data gaji berdasarkan users_id
    public function getGajiByUserId($users_id)
    {
        return $this->db->get_where('gaji', array('users_id' => $users_id))->row();
    }

    // Mendapatkan semua data gaji
    public function getAllGaji()
    {
        return $this->db->get('gaji')->result();
    }

    public function getAllGajiData()
    {
        $this->db->select('gaji.*, users.username'); // Pilih kolom yang dibutuhkan
        $this->db->from('gaji');
        $this->db->join('users', 'gaji.users_id = users.users_id'); // Lakukan JOIN dengan tabel users
        $query = $this->db->get();
        return $query->result();
    }

    // delete
    public function deleteGajiById($id)
    {
        // Hapus data gaji berdasarkan ID
        $this->db->where('id_gaji', $id);
        $this->db->delete('gaji');
    }

    // cek tanggal dan userid
    public function getGajiByTanggalAndUser($tanggal, $users_id)
    {
        $this->db->where('tanggal', $tanggal);
        $this->db->where('users_id', $users_id);
        return $this->db->get('gaji')->row();
    }
}
