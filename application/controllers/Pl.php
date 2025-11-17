<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pl extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    admin_only(); // hanya admin
    $this->load->model('M_pl');
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['pl'] = $this->M_pl->get_all();
    $data['title'] = 'Profil Lulusan';
    template('pl/index', $data);
  }

  public function add()
  {
    $data['prodi'] = $this->M_pl->get_prodi();

    $this->form_validation->set_rules('kodepl', 'Kode PL', 'required');
    $this->form_validation->set_rules('pl', 'Profil Lulusan', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('pl', $data);
    } else {
      $insert = [
        'kdprodi'   => $this->input->post('kdprodi'),
        'kodepl'    => $this->input->post('kodepl'),
        'pl'        => $this->input->post('pl'),
        'deskripsi' => $this->input->post('deskripsi')
      ];
      $this->M_pl->insert($insert);
      redirect('pl');
    }
  }

  public function edit($id)
  {
    $data['prodi'] = $this->M_pl->get_prodi();
    $data['p'] = $this->M_pl->get_by_id($id);
    if (!$data['p']) redirect('pl');

    $this->form_validation->set_rules('kodepl', 'Kode PL', 'required');
    $this->form_validation->set_rules('pl', 'Profil Lulusan', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('pl/edit', $data);
    } else {
      $update = [
        'kdprodi'   => $this->input->post('kdprodi'),
        'kodepl'    => $this->input->post('kodepl'),
        'pl'        => $this->input->post('pl'),
        'deskripsi' => $this->input->post('deskripsi')
      ];
      $this->M_pl->update($id, $update);
      redirect('pl');
    }
  }

  public function delete($id)
  {
    $this->M_pl->delete($id);
    redirect('pl');
  }
}
