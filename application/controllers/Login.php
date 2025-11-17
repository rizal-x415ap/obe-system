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
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    $user = $this->M_login->get_user_by_username($username);

    if ($user) {
      if (password_verify($password, $user->password_hash)) {
        if ($user->is_active == 1) {
          $id_dosen = null;

          if ($user->role == 'dosen') {
            $dosen = $this->M_dosen->get_by_user_id($user->id);
            if ($dosen) {
              $id_dosen = $dosen->id_dosen;
              $nidn_dosen = $dosen->nidn;
            }
          }

          $this->session->set_userdata([
            'user_id'   => $user->id,
            'username'  => $user->username,
            'role'      => $user->role,
            'id_dosen'  => $id_dosen,
            'nidn_dosen' => $nidn_dosen,
            'logged_in' => TRUE
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
      $this->session->set_flashdata('error', 'Username tidak ditemukan');
      redirect('login');
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect('login');
  }
}
