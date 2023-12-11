<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Laporan_model');
		$user = $this->session->userdata('user');
		if (!$user) {
			redirect('login');
		}
	}


	//laporan Harian
	public function laporanHarian()
	{
		$data['pilihanHari'] = $this->Laporan_model->getPilihanHari();
		$this->template->load('layouts/template', 'laporan/laporanHarian', $data);
	}

	public function generateLaporanHarian()
	{
		// Load library DOMPDF
		$this->load->library('pdf');

		// Ambil nilai hari dari formulir
		$hari = $this->input->post('hari');

		// Panggil model untuk mendapatkan data laporan berdasarkan hari
		$data['laporan'] = $this->Laporan_model->getLaporanPendapatanByHari($hari);
		$data['hari'] = $hari;

		// Load view laporan
		$html = $this->load->view('laporan/laporan_pendapatanHari', $data, true);

		// Konversi view HTML ke PDF
		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'portrait');
		$this->pdf->render();

		// Output file PDF ke browser
		$this->pdf->stream('laporan_pendapatanHari.pdf', array('Attachment' => false));
	}





	// laporan BULANAN
	public function laporanBulanan()
	{
		$data['pilihanBulan'] = $this->Laporan_model->getPilihanBulan();
		$this->template->load('layouts/template', 'laporan/laporanBulanan', $data);
	}

	public function generateLaporanBulanan()
	{
		// Load library DOMPDF

		// require_once "lib/dompdf/dompdf_config.inc.php";
		$this->load->library('pdf');
		// Ambil nilai bulan dari formulir
		$bulan = $this->input->post('bulan');

		// Panggil model untuk mendapatkan data laporan berdasarkan bulan
		$data['laporan'] = $this->Laporan_model->getLaporanPendapatanByBulan($bulan);
		$data['bulan'] = $bulan;

		// Load view laporan
		$html = $this->load->view('laporan/laporan_pendapatan', $data, true);

		// Konversi view HTML ke PDF
		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'portrait');
		$this->pdf->render();

		// Output file PDF ke browser
		$this->pdf->stream('laporan_pendapatan.pdf', array('Attachment' => false));
	}
}
