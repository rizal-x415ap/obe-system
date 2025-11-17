<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kaprodi extends CI_Model
{

  public function get_all()
  {
    $this->db->select('kaprodi.*, prodi.nama_prodi, dosen.nama_dosen');
    $this->db->from('kaprodi');
    $this->db->join('prodi', 'prodi.id_prodi = kaprodi.prodi_id', 'left');
    $this->db->join('dosen', 'dosen.id_dosen = kaprodi.id_dosen', 'left');
    return $this->db->get()->result();
  }

  public function get_prodi()
  {
    return $this->db->get('prodi')->result();
  }
  public function get_dosen()
  {
    return $this->db->get('dosen')->result();
  }

  public function insert($data)
  {
    return $this->db->insert('kaprodi', $data);
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('kaprodi', ['id_kaprodi' => $id])->row();
  }

  public function update($id, $data)
  {
    $this->db->where('id_kaprodi', $id);
    return $this->db->update('kaprodi', $data);
  }

  public function delete($id)
  {
    $this->db->where('id_kaprodi', $id);
    return $this->db->delete('kaprodi');
  }
}
