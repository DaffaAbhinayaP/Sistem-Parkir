<?php

class Laporan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Memuat library database
    }

    public function getLaporanPendapatanByHari($hari)
    {
        $this->db->select('parkir_keluar.kode_karcis, parkir_keluar.waktu_keluar, parkir_keluar.durasi_parkir, parkir_keluar.harga');
        $this->db->from('parkir_keluar');
        $this->db->join('parkir_masuk', 'parkir_masuk.id_masuk = parkir_keluar.id_masuk');
        $this->db->where('DAY(parkir_masuk.tanggal_masuk)', date('d', strtotime($hari)));
        $query = $this->db->get();
        return $query->result();
    }


    public function getPilihanHari()
    {
        $this->db->select("DAY(waktu_keluar) AS hari");
        $this->db->from('parkir_keluar');
        $this->db->group_by("DAY(waktu_keluar)");
        $query = $this->db->get();
        $parkirKeluarHari = $query->result();

        $this->db->select("DAY(tanggal_masuk) AS hari");
        $this->db->from('parkir_masuk');
        $this->db->group_by("DAY(tanggal_masuk)");
        $query = $this->db->get();
        $parkirMasukHari = $query->result();

        $pilihanHari = array();

        foreach ($parkirKeluarHari as $hari) {
            $pilihanHari[$hari->hari] = $hari->hari;
        }

        foreach ($parkirMasukHari as $hari) {
            $pilihanHari[$hari->hari] = $hari->hari;
        }

        return $pilihanHari;
    }


    public function getLaporanPendapatanByBulan($bulan)
    {
        $this->db->select('*');
        $this->db->from('parkir_keluar');
        $this->db->join('parkir_masuk', 'parkir_masuk.id_masuk = parkir_keluar.id_masuk');
        $this->db->where('MONTH(parkir_masuk.tanggal_masuk)', $bulan);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPilihanBulan()
    {
        $this->db->select("MONTH(waktu_keluar) AS bulan");
        $this->db->from('parkir_keluar');
        $this->db->group_by("MONTH(waktu_keluar)");
        $query = $this->db->get();
        $parkirKeluarBulan = $query->result();

        $this->db->select("MONTH(tanggal_masuk) AS bulan");
        $this->db->from('parkir_masuk');
        $this->db->group_by("MONTH(tanggal_masuk)");
        $query = $this->db->get();
        $parkirMasukBulan = $query->result();

        $pilihanBulan = array();

        foreach ($parkirKeluarBulan as $bulan) {
            $pilihanBulan[$bulan->bulan] = date('F', mktime(0, 0, 0, $bulan->bulan, 1));
        }

        foreach ($parkirMasukBulan as $bulan) {
            $pilihanBulan[$bulan->bulan] = date('F', mktime(0, 0, 0, $bulan->bulan, 1));
        }

        return $pilihanBulan;
    }
}
