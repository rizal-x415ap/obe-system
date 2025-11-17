<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rangkuman extends CI_Model
{

  // Ambil semua CPL
  public function get_cpl()
  {
    return $this->db->order_by('idcpl', 'ASC')->get('obe_cpl')->result();
  }

  // Ambil semua BK dengan relasi CPL
  public function get_bk_with_cpl()
  {
    $this->db->select('b.idbk, b.kodebk, b.bahan_kajian, cb.idcpl');
    $this->db->from('obe_bk b');
    $this->db->join('obe_cpl_bk cb', 'cb.idbk = b.idbk', 'left');
    $this->db->order_by('b.idbk', 'ASC');
    return $this->db->get()->result();
  }

  // Ambil relasi BK–MK
  public function get_bk_mk()
  {
    $this->db->select('bm.idbk, mk.id_mk, mk.KodeMK, mk.NamaMK');
    $this->db->from('obe_bk_mk bm');
    $this->db->join('mata_kuliah mk', 'mk.id_mk = bm.id_mk', 'left');
    $this->db->order_by('mk.KodeMK', 'ASC');
    return $this->db->get()->result();
  }

  // Gabungkan semua data menjadi satu array
  public function get_map_data()
  {
    $cpl = $this->get_cpl();
    $bk_cpl = $this->get_bk_with_cpl();
    $bk_mk = $this->get_bk_mk();

    // CPL ↔ BK
    $map = [];
    foreach ($bk_cpl as $r) {
      $map[$r->idbk]['kodebk'] = $r->kodebk;
      $map[$r->idbk]['bahan_kajian'] = $r->bahan_kajian;
      $map[$r->idbk]['cpl'][] = $r->idcpl;
    }

    // BK ↔ MK
    $mk_map = [];
    foreach ($bk_mk as $r) {
      $mk_map[$r->idbk][] = [
        'KodeMK' => $r->KodeMK,
        'NamaMK' => $r->NamaMK
      ];
    }

    return [
      'cpl' => $cpl,
      'map' => $map,
      'mk'  => $mk_map
    ];
  }
  // ORGANISASI MK
  public function get_organisasi_mk()
  {
    $this->db->select('
        mk.id_mk, mk.KodeMK, mk.NamaMK,
        km.sks_teori, km.sks_praktek, km.semester, km.kategori
    ');
    $this->db->from('kurikulum_mk km');
    $this->db->join('mata_kuliah mk', 'mk.id_mk = km.id_mk', 'left');
    $this->db->order_by('km.semester', 'ASC');
    return $this->db->get()->result();
  }

  // PETA PEMENUHAN CPL & MK TIAP SEMESTER
  public function get_cpl_mk_semester()
  {
    $this->db->select('
        c.idcpl, c.kodecpl, c.cpl,
        mk.id_mk, mk.KodeMK, mk.NamaMK,
        km.semester
    ');
    $this->db->from('obe_cpl c');
    // hubungkan CPL → BK → MK → kurikulum_mk
    $this->db->join('obe_cpl_bk cb', 'cb.idcpl = c.idcpl', 'left');
    $this->db->join('obe_bk_mk bm', 'bm.idbk = cb.idbk', 'left');
    $this->db->join('mata_kuliah mk', 'mk.id_mk = bm.id_mk', 'left');
    $this->db->join('kurikulum_mk km', 'km.id_mk = mk.id_mk', 'left');
    $this->db->order_by('c.idcpl, km.semester, mk.KodeMK', 'ASC');
    return $this->db->get()->result();
  }

  // PETA PEMENUHAN INDIKATOR CPL & MK
  public function get_indikator_cpl_mk()
  {
    $this->db->select('
        mk.id_mk, mk.KodeMK, mk.NamaMK,
        c.idcpl, c.kodecpl,
        p.idcpmk, p.kodecpmk, p.cpmk
    ');
    $this->db->from('mata_kuliah mk');
    $this->db->join('obe_cpmk_mk pm', 'pm.id_mk = mk.id_mk', 'left');
    $this->db->join('obe_cpmk p', 'p.idcpmk = pm.idcpmk', 'left');
    $this->db->join('obe_cpl_cpmk cp', 'cp.idcpmk = p.idcpmk', 'left');
    $this->db->join('obe_cpl c', 'c.idcpl = cp.idcpl', 'left');
    $this->db->order_by('mk.KodeMK, c.idcpl, p.idcpmk', 'ASC');
    return $this->db->get()->result();
  }
}
