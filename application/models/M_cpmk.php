<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_cpmk extends CI_Model
{

  public function get_all_grouped()
  {
    $this->db->select('obe_cpl.idcpl, obe_cpl.kodecpl, obe_cpl.cpl,
                           obe_cpmk.idcpmk, obe_cpmk.kodecpmk, obe_cpmk.cpmk,
                           obe_cpmk.bobot, mata_kuliah.NamaMK');
    $this->db->from('obe_cpl');
    $this->db->join('obe_cpl_cpmk', 'obe_cpl.idcpl = obe_cpl_cpmk.idcpl', 'left');
    $this->db->join('obe_cpmk', 'obe_cpl_cpmk.idcpmk = obe_cpmk.idcpmk', 'left');
    $this->db->join('mata_kuliah', 'mata_kuliah.id_mk = obe_cpmk.id_mk', 'left');
    $this->db->order_by('obe_cpl.idcpl, obe_cpmk.idcpmk');
    $query = $this->db->get();

    $data = [];
    foreach ($query->result() as $row) {
      $idcpl = $row->idcpl;
      if (!isset($data[$idcpl])) {
        $data[$idcpl] = [
          'kodecpl' => $row->kodecpl,
          'cpl' => $row->cpl,
          'indikator' => []
        ];
      }
      if ($row->idcpmk) {
        $data[$idcpl]['indikator'][] = [
          'idcpmk' => $row->idcpmk,
          'kodecpmk' => $row->kodecpmk,
          'cpmk' => $row->cpmk,
          'bobot' => $row->bobot,
          'NamaMK' => $row->NamaMK
        ];
      }
    }
    return $data;
  }

  public function get_cpl()
  {
    return $this->db->get('obe_cpl')->result();
  }
  public function get_mk()
  {
    return $this->db->get('mata_kuliah')->result();
  }

  public function insert_cpmk($data)
  {
    $this->db->insert('obe_cpmk', $data);
    return $this->db->insert_id();
  }

  public function insert_mapping($idcpl, $idcpmk)
  {
    return $this->db->insert('obe_cpl_cpmk', ['idcpl' => $idcpl, 'idcpmk' => $idcpmk]);
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('obe_cpmk', ['idcpmk' => $id])->row();
  }

  public function update($id, $data)
  {
    $this->db->where('idcpmk', $id);
    return $this->db->update('obe_cpmk', $data);
  }

  public function delete($id)
  {
    $this->db->where('idcpmk', $id);
    return $this->db->delete('obe_cpmk');
  }
}
