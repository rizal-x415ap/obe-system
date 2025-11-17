<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cpmk extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    admin_only();
    $this->load->model('M_cpmk');
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['grouped'] = $this->M_cpmk->get_all_grouped();
    $data['title'] = 'Indikator CPL';
    $data['cpl'] = $this->M_cpmk->get_cpl();
    $data['mk']  = $this->M_cpmk->get_mk();
    template('cpmk/index_grouped', $data);
  }

  public function add()
  {

    $this->form_validation->set_rules('kodecpmk', 'Kode CPMK', 'required');
    $this->form_validation->set_rules('cpmk', 'Deskripsi CPMK', 'required');
    $this->form_validation->set_rules('bobot', 'Bobot', 'required|integer');
    $this->form_validation->set_rules('idcpl', 'CPL', 'required');
    $this->form_validation->set_rules('id_mk', 'Mata Kuliah', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('cpmk/add', $data);
    } else {
      $insert = [
        'id_mk' => $this->input->post('id_mk'),
        'kodecpmk' => $this->input->post('kodecpmk'),
        'cpmk' => $this->input->post('cpmk'),
        'bobot' => $this->input->post('bobot')
      ];
      $idcpmk = $this->M_cpmk->insert_cpmk($insert);
      $this->M_cpmk->insert_mapping($this->input->post('idcpl'), $idcpmk);
      redirect('cpmk');
    }
  }

  public function edit($id)
  {
    $data['title'] = 'Edit Indikator CPL';
    $data['c']  = $this->M_cpmk->get_by_id($id);
    $data['mk'] = $this->M_cpmk->get_mk();

    $this->form_validation->set_rules('kodecpmk', 'Kode CPMK', 'required');
    $this->form_validation->set_rules('cpmk', 'Deskripsi CPMK', 'required');
    $this->form_validation->set_rules('bobot', 'Bobot', 'required|integer');

    if ($this->form_validation->run() == FALSE) {
      template('cpmk/edit', $data);
    } else {
      $update = [
        'id_mk' => $this->input->post('id_mk'),
        'kodecpmk' => $this->input->post('kodecpmk'),
        'cpmk' => $this->input->post('cpmk'),
        'bobot' => $this->input->post('bobot')
      ];
      $this->M_cpmk->update($id, $update);
      redirect('cpmk');
    }
  }

  public function delete($id)
  {
    $this->M_cpmk->delete($id);
    redirect('cpmk');
  }
}
