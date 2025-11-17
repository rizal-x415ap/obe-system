<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dosen extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    admin_only();
    $this->load->model('M_dosen');
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['dosen'] = $this->M_dosen->get_all();
    $data['fakultas'] = $this->M_dosen->get_fakultas();
    $data['prodi'] = $this->M_dosen->get_prodi();
    template('dosen/index', $data);
  }

  public function add()
  {
    $this->form_validation->set_rules('nidn', 'NIDN', 'required');
    $this->form_validation->set_rules('nama_dosen', 'Nama Dosen', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    if ($this->form_validation->run() == FALSE) {
      template('dosen', $data);
    } else {
      $nidn = $this->input->post('nidn');

      if ($this->M_dosen->cekNidnExists($nidn)) {
        set_alert('error', 'Gagal!', 'NIDN sudah terdaftar, gunakan NIDN lain.', 'swal');
        redirect('dosen');
        return;
      }

      $insert = [
        'nidn' => $nidn,
        'nama_dosen' => $this->input->post('nama_dosen'),
        'email' => $this->input->post('email'),
        'fakultas_id' => $this->input->post('fakultas_id'),
        'prodi_id' => $this->input->post('prodi_id')
      ];

      if ($this->M_dosen->insert($insert)) {
        set_alert('success', 'Sukses!', 'Dosen berhasil ditambahkan.', 'toast');
      } else {
        set_alert('error', 'Gagal!', 'Gagal menambah dosen.', 'swal');
      }

      redirect('dosen');
    }
  }




  public function edit($id)
  {
    $data['d'] = $this->M_dosen->get_by_id($id);
    if (!$data['d']) redirect('dosen');
    $data['fakultas'] = $this->M_dosen->get_fakultas();
    $data['prodi'] = $this->M_dosen->get_prodi();

    $this->form_validation->set_rules('nidn', 'NIDN', 'required');
    $this->form_validation->set_rules('nama_dosen', 'Nama Dosen', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('dosen/edit', $data);
    } else {
      $update = [
        'nidn' => $this->input->post('nidn'),
        'nama_dosen' => $this->input->post('nama_dosen'),
        'email' => $this->input->post('email'),
        'fakultas_id' => $this->input->post('fakultas_id'),
        'prodi_id' => $this->input->post('prodi_id')
      ];
      $this->M_dosen->update($id, $update);
      redirect('dosen');
    }
  }

  public function delete($id)
  {
    $this->M_dosen->delete($id);
    redirect('dosen');
  }
}
