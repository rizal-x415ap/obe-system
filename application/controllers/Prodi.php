<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prodi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    admin_only();
    $this->load->model('M_prodi');
  }

  public function index()
  {
    $data = [
      'title' => 'Prodi',
      'prodi' => $this->M_prodi->get_all(),
      'fakultas' => $this->M_prodi->get_fakultas(),
    ];
    template('prodi/index', $data);
  }

  public function add()
  {
    $data['fakultas'] = $this->M_prodi->get_fakultas();

    $this->form_validation->set_rules('kode_prodi', 'Kode Prodi', 'required');
    $this->form_validation->set_rules('nama_prodi', 'Nama Prodi', 'required');
    $this->form_validation->set_rules('fakultas_id', 'Fakultas', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('prodi', $data);
    } else {
      $insert = [
        'kode_prodi' => $this->input->post('kode_prodi'),
        'nama_prodi' => $this->input->post('nama_prodi'),
        'fakultas_id' => $this->input->post('fakultas_id'),
        'jenjang' => $this->input->post('jenjang'),
        'akreditasi' => $this->input->post('akreditasi')
      ];
      $this->M_prodi->insert($insert);
      set_alert('success', 'Sukses!', 'Data Prodi berhasil ditambahkan.', 'toast');
      redirect('prodi');
    }
  }

  public function edit($id)
  {
    $data['fakultas'] = $this->M_prodi->get_fakultas();
    $data['p'] = $this->M_prodi->get_by_id($id);
    if (!$data['p']) redirect('prodi');

    $this->form_validation->set_rules('kode_prodi', 'Kode Prodi', 'required');
    $this->form_validation->set_rules('nama_prodi', 'Nama Prodi', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('prodi/edit', $data);
    } else {
      $update = [
        'kode_prodi' => $this->input->post('kode_prodi'),
        'nama_prodi' => $this->input->post('nama_prodi'),
        'fakultas_id' => $this->input->post('fakultas_id'),
        'jenjang' => $this->input->post('jenjang'),
        'akreditasi' => $this->input->post('akreditasi')
      ];
      $this->M_prodi->update($id, $update);
      set_alert('success', 'Sukses!', 'Data Prodi berhasil diperbarui.', 'both');
      redirect('prodi');
    }
  }

  public function delete($id)
  {
    $this->M_prodi->delete($id);
    set_alert('success', 'Sukses!', 'Data Prodi berhasil dihapus.', 'swal');
    redirect('prodi');
  }
}
