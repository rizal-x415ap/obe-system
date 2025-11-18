<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Thnakademik_aktif extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_thnakademik_aktif', 'thnaktif');
    $this->load->library('session');
    $this->load->helper(['url', 'form']);

    if (!$this->session->userdata('logged_in')) {
      redirect('auth/login');
    }
  }

  // Halaman form update tahun akademik aktif
  public function index()
  {
    $current = $this->thnaktif->get_current();

    $data = [
      'title'   => 'Tahun Akademik Aktif',
      'current' => $current,
    ];

    template('thnakademik_aktif/index', $data);
  }

  // Proses update (POST)
  public function update()
  {
    // Biar aman: cek method POST
    if ($this->input->method() !== 'post') {
      redirect('thnakademik_aktif');
    }

    $id           = $this->input->post('id', TRUE);
    $thnakademik  = $this->input->post('Thnakademik', TRUE);
    $semester     = $this->input->post('Semester', TRUE);

    // Validasi simple
    if (empty($id) || empty($thnakademik) || empty($semester)) {
      $this->session->set_flashdata('error', 'Tahun akademik dan semester wajib diisi.');
      redirect('thnakademik_aktif');
    }

    $data_update = [
      'Thnakademik' => $thnakademik,
      'Semester'    => (int)$semester,
    ];

    $ok = $this->thnaktif->update_current($id, $data_update);

    if ($ok) {
      $this->session->set_flashdata('success', 'Tahun akademik aktif berhasil diperbarui.');
    } else {
      $this->session->set_flashdata('error', 'Gagal memperbarui tahun akademik aktif.');
    }

    redirect('thnakademik_aktif');
  }
}
