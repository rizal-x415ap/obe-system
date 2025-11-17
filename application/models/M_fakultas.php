<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_fakultas extends CI_Model
{

  public function get_all()
  {
    return $this->db->get('fakultas')->result();
  }

  public function insert($data)
  {
    return $this->db->insert('fakultas', $data);
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('fakultas', ['id_fakultas' => $id])->row();
  }

  public function update($id, $data)
  {
    $this->db->where('id_fakultas', $id);
    return $this->db->update('fakultas', $data);
  }

  public function delete($id)
  {
    $this->db->where('id_fakultas', $id);
    return $this->db->delete('fakultas');
  }
}
