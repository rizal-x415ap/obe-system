<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_bk extends CI_Model
{

  public function get_all()
  {
    $this->db->select('obe_bk.*, prodi.nama_prodi');
    $this->db->join('prodi', 'prodi.id_prodi = obe_bk.kdprodi', 'left');
    return $this->db->get('obe_bk')->result();
  }

  public function get_prodi()
  {
    return $this->db->get('prodi')->result();
  }
  public function get_cpl()
  {
    return $this->db->get('obe_cpl')->result();
  }

  public function insert($data)
  {
    $this->db->insert('obe_bk', $data);
    return $this->db->insert_id();
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('obe_bk', ['idbk' => $id])->row();
  }

  public function update($id, $data)
  {
    $this->db->where('idbk', $id);
    return $this->db->update('obe_bk', $data);
  }

  public function delete($id)
  {
    $this->db->where('idbk', $id);
    return $this->db->delete('obe_bk');
  }
}
