<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pl extends CI_Model
{

  public function get_all()
  {
    $this->db->select('obe_pl.*, prodi.nama_prodi');
    $this->db->join('prodi', 'prodi.id_prodi = obe_pl.kdprodi', 'left');
    return $this->db->get('obe_pl')->result();
  }

  public function get_prodi()
  {
    return $this->db->get('prodi')->result();
  }

  public function insert($data)
  {
    return $this->db->insert('obe_pl', $data);
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('obe_pl', ['idpl' => $id])->row();
  }

  public function update($id, $data)
  {
    $this->db->where('idpl', $id);
    return $this->db->update('obe_pl', $data);
  }

  public function delete($id)
  {
    $this->db->where('idpl', $id);
    return $this->db->delete('obe_pl');
  }
}
