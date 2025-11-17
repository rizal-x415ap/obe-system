<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mk extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    admin_only();
    $this->load->model('M_mk');
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['mk'] = $this->M_mk->get_all();
    $data['prodi'] = $this->M_mk->get_prodi();
    $data['title'] = 'Matakuliah';
    template('mk/index', $data);
  }

  public function add()
  {

    $this->form_validation->set_rules('KodeMK', 'Kode MK', 'required');
    $this->form_validation->set_rules('NamaMK', 'Nama Mata Kuliah', 'required');
    $this->form_validation->set_rules('Sks', 'SKS', 'required|integer');
    $this->form_validation->set_rules('Semester', 'Semester', 'required|integer');

    if ($this->form_validation->run() == FALSE) {
      template('mk/index', $data);
    } else {
      $insert = [
        'kdprodi'   => $this->input->post('kdprodi'),
        'KodeMK'   => $this->input->post('KodeMK'),
        'NamaMK'   => $this->input->post('NamaMK'),
        'Subjects'  => $this->input->post('Subjects'),
        'Sks'       => $this->input->post('Sks'),
        'Semester'  => $this->input->post('Semester'),
        'Jenis'     => $this->input->post('Jenis')
      ];
      $this->M_mk->insert($insert);

      redirect('mk');
    }
  }

  public function edit($id)
  {
    $data['m'] = $this->M_mk->get_by_id($id);
    $data['prodi'] = $this->M_mk->get_prodi();

    $this->form_validation->set_rules('NamaMK', 'Nama MK', 'required');
    $this->form_validation->set_rules('Sks', 'SKS', 'required|integer');
    $this->form_validation->set_rules('Semester', 'Semester', 'required|integer');

    if ($this->form_validation->run() == FALSE) {
      template('mk/edit', $data);
    } else {
      $update = [
        'kdprodi'   => $this->input->post('kdprodi'),
        'KodeMK'   => $this->input->post('KodeMK'),
        'NamaMK'   => $this->input->post('NamaMK'),
        'Subjects'  => $this->input->post('Subjects'),
        'Sks'       => $this->input->post('Sks'),
        'Semester'  => $this->input->post('Semester'),
        'Jenis'     => $this->input->post('Jenis')
      ];
      $this->M_mk->update($id, $update);
      redirect('mk');
    }
  }

  public function delete($id)
  {
    $this->M_mk->delete($id);
    redirect('mk');
  }
}
