<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bk extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    admin_only();
    $this->load->model('M_bk');
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['bk'] = $this->M_bk->get_all();
    $data['prodi'] = $this->M_bk->get_prodi();
    $data['title'] = 'Bahan Kajian';
    template('bk/index', $data);
  }

  public function add()
  {

    $this->form_validation->set_rules('kodebk', 'Kode BK', 'required');
    $this->form_validation->set_rules('bahan_kajian', 'Nama Bahan Kajian', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('bk/index', $data);
    } else {
      $insert = [
        'kdprodi'      => $this->input->post('kdprodi'),
        'kodebk'       => $this->input->post('kodebk'),
        'bahan_kajian' => $this->input->post('bahan_kajian'),
        'deskripsi'    => $this->input->post('deskripsi')
      ];
      $this->M_bk->insert($insert);
      redirect('bk');
    }
  }

  public function edit($id)
  {
    $data['bk']     = $this->M_bk->get_by_id($id);
    $data['prodi']  = $this->M_bk->get_prodi();

    $this->form_validation->set_rules('kodebk', 'Kode BK', 'required');
    $this->form_validation->set_rules('bahan_kajian', 'Nama Bahan Kajian', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('bk/edit', $data);
    } else {
      $update = [
        'kdprodi'      => $this->input->post('kdprodi'),
        'kodebk'       => $this->input->post('kodebk'),
        'bahan_kajian' => $this->input->post('bahan_kajian'),
        'deskripsi'    => $this->input->post('deskripsi')
      ];
      $this->M_bk->update($id, $update);
      redirect('bk');
    }
  }

  public function delete($id)
  {
    $this->M_bk->delete($id);
    redirect('bk');
  }
}
