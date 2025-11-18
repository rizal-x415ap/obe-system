<?php
function admin_only()
{
  $ci = &get_instance();
  if (!$ci->session->userdata('logged_in')) {
    redirect('login');
  }
  if ($ci->session->userdata('level') != 'admin') {
    $ci->session->set_flashdata('error', 'Akses ditolak! Halaman ini hanya untuk admin.');
    redirect('dashboard');
  }
}
function dosen_only()
{
  $ci = &get_instance();
  if (!$ci->session->userdata('logged_in')) {
    redirect('login');
  }
  if ($ci->session->userdata('level') != 'dosen') {
    $ci->session->set_flashdata('error', 'Akses ditolak! Halaman ini hanya untuk admin.');
    redirect('dashboard');
  }

  if (!function_exists('redirect_back')) {
    function redirect_back($default = 'dashboard')
    {
      $CI = &get_instance();
      $url = $CI->input->server('HTTP_REFERER');
      if ($url) {
        redirect($url);
      } else {
        redirect($default);
      }
    }
  }
}
