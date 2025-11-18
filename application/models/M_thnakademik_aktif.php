<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_thnakademik_aktif extends CI_Model
{
  private $table = 'thnakademik_aktif';

  public function get_current()
  {
    return $this->db->order_by('id', 'ASC')
      ->limit(1)
      ->get($this->table)
      ->row();
  }

  public function update_current($id, $data)
  {
    $this->db->where('id', (int)$id);
    return $this->db->update($this->table, $data);
  }
}
