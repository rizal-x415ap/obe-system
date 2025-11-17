<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_prodi extends CI_Model
{

  public function get_all()
  {
    $this->db->select('prodi.*, fakultas.nama_fakultas');
    $this->db->from('prodi');
    $this->db->join('fakultas', 'fakultas.id_fakultas = prodi.fakultas_id', 'left');
    return $this->db->get()->result();
  }

  public function get_fakultas()
  {
    return $this->db->get('fakultas')->result();
  }

  public function insert($data)
  {
    return $this->db->insert('prodi', $data);
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('prodi', ['id_prodi' => $id])->row();
  }

  public function update($id, $data)
  {
    $this->db->where('id_prodi', $id);
    return $this->db->update('prodi', $data);
  }

  public function delete($id)
  {
    $this->db->where('id_prodi', $id);
    return $this->db->delete('prodi');
  }
}
