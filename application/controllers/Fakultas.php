<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fakultas extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('logged_in')) {
      redirect('login');
    }
    admin_only();
    $this->load->model('M_fakultas');
  }

  public function index()
  {
    $data = [
      'title' => 'Fakultas',
      'fakultas' => $this->M_fakultas->get_all(),
    ];

    template('fakultas/index', $data);
  }

  public function add()
  {
    $this->form_validation->set_rules('kode_fakultas', 'Kode Fakultas', 'required');
    $this->form_validation->set_rules('nama_fakultas', 'Nama Fakultas', 'required');
    $this->form_validation->set_rules('universitas', 'Universitas', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('fakultas');
    } else {
      $data = [
        'kode_fakultas' => $this->input->post('kode_fakultas'),
        'nama_fakultas' => $this->input->post('nama_fakultas'),
        'universitas' => $this->input->post('universitas')
      ];
      $this->M_fakultas->insert($data);
      set_alert('success', 'Sukses!', 'Data Fakultas berhasil ditambah.', 'toast');
      redirect('fakultas');
    }
  }

  public function edit($id)
  {
    $data['f'] = $this->M_fakultas->get_by_id($id);
    if (!$data['f']) redirect('fakultas');

    $this->form_validation->set_rules('kode_fakultas', 'Kode Fakultas', 'required');
    $this->form_validation->set_rules('nama_fakultas', 'Nama Fakultas', 'required');
    $this->form_validation->set_rules('universitas', 'Universitas', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('fakultas/edit', $data);
    } else {
      $update = [
        'kode_fakultas' => $this->input->post('kode_fakultas'),
        'nama_fakultas' => $this->input->post('nama_fakultas'),
        'universitas' => $this->input->post('universitas')
      ];
      $this->M_fakultas->update($id, $update);
      set_alert('success', 'Sukses!', 'Data Fakultas berhasil diperbarui.', 'both');
      redirect('fakultas');
    }
  }

  public function delete($id)
  {
    $this->M_fakultas->delete($id);
    set_alert('success', 'Sukses!', 'Data Fakultas berhasil dihapus.', 'toast');
    redirect('fakultas');
  }
}
