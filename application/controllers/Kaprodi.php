<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kaprodi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    admin_only();
    $this->load->model('M_kaprodi');
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['title'] = 'Kaprodi';
    $data['kaprodi'] = $this->M_kaprodi->get_all();
    $data['prodi'] = $this->M_kaprodi->get_prodi();
    $data['dosen'] = $this->M_kaprodi->get_dosen();
    template('kaprodi/index', $data);
  }

  public function add()
  {

    $this->form_validation->set_rules('prodi_id', 'Prodi', 'required');
    $this->form_validation->set_rules('id_dosen', 'Nama Dosen', 'required');
    $this->form_validation->set_rules('tahun_aktif', 'Tahun Aktif', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->template('kaprodi', $data);
    } else {
      $insert = [
        'prodi_id' => $this->input->post('prodi_id'),
        'id_dosen' => $this->input->post('id_dosen'),
        'tahun_aktif' => $this->input->post('tahun_aktif')
      ];
      $this->M_kaprodi->insert($insert);
      redirect('kaprodi');
    }
  }

  public function edit($id)
  {
    $data['k'] = $this->M_kaprodi->get_by_id($id);
    if (!$data['k']) redirect('kaprodi');
    $data['prodi'] = $this->M_kaprodi->get_prodi();
    $data['dosen'] = $this->M_kaprodi->get_dosen();

    $this->form_validation->set_rules('tahun_aktif', 'Tahun Aktif', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('kaprodi/edit', $data);
    } else {
      $update = [
        'prodi_id' => $this->input->post('prodi_id'),
        'id_dosen' => $this->input->post('id_dosen'),
        'tahun_aktif' => $this->input->post('tahun_aktif')
      ];
      $this->M_kaprodi->update($id, $update);
      redirect('kaprodi');
    }
  }

  public function delete($id)
  {
    $this->M_kaprodi->delete($id);
    redirect('kaprodi');
  }
}
