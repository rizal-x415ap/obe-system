<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_mk extends CI_Model
{

  public function get_all()
  {
    $this->db->select('mata_kuliah.*, prodi.nama_prodi');
    $this->db->join('prodi', 'prodi.kode_prodi = mata_kuliah.kdprodi', 'left');
    return $this->db->get('mata_kuliah')->result();
  }

  public function get_prodi()
  {
    return $this->db->get('prodi')->result();
  }

  public function get_cpl()
  {
    return $this->db->get('obe_cpl')->result();
  }

  public function get_bk()
  {
    return $this->db->get('obe_bk')->result();
  }

  public function insert($data)
  {
    $this->db->insert('mata_kuliah', $data);
    return $this->db->insert_id();
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('mata_kuliah', ['id_mk' => $id])->row();
  }

  public function update($id, $data)
  {
    $this->db->where('id_mk', $id);
    return $this->db->update('mata_kuliah', $data);
  }

  public function delete($id)
  {
    $this->db->where('id_mk', $id);
    return $this->db->delete('mata_kuliah');
  }
}
