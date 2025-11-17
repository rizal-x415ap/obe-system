<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_cpl extends CI_Model
{

  public function get_all()
  {
    $this->db->select('obe_cpl.*, prodi.nama_prodi');
    $this->db->join('prodi', 'prodi.id_prodi = obe_cpl.kdprodi', 'left');
    return $this->db->get('obe_cpl')->result();
  }

  public function get_prodi()
  {
    return $this->db->get('prodi')->result();
  }

  public function get_pl()
  {
    return $this->db->get('obe_pl')->result();
  }

  public function insert($data)
  {
    $this->db->insert('obe_cpl', $data);
    return $this->db->insert_id();
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('obe_cpl', ['idcpl' => $id])->row();
  }

  public function update($id, $data)
  {
    $this->db->where('idcpl', $id);
    return $this->db->update('obe_cpl', $data);
  }

  public function delete($id)
  {
    $this->db->where('idcpl', $id);
    return $this->db->delete('obe_cpl');
  }
}
