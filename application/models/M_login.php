<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{

  public function get_user_by_userid($userid)
  {
    // tetap pakai tabel login_system kalau memang ini tabel utamanya
    return $this->db->get_where('login_system', ['userid' => $userid])->row();
  }

  public function get_by_user_id($userid)
  {
    $this->db->select('dosen.*, fakultas.nama_fakultas, prodi.nama_prodi');
    $this->db->from('dosen');
    $this->db->join('fakultas', 'fakultas.id_fakultas = dosen.fakultas_id', 'left');
    $this->db->join('prodi', 'prodi.id_prodi = dosen.prodi_id', 'left');
    $this->db->where('dosen.users_id', $userid);
    return $this->db->get()->row();
  }

  public function check_user($userid, $password)
  {
    return $this->db->get_where('login_system', [
      'userid'   => $userid,
      'password' => md5($password)
    ])->row();
  }
}
