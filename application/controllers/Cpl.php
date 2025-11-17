<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cpl extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    admin_only();
    $this->load->model('M_cpl');
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['title'] = 'CPL Prodi';
    $data['cpl'] = $this->M_cpl->get_all();
    template('cpl/index', $data);
  }

  public function add()
  {
    $data['prodi'] = $this->M_cpl->get_prodi();
    $data['pl'] = $this->M_cpl->get_pl();

    $this->form_validation->set_rules('kodecpl', 'Kode CPL', 'required');
    $this->form_validation->set_rules('cpl', 'Deskripsi CPL', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('cpl', $data);
    } else {
      $insert = [
        'kdprodi' => $this->input->post('kdprodi'),
        'kodecpl' => $this->input->post('kodecpl'),
        'cpl' => $this->input->post('cpl')
      ];
      $this->M_cpl->insert($insert);
      redirect('cpl');
    }
  }

  public function edit($id)
  {
    $data['prodi'] = $this->M_cpl->get_prodi();
    $data['c'] = $this->M_cpl->get_by_id($id);
    if (!$data['c']) redirect('cpl');

    $this->form_validation->set_rules('kodecpl', 'Kode CPL', 'required');
    $this->form_validation->set_rules('cpl', 'Deskripsi CPL', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('cpl/edit', $data);
    } else {
      $update = [
        'kdprodi' => $this->input->post('kdprodi'),
        'kodecpl' => $this->input->post('kodecpl'),
        'cpl' => $this->input->post('cpl')
      ];
      $this->M_cpl->update($id, $update);
      redirect('cpl');
    }
  }

  public function delete($id)
  {
    $this->M_cpl->delete($id);
    redirect('cpl');
  }
}
