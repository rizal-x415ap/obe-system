<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  public function index()
  {
    if (!$this->session->userdata('logged_in')) {
      redirect('login');
    }
    $data = [
      'title' => 'Dashboard',
    ];
    // $this->load->view('dashboard_view');
    template('dashboard', $data);
  }
}
