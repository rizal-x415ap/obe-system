<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_login');
    $this->load->model('M_dosen');
  }

  public function index()
  {
    $data['error'] = $this->session->flashdata('error');
    $this->load->view('auth/login_view', $data);
  }

  public function auth()
  {
    $userid = $this->input->post('userid');
    $password = $this->input->post('password');

    $user = $this->M_login->get_user_by_userid($userid);

    if ($user) {
      if (md5($password) === $user->password) {
        if ($user->blokir == 'N') {

          $id_dosen   = null;
          $nidn_dosen = null;
          $nama_dosen = null;

          if ($user->level == 'dosen') {
            $dosen = $this->M_dosen->get_by_user_id($user->userid);
            if ($dosen) {
              $id_dosen    = $dosen->id_dosen;
              $nidn_dosen  = $dosen->nidn;
              $nama_dosen  = $dosen->nama_dosen;
            }
          }

          $this->session->set_userdata([
            'userid'      => $user->userid,
            'level'       => $user->level,
            'id_dosen'    => $id_dosen,
            'nidn_dosen'  => $nidn_dosen,
            'nama_dosen'  => $nama_dosen,
            'logged_in'   => TRUE
          ]);

          redirect('dashboard');
        } else {
          $this->session->set_flashdata('error', 'Akun tidak aktif');
          redirect('login');
        }
      } else {
        $this->session->set_flashdata('error', 'Password salah');
        redirect('login');
      }
    } else {
      $this->session->set_flashdata('error', 'userid tidak ditemukan');
      redirect('login');
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect('login');
  }
}
