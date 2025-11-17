<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pemetaan extends CI_Model
{

  public function get_all()
  {
    $query = $this->db->query("
            SELECT obe_cpl.idcpl, obe_cpl.kodecpl, obe_cpl.cpl,
                   GROUP_CONCAT(DISTINCT obe_pl.kodepl SEPARATOR ', ') AS profil,
                   GROUP_CONCAT(DISTINCT obe_bk.kodebk SEPARATOR ', ') AS bahan_kajian,
                   GROUP_CONCAT(DISTINCT mata_kuliah.NamaMK SEPARATOR ', ') AS matkul,
                   GROUP_CONCAT(DISTINCT obe_cpmk.kodecpmk SEPARATOR ', ') AS indikator
            FROM obe_cpl
            LEFT JOIN obe_pl_cpl ON obe_cpl.idcpl = obe_pl_cpl.idcpl
            LEFT JOIN obe_pl ON obe_pl_cpl.idpl = obe_pl.idpl
            LEFT JOIN obe_cpl_bk ON obe_cpl.idcpl = obe_cpl_bk.idcpl
            LEFT JOIN obe_bk ON obe_cpl_bk.idbk = obe_bk.idbk
            LEFT JOIN obe_cpl_mk ON obe_cpl.idcpl = obe_cpl_mk.idcpl
            LEFT JOIN mata_kuliah ON obe_cpl_mk.id_mk = mata_kuliah.id_mk
            LEFT JOIN obe_cpl_cpmk ON obe_cpl.idcpl = obe_cpl_cpmk.idcpl
            LEFT JOIN obe_cpmk ON obe_cpl_cpmk.idcpmk = obe_cpmk.idcpmk
            GROUP BY obe_cpl.idcpl
            ORDER BY obe_cpl.idcpl ASC
        ");
    return $query->result();
  }

  public function get_all_cpl()
  {
    return $this->db->get('obe_cpl')->result();
  }
  public function get_all_pl()
  {
    return $this->db->get('obe_pl')->result();
  }
  public function get_all_bk()
  {
    return $this->db->get('obe_bk')->result();
  }
  public function get_all_mk()
  {
    return $this->db->get('mata_kuliah')->result();
  }
  public function get_all_cpmk()
  {
    return $this->db->get('obe_cpmk')->result();
  }

  // tambah relasi
  public function add_relation($table, $data)
  {
    return $this->db->insert($table, $data);
  }

  // hapus relasi
  public function delete_relation($table, $where)
  {
    return $this->db->delete($table, $where);
  }
}
