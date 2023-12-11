<?php
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Memuat library database
    }

    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        return $query->row();
    }

    function getUsers()
    {
        $query = $this->db->get('users'); // Ganti "nama_tabel" dengan nama tabel yang sesuai
        return $query->result();
    }

    public function createPegawai($data)
    {
        $this->db->insert('users', $data); // 'pegawai' adalah nama tabel pegawai
        return $this->db->insert_id(); // Mengembalikan ID pegawai yang baru saja dibuat
    }

    public function getDataById($pegawai_id)
    {
        // Ambil data pegawai berdasarkan ID
        $this->db->where('users_id', $pegawai_id);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function updatePegawai($pegawai_id, $pegawai_data)
    {
        // Lakukan update data pegawai berdasarkan ID
        $this->db->where('users_id', $pegawai_id);
        $this->db->update('users', $pegawai_data);

        // Kembalikan status berhasil atau tidaknya update
        return ($this->db->affected_rows() > 0) ? true : false;
    }


    public function deletePegawai($pegawai_id)
    {
        // Hapus data pegawai berdasarkan ID
        $this->db->where('users_id', $pegawai_id);
        $this->db->delete('users');
    }

    public function getAllUsers()
    {
        $query = $this->db->get('users');
        return $query->result(); // Mengembalikan seluruh data pengguna sebagai array of objects
    }
    public function getUsersByRole($role) {
        $this->db->where('role', $role);
        return $this->db->get('users')->result();
    }
}
