<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemetaan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    admin_only();
    $this->load->model('M_pemetaan');
    $this->load->library('form_validation');
  }

  // CPL & PLL
  public function cpl_pl()
  {
    $data['cpl'] = $this->db->get('obe_cpl')->result();
    $data['pl']  = $this->db->get('obe_pl')->result();
    $data['title'] = 'Pemetaan CPL & PL';

    // ambil relasi CPL ↔ PL
    $rows = $this->db->get('obe_pl_cpl')->result();
    $relasi = [];
    foreach ($rows as $r) {
      $relasi[$r->idcpl][] = $r->idpl;
    }
    $data['relasi'] = $relasi;

    template('pemetaan/cpl_pl', $data);
  }

  public function update_cpl_pl()
  {
    $idcpl = $this->input->post('idcpl');
    $idpl  = $this->input->post('idpl');
    $checked = $this->input->post('checked') === 'true';

    if ($checked) {
      $exist = $this->db->get_where('obe_pl_cpl', ['idcpl' => $idcpl, 'idpl' => $idpl])->row();
      if (!$exist) $this->db->insert('obe_pl_cpl', ['idcpl' => $idcpl, 'idpl' => $idpl]);
    } else {
      $this->db->delete('obe_pl_cpl', ['idcpl' => $idcpl, 'idpl' => $idpl]);
    }
    echo json_encode(['success' => true]);
  }

  // CPL & BK
  public function cpl_bk()
  {
    $data['cpl'] = $this->db->get('obe_cpl')->result();
    $data['bk']  = $this->db->get('obe_bk')->result();
    $data['title'] = 'Pemetaan CPL & BK';

    // ambil relasi BK ↔ CPL
    $rows = $this->db->get('obe_cpl_bk')->result();
    $relasi = [];
    foreach ($rows as $r) {
      $relasi[$r->idbk][] = $r->idcpl;
    }
    $data['relasi'] = $relasi;

    template('pemetaan/cpl_bk', $data);
  }

  public function update_cpl_bk()
  {
    $idbk = $this->input->post('idbk');
    $idcpl = $this->input->post('idcpl');
    $checked = $this->input->post('checked') === 'true';

    if ($checked) {
      $exist = $this->db->get_where('obe_cpl_bk', ['idbk' => $idbk, 'idcpl' => $idcpl])->row();
      if (!$exist) $this->db->insert('obe_cpl_bk', ['idbk' => $idbk, 'idcpl' => $idcpl]);
    } else {
      $this->db->delete('obe_cpl_bk', ['idbk' => $idbk, 'idcpl' => $idcpl]);
    }
    echo json_encode(['success' => true]);
  }

  // BK & MK

  public function bk_mk()
  {
    $data['bk'] = $this->db->get('obe_bk')->result();
    $data['mk'] = $this->db->get('mata_kuliah')->result();
    $data['title'] = 'Pemetaan BK & MK';

    // ambil relasi BK ↔ MK
    $rows = $this->db->get('obe_bk_mk')->result();
    $relasi = [];
    foreach ($rows as $r) {
      $relasi[$r->id_mk][] = $r->idbk;
    }
    $data['relasi'] = $relasi;

    template('pemetaan/bk_mk', $data);
  }

  public function update_bk_mk()
  {
    $idmk = $this->input->post('idmk');
    $idbk = $this->input->post('idbk');
    $checked = $this->input->post('checked') === 'true';

    if ($checked) {
      $exist = $this->db->get_where('obe_bk_mk', ['id_mk' => $idmk, 'idbk' => $idbk])->row();
      if (!$exist) $this->db->insert('obe_bk_mk', ['id_mk' => $idmk, 'idbk' => $idbk]);
    } else {
      $this->db->delete('obe_bk_mk', ['id_mk' => $idmk, 'idbk' => $idbk]);
    }
    echo json_encode(['success' => true]);
  }

  //cpl & mk
  public function cpl_mk()
  {
    $data['cpl'] = $this->db->get('obe_cpl')->result();
    $data['mk']  = $this->db->get('mata_kuliah')->result();
    $data['title'] = 'Pemetaan CPL & MK';

    // ambil relasi CPL ↔ MK
    $rows = $this->db->get('obe_cpl_mk')->result();
    $relasi = [];
    foreach ($rows as $r) {
      $relasi[$r->id_mk][] = $r->idcpl;
    }
    $data['relasi'] = $relasi;

    template('pemetaan/cpl_mk', $data);
  }

  public function update_cpl_mk()
  {
    $idmk = $this->input->post('idmk');
    $idcpl = $this->input->post('idcpl');
    $checked = $this->input->post('checked') === 'true';

    if ($checked) {
      $exist = $this->db->get_where('obe_cpl_mk', ['id_mk' => $idmk, 'idcpl' => $idcpl])->row();
      if (!$exist) $this->db->insert('obe_cpl_mk', ['id_mk' => $idmk, 'idcpl' => $idcpl]);
    } else {
      $this->db->delete('obe_cpl_mk', ['id_mk' => $idmk, 'idcpl' => $idcpl]);
    }
    echo json_encode(['success' => true]);
  }
}
