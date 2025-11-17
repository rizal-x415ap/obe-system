<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{

  public function get_user_by_username($username)
  {
    return $this->db->get_where('users', ['username' => $username])->row();
  }

  public function get_by_user_id($user_id)
  {
    $this->db->select('dosen.*, fakultas.nama_fakultas, prodi.nama_prodi');
    $this->db->from('dosen');
    $this->db->join('fakultas', 'fakultas.id_fakultas = dosen.fakultas_id', 'left');
    $this->db->join('prodi', 'prodi.id_prodi = dosen.prodi_id', 'left');
    $this->db->where('dosen.users_id', $user_id);
    return $this->db->get()->row();
  }

  public function check_user($username, $password)
  {
    return $this->db->get_where('users', [
      'username' => $username,
      'password_hash' => $password
    ])->row();
  }
}
