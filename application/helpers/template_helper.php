<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('template')) {
  /**
   * Helper untuk memanggil template dengan data global
   * 
   * @param string $view Nama view utama (misal: 'pages/home')
   * @param array $data Data yang akan dilempar ke view
   */
  function template($view, $data = [])
  {
    $CI = &get_instance();

    // Data global (bisa kamu atur sesuai kebutuhan)
    $global_data = [
      'app_name' => 'MyApp',
      'app_version' => '1.0.0',
      'user_login' => $CI->session->userdata('user'), // contoh ambil data user dari session
      'nama_dosen' => $CI->session->userdata('nama_dosen'),
    ];

    // Merge data global dengan data view
    $data = array_merge($global_data, $data);

    $level = $CI->session->userdata('level');
    // Load template (header, sidebar, content, footer)
    $CI->load->view('template/header', $data);
    if ($level === 'dosen') {
      $CI->load->view('template/sidebar_dosen', $data);
    } elseif ($level === 'admin') {
      $CI->load->view('template/sidebar', $data);
    } else {
      $CI->load->view('template/sidebar', $data);
    }
    $CI->load->view($view, $data);
    $CI->load->view('template/footer', $data);
  }

  function set_alert($type, $title, $message, $target = 'both')
  {
    $CI = &get_instance(); // ambil instance CI

    if ($target === 'toast' || $target === 'both') {
      $CI->session->set_flashdata('toast', [
        'type'    => $type,
        'message' => $message,
      ]);
    }

    if ($target === 'swal' || $target === 'both') {
      $CI->session->set_flashdata('swal', [
        'type'  => $type,
        'title' => $title,
        'text'  => $message,
      ]);
    }
  }
}
