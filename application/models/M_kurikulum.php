<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kurikulum extends CI_Model
{

  // ================== MASTER KURIKULUM ==================

  public function get_all()
  {
    $this->db->select('kurikulum.*, prodi.nama_prodi');
    $this->db->join('prodi', 'prodi.id_prodi = kurikulum.kdprodi', 'left');
    $this->db->order_by('TahunMulai', 'DESC');
    return $this->db->get('kurikulum')->result();
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('kurikulum', ['IdKurikulum' => $id])->row();
  }

  public function get_prodi()
  {
    return $this->db->get('prodi')->result();
  }

  public function get_aktif()
  {
    return $this->db->get_where('kurikulum', ['Status' => 'Aktif'])->row();
  }

  public function insert($data)
  {
    return $this->db->insert('kurikulum', $data);
  }

  public function update($id, $data)
  {
    return $this->db->where('IdKurikulum', $id)->update('kurikulum', $data);
  }

  public function delete($id)
  {
    return $this->db->delete('kurikulum', ['IdKurikulum' => $id]);
  }


  // ================== PENYUSUNAN MK ==================

  public function get_mk()
  {
    return $this->db->order_by('NamaMK', 'ASC')->get('mata_kuliah')->result();
  }

  public function get_kurikulum_mk($IdKurikulum)
  {
    $this->db->where('IdKurikulum', $IdKurikulum);
    $rows = $this->db->get('kurikulum_mk')->result();
    $map = [];
    foreach ($rows as $r) {
      $map[$r->id_mk] = $r;
    }
    return $map;
  }

  public function save_kurikulum_mk($IdKurikulum, $records)
  {
    $this->db->trans_start();

    foreach ($records as $id_mk => $r) {
      $exists = $this->db->get_where('kurikulum_mk', [
        'IdKurikulum' => $IdKurikulum,
        'id_mk' => $id_mk
      ])->row();

      $data = [
        'IdKurikulum' => $IdKurikulum,
        'id_mk' => $id_mk,
        'sks_teori' => $r['sks_teori'],
        'sks_praktek' => $r['sks_praktek'],
        'kategori' => $r['kategori'],
        'semester' => $r['semester']
      ];

      if ($exists) {
        $this->db->where('id', $exists->id)->update('kurikulum_mk', $data);
      } else {
        $this->db->insert('kurikulum_mk', $data);
      }
    }

    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  // ================== MK PRASYARAT ==================

  public function get_mk_prasyarat_detail()
  {
    $this->db->select('
        mp.id,
        mp.id_mk,
        mp.id_mk_prasyarat,
        mk1.KodeMK AS kode_mk,
        mk1.NamaMK AS nama_mk,
        km1.sks_teori AS sks_teori,
        km1.sks_praktek AS sks_praktek,
        km1.kategori AS kategori,
        km1.semester AS semester_mk,
        mk2.KodeMK AS kode_prasyarat,
        mk2.NamaMK AS nama_prasyarat,
        km2.semester AS semester_prasyarat
    ');
    $this->db->from('mk_prasyarat mp');
    $this->db->join('mata_kuliah mk1', 'mk1.id_mk = mp.id_mk', 'left');
    $this->db->join('mata_kuliah mk2', 'mk2.id_mk = mp.id_mk_prasyarat', 'left');
    $this->db->join('kurikulum_mk km1', 'km1.id_mk = mk1.id_mk', 'left');
    $this->db->join('kurikulum_mk km2', 'km2.id_mk = mk2.id_mk', 'left');
    $this->db->order_by('km1.semester', 'ASC');
    return $this->db->get()->result();
  }

  public function get_prasyarat_map_detail()
  {
    $rows = $this->get_mk_prasyarat_detail();
    $map = [];
    foreach ($rows as $r) {
      $map[$r->id_mk][] = [
        'id' => $r->id,
        'kode' => $r->kode_prasyarat,
        'nama' => $r->nama_prasyarat,
        'semester' => $r->semester_prasyarat ?? 0
      ];
    }
    return $map;
  }


  public function add_mk_prasyarat($id_mk, $id_mk_prasyarat)
  {
    $exist = $this->db->get_where('mk_prasyarat', [
      'id_mk' => $id_mk,
      'id_mk_prasyarat' => $id_mk_prasyarat
    ])->row();
    if (!$exist) {
      $this->db->insert('mk_prasyarat', [
        'id_mk' => $id_mk,
        'id_mk_prasyarat' => $id_mk_prasyarat
      ]);
    }
  }

  public function delete_mk_prasyarat($id)
  {
    $this->db->delete('mk_prasyarat', ['id' => $id]);
  }

  // ================== DOSEN PENGAMPU MK ==================

  public function get_dosen()
  {
    return $this->db->order_by('nama_dosen', 'ASC')->get('dosen')->result();
  }

  public function get_pengampu_map()
  {
    $rows = $this->db->select('dm.*, d.nama_dosen')
      ->from('dosen_pengampu_mk dm')
      ->join('dosen d', 'd.id_dosen=dm.id_dosen', 'left')
      ->get()->result();
    $map = [];
    foreach ($rows as $r) {
      $map[$r->id_mk][] = [
        'id' => $r->id,
        'id_dosen' => $r->id_dosen,
        'nama' => $r->nama_dosen
      ];
    }
    return $map;
  }

  public function add_pengampu($id_mk, $id_dosen)
  {
    $exist = $this->db->get_where('dosen_pengampu_mk', [
      'id_mk' => $id_mk,
      'id_dosen' => $id_dosen
    ])->row();
    if (!$exist) {
      $this->db->insert('dosen_pengampu_mk', [
        'id_mk' => $id_mk,
        'id_dosen' => $id_dosen
      ]);
    }
  }

  public function delete_pengampu($id)
  {
    $this->db->delete('dosen_pengampu_mk', ['id' => $id]);
  }


  // ================== INDIKATOR MK ==================

  public function get_cpl_with_cpmk()
  {
    $this->db->select('obe_cpl.idcpl, obe_cpl.kodecpl, obe_cpl.cpl,
                       obe_cpmk.idcpmk, obe_cpmk.kodecpmk, obe_cpmk.cpmk');
    $this->db->from('obe_cpl');
    $this->db->join('obe_cpl_cpmk', 'obe_cpl.idcpl = obe_cpl_cpmk.idcpl', 'left');
    $this->db->join('obe_cpmk', 'obe_cpl_cpmk.idcpmk = obe_cpmk.idcpmk', 'left');
    $this->db->order_by('obe_cpl.idcpl, obe_cpmk.idcpmk');
    return $this->db->get()->result();
  }

  public function get_cpmk_mk_map()
  {
    $rows = $this->db->get('obe_cpmk_mk')->result();
    $map = [];
    foreach ($rows as $r) {
      $map[$r->idcpmk][] = $r->id_mk;
    }
    return $map;
  }

  public function add_cpmk_mk($idcpmk, $id_mk)
  {
    $exist = $this->db->get_where('obe_cpmk_mk', [
      'idcpmk' => $idcpmk,
      'id_mk' => $id_mk
    ])->row();
    if (!$exist) {
      $this->db->insert('obe_cpmk_mk', [
        'idcpmk' => $idcpmk,
        'id_mk' => $id_mk
      ]);
    }
  }

  public function delete_cpmk_mk($idcpmk, $id_mk)
  {
    $this->db->delete('obe_cpmk_mk', ['idcpmk' => $idcpmk, 'id_mk' => $id_mk]);
  }
}
