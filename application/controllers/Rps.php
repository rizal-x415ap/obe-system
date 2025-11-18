<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rps extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_rps');
    $this->load->library(['session', 'form_validation']);
    dosen_only(); // gunakan admin_only() jika ingin akses penuh admin
  }

  /* ==========================================================
     TAB 1 — IDENTITAS RPS
  ========================================================== */

  public function index()
  {
    $data['rps']        = $this->M_rps->get_all();
    $data['matakuliah'] = $this->M_rps->get_mk_susun();
    $data['dosen']      = $this->M_rps->get_dosen();
    $data['kaprodi']    = $this->M_rps->get_kaprodi();
    $data['title'] = 'RPS';
    template('rps/index', $data);
  }

  public function add()
  {
    $this->M_rps->insert_identitas($this->input->post());
    $this->session->set_flashdata('success', 'RPS berhasil ditambahkan.');
    redirect('rps');
  }

  public function delete($id)
  {
    if ($this->M_rps->delete_rps($id)) {
      $this->session->set_flashdata('success', 'RPS dihapus.');
    } else {
      $this->session->set_flashdata('error', 'Gagal menghapus RPS.');
    }
    redirect_back();
  }

  /* ==========================================================
     TAB 2 — DETAIL RPS
  ========================================================== */

  public function detail($id_rps)
  {
    $data['rps']        = $this->M_rps->get_by_id($id_rps);
    $data['cpmk']       = $this->M_rps->get_rps_cpmk($id_rps);
    $data['materi']     = $this->M_rps->get_rps_materi($id_rps);
    $data['pustaka']    = $this->M_rps->get_rps_pustaka($id_rps);
    $data['media']      = $this->M_rps->get_rps_media($id_rps);
    $data['penilaian']  = $this->M_rps->get_rps_penilaian($id_rps);
    $data['pertemuan']  = $this->M_rps->get_rps_pertemuan($id_rps);
    $data['title'] = 'Detail RPS';
    template('rps/detail', $data);
  }

  /* === CPMK CRUD === */
  public function add_cpmk()
  {
    $this->M_rps->insert_cpmk($this->input->post());
    redirect_back();
  }
  public function edit_cpmk($id)
  {
    $this->M_rps->update_cpmk($id, $this->input->post());
    redirect_back();
  }

  /* === SUBCPMK CRUD === */
  public function add_subcpmk()
  {
    $this->M_rps->insert_subcpmk($this->input->post());
    redirect_back();
  }
  public function edit_subcpmk($id)
  {
    $this->M_rps->update_subcpmk($id, $this->input->post());
    redirect_back();
  }

  /* === INDIKATOR CRUD === */
  public function add_indikator()
  {
    $data = [
      'id_rps_cpmk' => $this->input->post('id_rps_cpmk') ?: null,
      'id_subcpmk'  => $this->input->post('id_subcpmk') ?: null,
      'kode_indikator' => $this->input->post('kode_indikator'),
      'indikator' => $this->input->post('indikator')
    ];
    $this->M_rps->insert_indikator($data);
    redirect_back();
  }

  public function edit_indikator($id)
  {
    $data = [
      'kode_indikator' => $this->input->post('kode_indikator'),
      'indikator' => $this->input->post('indikator')
    ];
    $this->M_rps->update_indikator($id, $data);
    redirect_back();
  }

  public function delete_indikator($id)
  {
    $this->M_rps->delete_indikator($id);
    redirect_back();
  }

  /* === MATERI === */
  public function add_materi()
  {
    $this->M_rps->insert_materi($this->input->post());
    redirect_back();
  }

  public function delete_materi($id)
  {
    $this->M_rps->delete_materi($id);
    redirect_back();
  }

  /* === PUSTAKA === */
  public function add_pustaka()
  {
    $this->M_rps->insert_pustaka($this->input->post());
    redirect_back();
  }

  public function delete_pustaka($id)
  {
    $this->M_rps->delete_pustaka($id);
    redirect_back();
  }

  /* === MEDIA === */
  public function add_media()
  {
    $this->M_rps->insert_media($this->input->post());
    redirect_back();
  }

  public function delete_media($id)
  {
    $this->M_rps->delete_media($id);
    redirect_back();
  }

  /* === PENILAIAN === */
  public function add_penilaian()
  {
    $this->M_rps->insert_penilaian($this->input->post());
    redirect_back();
  }

  public function delete_penilaian($id)
  {
    $this->M_rps->delete_penilaian($id);
    redirect_back();
  }

  /* === PERTEMUAN === */
  public function add_pertemuan()
  {
    $this->M_rps->insert_pertemuan($this->input->post());
    redirect_back();
  }

  public function delete_pertemuan($id)
  {
    $this->M_rps->delete_pertemuan($id);
    redirect_back();
  }

  /* ==========================================================
     CETAK RPS (PDF)
  ========================================================== */
  public function cetak($id_rps)
  {
    $data['rps']        = $this->M_rps->get_full($id_rps);
    $data['cpl']        = $this->M_rps->get_cpl_by_mk($data['rps']->id_mk);
    $data['cpmk']       = $this->M_rps->get_rps_cpmk($id_rps);
    $data['materi']     = $this->M_rps->get_rps_materi($id_rps);
    $data['pustaka']    = $this->M_rps->get_rps_pustaka($id_rps);
    $data['media']      = $this->M_rps->get_rps_media($id_rps);
    $data['penilaian']  = $this->M_rps->get_rps_penilaian($id_rps);
    $data['pertemuan']  = $this->M_rps->get_rps_pertemuan($id_rps);
    $data['prodi']      = $this->M_rps->get_prodi_rps($id_rps);

    // --- Load Dompdf ---
    require_once APPPATH . '../vendor/autoload.php';
    $dompdf = new Dompdf\Dompdf([
      'isHtml5ParserEnabled' => true,
      'isRemoteEnabled' => true
    ]);

    $html = $this->load->view('rps/print_pdf', $data, true);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('RPS_' . $data['rps']->KodeMK . '.pdf', ['Attachment' => false]);
  }
}
