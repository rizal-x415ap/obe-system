<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dosen extends CI_Model
{

  public function get_all()
  {
    $this->db->select('dosen.*, fakultas.nama_fakultas, prodi.nama_prodi');
    $this->db->from('dosen');
    $this->db->join('fakultas', 'fakultas.id_fakultas = dosen.fakultas_id', 'left');
    $this->db->join('prodi', 'prodi.id_prodi = dosen.prodi_id', 'left');
    return $this->db->get()->result();
  }
  public function get_by_user_id($user_id)
  {
    return $this->db->get_where('dosen', ['users_id' => $user_id])->row();
  }
  public function cekNidnExists($nidn)
  {
    return $this->db->where('nidn', $nidn)->count_all_results('dosen') > 0;
  }

  public function get_fakultas()
  {
    return $this->db->get('fakultas')->result();
  }
  public function get_prodi()
  {
    return $this->db->get('prodi')->result();
  }

  public function insert($data)
  {
    $this->db->trans_start();

    // Buat akun di tabel users (akun login)
    $user_data = [
      'userid' => $data['nidn'],
      'password' => md5($data['nidn']),
      'role'     => 'dosen',
      'is_active' => 1
    ];

    $this->db->insert('login_system', $user_data);
    $users_id = $this->db->insert_id();

    // Simpan data dosen & hubungkan ke akun user
    $data['users_id'] = $users_id;
    $this->db->insert('dosen', $data);

    $this->db->trans_complete();
    return $this->db->trans_status();
  }




  public function get_by_id($id)
  {
    return $this->db->get_where('dosen', ['id_dosen' => $id])->row();
  }

  public function update($id, $data)
  {
    $dosen = $this->db->get_where('dosen', ['id_dosen' => $id])->row();

    if ($dosen) {
      $this->db->where('id_dosen', $id);
      $this->db->update('dosen', $data);

      if (!empty($data['nidn'])) {
        $user_update = [
          'username' => $data['nidn'],
          'password' => md5($data['nidn']),
        ];
        $this->db->where('userid', $dosen->users_id);
        $this->db->update('login_system', $user_update);
      }
    }
  }



  public function delete($id)
  {
    // Ambil users_id dari tabel dosen
    $dosen = $this->db->get_where('dosen', ['id_dosen' => $id])->row();

    if ($dosen) {
      // Hapus data dosen
      $this->db->where('id_dosen', $id);
      $this->db->delete('dosen');

      // Hapus data user terkait
      $this->db->where('id', $dosen->users_id);
      $this->db->delete('users');
    }
  }
}
